<?php

declare(strict_types=1);

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Contracts\Process\ProcessResult;
use Illuminate\Process\PendingProcess;
use Illuminate\Support\Facades\Process;
use Tests\TestCase;

class BackupTest extends TestCase
{
    public function test_backup()
    {
        Process::fake();

        Carbon::setTestNow(Carbon::create(2023, 2, 26));

        $this->artisan('sail:backup:mysql')
            ->assertSuccessful()
            ->expectsOutput('Backing up mysql database test-202302260000.sql');

        Process::assertRan(fn (
            PendingProcess $process,
            ProcessResult  $result,
        ) => collect($process->command)->contains('--result-file='.base_path('.backup/mysql_backup/test-202302260000.sql')));
    }

    public function test_backup_with_path()
    {
        Process::fake();

        Carbon::setTestNow(Carbon::create(2023, 2, 26));

        $this->artisan('sail:backup:mysql', ['--path' => 'mysql'])
            ->assertSuccessful()
            ->expectsOutput('Backing up mysql database test-202302260000.sql');

        Process::assertRan(fn (
            PendingProcess $process,
            ProcessResult  $result,
        ) => collect($process->command)->contains('--result-file='.base_path('mysql/test-202302260000.sql')));
    }

    public function test_backup_with_connection()
    {
        Process::fake();

        Carbon::setTestNow(Carbon::create(2024, 3, 29));

        $this->artisan('sail:backup:mysql', ['--connection' => 'mysql2'])
            ->assertSuccessful()
            ->expectsOutput('Backing up mysql database test2-202403290000.sql');

        Process::assertRan(fn (
            PendingProcess $process,
            ProcessResult  $result,
        ) => collect($process->command)->contains('--result-file='.base_path('.backup/mysql_backup/test2-202403290000.sql')));
    }
}
