<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Finalizar Atendimento - Animal Health Center</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #fcfaf6; font-family: 'Georgia', serif; }
        .form-card { background: white; padding: 2.5rem; border-radius: 12px; border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.02); }
        label { font-family: sans-serif; font-weight: 600; font-size: 0.9rem; color: #4a4a4a; margin-bottom: 0.4rem; }
        .form-control { border-radius: 8px; padding: 0.6rem 1rem; border: 1px solid #e0e0e0; }
        .form-control:focus { border-color: #a78bfa; box-shadow: 0 0 0 0.2rem rgba(167, 139, 250, 0.25); }
        
        /* Botão Verde para Finalizar */
        .btn-finish { background-color: #198754; border-color: #198754; color: white; font-family: sans-serif; font-weight: bold; border-radius: 8px; }
        .btn-finish:hover { background-color: #157347; color: white; }
        
        .info-box { background-color: #e0f2fe; border-radius: 8px; padding: 20px; margin-bottom: 25px; font-family: sans-serif; color: #0369a1; border-left: 5px solid #0ea5e9; }
    </style>
</head>
<body>

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <h2 class="mb-4 text-center">Finalizar Atendimento</h2>

                <div class="info-box shadow-sm">
                    <div class="row">
                        <div class="col-md-6"><strong>Paciente:</strong> {{ $agendamento->pet->nome }}</div>
                        <div class="col-md-6"><strong>Dono:</strong> {{ $agendamento->pet->cliente->nome_completo }}</div>
                        <div class="col-md-12 mt-2"><strong>Motivo:</strong> {{ $agendamento->tipo }}</div>
                    </div>
                </div>

                <div class="form-card">
                    <form action="{{ route('agendamentos.storeFinalizacao', $agendamento->id) }}" method="POST">
                        @csrf
                        
                        <h5 class="border-bottom pb-2 mb-4" style="font-family: sans-serif;">Registro Clínico Obrigatório</h5>
                        
                        <div class="mb-3">
                            <label>Sintomas / Queixa Principal <span class="text-danger">*</span></label>
                            <textarea name="sintomas" class="form-control" rows="3" required placeholder="Descreva o quadro clínico..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Diagnóstico</label>
                            <textarea name="diagnostico" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Tratamento / Prescrição</label>
                            <textarea name="tratamento" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="mb-4">
                            <label>Observações</label>
                            <textarea name="observacoes" class="form-control" rows="2">{{ $agendamento->observacoes }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('agendamentos.index') }}" class="text-decoration-none text-muted fw-bold">Cancelar</a>
                            <button type="submit" class="btn btn-finish py-2 px-4">
                                Confirmar e Finalizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>