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

3. INSTRUÇÕES PARA DEVS (Ambiente de Desenvolvimento)

Siga as instruções abaixo para preparar o ambiente de desenvolvimento local do projeto.
Este projeto foi configurado para execução local com PHP, Composer e MySQL.

3.1. Preparação

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

3.2. Criação do Banco de Dados

Utilizando o MySQL local (por exemplo, via Laragon):

Abra o terminal do MySQL:

mysql -u root


Crie o banco de dados:

CREATE DATABASE laravel;


Verifique se o banco foi criado:

SHOW DATABASES;

3.3. Instalação e Execução Local

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

4. TECNOLOGIAS

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

5. ORGANIZAÇÃO DO PROJETO

O projeto segue a estrutura padrão do framework Laravel:

app/
Contém o código-fonte principal da aplicação.

app/Models/: Modelos e entidades do sistema.

app/Http/Controllers/: Controllers e regras de negócio.

resources/
Arquivos de frontend.

resources/views/: Templates Blade.

resources/css/: Estilos.

resources/js/: Scripts JavaScript.

routes/
Definição das rotas da aplicação.

web.php: Rotas web do sistema.

public/
Ponto de entrada da aplicação (index.php) e arquivos públicos.

database/

database/migrations/: Migrations do banco de dados.

database/seeders/: Seeders para dados iniciais.

tests/

tests/Unit/: Testes unitários.

tests/Feature/: Testes de funcionalidades (caixa-preta).

docs/
Documentação do projeto.

requisitos.docx

Casos de uso e diagramas.

composer.json
Gerenciamento de dependências PHP.
