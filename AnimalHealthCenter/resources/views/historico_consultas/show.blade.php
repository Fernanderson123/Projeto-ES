<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Detalhes da Consulta - Animal Health Center</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #fcfaf6; font-family: 'Georgia', serif; }
        .details-card { background: white; border-radius: 12px; padding: 3rem; box-shadow: 0 4px 15px rgba(0,0,0,0.03); max-width: 800px; margin: 3rem auto; }
        .page-header { text-align: center; margin-bottom: 2.5rem; border-bottom: 1px solid #eee; padding-bottom: 1.5rem; }
        .page-title { font-family: sans-serif; font-weight: bold; color: #333; margin: 0; }
        .page-subtitle { color: #888; font-family: sans-serif; margin-top: 5px; }
        
        .info-label { font-family: sans-serif; font-size: 0.8rem; text-transform: uppercase; color: #000000ff; font-weight: bold; letter-spacing: 1px; margin-bottom: 5px; }
        .info-content { font-family: sans-serif; font-size: 1.05rem; color: #333; line-height: 1.6; background: #fcfaf6; padding: 15px; border-radius: 8px; border: 1px solid #f0f0f0; }
        
        .btn-back { background-color: #6c757d; color: white; border-radius: 50px; padding: 10px 35px; text-decoration: none; font-family: sans-serif; font-weight: 500; transition: 0.2s; }
        .btn-back:hover { background-color: #555; color: white; }
    </style>
</head>
<body>

    <div class="container">
        <div class="details-card">
            
            <div class="page-header">
                <h2 class="page-title">Relatório de Consulta</h2>
                <div class="page-subtitle">Realizada em {{ $consulta->data_atendimento->format('d de F, Y') }} às {{ $consulta->data_atendimento->format('H:i') }}</div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="info-label">Paciente</div>
                    <div class="fw-bold fs-5">{{ $consulta->pet->nome }}</div>
                    <div class="text-muted small">{{ $consulta->pet->raca }}</div>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="info-label">Veterinário Responsável</div>
                    <div class="fw-bold">{{ $consulta->veterinario->name ?? 'Não informado' }}</div>
                </div>
            </div>

            <div class="mb-4">
                <div class="info-label">Queixa Principal / Sintomas</div>
                <div class="info-content">
                    {{ $consulta->sintomas }}
                </div>
            </div>

            <div class="mb-4">
                <div class="info-label">Diagnóstico</div>
                <div class="info-content" style="border-left: 4px solid #a78bfa;">
                    {{ $consulta->diagnostico }}
                </div>
            </div>

            <div class="mb-5">
                <div class="info-label">Tratamento Prescrito</div>
                <div class="info-content">
                    {{ $consulta->tratamento }}
                </div>
            </div>

            @if($consulta->observacoes)
            <div class="mb-5">
                <div class="info-label">Observações</div>
                <div class="text-muted fst-italic font-sans">
                    "{{ $consulta->observacoes }}"
                </div>
            </div>
            @endif

            <div class="text-center mt-5">
                <a href="{{ route('historico_consultas.index') }}" class="btn-back">Voltar ao Histórico</a>
            </div>

        </div>
    </div>

</body>
</html>