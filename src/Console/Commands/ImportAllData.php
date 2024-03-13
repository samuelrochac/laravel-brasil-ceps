<?php

namespace Samuelrochac\LaravelBrasilCeps\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ImportAllData extends Command
{
    protected $signature = 'import:zipcodes';

    protected $description = 'Import all data (states, cities, districts, addresses) from SQL files';

    public function handle()
    {
        // Supondo que 'packages' esteja na raiz do seu projeto Laravel
        $basePath = base_path('packages/samuelrochac/laravel-brasil-ceps/src/database/SQL');

        $this->importSql($basePath . '/states.sql', 'States');
        $this->importSql($basePath . '/cities.sql', 'Cities');
        $this->importSql($basePath . '/districts.sql', 'Districts');
        $this->importSql($basePath . '/addresses.sql', 'Addresses');

        $this->info('All data has been imported successfully!');
    }

    protected function importSql($path, $type)
    {
        $this->info('Importing ' . $type . ' from ' . $path . '...');

        if (File::exists($path)) {
            $sql = File::get($path);
            DB::unprepared($sql);
            $this->info($type . ' imported successfully.');
        } else {
            $this->error($type . ' SQL file does not exist.');
        }
    }
}
