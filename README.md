# json-php

## License

MIT

## Reference

[json.org](http://json.org)

## Prerequisites & Installation

1. **Install PHP**

   Download and install PHP from [php.net](https://www.php.net/downloads).

   Make sure the `mbstring` and `openssl` extensions are enabled in your `php.ini` file.

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

## Project Structure

- `cli/src/cli.php` - CLI entry point
- `shared/src/Parser.php` - JSON parser implementation
- Other files in `shared/src/` provide supporting functionality.
