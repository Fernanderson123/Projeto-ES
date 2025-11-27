<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Novo Pet - Animal Health Center</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #fcfaf6; font-family: 'Georgia', serif; }
        .page-title { font-family: sans-serif; margin-bottom: 1.5rem; color: #1a1a1a; }
        .form-card { background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px rgba(0,0,0,0.02); border: none; max-width: 800px; margin: 0 auto; }
        .form-label { font-family: sans-serif; font-weight: bold; font-size: 0.9rem; color: #555; }
        .btn-save { background-color: #a78bfa; color: white; border: none; border-radius: 50px; padding: 10px 30px; font-weight: bold; font-family: sans-serif; }
        .btn-save:hover { background-color: #9061f9; color: white; }
        .btn-back { font-family: sans-serif; text-decoration: none; color: #666; margin-right: 15px; }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="d-flex justify-content-center">
            <div class="col-12 col-md-8">
                <h2 class="page-title text-center">Cadastrar Novo Pet 🐾</h2>
                
                <div class="form-card">
                    <form action="{{ route('pets.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label">Tutor (Dono)</label>
                            @if(Auth::user()->isCliente())
                                <input type="text" class="form-control bg-light" value="{{ Auth::user()->cliente->nome_completo }}" disabled>
                                @else
                                <select name="cliente_id" class="form-select" required>
                                    <option value="">Selecione um cliente...</option>
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id }}">{{ $cliente->nome_completo }} (CPF: {{ $cliente->cpf }})</option>
                                    @endforeach
                                </select>
                            @endif
                            @error('cliente_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nome" class="form-label">Nome do Pet</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Ex: Rex, Luna..." required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="especie" class="form-label">Espécie</label>
                                <select class="form-select" id="especie" name="especie" required>
                                    <option value="Cachorro">Cachorro</option>
                                    <option value="Gato">Gato</option>
                                    <option value="Ave">Ave</option>
                                    <option value="Roedor">Roedor</option>
                                    <option value="Outro">Outro</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="raca" class="form-label">Raça (Opcional)</label>
                                <input type="text" class="form-control" id="raca" name="raca" placeholder="Ex: Labrador, Siamês">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="peso" class="form-label">Peso (kg) (Opcional)</label>
                                <input type="number" step="0.1" class="form-control" id="peso" name="peso">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="data_nascimento" class="form-label">Data de Nascimento (Aproximada)</label>
                            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento">
                        </div>

                        <div class="text-end">
                            <a href="{{ route('pets.index') }}" class="btn-back">Cancelar</a>
                            <button type="submit" class="btn-save">Salvar Pet</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>