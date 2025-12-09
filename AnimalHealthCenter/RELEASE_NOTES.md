\#\#\# Notas de Release: Versão 1.0.0 \- Lançamento Inicial (Mês/Ano)

Esta é a primeira versão estável do sistema Animal Health Center.

\#\#\#\# Novas Funcionalidades (Requisitos Funcionais Entregues)

\* \[RF011\]: Sistema de \*\*Autenticação de Usuários\*\* para todos os perfis (Admin, Recepcionista, Veterinário).  
\* \[RF005, RF006\]: \*\*CRUD Completo de Clientes e Pets\*\*.  
\* \[RF001, RF002, RF003, RF004\]: \*\*CRUD e Gestão de Estoque\*\* (Produtos/Medicamentos).  
\* \[RF007, RF008, RF010\]: \*\*Módulo de Agendamento\*\* (Cadastro, Consulta e Remarcação).  
\* \[RF009, RF012\]: \*\*Módulo Inicial de Prontuário\*\* (Registro e Consulta).

\#\#\#\# Problemas Conhecidos

\* A interface do Cliente (Portal do Cliente) não foi implementada; o foco é no uso interno da clínica.  
\* Não há integração com sistemas de pagamento externos ou emissão de Nota Fiscal eletrônica.

| Ação | Perfil | Fluxo de Uso Rápido |
| :---- | :---- | :---- |
| **Login** \[RF011\] | Todos | Acesse https://www.figma.com/design/KUxdRJd97fsoErIDBRxhFx/Trabalho-ES?node-id=4-41\&t=fGXZYlaSvsMixqGC-1. |
| **Agendar Consulta** \[RF007\] | Recepcionista | 1\. Vá para "Agendamentos".  2\. Clique em "Novo Agendamento".  3\. Busque o cliente e selecione o Pet.  4\. Escolha o Veterinário e o horário (o sistema validará a disponibilidade).  5\. Confirme. |
| **Registrar Atendimento** \[RF009\] | Veterinário | 1\. Vá para a Agenda e localize o agendamento em andamento.  2\. Clique em "Iniciar Prontuário".  3\. Preencha Diagnóstico, Tratamento e Observações.  4\. Registre os Medicamentos/Produtos utilizados (o sistema fará a Baixa de Estoque \[RF004\]). 5\. Salve o Prontuário. |

