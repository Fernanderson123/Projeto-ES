# 📌 Padrão de Commits

> Históricos limpos, previsíveis e fáceis de revisar.

---

## 🧱 Formato

```txt
tipo(escopo): descrição breve no imperativo

    tipo: uma das categorias abaixo

    escopo (opcional): módulo/pasta/contexto (api, auth, frontend…)

    descrição: curta, direta, no imperativo

        Ex.: corrigir, adicionar, ajustar, remover, atualizar

Exemplos

feat(auth): adicionar fluxo de recuperação de senha
fix(api): corrigir cálculo do total de pedidos
docs(readme): atualizar instruções de deploy

🎯 Tipos de Commit

Tipo	Quando usar	Impacto semântico

feat	    Novo recurso / funcionalidade	MINOR
fix	        Correção de bug	PATCH
docs	    Documentação (README, guias, comentários relevantes)	—
style	    Formatação (identação, aspas, espaços, imports)	—
refactor	Refatoração sem mudar comportamento	—
perf	    Melhorias de desempenho	—
test	    Adição/ajuste de testes (unit, integration, e2e)	—
build	    Build, dependências, Docker, bundlers	—
ci	        Pipelines de CI/CD	—
chore	    Manutenção geral (scripts, limpeza, configs internas)	—
revert	    Reverter um commit anterior	

---

✅ Boas práticas

    Descrição sempre no imperativo e em uma linha:

        ✅ ajustar validação de CPF

        ❌ ajustei validação de CPF

    Um commit = uma mudança lógica.

    Use escopo quando ajudar a localizar o contexto:

        feat(auth), fix(order), refactor(core)…

    Evite misturar feat com fix ou refactor no mesmo commit.

---

💡 Exemplos rápidos

feat(user): adicionar cadastro de usuário com confirmação de e-mail
fix(order): corrigir cálculo de frete para região sudeste
docs(api): documentar endpoints de relatório financeiro
style(frontend): padronizar uso de aspas simples
refactor(service): extrair lógica de envio de e-mail
perf(report): otimizar consulta de relatórios mensais
test(auth): adicionar testes para fluxo de login social
build: atualizar dependências do projeto
ci: adicionar etapa de testes de integração no pipeline
chore: remover arquivos temporários do repositório
revert: revert "feat(auth): adicionar login social"

---


Todos os colaboradores devem seguir este padrão ao criar commits.