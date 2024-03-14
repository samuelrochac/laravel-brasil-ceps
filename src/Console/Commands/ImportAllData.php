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

        // delete data from tables
        // check if address table exists
        if (Schema::hasTable('addresses')) {
            DB::table('addresses')->delete();
        }
        
        // check if district table exists
        if (Schema::hasTable('districts')) {
            DB::table('districts')->delete();
        }

        // check if city table exists
        if (Schema::hasTable('cities')) {
            DB::table('cities')->delete();
        }

        // check if state table exists
        if (Schema::hasTable('states')) {
            DB::table('states')->delete();
        }

        // delete migrations
        DB::table('migrations')->where('migration', 'like', '2024_01_01_100000_create_states_table')->delete();
        DB::table('migrations')->where('migration', 'like', '2024_01_01_100001_create_cities_table')->delete();
        DB::table('migrations')->where('migration', 'like', '2024_01_01_100002_create_districts_table')->delete();
        DB::table('migrations')->where('migration', 'like', '2024_01_01_100003_create_addresses_table')->delete();

        // run migrations
        $this->call('migrate');

        // Supondo que 'packages' esteja na raiz do seu projeto Laravel
        $basePath = base_path('vendor/samuelrochac/laravel-brasil-ceps/src/Database/SQL');

        $this->importSql($basePath . '/states.sql', 'States');
        $this->importSql($basePath . '/cities.sql', 'Cities');
        $this->importSql($basePath . '/districts.sql', 'Districts');

        $this->importSql($basePath . '/addresses_1.sql', 'Addresses');
        $this->importSql($basePath . '/addresses_2.sql', 'Addresses');
        $this->importSql($basePath . '/addresses_3.sql', 'Addresses');
        $this->importSql($basePath . '/addresses_4.sql', 'Addresses');
        $this->importSql($basePath . '/addresses_5.sql', 'Addresses');
        $this->importSql($basePath . '/addresses_6.sql', 'Addresses');
        $this->importSql($basePath . '/addresses_7.sql', 'Addresses');
        $this->importSql($basePath . '/addresses_8.sql', 'Addresses');
        $this->importSql($basePath . '/addresses_9.sql', 'Addresses');
        $this->importSql($basePath . '/addresses_10.sql', 'Addresses');
        $this->importSql($basePath . '/addresses_11.sql', 'Addresses');

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
