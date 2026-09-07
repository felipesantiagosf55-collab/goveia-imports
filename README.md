# Goveia Imports

Catálogo online de iPhones desenvolvido em **PHP puro com arquitetura MVC**, HTML, CSS e JavaScript. O fechamento de pedidos é feito via **WhatsApp**, sem checkout ou pagamento online.

> Projeto em desenvolvimento contínuo — este README é atualizado conforme novas funcionalidades são adicionadas.

## Visão geral

O site foi desenvolvido priorizando o uso em dispositivos mobile, pois a Goveia Imports trabalha diretamente com a divulgação do site pelo Instagram.

O site apresenta os produtos por seção decrescente, exibindo primeiro iPhone 17, iPhone 16, iPhone 15...

No mobile, cada linha possui sua própria seção com rolagem horizontal de cards, informações do aparelho, preço e botão de compra, com bolinhas indicadoras logo abaixo para melhorar a navegação em dispositivos móveis.

Em desktop não aparecem as bolinhas indicadoras: os aparelhos são organizados em uma grade que se ajusta automaticamente à largura da tela, dividida por linha.

O painel administrativo permite:

- autenticar usuários com senha protegida por bcrypt;
- cadastrar produtos com upload de imagens;
- extrair automaticamente a linha do iPhone a partir do modelo;
- visualizar a quantidade de produtos por linha;
- filtrar o estoque instantaneamente;
- excluir produtos e suas respectivas imagens.

## Tecnologias

- PHP 8.1+ (testado com PHP 8.2 no ambiente Docker local)
- MySQL 8
- PDO com prepared statements
- Apache e `.htaccess`
- Docker e Docker Compose
- HTML, CSS e JavaScript
- Composer com autoload PSR-4

## Arquitetura

```text
app/
├── Contracts/       Interfaces dos repositórios
├── Controllers/     Entrada das requisições e escolha das views
├── Core/            Router, configuração, ambiente, banco e sessão
├── Migrations/      Estrutura e atualização do banco
├── Models/          Representações tipadas dos dados
├── Repositories/    Única camada com SQL/PDO
├── Seeders/         Dados iniciais para desenvolvimento
├── Services/        Regras de negócio, autenticação e uploads
└── Views/           Templates PHP da aplicação
```

O fluxo principal é:

```text
Requisição → Router → Controller → Service/Repository → View
```

## Como executar localmente

### Pré-requisitos

- Docker Desktop
- Docker Compose
- Git

### Instalação

Clone o projeto e entre na pasta:

```bash
git clone https://github.com/SEU_USUARIO/goveia-imports.git
cd goveia-imports
```

Crie o arquivo de ambiente a partir do modelo:

```bash
cp .env.example .env
```

No PowerShell, use:

```powershell
Copy-Item .env.example .env
```

Suba a aplicação:

```bash
docker compose up --build -d
```

Inicialize o schema e os dados de demonstração:

```bash
docker compose exec app php migrate.php
docker compose exec app php seed.php
```

Abra no navegador:

```text
http://localhost:8080
```

## Variáveis de ambiente

| Variável | Descrição |
| --- | --- |
| `APP_ENV` | Ambiente da aplicação (`local`, `production`) |
| `DB_HOST` | Host do banco de dados MySQL |
| `DB_PORT` | Porta do MySQL (padrão `3306`) |
| `DB_NAME` | Nome do banco de dados |
| `DB_USER` | Usuário do banco de dados |
| `DB_PASSWORD` | Senha do banco de dados |

## Acesso administrativo local

Depois de executar o seed:

```text
URL: http://localhost:8080/admin/login
Usuário: admin
Senha: admin123
```

Essas credenciais são apenas para desenvolvimento local. Altere-as antes de qualquer uso real.

## Rotas principais

| Rota | Método | Função |
| --- | --- | --- |
| `/` | GET | Catálogo público |
| `/admin/login` | GET | Formulário de login |
| `/admin/login` | POST | Autenticação |
| `/admin` | GET | Painel administrativo protegido |
| `/admin/products` | POST | Cadastro de produto |
| `/admin/products/delete` | POST | Exclusão de produto |
| `/admin/logout` | GET | Encerramento da sessão |

## Segurança

- Credenciais são carregadas pelo `.env` e não ficam hardcoded no PHP.
- `.env` está protegido pelo `.gitignore` e pelo `.htaccess`.
- Senhas são armazenadas com `password_hash()` e verificadas com `password_verify()`.
- Queries usam `PDO::prepare()` e parâmetros nomeados.
- Dados de entrada recebem limpeza com `strip_tags()` antes de serem persistidos.
- Dados exibidos nas views passam por `htmlspecialchars()`.
- Uploads aceitam somente imagens JPG, JPEG, PNG e WEBP.
- Rotas administrativas exigem sessão autenticada.

## Implantação em produção

- Nunca deixe `seed.php` ou `migrate.php` acessíveis publicamente depois de usados uma vez — apague-os do servidor após a configuração inicial.
- Troque a senha padrão do usuário `admin` (gerando um novo hash com `password_hash()`) antes de entregar o site ao cliente.
- Confirme que o `.htaccess` foi enviado ao servidor e bloqueia o acesso direto a arquivos ocultos (`.env` incluso).
- Configure o `.env` de produção com as credenciais reais do banco de dados da hospedagem.
- Confirme que a hospedagem oferece PHP 8.1 ou superior antes de publicar.

## Arquivos importantes

- [`index.php`](index.php): front controller da aplicação.
- [`app/Core/Router.php`](app/Core/Router.php): definição das rotas.
- [`app/Services/ProductService.php`](app/Services/ProductService.php): validação e extração da linha do iPhone.
- [`app/Repositories/ProductRepository.php`](app/Repositories/ProductRepository.php): consultas e agrupamento do catálogo.
- [`app/Views/home.php`](app/Views/home.php): catálogo público.
- [`app/Views/admin_dashboard.php`](app/Views/admin_dashboard.php): painel de estoque.
- [`docker-compose.yml`](docker-compose.yml): ambiente PHP + MySQL.

## Licença

Projeto privado — uso interno da Goveia Imports. Sem licença de distribuição pública definida.