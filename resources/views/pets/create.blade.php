<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Novo Pet - Animal Health Center</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <style>
        body { 
            background-color: #fcfaf6; /* Fundo Bege */
            font-family: 'Georgia', serif; 
        }
        
        /* Títulos */
        h2, h5 { font-family: 'Georgia', serif; color: #1a1a1a; }
        
        /* Card do Formulário */
        .form-card { 
            background: white; 
            padding: 2.5rem; 
            border-radius: 12px; 
            border: none; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.02); 
        }
        
        /* Labels e Inputs */
        label { 
            font-family: sans-serif; 
            font-weight: 600; 
            font-size: 0.9rem; 
            color: #4a4a4a; 
            margin-bottom: 0.4rem;
        }
        .form-control, .form-select {
            border-radius: 8px;
            padding: 0.6rem 1rem;
            border: 1px solid #e0e0e0;
        }
        .form-control:focus, .form-select:focus {
            border-color: #a78bfa;
            box-shadow: 0 0 0 0.2rem rgba(167, 139, 250, 0.25);
        }

        /* Botão Padrão (Cor do Login - Roxo Suave) */
        .btn-custom {
            background-color: #a78bfa; /* Roxo do Login */
            border-color: #a78bfa;
            color: white;
            font-family: sans-serif;
            font-weight: bold;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .btn-custom:hover {
            background-color: #9061f9; /* Roxo mais escuro no hover */
            border-color: #9061f9;
            color: white;
        }

        /* Link de Voltar */
        .link-back {
            color: #1a1a1a;
            text-decoration: none;
            font-family: sans-serif;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        .link-back:hover { color: #666; }
        
        /* Header Styles */
        .navbar-brand { color: #1a1a1a !important; }
    </style>
</head>
<body>

    <!-- Header Padronizado -->
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
            <div class="col-lg-8">
                
                <!-- Link de Voltar -->
                <a href="{{ route('pets.index') }}" class="link-back">
                    <i class="bi bi-arrow-left me-2"></i> Voltar para Lista de Pets
                </a>

                <h2 class="mb-4 text-center">Cadastrar Novo Pet</h2>

                <!-- Alerta de Erros -->
                @if ($errors->any())
                    <div class="alert alert-danger rounded-3 border-0 mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-card">
                    <form action="{{ route('pets.store') }}" method="POST">
                        @csrf

                        <!-- Seleção do Dono -->
                        <div class="mb-4">
                            <label class="form-label">Dono (Cliente) <span class="text-danger">*</span></label>
                            <select name="cliente_id" class="form-select" required>
                                <option value="" selected disabled>Selecione o cliente...</option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->nome_completo }} (CPF: {{ $cliente->cpf }})</option>
                                @endforeach
                            </select>
                            <div class="form-text ms-1 text-muted small">O pet será vinculado a este cliente.</div>
                        </div>

                        <h5 class="border-bottom pb-2 mb-4">Dados do Animal</h5>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nome do Pet <span class="text-danger">*</span></label>
                                <input type="text" name="nome" class="form-control" placeholder="Ex: Rex" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Espécie <span class="text-danger">*</span></label>
                                <select name="especie" class="form-select" required>
                                    <option value="" selected disabled>Selecione...</option>
                                    <option value="Cachorro">Cachorro</option>
                                    <option value="Gato">Gato</option>
                                    <option value="Pássaro">Pássaro</option>
                                    <option value="Outro">Outro</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Raça</label>
                                <input type="text" name="raca" class="form-control" placeholder="Ex: Labrador">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Peso (kg)</label>
                                <input type="number" step="0.01" name="peso" class="form-control" placeholder="0.00">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Data Nascimento</label>
                                <input type="date" name="data_nascimento" class="form-control">
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-custom py-2 fs-5">Salvar Cadastro</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>