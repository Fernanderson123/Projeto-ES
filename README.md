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

Siga as instruções abaixo para preparar seu ambiente e ser um desenvolvedor do projeto. O projeto utiliza Docker para garantir a consistência do ambiente.

### 3.1. Preparação

1.  **Clone o projeto:** Clone o repositório na sua máquina aplicando o comando:
    ```bash
    git clone [https://...](https://.../pt/what-is/repo/) animalHealthCenter
    cd animalHealthCenter
    ```
2.  **Configurar Variáveis de Ambiente:** Copie o arquivo de exemplo para criar o arquivo de configuração:
    ```bash
    cp .env.example .env
    ```
    *Obs: Edite o arquivo `.env` para configurar as variáveis específicas do ambiente, se necessário.*

### 3.2. Instalação e Execução com Docker (Recomendado)

O Docker simplifica a configuração do ambiente (PHP, Banco de Dados, Web Server).

1.  **Executar o ambiente:** Execute o comando para construir as imagens e iniciar os contêineres:
    ```bash
    docker-compose up --build -d
    ```
2.  **Instalar Dependências e Chave:** Acesse o contêiner PHP e execute a instalação e configuração inicial:
    ```bash
    docker-compose exec app composer install
    docker-compose exec app php artisan key:generate
    ```
3.  **Criar o Banco de Dados:** Execute as migrações para criar as tabelas no banco de dados:
    ```bash
    docker-compose exec app php artisan migrate
    ```
4.  **Acesso:** Em seguida, acesse o navegador e digite a URL: `http://localhost:8080`. Você deverá ver o sistema no seu browser.

### 3.3. Execução Local (Opcional)

Se preferir rodar localmente (assumindo PHP e Composer instalados):

1.  **Instalar dependências:** Execute o comando para instalar as bibliotecas e outras dependências:
    ```bash
    composer install
    ```
2.  **Executar o servidor:** Para executar o projeto, execute o comando na raiz do projeto:
    ```bash
    php artisan serve
    ```
    Em seguida, acesse o browser e digite a URL `http://localhost:8000`.

---

## 4. TECNOLOGIAS

O projeto foi desenvolvido utilizando as seguintes tecnologias:

* **Linguagem:** PHP
* **Framework:** Laravel
* **Frontend:** HTML, CSS, JavaScript puro, e Blade templates
* **Contêineres:** Docker e Docker Compose
* **Testes:** PHPUnit (Unitários e de Caixa-preta)

---

## 5. ORGANIZAÇÃO DO PROJETO

Este projeto está organizado nas pastas descritas abaixo com as seguintes finalidades:

* **`app/`**: Contém o código-fonte principal da aplicação Laravel (Modelos, Controllers, Middleware, etc.).
    * **`app/Models/`**: Definição das classes de dados (Entidades).
    * **`app/Http/Controllers/`**: Lógica de negócio e manipulação de requisições.
* **`resources/`**: Arquivos de *frontend*.
    * **`resources/views/`**: Templates Blade e código HTML.
    * **`resources/css/`**: Arquivos de estilo.
    * **`resources/js/`**: Arquivos JavaScript.
* **`routes/`**: Definição das rotas da aplicação (ex: `web.php`).
* **`public/`**: Contém o `index.php` e os recursos acessíveis publicamente.
* **`tests/`**: Arquivos e scripts de testes automatizados.
    * **`tests/Unit/`**: Testes de classes e métodos isolados.
    * **`tests/Feature/`**: Testes de interface e comportamento (caixa-preta/E2E).
* **`docs/`**: Documentação do projeto, incluindo requisitos e padrões.
    * **`docs/requisitos.docx`**: O documento de especificação de requisitos.
    * **`docs/casos_de_uso/`**: Detalhamento dos casos de uso.
* **`composer.json`**: Definição das dependências do PHP/Laravel.
* **`docker-compose.yml`**: Configuração do ambiente de desenvolvimento com Docker.
