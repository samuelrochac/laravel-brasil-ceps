<?php

namespace Samuelrochac\LaravelBrasilCeps\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class ImportAllData extends Command
{
    protected $signature = 'import:zipcodes';

    protected $description = 'Import all data (states, cities, districts, addresses) from SQL files';

    public function handle()
    {

        // truncate tables
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // check if address table exists
        if (Schema::hasTable('addresses')) {
            DB::table('addresses')->truncate();
        }
        
        // check if district table exists
        if (Schema::hasTable('districts')) {
            DB::table('districts')->truncate();
        }

        // check if city table exists
        if (Schema::hasTable('cities')) {
            DB::table('cities')->truncate();
        }

        // check if state table exists
        if (Schema::hasTable('states')) {
            DB::table('states')->truncate();
        }

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

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // delete migrations
        DB::table('migrations')->where('migration', 'like', '2024_01_01_100000_create_states_table')->delete();
        DB::table('migrations')->where('migration', 'like', '2024_01_01_100001_create_cities_table')->delete();
        DB::table('migrations')->where('migration', 'like', '2024_01_01_100002_create_districts_table')->delete();
        DB::table('migrations')->where('migration', 'like', '2024_01_01_100003_create_addresses_table')->delete();

        // run migrate especific to create tables
        if (Schema::hasTable('states')) {
            $this->call('migrate', ['--path' => 'vendor/samuelrochac/laravel-brasil-ceps/src/Database/Migrations/2024_01_01_100000_create_states_table.php']);
        }

        if (Schema::hasTable('cities')) {
            $this->call('migrate', ['--path' => 'vendor/samuelrochac/laravel-brasil-ceps/src/Database/Migrations/2024_01_01_100001_create_cities_table.php']);
        }

        if (Schema::hasTable('districts')) {
            $this->call('migrate', ['--path' => 'vendor/samuelrochac/laravel-brasil-ceps/src/Database/Migrations/2024_01_01_100002_create_districts_table.php']);
        }

        if (Schema::hasTable('addresses')) {
            $this->call('migrate', ['--path' => 'vendor/samuelrochac/laravel-brasil-ceps/src/Database/Migrations/2024_01_01_100003_create_addresses_table.php']);
        }

        // Supondo que 'packages' esteja na raiz do seu projeto Laravel
        $basePath = base_path('vendor/samuelrochac/laravel-brasil-ceps/src/Database/SQL');

        $this->importSql($basePath . '/states.sql', 'States');
        $this->importSql($basePath . '/cities.sql', 'Cities');
        $this->importSql($basePath . '/districts.sql', 'Districts');

        $this->importSql($basePath . '/addresses_1_0.sql', 'Addresses');
        $this->importSql($basePath . '/addresses_2_0.sql', 'Addresses');
        $this->importSql($basePath . '/addresses_3_0.sql', 'Addresses');
        $this->importSql($basePath . '/addresses_3_1.sql', 'Addresses');
        $this->importSql($basePath . '/addresses_4_0.sql', 'Addresses');
        $this->importSql($basePath . '/addresses_5_0.sql', 'Addresses');
        $this->importSql($basePath . '/addresses_5_1.sql', 'Addresses');
        $this->importSql($basePath . '/addresses_6_0.sql', 'Addresses');
        $this->importSql($basePath . '/addresses_6_1.sql', 'Addresses');
        $this->importSql($basePath . '/addresses_7_0.sql', 'Addresses');
        $this->importSql($basePath . '/addresses_8_0.sql', 'Addresses');
        $this->importSql($basePath . '/addresses_9_0.sql', 'Addresses');
        $this->importSql($basePath . '/addresses_9_1.sql', 'Addresses');
        $this->importSql($basePath . '/addresses_10_0.sql', 'Addresses');
        $this->importSql($basePath . '/addresses_10_1.sql', 'Addresses');
        $this->importSql($basePath . '/addresses_11_0.sql', 'Addresses');
        $this->importSql($basePath . '/addresses_11_1.sql', 'Addresses');

        $this->info('All data has been imported successfully!');
    }

    protected function importSql($path, $type)
    {
        $this->info('Importing ' . $type . ' from ' . $path . '...');
    
        if (File::exists($path)) {
            $file = new \SplFileObject($path);
            $sql = '';
            while (!$file->eof()) {
                $line = trim($file->fgets());
                if ($line == '' || strpos($line, '--') === 0) {
                    // Ignora linhas vazias e comentários
                    continue;
                }
                $sql .= $line;
                if (substr($line, -1) == ';') {
                    // Quando encontrar um ponto e vírgula, considera como o fim de uma instrução e executa
                    DB::unprepared($sql);
                    $sql = ''; // Reseta a variável SQL para a próxima instrução
                }
            }
            $this->info($type . ' imported successfully.');
        } else {
            $this->error($type . ' SQL file does not exist.');
        }
    }
}
