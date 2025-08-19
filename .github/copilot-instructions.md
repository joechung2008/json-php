# Copilot Instructions for json-php

## Project Overview

- **json-php** is a PHP library and CLI tool for parsing and manipulating JSON data, inspired by [json.org](http://json.org).
- The codebase is split into CLI logic (`cli/src/cli.php`) and core JSON/data utilities (`shared/src/`).
- All business logic for JSON parsing and manipulation is in `shared/src/Parser.php` and supporting files (e.g., `Arrays.php`, `Objects.php`, `Strings.php`).
- The CLI (`cli/src/cli.php`) acts as a thin wrapper around the parser, reading input from stdin or files.

## Key Workflows

- **Install dependencies:**
  - `composer install` (run in project root)
- **Run tests:**
  - `./vendor/bin/phpunit` (tests in `tests/shared/`)
- **Lint/fix code style:**
  - Lint: `./vendor/bin/php-cs-fixer fix --dry-run --diff .`
  - Auto-fix: `./vendor/bin/php-cs-fixer fix .`
- **Run CLI parser:**
  - `php cli/src/cli.php` (input via stdin or file)
  - Example: `cat example.json | php cli/src/cli.php`

## Conventions & Patterns

- **File organization:**
  - Core logic in `shared/src/`, CLI in `cli/src/`, tests in `tests/shared/`.
  - Each major data type (Array, Object, String, etc.) has its own file/class in `shared/src/`.
- **Testing:**
  - PHPUnit tests are in `tests/shared/`, mirroring the structure of `shared/src/`.
  - Test classes are named `*Test.php` and match their source file (e.g., `ArraysTest.php` for `Arrays.php`).
- **Composer:**
  - All dependencies managed via Composer; autoloading is handled by `vendor/autoload.php`.
- **Formatting:**
  - Use `php-cs-fixer` for code style; do not manually reformat code.

## Integration Points

- **External dependencies:**
  - See `composer.json` for required packages (e.g., PHPUnit, php-cs-fixer).
  - CLI and core logic are decoupled; CLI only interacts with parser via function calls.
- **Extending functionality:**
  - Add new data types or utilities in `shared/src/` and corresponding tests in `tests/shared/`.
  - Update CLI logic in `cli/src/cli.php` if new input/output formats are needed.

## Examples

- To add a new JSON type, create `shared/src/NewType.php` and `tests/shared/NewTypeTest.php`.
- To run all tests after a change: `./vendor/bin/phpunit`
- To check/fix code style: `./vendor/bin/php-cs-fixer fix --dry-run --diff .` or `./vendor/bin/php-cs-fixer fix .`

## References

- See `README.md` for setup, usage, and workflow details.
- See `phpunit.xml` for test configuration.

---

**Feedback:** If any section is unclear or missing important project-specific details, please specify so it can be improved.
