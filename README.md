# Clínica Veterinária Animal Health Center — Projeto Final

Sistema web para gerenciamento de uma clínica veterinária (agendamento, cadastro de clientes e pets, controle de estoque e prontuários, além de autenticação de usuários). 
O sistema será simples, funcional e atenderá a todos os requisitos do trabalho: login obrigatório, CRUDs simples e CRUDs envolvendo múltiplas tabelas, além de testes unitários e de caixa-preta automatizados.


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
