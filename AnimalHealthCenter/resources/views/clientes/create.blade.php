<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Novo Cliente - Animal Health Center</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <style>
        body { background-color: #fcfaf6; font-family: 'Georgia', serif; }
        .form-card { background: white; padding: 2.5rem; border-radius: 12px; border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.02); }
        label { font-family: sans-serif; font-weight: 600; font-size: 0.9rem; color: #4a4a4a; margin-bottom: 0.4rem; }
        .form-control { border-radius: 8px; padding: 0.6rem 1rem; border: 1px solid #e0e0e0; }
        .form-control:focus { border-color: #a78bfa; box-shadow: 0 0 0 0.2rem rgba(167, 139, 250, 0.25); }
        .btn-custom { background-color: #a78bfa; border-color: #a78bfa; color: white; font-family: sans-serif; font-weight: bold; border-radius: 8px; transition: all 0.2s; }
        .btn-custom:hover { background-color: #9061f9; color: white; }
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
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Sair</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                
                <a href="{{ route('clientes.index') }}" class="link-back">
                    <i class="bi bi-arrow-left me-2"></i> Voltar para Clientes
                </a>

                <h2 class="mb-4 text-center" style="font-family: sans-serif;">Cadastrar Novo Cliente</h2>

                @if ($errors->any())
                    <div class="alert alert-danger rounded-3 border-0 mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-card">
                    <form action="{{ route('clientes.store') }}" method="POST">
                        @csrf

                        <h5 class="border-bottom pb-2 mb-4" style="font-family: sans-serif;">Informações Pessoais</h5>
                        
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label class="form-label">Nome Completo <span class="text-danger">*</span></label>
                                <!-- CORREÇÃO: Apenas old('nome_completo') -->
                                <input type="text" name="nome_completo" class="form-control" value="{{ old('nome_completo') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">CPF <span class="text-danger">*</span></label>
                                <!-- CORREÇÃO: Apenas old('cpf') -->
                                <input type="text" name="cpf" class="form-control" value="{{ old('cpf') }}" required maxlength="14" oninput="mascaraCPF(this)" placeholder="000.000.000-00">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Telefone</label>
                                <input type="text" name="telefone" class="form-control" value="{{ old('telefone') }}" oninput="mascaraTelefone(this)" placeholder="(00) 00000-0000">
                            </div>
                        </div>

                        <h5 class="border-bottom pb-2 mb-4 mt-5" style="font-family: sans-serif;">Endereço</h5>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">CEP</label>
                                <input type="text" name="endereco_cep" class="form-control" value="{{ old('endereco_cep') }}" maxlength="9" oninput="mascaraCEP(this)">
                            </div>
                            <div class="col-md-7">
                                <label class="form-label">Rua</label>
                                <input type="text" name="endereco_rua" class="form-control" value="{{ old('endereco_rua') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Nº</label>
                                <input type="text" name="endereco_numero" class="form-control" value="{{ old('endereco_numero') }}">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Bairro</label>
                                <input type="text" name="endereco_bairro" class="form-control" value="{{ old('endereco_bairro') }}">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Cidade</label>
                                <input type="text" name="endereco_cidade" class="form-control" value="{{ old('endereco_cidade') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">UF</label>
                                <input type="text" name="endereco_estado" class="form-control" maxlength="2" value="{{ old('endereco_estado') }}" style="text-transform: uppercase;">
                            </div>
                        </div>

                        <div class="d-grid pt-3">
                            <button type="submit" class="btn btn-custom py-2 fs-5">Salvar Cliente</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPTS DE MÁSCARA -->
    <script>
        function mascaraCPF(i) {
            var v = i.value;
            if(isNaN(v[v.length-1])){ i.value = v.substring(0, v.length-1); return; }
            i.setAttribute("maxlength", "14");
            if (v.length == 3 || v.length == 7) i.value += ".";
            if (v.length == 11) i.value += "-";
        }
        function mascaraTelefone(i) {
            var v = i.value;
            if(isNaN(v[v.length-1])){ i.value = v.substring(0, v.length-1); return; }
            i.setAttribute("maxlength", "15");
            if (v.length == 1) i.value = "(" + i.value;
            if (v.length == 3) i.value += ") ";
            if (v.length == 10) i.value += "-";
        }
        function mascaraCEP(i) {
            var v = i.value;
            if(isNaN(v[v.length-1])){ i.value = v.substring(0, v.length-1); return; }
            i.setAttribute("maxlength", "9");
            if (v.length == 5) i.value += "-";
        }
    </script>

</body>
</html>