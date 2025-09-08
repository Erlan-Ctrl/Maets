@extends('layouts.default')
@section('conteudo')

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <form class="d-flex" method="GET" action="{{ route('inicio') }}">
                <input name="q" class="form-control me-2" type="search" placeholder="Buscar títulos..." value="{{ $q ?? '' }}">
                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
            </form>

            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">+ Novo Jogo</button>
        </div>

        <div class="row g-3">
            @forelse($jogos as $j)
                <div class="col-md-4">
                    <div class="card h-100 game-card">
                        @php
                            $coverUrl = null;
                            if (!empty($j->cover)) {
                                if (\Illuminate\Support\Str::startsWith($j->cover, ['http://','https://','/'])) {
                                    $coverUrl = $j->cover;
                                } else {
                                    $coverUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($j->cover);
                                }
                            }
                        @endphp

                        @if($coverUrl)
                            <img src="{{ $coverUrl }}" class="card-img-top game-cover" alt="{{ $j->titulo }}" loading="lazy">
                        @else
                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height:200px;">
                                Sem imagem
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $j->titulo }}</h5>
                            <p class="card-text text-muted small mb-1">{{ $j->plataforma ?? '—' }}</p>
                            <p class="card-text flex-grow-1">{{ \Illuminate\Support\Str::limit($j->descricao, 110) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>{{ $j->preco_formatado ?? 'R$ ' . number_format($j->preco, 2, ',', '.') }}</strong>
                                <div>
                                    <a href="{{ route('inicio.show', $j) }}" class="btn btn-sm btn-outline-primary">Detalhes</a>
                                    <a href="{{ route('inicio.edit', $j) }}" class="btn btn-sm btn-outline-warning">Editar</a>

                                    <form action="{{ route('inicio.destroy', $j) }}" method="POST" class="d-inline" onsubmit="return confirm('Deseja realmente apagar {{ addslashes($j->titulo) }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Excluir</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">Nenhum jogo encontrado.</div>
                </div>
            @endforelse
        </div>
            <div class="pagination-wrapper">
                {{ $jogos->links('pagination::bootstrap-5') }}
            </div>
    </div>
</div>

<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" method="POST" action="{{ route('inicio.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Criar novo jogo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Título</label>
                    <input name="titulo" class="form-control" value="{{ old('titulo') }}" required>
                    @error('titulo') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Descrição</label>
                    <textarea name="descricao" class="form-control" rows="4">{{ old('descricao') }}</textarea>
                    @error('descricao') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Preço</label>
                        <input name="preco" type="number" step="0.01" class="form-control" value="{{ old('preco', '0.00') }}" required>
                        @error('preco') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Plataforma</label>
                        <input name="plataforma" class="form-control" value="{{ old('plataforma') }}">
                        @error('plataforma') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Capa (imagem)</label>
                    <input type="file" name="cover" class="form-control">
                    @error('cover') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Data de Lançamento</label>
                    <input type="date" name="lancamento" class="form-control" value="{{ old('lancamento') }}">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        try {
            const threshold = 300;
            const candidates = Array.from(document.querySelectorAll('img, svg'));

            candidates.forEach(el => {
                if (el.classList && el.classList.contains('game-cover')) return;

                const rect = el.getBoundingClientRect();
                if (!rect) return;
                if (rect.width === 0 && rect.height === 0) return;

                if (rect.width > threshold || rect.height > threshold) {
                    el.classList.add('constrain-large-icon');
                    if (el.tagName.toLowerCase() === 'svg' && !el.getAttribute('width') && !el.getAttribute('height')) {
                        el.style.width = 'auto';
                        el.style.height = 'auto';
                    }
                }
            });
        } catch (e) {
            console.error('Error running auto-limit script:', e);
        }
    });
</script>

@if($errors->any() && old())
    <script>
        const modal = new bootstrap.Modal(document.getElementById('createModal'));
        modal.show();
    </script>
@endif

@endsection
