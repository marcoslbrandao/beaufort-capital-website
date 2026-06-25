# Beaufort 2026 — Tema WordPress

Tema custom para [beaufortcapital.co.uk](https://www.beaufortcapital.co.uk), substituindo o site estático atual.

## Estrutura

```
beaufort-2026/
├── style.css              ← cabeçalho obrigatório do tema (nome, versão)
├── functions.php          ← carrega CSS/JS, registra menus e CPTs
├── header.php             ← <head> + navegação
├── footer.php             ← rodapé, contato, disclaimer legal
├── front-page.php         ← template da HOME PAGE (já puxa Transactions do painel)
├── index.php              ← template de fallback obrigatório
├── inc/
│   ├── cpt-transactions.php   ← Custom Post Type "Transaction"
│   └── cpt-news.php           ← Custom Post Type "News"
└── assets/
    ├── css/main.css        ← todo o estilo visual (navy + gold)
    └── js/main.js          ← interações futuras
```

## Por que Custom Post Types?

Hoje, cada transação ("54-unit retirement scheme", etc.) é HTML fixo no
código do site. Com o CPT `transaction`, isso passa a ser conteúdo
gerenciável pelo painel do WordPress (wp-admin → Transactions → Add New),
sem precisar editar código a cada novo negócio fechado. O mesmo vale
para `beaufort_news`.

## Status atual (draft inicial)

- [x] Esqueleto do tema
- [x] Home page com layout do draft aprovado (navy + gold, "deal tape")
- [x] CPT Transactions conectado à home page
- [x] CPT News (ainda sem template de listagem)
- [ ] Páginas internas: About Us, Team, ESG, Products, Asset Classes
- [ ] Página de Transactions (arquivo `archive-transaction.php`)
- [ ] Migração de conteúdo do site atual
- [ ] ACF (Advanced Custom Fields) para campos como Asset Class, Location, GDV
- [ ] Formulário de contato (ex: Contact Form 7 ou Gravity Forms)
- [ ] Integração da newsletter com Mailchimp (eepurl.com/dCxwv5)

## Próximos passos no seu ambiente local

1. Instalar WordPress localmente (sugestão: Local by Flywheel — mais
   simples para começar)
2. Copiar esta pasta para `wp-content/themes/beaufort-2026`
3. Ativar o tema no painel (Aparência → Temas)
4. Criar os menus em Aparência → Menus (Primary e Footer)
5. Cadastrar 2-3 Transactions de teste para ver a home funcionando

## Workflow Git/GitHub

```bash
# dentro da pasta beaufort-2026
git init
git add .
git commit -m "Initial theme skeleton"
git branch -M main
git remote add origin <URL do repositório no GitHub>
git push -u origin main
```
