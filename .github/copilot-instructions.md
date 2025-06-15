# Copilot Instructions for invokable/sail-db-backup

## Project Overview

The `invokable/sail-db-backup` repository provides a Laravel package that simplifies MySQL database backups specifically for Laravel Sail development environments. This package adds an Artisan command that creates timestamped MySQL dumps, making it easy for developers to backup their development databases.

**Key Features:**
- Simple MySQL database backup command for Laravel Sail
- Timestamped backup files with customizable paths
- Support for multiple database connections
- Development-only functionality (disabled in production)
- Zero configuration required

**Package Details:**
- **Namespace:** `Revolution\Sail\Backup`
- **Main Command:** `sail:backup:mysql`
- **Requirements:** PHP ≥8.2, Laravel ≥11.0
- **License:** MIT

## Setup Instructions

### Prerequisites
- PHP 8.2 or higher
- Laravel 11.0 or higher
- Laravel Sail development environment
- Composer package manager

### Installation

1. **Install the package via Composer:**
   ```bash
   composer require revolution/sail-db-backup --dev
   ```

2. **The package will auto-register** via Laravel's package discovery. No additional configuration is needed.

3. **Verify installation:**
   ```bash
   vendor/bin/sail artisan list | grep sail:backup
   ```

### Configuration

The package works without configuration, but you can customize:

- **Backup path:** Default is `.backup/mysql_backup`
- **Database connection:** Default is `mysql`
- **Global .gitignore:** Add `.backup` to exclude backups from version control

## Common Workflows

### Basic Database Backup
```bash
# Basic backup (saves to .backup/mysql_backup/)
vendor/bin/sail artisan sail:backup:mysql

# Custom backup path
vendor/bin/sail artisan sail:backup:mysql --path=database/backups

# Specific database connection
vendor/bin/sail artisan sail:backup:mysql --connection=mysql2
```

### Development Workflow
1. **Start Laravel Sail:**
   ```bash
   vendor/bin/sail up -d
   ```

2. **Create backup before major changes:**
   ```bash
   vendor/bin/sail artisan sail:backup:mysql
   ```

3. **Backup files are saved with timestamps:**
   ```
   .backup/mysql_backup/database_name-202312010930.sql
   ```

### Package Development

#### Setting Up Development Environment
```bash
# Clone the repository
git clone https://github.com/invokable/sail-db-backup.git
cd sail-db-backup

# Install dependencies
composer install

# Run tests
vendor/bin/phpunit

# Check code style
vendor/bin/pint --test
```

#### Key Files to Understand
- `src/Console/SailMySQLBackup.php` - Main backup command
- `src/SailBackupServiceProvider.php` - Laravel service provider
- `tests/Feature/BackupTest.php` - Feature tests
- `composer.json` - Package configuration

## Testing and Development

### Running Tests
```bash
# Run all tests
vendor/bin/phpunit

# Run tests with coverage
vendor/bin/phpunit --coverage-text

# Run specific test
vendor/bin/phpunit --filter=BackupTest
```

### Code Quality
```bash
# Check code style
vendor/bin/pint --test

# Fix code style issues
vendor/bin/pint

# The project uses Laravel Pint with Laravel preset
```

### Testing Strategy
- **Feature Tests:** Mock the `mysqldump` process execution
- **Test Database:** Uses Orchestra Testbench with mock database connections
- **Coverage:** Generates Clover XML coverage reports
- **CI/CD:** Automated testing on PHP 8.4 with GitHub Actions

## Contribution Guidelines

### Branching Strategy
- **Main Branch:** `main` - stable releases
- **Development Branch:** `develop` - active development
- **Feature Branches:** `feature/description` or `fix/description`

### Pull Request Process
1. **Fork the repository** and create a feature branch
2. **Write tests** for new functionality
3. **Ensure code quality:**
   ```bash
   vendor/bin/phpunit
   vendor/bin/pint --test
   ```
4. **Submit PR** with clear description
5. **Target:** Pull requests should target the `develop` branch

### Code Style Guidelines
- **PSR-12** compliant code style
- **Laravel conventions** for naming and structure
- **Strict types** declaration required (`declare(strict_types=1);`)
- **Type hints** for all parameters and return types
- **Documentation blocks** for public methods

### Commit Message Format
- Use clear, descriptive commit messages
- Follow conventional commit format when possible
- Reference issues when applicable

## Documentation and Help

### Primary Documentation
- **README.md** - Basic usage and installation
- **This file** - Comprehensive development guide
- **Code comments** - Inline documentation in source files

### External Resources
- [Laravel Sail Documentation](https://laravel.com/docs/sail)
- [Laravel Package Development](https://laravel.com/docs/packages)
- [Orchestra Testbench](https://packages.tools/testbench)

### Getting Help
- **Issues:** GitHub Issues for bugs and feature requests
- **Discussions:** Use GitHub Discussions for questions
- **Author:** kawax (kawaxbiz@gmail.com)

## Special Notes for Copilot and AI Assistance

### Context Awareness
- This package is **development-only** - it should never run in production
- The main functionality is **process execution** of `mysqldump` command
- **Testing uses mocks** - actual database connections are not made in tests

### Code Patterns to Follow
- **Command Structure:** Extend `Illuminate\Console\Command`
- **Service Provider:** Register commands in `boot()` method with console check
- **Process Execution:** Use `Illuminate\Support\Facades\Process` for shell commands
- **File Operations:** Use `Illuminate\Support\Facades\File` for directory operations

### Common Implementation Patterns
```php
// Command signature with options
protected $signature = 'command:name {--option=default}';

// Process execution with array of command parts
Process::run(['command', '--option=value', 'argument']);

// Environment-aware service registration
if ($this->app->runningInConsole() && ! $this->app->isProduction()) {
    $this->commands([CommandClass::class]);
}
```

### Testing Patterns
- **Mock processes** using `Process::fake()`
- **Assert process execution** with `Process::assertRan()`
- **Use Carbon for time testing** with `Carbon::setTestNow()`
- **Orchestra Testbench** for Laravel package testing

### Areas Requiring Caution
- **Security:** Never expose database credentials in logs
- **File paths:** Always use `base_path()` for absolute paths
- **Production safety:** Ensure commands are development-only
- **Process execution:** Validate inputs to prevent injection

This package follows Laravel best practices and maintains a simple, focused scope for MySQL backups in Sail environments.