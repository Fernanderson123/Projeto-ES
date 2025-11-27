<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Novo Atendimento - Animal Health Center</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background-color: #fcfaf6; font-family: 'Georgia', serif; }
        .form-card { background: white; padding: 2.5rem; border-radius: 12px; border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.02); }
        label { font-family: sans-serif; font-weight: 600; font-size: 0.9rem; color: #4a4a4a; margin-bottom: 0.4rem; }
        .form-control { border-radius: 8px; padding: 0.6rem 1rem; border: 1px solid #e0e0e0; }
        .form-control:focus { border-color: #a78bfa; box-shadow: 0 0 0 0.2rem rgba(167, 139, 250, 0.25); }
        
        /* Botão Verde para Finalizar */
        .btn-finish { background-color: #198754; border-color: #198754; color: white; font-family: sans-serif; font-weight: bold; border-radius: 8px; }
        .btn-finish:hover { background-color: #157347; color: white; }
        
        .info-box { background-color: #e0f2fe; border-radius: 8px; padding: 15px; margin-bottom: 20px; font-family: sans-serif; color: #0369a1; border-left: 5px solid #0ea5e9; }
        .link-back { color: #1a1a1a; text-decoration: none; font-family: sans-serif; font-weight: 600; display: inline-flex; align-items: center; margin-bottom: 1rem; }
        .navbar-brand { color: #1a1a1a !important; }
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
                    <a class="small text-muted text-decoration-none" href="{{ route('profile.edit') }}">
                        Bem vindo(a) <strong class="text-dark">{{ Auth::user()->name }}</strong>
                    </a>
                    <div class="small text-muted">Perfil: <strong class="text-dark">{{ Auth::user()->perfil }}</strong></div>
                </div>
                <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="btn btn-danger btn-sm">Sair</button></form>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                
                <a href="{{ route('agendamentos.index') }}" class="link-back"><i class="bi bi-arrow-left me-2"></i> Voltar para Agenda</a>
                
                <h2 class="mb-4 text-center" style="font-family: sans-serif;">Registro Clínico</h2>

                <!-- Dados do Agendamento Vinculado -->
                <div class="info-box shadow-sm">
                    <div class="row">
                        <div class="col-md-6"><strong>Paciente:</strong> {{ $agendamento->pet->nome }}</div>
                        <div class="col-md-6"><strong>Dono:</strong> {{ $agendamento->pet->cliente->nome_completo }}</div>
                        <div class="col-md-12 mt-2"><strong>Motivo Agendado:</strong> {{ $agendamento->tipo }} ({{ $agendamento->data_hora->format('d/m/Y H:i') }})</div>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger rounded-3 border-0 mb-4">
                        <ul class="mb-0"> @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach </ul>
                    </div>
                @endif

                <div class="form-card">
                    <form action="{{ route('prontuario.store') }}" method="POST">
                        @csrf
                        
                        <!-- Vínculo Oculto -->
                        <input type="hidden" name="agendamento_id" value="{{ $agendamento->id }}">
                        <input type="hidden" name="pet_id" value="{{ $agendamento->pet_id }}">

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label>Data do Atendimento</label>
                                <input type="date" name="data_atendimento" class="form-control" value="{{ date('Y-m-d') }}" readonly>
                            </div>
                        </div>

                        <h5 class="border-bottom pb-2 mb-3" style="font-family: sans-serif;">Anamnese e Exame Físico</h5>
                        
                        <div class="mb-3">
                            <label>Sintomas / Queixa Principal <span class="text-danger">*</span></label>
                            <textarea name="sintomas" class="form-control" rows="3" placeholder="Descreva os sintomas..." required></textarea>
                        </div>

                        <h5 class="border-bottom pb-2 mb-3 mt-4" style="font-family: sans-serif;">Avaliação Médica</h5>

                        <div class="mb-3">
                            <label>Diagnóstico</label>
                            <textarea name="diagnostico" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Tratamento / Prescrição</label>
                            <textarea name="tratamento" class="form-control" rows="3" placeholder="Medicamentos..."></textarea>
                        </div>

                        <div class="mb-4">
                            <label>Observações Adicionais</label>
                            <textarea name="observacoes" class="form-control" rows="2">{{ $agendamento->observacoes }}</textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-finish py-2 fs-5">
                                <i class="bi bi-check-circle-fill me-2"></i> Finalizar e Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>