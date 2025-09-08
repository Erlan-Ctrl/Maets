
@extends('layouts.default')
@section('conteudo')
    <style>
        .d-flex.justify-content-between.mb-3 > h3 {
            color: #ffffff !important;
        }
        .form-text {
            color: #ffffff !important;
        }
    </style>
    <div class="d-flex justify-content-between mb-3">
        <h3>Editar Jogo</h3>
        <a href="{{ route('inicio') }}" class="btn btn-secondary">Voltar</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form id="editForm" action="{{ route('inicio.update', $jogo) }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label">Título</label>
                            <input name="titulo" class="form-control @error('titulo') is-invalid @enderror" value="{{ old('titulo', $jogo->titulo) }}" required>
                            @error('titulo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descrição</label>
                            <textarea name="descricao" class="form-control @error('descricao') is-invalid @enderror" rows="5">{{ old('descricao', $jogo->descricao) }}</textarea>
                            @error('descricao') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Preço</label>
                                <input name="preco" type="number" step="0.01" min="0" class="form-control @error('preco') is-invalid @enderror" value="{{ old('preco', $jogo->preco) }}" required>
                                @error('preco') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Plataforma</label>
                                <input name="plataforma" class="form-control @error('plataforma') is-invalid @enderror" value="{{ old('plataforma', $jogo->plataforma) }}">
                                @error('plataforma') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Data de Lançamento</label>
                            <input type="date" name="lancamento" class="form-control @error('lancamento') is-invalid @enderror"
                                   value="{{ old('lancamento', optional($jogo->lancamento)->format('Y-m-d')) }}">
                            @error('lancamento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nova Capa (opcional)</label>
                            <input type="file" name="cover" class="form-control @error('cover') is-invalid @enderror" accept="image/*">
                            @error('cover') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <div class="form-text">Envie imagem até 2MB. Se não enviar, a capa atual será mantida.</div>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('inicio') }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button id="submitBtn" type="submit" class="btn btn-success">Salvar</button>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Capa atual</label>
                        <div class="card mb-3">
                            @if($jogo->cover)
                                <img src="{{ $jogo->cover }}" class="img-fluid" alt="{{ $jogo->titulo }}" style="object-fit:cover; max-height:300px;">
                            @else
                                <div class="d-flex align-items-center justify-content-center" style="height:300px; background:#e9ecef;">
                                    <span class="text-muted">Sem imagem</span>
                                </div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title small mb-1">{{ $jogo->titulo }}</h5>
                                <p class="card-text small text-muted mb-1">{{ $jogo->plataforma ?? '—' }}</p>
                                <p class="card-text small"><strong>{{ $jogo->preco_formatado ?? 'R$ ' . number_format($jogo->preco, 2, ',', '.') }}</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editForm = document.getElementById('editForm');
            const submitBtn = document.getElementById('submitBtn');
            const deleteBtn = document.getElementById('deleteBtn');
            const deleteForm = document.getElementById('deleteForm');

            if (editForm && submitBtn) {
                editForm.addEventListener('submit', function () {
                    submitBtn.disabled = true;
                    submitBtn.innerText = 'Salvando...';
                }, { once: true });
            }

            if (deleteBtn && deleteForm) {
                deleteBtn.addEventListener('click', function () {
                    if (!confirm('Deseja realmente apagar "{{ addslashes($jogo->titulo) }}"? Esta ação é irreversível.')) return;
                    deleteForm.submit();
                });
            }
        });
    </script>
@endsection


