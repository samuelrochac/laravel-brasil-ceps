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
        
        $this->clearData();

        // run migrate especific to create tables
        if (!Schema::hastable($prefix.'states')) {
            $this->call('migrate', ['--path' => 'vendor/samuelrochac/laravel-brasil-ceps/src/Database/Migrations/2024_01_01_100000_create_states_table.php']);
        }

        if (!Schema::hastable($prefix.'cities')) {
            $this->call('migrate', ['--path' => 'vendor/samuelrochac/laravel-brasil-ceps/src/Database/Migrations/2024_01_01_100001_create_cities_table.php']);
        }

        if (!Schema::hastable($prefix.'districts')) {
            $this->call('migrate', ['--path' => 'vendor/samuelrochac/laravel-brasil-ceps/src/Database/Migrations/2024_01_01_100002_create_districts_table.php']);
        }

        if (!Schema::hastable($prefix.'addresses')) {
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
        $prefix = config('brasil_ceps.db_prefix') ?? 'brasil_zip_codes_';
        
        $replaces = [
            'states' => config('brasil_ceps.db_prefix') . 'states',
            'cities' => config('brasil_ceps.db_prefix') . 'cities',
            'districts' => config('brasil_ceps.db_prefix') . 'districts',
            'addresses' => config('brasil_ceps.db_prefix') . 'addresses',
        ];

        $this->info('Importing ' . $type. '...');
    
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

                    $sql = str_replace(array_keys($replaces), array_values($replaces), $sql);
                    
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

    public function clearData(){

        $prefix = config('brasil_ceps.db_prefix') ?? 'brasil_zip_codes_';

        // truncate tables
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // check if address table exists
        if (Schema::hastable($prefix.'addresses')) {
            try{
                $truncate = DB::table($prefix.'addresses')->truncate();
                $this->info('Addresses table truncated successfully!');
            }catch(\Exception $e){
                $this->error('Error on truncate addresses table: ' . $e->getMessage());
            }
        }
        
        // check if district table exists
        if (Schema::hastable($prefix.'districts')) {
            try{
                $truncate = DB::table($prefix.'districts')->truncate();
                $this->info('Districts table truncated successfully!');
            }catch(\Exception $e){
                $this->error('Error on truncate districts table: ' . $e->getMessage());
            }
        }

        // check if city table exists
        if (Schema::hastable($prefix.'cities')) {
            try{
                $truncate = DB::table($prefix.'cities')->truncate();
                $this->info('Cities table truncated successfully!');
            }catch(\Exception $e){
                $this->error('Error on truncate cities table: ' . $e->getMessage());
            }
        }

        // check if state table exists
        if (Schema::hastable($prefix.'states')) {
            try{
                $truncate = DB::table($prefix.'states')->truncate();
                $this->info('States table truncated successfully!');
            }catch(\Exception $e){
                $this->error('Error on truncate states table: ' . $e->getMessage());
            }
        }

        // check if address table exists
        if (Schema::hastable($prefix.'addresses')) {
            try{
                $delete = DB::table($prefix.'addresses')->delete();
                $this->info('Addresses table deleted successfully!');
            }catch(\Exception $e){
                $this->error('Error on delete addresses table: ' . $e->getMessage());
            }
        }
        
        // check if district table exists
        if (Schema::hastable($prefix.'districts')) {
            try{
                $delete = DB::table($prefix.'districts')->delete();
                $this->info('Districts table deleted successfully!');
            }catch(\Exception $e){
                $this->error('Error on delete districts table: ' . $e->getMessage());
            }
        }

        // check if city table exists
        if (Schema::hastable($prefix.'cities')) {
            try{
                $delete = DB::table($prefix.'cities')->delete();
                $this->info('Cities table deleted successfully!');
            }catch(\Exception $e){
                $this->error('Error on delete cities table: ' . $e->getMessage());
            }
        }

        // check if state table exists
        if (Schema::hastable($prefix.'states')) {
            try{
                $delete = DB::table($prefix.'states')->delete();
                $this->info('States table deleted successfully!');
            }catch(\Exception $e){
                $this->error('Error on delete states table: ' . $e->getMessage());
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // delete migrations
        DB::table($prefix.'migrations')->where('migration', 'like', '2024_01_01_100000_create_states_table')->delete();
        DB::table($prefix.'migrations')->where('migration', 'like', '2024_01_01_100001_create_cities_table')->delete();
        DB::table($prefix.'migrations')->where('migration', 'like', '2024_01_01_100002_create_districts_table')->delete();
        DB::table($prefix.'migrations')->where('migration', 'like', '2024_01_01_100003_create_addresses_table')->delete();

    }

}
