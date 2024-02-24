<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateDatabase extends Command
{
    protected $signature = 'db:create';
    protected $description = 'Create database if not exists, database independent.';

    public function handle()
    {
        $databaseName = config('database.connections.'.config('database.default').'.database');
        $charset = config('database.connections.'.config('database.default').'.charset', 'utf8mb4');
        $collation = config('database.connections.'.config('database.default').'.collation', 'utf8mb4_unicode_ci');

        // Temporary switch to a default system database to avoid "Unknown database" error
        $this->configureConnectionTemporary();

        try {
            if (config('database.default') === 'mysql') {
                $query = "CREATE DATABASE IF NOT EXISTS `$databaseName` CHARACTER SET $charset COLLATE $collation;";
                DB::statement($query);
            } elseif (config('database.default') === 'pgsql') {
                $query = "SELECT 'CREATE DATABASE $databaseName' WHERE NOT EXISTS (SELECT FROM pg_database WHERE datname = '$databaseName')\\gexec";
                DB::statement($query);
            }
            // Add more conditions here for other database types like SQLite, SQL Server, etc.
        } finally {
            // Revert back to the original database configuration
            config(['database.connections.'.config('database.default').'.database' => $databaseName]);
        }

        $this->info("Database $databaseName created or already exists");
    }

    private function configureConnectionTemporary()
    {
        $default = config('database.default');
        switch ($default) {
            case 'mysql':
                config(['database.connections.'.$default.'.database' => null]);
                break;
            case 'pgsql':
                config(['database.connections.'.$default.'.database' => 'postgres']);
                break;
            // Add more cases here for other database systems if needed
        }
    }
}
