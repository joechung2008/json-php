# Copilot Instructions for json-php

## For AI Coding Assistants

- Core JSON logic is in `shared/src/` (Parser.php, Arrays.php, etc.).
- CLI entry point is `cli/src/cli.php` (thin wrapper around parser).
- Laravel API code is in `api-laravel/app/Http/Controllers/` (main: ParseController.php).
- Symfony API code is in `api-symfony/src/Controller/` (main: ParseController.php).
- To add new API endpoints, create methods in ParseController or new controllers, and register routes in `api-laravel/routes/api.php` for Laravel or use route attributes in Symfony controllers.
- Tests for core logic are in `tests/shared/`, named `*Test.php` to match their source.
- Use Composer autoloading conventions for new classes.
- Follow PSR standards for formatting and organization.
- Do not duplicate logic between CLI and API; reuse parser/utilities.
- Prefer adding new data types/utilities in `shared/src/` and corresponding tests.
- Avoid manual formatting; rely on php-cs-fixer.

For more information, see [README.md](../README.md).
