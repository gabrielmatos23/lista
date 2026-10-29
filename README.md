# Doce Gestão

Aplicação didática em Laravel para administrar produtos, clientes, pedidos e fretes de uma confeitaria. O projeto usa SQLite, PHPUnit e Cypress.

## Requisitos

- PHP 8.3 ou superior, com as extensões padrão do Laravel e `pdo_sqlite` habilitada.
- Composer.
- Node.js e npm para os testes Cypress.

## Preparar o ambiente

Na primeira execução, a partir da pasta do projeto:

```powershell
composer install
php artisan key:generate
php artisan migrate:fresh --seed
npm install
```

O banco local fica em `database/database.sqlite`. O seeder cria produtos e clientes de exemplo, incluindo mais de dez produtos para exercitar a paginação.

## Iniciar a aplicação

```powershell
php artisan serve --host=127.0.0.1 --port=8000
```

Abra `http://localhost:8000` no navegador.

### Alternativa com Docker Compose

Com Docker Desktop instalado e ativo, rode no Git Bash ou WSL:

```sh
bash docker/install.sh
bash docker/start.sh
```

Para executar a preparação do banco via contêiner antes da suíte Cypress, defina `CYPRESS_DOCKER=1`. No PowerShell:

```powershell
$env:CYPRESS_DOCKER = '1'
npm run cy:run
```

## Executar os testes

```powershell
php artisan test
npm run cy:open
```

Para rodar o Cypress em modo headless:

```powershell
npm run cy:run
```

Os comandos `cy:open` e `cy:run` removem `ELECTRON_RUN_AS_NODE` apenas do processo Cypress, caso o IDE tenha definido essa variável.

A configuração Cypress executa a preparação do banco uma vez antes da suíte e também disponibiliza a task `db:fresh:seed`. Ela recria o SQLite local e aplica os dados de exemplo para manter os cenários previsíveis. Por padrão usa PHP local; com `CYPRESS_DOCKER=1`, executa `docker compose exec -T app php artisan migrate:fresh --seed`.

## Módulos

- **Produtos:** cadastro, edição, exclusão, paginação e alerta de estoque baixo.
- **Clientes:** cadastro, edição e exclusão com contato e endereço.
- **Pedidos:** associação de cliente e produto, cálculo do total, validação de estoque e baixa automática dentro de transação.
- **Fretes:** pedido associado, endereço, taxa, previsão, rastreio e atualização de status.

Os seletores `data-cy` ficam nas views Blade para que os testes Cypress não dependam de classes de estilo.
