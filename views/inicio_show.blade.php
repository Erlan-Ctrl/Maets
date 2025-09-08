@extends('layouts.default')
@section('conteudo')

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                @php
                    $coverUrl = null;
                    if (!empty($jogo->cover)) {
                        if (\Illuminate\Support\Str::startsWith($jogo->cover, ['http://','https://','/'])) {
                            $coverUrl = $jogo->cover;
                        } else {
                            $coverUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($jogo->cover);
                        }
                    }
                @endphp

                @if($coverUrl)
                    <img src="{{ $coverUrl }}" class="card-img-top" alt="{{ $jogo->titulo }}" style="height:100%;object-fit:cover;">
                @else
                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height:300px;">
                        Sem imagem
                    </div>
                @endif

                <div class="card-body">
                    <h4 class="card-title">{{ $jogo->titulo }}</h4>
                    <p class="card-text small text-muted">{{ $jogo->plataforma ?? '—' }}</p>
                    <p class="card-text"><strong>{{ $jogo->preco_formatado ?? ('R$ ' . number_format($jogo->preco ?: 0, 2, ',', '.')) }}</strong></p>
                    <p class="card-text"><small class="text-muted">Lançamento: {{ $jogo->lancamento ? $jogo->lancamento->format('d/m/Y') : '—' }}</small></p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card p-3">
                <h5>Descrição</h5>
                <p class="text-muted">{{ $jogo->descricao ?? 'Sem descrição.' }}</p>

                <div class="mt-4 d-flex gap-2">
                    <a href="{{ route('inicio.edit', $jogo) }}" class="btn btn-warning">Editar</a>

                    <form action="{{ route('inicio.destroy', $jogo) }}" method="POST" onsubmit="return confirm('Deseja realmente apagar {{ addslashes($jogo->titulo) }}?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Excluir</button>
                    </form>
                </div>
            </div>

            <div class="card mt-3 p-3">
                <h6>Informações</h6>
                <ul class="list-unstyled small mb-0">
                    <li><strong>ID:</strong> {{ $jogo->id }}</li>
                    <li><strong>Criado em:</strong> {{ $jogo->created_at ? $jogo->created_at->format('d/m/Y H:i') : '—' }}</li>
                    <li><strong>Atualizado em:</strong> {{ $jogo->updated_at ? $jogo->updated_at->format('d/m/Y H:i') : '—' }}</li>
                </ul>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection
