# Backup Sail's Database

## Requirements
- PHP >= 8.1
- Laravel >= 10.0

## Installation
```shell
composer require revolution/sail-db-backup --dev
```

### Uninstall
```shell
composer remove revolution/sail-db-backup
```
No config file.

## Usage
Be sure to run the command in Sail.
```shell
vendor/bin/sail art sail:backup:mysql
```

The SQL file will be saved in `.backup/mysql_backup`.(Same as Homestead)

If you want to change the `mysql_backup`
```shell
sail art sail:backup:mysql --path=database/backup
```

### Select Database connection
```shell
sail art sail:backup:mysql --connection=mysql2
```

## Global .gitignore
Recommend exclusion in global .gitignore

```
.backup
```

## LICENSE
MIT
