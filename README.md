# Clínica Veterinária Animal Health Center — Projeto Final

Sistema web para gerenciamento de uma clínica veterinária (agendamento, cadastro de clientes e pets, controle de estoque e prontuários, além de autenticação de usuários). 
O sistema será simples, funcional e atenderá a todos os requisitos do trabalho: login obrigatório, CRUDs simples e CRUDs envolvendo múltiplas tabelas, além de testes unitários e de caixa-preta automatizados.

teste samuel

animalHealthCenter/

├─ README.md

├─ composer.json

├─ .env.example

├─ Dockerfile

├─ docker-compose.yml

├─ public/

│ └─ index.php

├─ app/

│ ├─ Models/

│ ├─ Http/Controllers/

│ ├─ Http/Middleware/

│ └─ Providers/

├─ resources/

│ ├─ views/ # HTML + Blade templates

│ ├─ css/

│ └─ js/

├─ routes/

│ └─ web.php

├─ tests/

│ ├─ Unit/

│ └─ Feature/ # testes de interface e comportamento

└─ docs/

├─ requisitos.docx (ou .md)



├─ padroes_adotados/regras_verificacao.md

├─ prototipo_interfaces.pdf

└─ casos_de_uso/

Como rodar (desenvolvimento)
✅ Usando PHP/Laravel localmente

Instale o Composer (https://getcomposer.org/)

Clone o repositório e entre na pasta do projeto

Execute:
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
O sistema estará disponível em http://localhost:8000


🐳 Com Docker
docker-compose up --build
A aplicação rodará em http://localhost:8080

Testes
Unitários: php artisan test ou vendor/bin/phpunit
E2E / caixa-preta: scripts no diretório tests/Feature ou via Selenium (tests/e2e)

Observações finais

O design será simples (HTML/CSS/JS puro ou Blade templates), priorizando funcionalidade e rastreabilidade dos requisitos.

Todas as issues do backlog deverão usar identificadores RFxx/RNFxx no título para rastreabilidade.

O projeto deve conter pelo menos:

Um CRUD simples (ex: produtos ou clientes)

Um CRUD complexo (envolvendo pets, donos e agendamentos)

Sistema de login

Scripts de teste automatizado










