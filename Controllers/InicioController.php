<?php

namespace App\Http\Controllers;

use App\Models\JogosModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class InicioController extends Controller
{

    public function index(Request $request)
    {
        $q = $request->query('q');
        $query = JogosModel::query();

        if ($q) {
            $query->where('titulo', 'like', "%{$q}%");
        }

        $jogos = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('inicio', compact('jogos', 'q'));
    }

    public function create()
    {
        return view('inicio_create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'     => ['required', 'string', 'max:255'],
            'descricao'  => ['nullable', 'string'],
            'preco'      => ['required', 'numeric', 'min:0'],
            'plataforma' => ['nullable', 'string', 'max:100'],
            'lancamento' => ['nullable', 'date'],
            'cover'      => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $filename = now()->timestamp . '_' . Str::slug($data['titulo']) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/covers', $filename);
            $data['cover'] = Storage::url($path);
        }

        JogosModel::create($data);

        return redirect()->route('inicio')->with('success', 'Jogo criado com sucesso!');
    }

    public function show(JogosModel $jogo)
    {
        return view('inicio_show', compact('jogo'));
    }

    public function edit(JogosModel $jogo)
    {
        return view('inicio_edit', compact('jogo'));
    }

    public function update(Request $request, JogosModel $jogo)
    {
        $data = $request->validate([
            'titulo'     => ['required', 'string', 'max:255'],
            'descricao'  => ['nullable', 'string'],
            'preco'      => ['required', 'numeric', 'min:0'],
            'plataforma' => ['nullable', 'string', 'max:100'],
            'lancamento' => ['nullable', 'date'],
            'cover'      => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('cover')) {
            if ($jogo->cover) {
                if (Str::startsWith($jogo->cover, '/storage/')) {
                    $oldPath = str_replace('/storage/', 'public/', $jogo->cover);
                    Storage::delete($oldPath);
                } elseif (Str::startsWith($jogo->cover, 'storage/')) {
                    $oldPath = str_replace('storage/', 'public/', $jogo->cover);
                    Storage::delete($oldPath);
                }
            }

            $file = $request->file('cover');
            $filename = now()->timestamp . '_' . Str::slug($data['titulo']) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/covers', $filename);
            $data['cover'] = Storage::url($path);
        }

        $jogo->update($data);

        return redirect()->route('inicio')->with('success', 'Jogo atualizado!');
    }

    public function destroy(JogosModel $jogo)
    {
        if ($jogo->cover) {
            if (Str::startsWith($jogo->cover, '/storage/')) {
                $oldPath = str_replace('/storage/', 'public/', $jogo->cover);
                Storage::delete($oldPath);
            } elseif (Str::startsWith($jogo->cover, 'storage/')) {
                $oldPath = str_replace('storage/', 'public/', $jogo->cover);
                Storage::delete($oldPath);
            }
        }

        $jogo->delete();

        return redirect()->route('inicio')->with('success', 'Jogo removido!');
    }

    public function showCover($filename)
    {
        $path = storage_path('app/public/covers/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }

}
