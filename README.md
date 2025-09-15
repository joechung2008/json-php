# json-php

## License

MIT

## Reference

[json.org](http://json.org)

## Prerequisites & Installation

1. **Install PHP**

   Download and install PHP from [php.net](https://www.php.net/downloads).

   Make sure the `fileinfo`, `mbstring`, and `openssl` extensions are enabled in your PHP installation.

```bash
# Check if these extensions are loaded by your CLI PHP.
php -m | egrep -i 'mbstring|fileinfo|openssl'
```

```bash
# Check if the fileinfo and mbstring extensions are configured in conf.d.
ls -l /etc/php/8.3/cli/conf.d/*mbstring* /etc/php/8.3/cli/conf.d/*fileinfo* 2>/dev/null
```

2. **Install Composer**

   Download and install Composer from [getcomposer.org](https://getcomposer.org/download/).

3. **Install dependencies**

   Run the following command in the project root:

```sh
composer install
```

## Lint with php-cs-fixer

To check PHP files for formatting issues (lint), run:

```sh
./vendor/bin/php-cs-fixer fix --dry-run --diff .
```

This will show what would be changed without modifying files.

## Fix lint errors with php-cs-fixer

To automatically fix formatting and lint errors, run:

```sh
./vendor/bin/php-cs-fixer fix .
```

This will update all PHP files in the project to conform to standard formatting.

## Running the CLI

To run the CLI parser, use the following command from the project root:

```sh
php cli/src/cli.php
```

To pass in input from a file, pipe the input to the CLI parser.

```sh
cat example.json | php cli/src/cli.php
```

## Running Tests

To run the test suite, execute the following command from the project root:

```sh
./vendor/bin/phpunit
```

This will run all tests in the `tests/` directory and display the results.

If you have not installed dependencies yet, run:

```sh
composer install
```

## Starting the Laravel API

To start the Laravel API server:

1. Open a terminal in the `api-laravel` directory.
2. Install dependencies (if not already done):

```sh
composer install
```

3. Start the Laravel development server:

```sh
php artisan serve
```

The API will be available at `http://localhost:8000`.

## Starting the Symfony API

To start the Symfony API server:

1. Open a terminal in the `api-symfony` directory.

2. Create an `.env` file (if not already done):

```bash
php -r "echo 'APP_SECRET=' . bin2hex(random_bytes(32)) . PHP_EOL;" > .env
printf "APP_ENV=dev\nAPP_DEBUG=1\n" >> .env
```

3. Install dependencies (if not already done):

```sh
composer install
```

4. Start the Symfony development server:

```sh
php -S localhost:8000 public/index.php -t public/
```

The API will be available at `http://localhost:8000`.

## Sending Test Data with REST Client (VS Code Extension)

You can use the [REST Client extension](https://marketplace.visualstudio.com/items?itemName=humao.rest-client) in VS Code to send HTTP requests to the Laravel API.

1. Install the REST Client extension from the VS Code marketplace.
2. Open any `.rest` file in the `testdata/` directory.
3. Click "Send Request" above a request to execute it.
4. The response from the API will appear in a new VS Code pane.

Example request in `testdata/string.rest`:

```http
POST http://localhost:8000/api/parse
Content-Type: text/plain

"example string"
```
