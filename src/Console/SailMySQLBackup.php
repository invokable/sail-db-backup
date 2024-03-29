<?php

declare(strict_types=1);

namespace Revolution\Sail\Backup\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;

class SailMySQLBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sail:backup:mysql {--path=.backup/mysql_backup} {--connection=mysql}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Backup Sail's MySQL";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $config = config('database.connections.'.$this->option('connection'));
        $database = data_get($config, 'database');
        $now = now()->format('YmdHi');
        $path = base_path($this->option('path'));

        File::ensureDirectoryExists($path);

        $cmd = [
            'mysqldump',
            '--host='.data_get($config, 'host'),
            '--port='.data_get($config, 'port'),
            '--user='.data_get($config, 'username'),
            '--password='.data_get($config, 'password'),
            $database,
            "--result-file=$path/$database-$now.sql",
        ];

        Process::run($cmd);

        $this->info("Backing up mysql database $database-$now.sql");

        return 0;
    }
}
