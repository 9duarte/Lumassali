# Lumassali

PHP application for displaying the Lumassali café price list, managing prices
through a restricted area, and showing upcoming bus departures.

## Features

- Public price list organized by sections.
- Login and administration area.
- Manual price updates.
- Price updates through Excel files.
- JSON endpoint with upcoming departures at the Agrinha (Carreira) stop.
- Temporary cache for transport API responses to reduce external requests.

## Requirements

- PHP 7.4 or higher.
- MySQL/MariaDB with the `mysqli` and `mbstring` extensions.
- PHP `curl` extension for the bus endpoint.
- Composer.
- Web server (Apache, Nginx, or PHP's built-in server).

## Installation

1. Clone the repository and enter the project directory:

   ```bash
   git clone <url-do-repositorio>
   cd Lumassali
   ```

2. Install the dependencies:

   ```bash
   composer install
   ```

3. Create the `.env` file from the example:

   ```bash
   cp .env.example .env
   ```

   On Windows PowerShell, you can use:

   ```powershell
   Copy-Item .env.example .env
   ```

4. Fill in `.env` with the database details:

   ```dotenv
   DATABASE_HOST=localhost
   DATABASE_USER=utilizador
   DATABASE_PASS=password
   DATABASE_NAME=lumassali
   ```

   The `.env` file must not be committed. The variables are loaded in
   `db/conexao.php` through `phpdotenv`.

5. Configure the database with the tables required by the application,
   including:

   - `administrator`, used to authenticate administrators;
   - `secoes_produtos`, used for the sections and products displayed in the
     price list.

## Local execution

Using PHP's built-in server:

```bash
php -S localhost:8000
```

Then open [http://localhost:8000](http://localhost:8000).

The public page is `index.php`. The administration area is available at
`login.php` and requires an existing user in the `administrator` table.

## Importing prices from Excel

The administration area allows `.xlsx` and `.xls` files to be uploaded.
The import uses the active sheet and reads:

- column `A`: product code (`codigo`);
- column `F`: new price (`preco`).

The data is applied to the `secoes_produtos` table through
`importarExcel.php`. The first row is treated as a header and is not imported.

## Bus endpoint

The `proximos_autocarros.php` file queries Qmob's public endpoints and returns
JSON. It can be used directly:

```text
/proximos_autocarros.php
```

There is a test mode that makes no external requests:

```text
/proximos_autocarros.php?test=1
/proximos_autocarros.php?test=vazio
/proximos_autocarros.php?test=falha
```

The `cacert.pem` file is used to validate the TLS certificates for cURL
requests.

## Main structure

| File/folder | Description |
| --- | --- |
| `index.php` | Public price list |
| `login.php` | Authentication form |
| `loginVerification.php` | Login validation |
| `admin.php` | Manual price management and upload |
| `adminInserir.php` | Saving manual changes |
| `importarExcel.php` | Importing prices from Excel |
| `proximos_autocarros.php` | Upcoming departures endpoint/cache |
| `db/conexao.php` | Loading `.env` and connecting to the database |
| `css/` | Stylesheets |
| `images/` | Images used by the application |

## Security

- Never place credentials directly in the code or repository.
- Keep `.env` only in the environment where the application runs.
- Use HTTPS in production.
- Make sure configuration files and logs are not publicly accessible through
  the web server.
