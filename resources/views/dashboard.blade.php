<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Animal Health Center</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fcfaf6;
            font-family: Arial, sans-serif;
        }
        .navbar-brand, h1, h2 {
            font-family: Georgia, serif;
        }
        .dashboard-button {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 120px; /* Tamanho fixo para os botões */
            text-align: center;
            font-weight: bold;
            font-size: 1.25rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
            text-decoration: none; /* Remover sublinhado */
            color: #343a40; /* Cor do texto padrão */
        }
        .dashboard-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
            text-decoration: none;
        }
        /* Cores dos botões conforme os protótipos */
        .btn-green { background-color: #d4edda; border-color: #c3e6cb; } /* Produtos, Pets, Histórico */
        .btn-purple { background-color: #e0daef; border-color: #d1c7e6; } /* Medicamentos, Prontuário */
        .btn-orange { background-color: #ffeeba; border-color: #ffda6e; } /* Gerenciar, Agendamentos, Relatórios */
        .btn-red { background-color: #f8d7da; border-color: #f5c6cb; } /* Clientes */

        /* Nova cor para o botão "Gerenciar" do Administrador (Protótipo 1) */
        .btn-admin-manage { background-color: #fff3cd; border-color: #ffeeba; }
        /* Nova cor para o botão "Relatórios" do Administrador (Protótipo 1) */
        .btn-admin-reports { background-color: #fce4b3; border-color: #fcd489; }
        /* Nova cor para o botão "Clientes" da Recepcionista (Protótipo 2) */
        .btn-receptionist-clients { background-color: #f8d7da; border-color: #f5c6cb; }
        /* Nova cor para o botão "Agendamentos" da Recepcionista e Veterinário (Protótipo 2 e 3) */
        .btn-appointment { background-color: #fff3cd; border-color: #ffeeba; }
        /* Nova cor para o botão "Prontuário" da Recepcionista e Veterinário (Protótipo 2 e 3) */
        .btn-medical-record { background-color: #e0daef; border-color: #d1c7e6; }
        /* Nova cor para o botão "Relatórios" do Investidor (Protótipo 4) */
        .btn-investor-reports { background-color: #fce4b3; border-color: #fcd489; }
        /* Nova cor para o botão "Histórico de Consultas" do Cliente (Protótipo 5) */
        .btn-client-history { background-color: #d4edda; border-color: #c3e6cb; }


    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid mx-5">
            <a class="navbar-brand" href="{{ route('dashboard') }}" style="font-family: Georgia, serif; font-size: 1.5rem;">
                Animal Health Center 🐾
            </a>
            <div class="d-flex align-items-center">
                <div class="text-end me-3">
                    <a class="small text-muted" href="{{ route('profile.edit') }}">Bem vindo(a) <strong class="text-dark">{{ Auth::user()->name }}</strong></a>
                    <div class="small text-muted">Perfil: <strong class="text-dark">{{ Auth::user()->perfil }}</strong></div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Sair</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container d-flex flex-grow-1 justify-content-center align-items-center">
        <div class="row w-100 justify-content-center">
            <div class="col-md-8 col-lg-6">

                {{-- Mensagens de sucesso/erro --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sucesso!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Erro!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="grid-container">
                    {{-- Botões do Dashboard conforme o perfil --}}
                    <div class="row row-cols-1 row-cols-sm-2 g-4 justify-content-center">

                        @if (Auth::user()->perfil === 'Admin')
                            {{-- Administrador --}}
                            <div class="col"><a href="{{ route('produtos.index') }}" class="dashboard-button btn-green">Produtos</a></div>
                            <div class="col"><a href="{{ route('admin.users.index') }}" class="dashboard-button btn-admin-manage">Gerenciar</a></div>
                            <div class="col"><a href="{{ route('relatorios.index') }}" class="dashboard-button btn-admin-reports">Relatórios</a></div>
                        @elseif (Auth::user()->perfil === 'Recepcionista')
                            {{-- Recepcionista --}}
                            <div class="col"><a href="{{ route('clientes.index') }}" class="dashboard-button btn-receptionist-clients">Clientes</a></div>
                            <div class="col"><a href="{{ route('pets.index') }}" class="dashboard-button btn-green">Pets</a></div>
                            <div class="col"><a href="{{ route('agendamentos.index') }}" class="dashboard-button btn-appointment">Agendamentos</a></div>
                            <div class="col"><a href="{{ route('prontuario.index') }}" class="dashboard-button btn-medical-record">Prontuário</a></div>
                        @elseif (Auth::user()->perfil === 'Veterinário')
                            {{-- Veterinário --}}
                            <div class="col"><a href="{{ route('produtos.index') }}" class="dashboard-button btn-green">Produtos</a></div>
                            <div class="col"><a href="{{ route('agendamentos.index') }}" class="dashboard-button btn-appointment">Agendamentos</a></div>
                            <div class="col"><a href="{{ route('prontuario.index') }}" class="dashboard-button btn-medical-record">Prontuário</a></div>
                        @elseif (Auth::user()->perfil === 'Investidor')
                            {{-- Investidor --}}
                            <div class="col"><a href="{{ route('relatorios.index') }}" class="dashboard-button btn-investor-reports">Relatórios</a></div>
                        @elseif (Auth::user()->perfil === 'Cliente')
                            {{-- Cliente --}}
                            <div class="col"><a href="{{ route('agendamentos.index') }}" class="dashboard-button btn-appointment">Agendamentos</a></div>
                            <div class="col"><a href="{{ route('historico_consultas.index') }}" class="dashboard-button btn-client-history">Histórico de consultas</a></div>
                        @else
                            {{-- Perfil Desconhecido / Padrão --}}
                            <div class="col-12 text-center text-muted">Bem-vindo(a) {{ Auth::user()->name }}! Seu perfil não tem botões configurados.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>