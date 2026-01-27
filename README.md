# 🏥 Clínica Veterinária Animal Health Center

## 1. CONTEXTO DO PROBLEMA/SOLUÇÃO

### 1.1. Contexto do Problema (A Dor do Cliente)

Em clínicas veterinárias de pequeno e médio porte, a gestão de informações é frequentemente fragmentada: agendamentos feitos em papel ou planilhas, prontuários armazenados em arquivos físicos, e o controle de estoque de medicamentos realizado manualmente. Essa desorganização resulta em:
1. **Perda de Rastreabilidade:** Dificuldade em cruzar rapidamente o histórico do Pet com o Estoque, gerando erros de dosagem ou falta de insumos essenciais.
2. **Dupla Entrada de Dados:** Recepcionistas e Veterinários repetem informações (cliente, pet, horário) em diferentes sistemas/papéis.
3. **Alto Risco Operacional:** Agendamentos sobrepostos, dificuldade em identificar a validade de medicamentos e lentidão no atendimento ao cliente.

### 1.2. Descrição da Solução

O **Animal Health Center** é um sistema web de gerenciamento projetado para centralizar todas as operações vitais da clínica.

Este sistema web deverá propiciar:
* **Cadastro Integrado:** Gerenciamento centralizado (CRUDs) de Clientes, Pets e Produtos/Medicamentos.
* **Gestão de Fluxo Clínico:** Um módulo de **Agendamento** (CRUD complexo) que vincula o Cliente, o Pet e o Veterinário, garantindo que não haja sobreposição de horários.
* **Controle e Rastreabilidade:** Permite ao **Veterinário** registrar o **Prontuário** (CRUD complexo) do atendimento e, simultaneamente, realizar a **Baixa de Estoque** dos medicamentos utilizados, assegurando um inventário preciso e automatizado.
* **Segurança:** Autenticação obrigatória (Login) para todos os usuários.

---

## 2. INSTRUÇÕES PARA USO (Usuário Final)

O **Animal Health Center** é uma aplicação web. Não há necessidade de instalação; basta acessar a URL e fazer o login.

**Requisitos:**
* Navegador web moderno (Chrome, Firefox, Edge, ou Safari).
* Credenciais de acesso fornecidas pelo Administrador do Sistema.

**Passos para Acesso:**

1.  **Acessar a URL:** Abra seu navegador e acesse o endereço da aplicação (Ex: `https://animalhealthcenter.com.br` ou o endereço local fornecido pela equipe de infraestrutura).
2.  **Login:** Na tela de login ([RF011] - I\_Login), insira seu nome de usuário (e-mail) e senha.
3.  **Navegação:** Após o login, você será direcionado ao Painel Principal (Dashboard) com acesso às funcionalidades conforme seu perfil (Recepcionista, Veterinário, ou Admin).

---

## 3. INSTRUÇÕES PARA DEVS (Ambiente de Desenvolvimento)

Siga as instruções abaixo para preparar o ambiente de desenvolvimento local do projeto.
Este projeto foi configurado para execução local com PHP, Composer e MySQL.

### 3.1. Preparação

Clone o projeto:
Clone o repositório na sua máquina:

git clone https://github.com/seu-usuario/AnimalHealthCenter.git
cd AnimalHealthCenter


Configurar variáveis de ambiente:
Copie o arquivo de exemplo para criar o arquivo de configuração:

copy .env.example .env


(No Linux/Mac: cp .env.example .env)

Configurar o banco de dados no .env:
Edite o arquivo .env e ajuste as configurações do banco MySQL local:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

### 3.2. Criação do Banco de Dados

Utilizando o MySQL local (por exemplo, via Laragon):

Abra o terminal do MySQL:

mysql -u root


Crie o banco de dados:

CREATE DATABASE laravel;


Verifique se o banco foi criado:

SHOW DATABASES;

### 3.3. Instalação e Execução Local

Instalar dependências do projeto:

composer install


Gerar a chave da aplicação Laravel:

php artisan key:generate


Criar as tabelas do banco de dados (migrations):

php artisan migrate


Executar o servidor de desenvolvimento:

php artisan serve


Acessar o sistema:
Abra o navegador e acesse:

http://127.0.0.1:8000

## 4. Tecnologias

O projeto foi desenvolvido utilizando as seguintes tecnologias:

Frontend

HTML5

CSS3

JavaScript

Blade Templates (Laravel)

Backend

PHP 8.2.x

Laravel Framework 12.x

Banco de Dados

MySQL 8.x

Outras Ferramentas

Composer (Gerenciador de dependências PHP)

PHPUnit 10.x (Testes automatizados)


## 5. Estrutura do projeto
   
├── backend/
│   └── src/
│       ├── config/                # Configurações do sistema (env, database, auth, etc.)
│       │   └── database.php
│       │
│       ├── controllers/           # Controllers da aplicação
│       │   ├── AgendamentoController.php
│       │   ├── ClienteController.php
│       │   ├── PetController.php
│       │   ├── ProdutoController.php
│       │   ├── ProntuarioController.php
│       │   ├── RelatorioController.php
│       │   └── Auth/
│       │
│       ├── middleware/            # Middlewares (autenticação, permissões, etc.)
│       │   ├── Authenticate.php
│       │   ├── RedirectIfAuthenticated.php
│       │   └── AdminMiddleware.php
│       │
│       ├── models/                # Modelos e entidades do sistema
│       │   ├── User.php
│       │   ├── Cliente.php
│       │   ├── Pet.php
│       │   ├── Agendamento.php
│       │   ├── Produto.php
│       │   └── Prontuario.php
│       │
│       ├── public/                # Arquivos públicos
│       │   ├── css/
│       │   ├── js/
│       │   └── images/
│       │
│       ├── routes/                # Definição das rotas
│       │   ├── web.php
│       │   └── api.php
│       │
│       └── views/                 # Templates Blade (interface do sistema)
│           ├── auth/
│           ├── clientes/
│           ├── pets/
│           ├── agendamentos/
│           ├── produtos/
│           ├── prontuario/
│           └── dashboard.blade.php
│
├── documentacao/
│   ├── Requisitos/
│   │   ├── requisitos.docx
│   │   └── regras-de-negocio.pdf
│   │
│   └── Diagramas/
│       ├── casos-de-uso/
│       ├── DER/
│       ├── UML/
│       └── BPMN/
│
├── database/
│   ├── migrations/               # Migrations do banco de dados
│   └── seeders/                  # Seeders de dados iniciais
│
├── tests/                         # Testes automatizados
│   ├── Unit/
│   └── Feature/
│
├── .env                           # Variáveis de ambiente
├── .env.example
├── composer.json
├── artisan
└── README.md
