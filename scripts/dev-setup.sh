#!/usr/bin/env bash
set -euo pipefail

# dev-setup.sh
# Usage: ./scripts/dev-setup.sh
# Will prefer Docker Compose if available; otherwise runs migrations/fixtures locally.

ROOT_DIR=$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)
cd "$ROOT_DIR"

# Helper: run local commands
run_local() {
  echo "Running migrations and fixtures locally"
  php bin/console doctrine:migrations:migrate --no-interaction
  php bin/console doctrine:fixtures:load --no-interaction
}

# Helper: run via docker compose
run_compose() {
  echo "Using docker compose to build and start services"
  docker compose up -d --build
  echo "Waiting for DB to accept connections..."
  # Wait loop: try to connect via PHP console inside php container
  for i in {1..30}; do
    if docker compose exec -T php php -r "try{ new PDO(getenv('DATABASE_URL')); echo 'ok'; }catch(Exception \$e){ exit(1); }" 2>/dev/null; then
      echo "DB reachable"
      break
    fi
    echo "waiting..."
    sleep 2
  done

  echo "Running migrations and fixtures inside php container"
  docker compose exec php php bin/console doctrine:migrations:migrate --no-interaction
  docker compose exec php php bin/console doctrine:fixtures:load --no-interaction
}

# Detect availability
if command -v docker >/dev/null 2>&1 && command -v docker-compose >/dev/null 2>&1; then
  echo "docker-compose available; using docker compose"
  run_compose
elif command -v docker >/dev/null 2>&1 && docker compose version >/dev/null 2>&1; then
  echo "docker compose available; using docker compose"
  run_compose
else
  echo "Docker Compose not available; running locally"
  run_local
fi
