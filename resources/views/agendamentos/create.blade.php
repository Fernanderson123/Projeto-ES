<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Novo Agendamento - Animal Health Center</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <style>
        body { 
            background-color: #fcfaf6; 
            font-family: 'Georgia', serif; 
        }
        .page-title {
            font-family: sans-serif;
            margin-bottom: 1.5rem;
            color: #1a1a1a;
            text-align: center;
        }
        .form-card { 
            background: white; 
            border-radius: 12px; 
            padding: 2.5rem; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.02); 
            border: none; 
            max-width: 700px; 
            margin: 0 auto; 
        }
        .form-label { 
            font-family: sans-serif; 
            font-weight: bold; 
            font-size: 0.9rem; 
            color: #555; 
        }
        .btn-save { 
            background-color: #a78bfa; 
            color: white; 
            border: none; 
            border-radius: 50px; 
            padding: 10px 30px; 
            font-weight: bold; 
            font-family: sans-serif; 
        }
        .btn-save:hover { background-color: #9061f9; color: white; }
        .btn-back { font-family: sans-serif; text-decoration: none; color: #666; margin-right: 15px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-5">
        <div class="container-fluid mx-5">
            <a class="navbar-brand" href="{{ route('dashboard') }}" style="font-family: Georgia, serif; font-size: 1.5rem;">
                Animal Health Center 🐾
            </a>
            <div class="d-flex align-items-center">
                <div class="text-end me-3">
                    <div class="small text-muted">Olá, <strong class="text-dark">{{ Auth::user()->name }}</strong></div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf <button type="submit" class="btn btn-danger btn-sm">Sair</button>
                </form>
            </div>
        </div>
    </nav>
    <div class="container pb-5">
        
        <h2 class="page-title">Novo Agendamento</h2>

        <div class="form-card">
            
            @if ($errors->any())
                <div class="alert alert-danger border-0 rounded-3 mb-4">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-exclamation-octagon-fill fs-4 me-2"></i>
                        <strong class="font-sans">Não foi possível realizar o agendamento:</strong>
                    </div>
                    <ul class="mb-0 font-sans small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('agendamentos.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="pet_id" class="form-label">Paciente (Pet)</label>
                    <select name="pet_id" id="pet_id" class="form-select @error('pet_id') is-invalid @enderror" required>
                        <option value="">Selecione o animal...</option>
                        @foreach($pets as $pet)
                            <option value="{{ $pet->id }}" {{ old('pet_id') == $pet->id ? 'selected' : '' }}>
                                {{ $pet->nome }} ({{ $pet->especie }}) 
                                @if(!Auth::user()->isCliente()) - Tutor: {{ $pet->cliente->nome_completo ?? 'N/A' }} @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="data_hora" class="form-label">Data e Horário</label>
                    <input type="datetime-local" 
                           class="form-control @error('data_hora') is-invalid @enderror" 
                           id="data_hora" 
                           name="data_hora" 
                           value="{{ old('data_hora') }}" 
                           required>
                    <div class="form-text text-muted small font-sans">
                        <i class="bi bi-clock"></i> Funcionamento: 08:00 às 22:00.
                    </div>
                    @error('data_hora')
                        <div class="invalid-feedback fw-bold">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="tipo" class="form-label">Tipo de Serviço</label>
                        <select name="tipo" id="tipo" class="form-select" required>
                            <option value="Consulta" {{ old('tipo') == 'Consulta' ? 'selected' : '' }}>Consulta (1h)</option>
                            <option value="Cirurgia" {{ old('tipo') == 'Cirurgia' ? 'selected' : '' }}>Cirurgia (5h)</option>
                            <option value="Retorno" {{ old('tipo') == 'Retorno' ? 'selected' : '' }}>Retorno (1h)</option>
                            <option value="Exame" {{ old('tipo') == 'Exame' ? 'selected' : '' }}>Exame (1h)</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="veterinario_id" class="form-label">Veterinário</label>
                        <select name="veterinario_id" id="veterinario_id" class="form-select @error('veterinario_id') is-invalid @enderror">
                            <option value="">Qualquer disponível / A definir</option>
                            @foreach($veterinarios as $vet)
                                <option value="{{ $vet->id }}" {{ old('veterinario_id') == $vet->id ? 'selected' : '' }}>
                                    Dr(a). {{ $vet->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text small">Deixe em branco se não tiver preferência.</div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="observacoes" class="form-label">Observações / Motivo</label>
                    <textarea class="form-control" name="observacoes" rows="3" placeholder="Descreva brevemente o motivo...">{{ old('observacoes') }}</textarea>
                </div>

                <div class="text-end">
                    <a href="{{ route('agendamentos.index') }}" class="btn-back">Cancelar</a>
                    <button type="submit" class="btn-save">Agendar</button>
                </div>

            </form>
        </div>
    </div>

</body>
</html>