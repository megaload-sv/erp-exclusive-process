# Local Installation

## Requirements

- PHP 8.2 or newer
- Composer 2
- MySQL 8 or compatible MariaDB version
- Required PHP extensions for CodeIgniter 4

## Setup

```bash
git clone https://github.com/megaload-sv/erp-exclusive-process.git
cd erp-exclusive-process
composer install
cp .env.example .env
php spark serve
```

Open `http://localhost:8080`.

## Environment configuration

Configure at least:

- `CI_ENVIRONMENT`
- `app.baseURL`
- database credentials
- `encryption.key`

Never commit secrets or a production `.env` file.

## Verification

The dashboard should load at `/` and the machine-readable health check should respond at `/health`.

A healthy environment returns HTTP 200. An environment without a working database returns HTTP 503 with status `degraded`.
