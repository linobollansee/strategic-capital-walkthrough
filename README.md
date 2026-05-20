# Strategic Capital Walkthrough

This project is a Symfony app demonstrating portfolio construction.

Quick dev setup (choose one):

- Using Docker Compose (recommended):

```bash
docker compose up -d --build
./scripts/dev-setup.sh
```

- Local (no Docker): ensure you have PHP + MySQL running and then:

```bash
composer install
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console doctrine:fixtures:load --no-interaction
php -S 127.0.0.1:8000 -t public
```

The `scripts/dev-setup.sh` script will attempt to use Docker Compose when available, otherwise it runs migrations and loads fixtures locally.
# Strategic Capital Walkthrough

Strategic Capital Walkthrough is a Symfony application that presents a formal investment-planning scenario for financial portfolios. The project is structured as a concise walkthrough: it explains the framework, shows an allocation model, documents execution controls, and includes the infrastructure required to move the concept toward persisted data.

## Technology Stack

| Layer | Version | Notes | Location |
| --- | --- | --- | --- |
| Backend | Symfony 8.0.11 | Framework, Twig, routing, and HTTP kernel | `src/Kernel.php`, `src/Controller/HomeController.php`, `config/routes.yaml`, `config/services.yaml`, `config/packages/framework.yaml`, `templates/` |
| Runtime | PHP 8.5.6 | Containerized PHP-FPM runtime | `docker/php/Dockerfile` (PHP 8.5.6-FPM), `docker-compose.yml` (`php` service), `composer.json`, `vendor/autoload.php` |
| Frontend scripting | ES2025 | Native module loaded without transpilation | `public/assets/app.js` |
| Styling | CSS3 | Responsive layout and motion effects | `public/assets/styles/app.css` |
| Markup | HTML 5.2 (Second revision) | Semantic page structure | `templates/base.html.twig` (layout), `templates/home/index.html.twig` (walkthrough) |
| Database | MySQL 9.7 LTS | Doctrine-ready relational store | `docker-compose.yml` (`database` service), `config/packages/doctrine.yaml`, `migrations/Version20260519000000.php` (creates `investment_snapshot` table), `src/Entity/InvestmentSnapshot.php` |

## Project Purpose

The application is intentionally focused on financial investments. It demonstrates how a small Symfony codebase can be organized around a professional capital-allocation narrative:

1. Define the investment framework.
2. Present a target allocation model.
3. Describe execution controls and review cadence.
4. Keep the application ready for database-backed expansion.

## Project Structure

- `src/Controller/HomeController.php` renders the investment walkthrough page.
- `templates/home/index.html.twig` contains the portfolio narrative and structural sections.
- `public/assets/app.js` provides modern JavaScript behavior for reveal animations and allocation bars.
- `public/assets/styles/app.css` defines the visual system.
- `docker-compose.yml` runs PHP-FPM, Nginx, and MySQL together.
- `migrations/Version20260519000000.php` creates the initial table used by the walkthrough.

## Prerequisites

The recommended runtime for local development is Docker Desktop. If you prefer native execution, install the following:

- PHP 8.5.6
- Composer 2.x
- MySQL 9.7 LTS or a compatible server version
- A web server capable of routing requests to Symfony, such as Nginx or the Symfony CLI

Composer is configured to resolve dependencies against PHP 8.5.6 so the documented stack remains consistent even when the host PHP binary is older. The Docker-based workflow below is still the preferred way to run the application.

## Installation

### Docker-based setup

```powershell
docker compose up -d --build
docker compose exec php composer install
docker compose exec php php bin/console doctrine:migrations:migrate --no-interaction
```

After the containers are running, open the application at `http://localhost:8080`.

### Native setup

If you are not using Docker, create a local environment override and point it at your local MySQL instance.

```powershell
Copy-Item .env .env.local
```

Edit `.env.local` and update `DATABASE_URL` to your local host, database name, user, and password. Then install dependencies and apply the migration.

Make sure your local PHP installation has the `pdo_mysql` extension enabled before running the Doctrine commands below.

```powershell
composer install
php bin/console doctrine:database:create --if-not-exists
php bin/console doctrine:migrations:migrate --no-interaction
php -S 127.0.0.1:8000 -t public public/index.php
```

If you already have the Symfony CLI installed, you can use `symfony serve` instead of the PHP built-in server.

## Execution Commands

### Development server through Docker

```powershell
docker compose up -d
```

### Symfony console

```powershell
docker compose exec php php bin/console cache:clear
docker compose exec php php bin/console doctrine:migrations:status
docker compose exec php php bin/console doctrine:migrations:migrate --no-interaction
```

### Tests

```powershell
docker compose exec php php bin/phpunit
```

## Configuration Details

### Environment variables

- `APP_ENV` controls the Symfony runtime mode.
- `APP_SECRET` is used by the framework for cryptographic operations.
- `DATABASE_URL` points Doctrine at the MySQL 9.7 LTS service.

### Docker services

- `php` uses PHP 8.5.6-FPM and installs Composer for dependency management.
- `nginx` serves the public directory and forwards PHP requests to the PHP container.
- `database` runs MySQL 9.7 and exposes the database service on port `3306`.

### Doctrine persistence

The codebase includes Doctrine ORM and Doctrine Migrations so the walkthrough can grow into a persisted portfolio or reporting tool. The current migration creates `investment_snapshot`, which is ready for future storage of allocation snapshots and review records.

## Implementation Notes

This project was built as a focused Symfony scaffold rather than a hobby demo. The implementation choices are deliberate:

- A single-page controller keeps the walkthrough clear and maintainable.
- Semantic HTML sections make the content readable and accessible.
- CSS variables, responsive grid layouts, and subtle motion keep the presentation consistent.
- ES2025-flavored JavaScript enhances the interface without introducing a build pipeline.
- Doctrine and MySQL are present from the start so persistence can be added without restructuring the application.

## Verification

The repository includes a controller test that confirms the homepage returns successfully and renders the investment narrative. Run the test suite after installing dependencies.

## License

This project is provided as a private internal scaffold unless a different license is added later.
