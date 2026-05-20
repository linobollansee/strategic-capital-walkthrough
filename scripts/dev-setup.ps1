# PowerShell version of dev-setup
param()

$root = Split-Path -Parent $MyInvocation.MyCommand.Path
Set-Location $root\..

function Run-Local {
    Write-Host 'Running migrations and fixtures locally'
    php bin/console doctrine:migrations:migrate --no-interaction
    php bin/console doctrine:fixtures:load --no-interaction
}

function Run-Compose {
    Write-Host 'Using docker compose to build and start services'
    docker compose up -d --build
    Write-Host 'Waiting for DB to accept connections...'
    for ($i=0; $i -lt 30; $i++) {
        try {
            docker compose exec -T php php -r "new PDO(getenv('DATABASE_URL'));" | Out-Null
            Write-Host 'DB reachable'
            break
        } catch {
            Start-Sleep -Seconds 2
        }
    }
    Write-Host 'Running migrations and fixtures inside php container'
    docker compose exec php php bin/console doctrine:migrations:migrate --no-interaction
    docker compose exec php php bin/console doctrine:fixtures:load --no-interaction
}

if (Get-Command docker -ErrorAction SilentlyContinue) {
    try {
        docker compose version | Out-Null
        Run-Compose
    } catch {
        Write-Host 'Docker Compose not available; running locally'
        Run-Local
    }
} else {
    Write-Host 'Docker not available; running locally'
    Run-Local
}
