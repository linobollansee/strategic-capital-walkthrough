# Strategic Capital Walkthrough

Strategic Capital Walkthrough is a Symfony application that presents a formal investment-planning scenario for financial portfolios. The project is structured as a concise walkthrough: it explains the framework, shows an allocation model, documents execution controls, and includes the infrastructure required to move the concept toward persisted data.

## At a glance

- Framework: Symfony 8 (packages at ~8.0.11)
- Recommended PHP runtime (composer platform): 8.5.6
- Database: MySQL 9.7 (containerized by the included Docker Compose)
- Tests: PHPUnit 12

The application renders a portfolio walkthrough on the homepage and stores portfolio, allocation, and snapshot records via Doctrine ORM and migrations.

## Quick start (recommended: Docker)

1. Build and start the stack:

```powershell
docker compose up -d --build
```

2. Install dependencies and run migrations inside the PHP container:

```powershell
docker compose exec php composer install
docker compose exec php php bin/console doctrine:migrations:migrate --no-interaction
docker compose exec php php bin/console doctrine:fixtures:load --no-interaction
```

3. Open the app at: http://localhost:8080

Ports:
- `8080` → Nginx (public web)
- `3306` → MySQL (mapped for convenience)

Default database credentials (from `docker-compose.yml`):

- DB name: `investment_walkthrough`
- User: `investment_user`
- Password: `investment_password`
- Root password: `root_password`

## Native setup (no Docker)

1. Copy the env file and adjust `DATABASE_URL` to your local MySQL instance:

```powershell
Copy-Item .env .env.local
```

2. Ensure PHP 8.5+, Composer, and the `pdo_mysql` extension are available.

3. Install dependencies and prepare the database:

```powershell
composer install
php bin/console doctrine:database:create --if-not-exists
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console doctrine:fixtures:load --no-interaction
php -S 127.0.0.1:8000 -t public
```

If you have the Symfony CLI, `symfony server:start` is a convenient alternative to the built-in server.

## Database migrations

This project includes Doctrine Migrations to evolve the schema. Current migration files:

- `migrations/Version20260519000000.php` — creates the `investment_snapshot` table used for recording review snapshots.
- `migrations/Version20260519000001.php` — adds `portfolio`, `investment_type`, and `allocation` tables and refactors `investment_snapshot` to reference `portfolio`.

Run migrations with:

```powershell
php bin/console doctrine:migrations:migrate --no-interaction
```

## Data fixtures

Fixtures are provided to populate sample portfolios and allocations for the walkthrough. The main fixture class is `src/DataFixtures/PortfolioFixtures.php`, which:

- Registers several `InvestmentType` entities (core equity, bonds, cash, alternatives, tactical).
- Creates a `Strategic Core Portfolio` and a `Conservative Portfolio` with allocations and `InvestmentSnapshot` records.

Load fixtures with:

```powershell
php bin/console doctrine:fixtures:load --no-interaction
```

## Running tests

Run the PHPUnit test suite:

```powershell
docker compose exec php php bin/phpunit
```

Or locally after installing dev dependencies:

```powershell
composer test
```

The test suite includes a `HomeControllerTest` that verifies the homepage responds successfully and renders the portfolio narrative.

## Useful console commands

- Clear cache: `php bin/console cache:clear`
- Migrations status: `php bin/console doctrine:migrations:status`
- Create database: `php bin/console doctrine:database:create --if-not-exists`

## Project structure (high level)

- `src/Controller/HomeController.php` — renders the walkthrough page and prepares portfolio data for the view.
- `src/DataFixtures/PortfolioFixtures.php` — sample portfolios, allocations, and snapshots.
- `src/Entity/` — domain entities: `Portfolio`, `Allocation`, `InvestmentType`, `InvestmentSnapshot`.
- `templates/` — Twig templates for the walkthrough UI.
- `migrations/` — Doctrine migration classes.
- `docker/` and `docker-compose.yml` — container definitions for PHP, Nginx, and MySQL.

## Notes

- Composer is configured with a `platform.php` setting of `8.5.6` to standardize dependency resolution.
- The repository is scaffolded as a focused demonstration of portfolio design and persistence; it is structured for extension into a data-backed application.

## License

This project is provided as a private internal scaffold unless a different license is added later.
