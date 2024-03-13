<?php

namespace Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ImportAllData extends Command
{
    protected $signature = 'import:zipcodes';

    protected $description = 'Import all data (states, cities, districts, addresses) from SQL files';

    public function handle()
    {
        $this->importSql(database_path('SQL/states.sql'), 'States');
        $this->importSql(database_path('SQL/cities.sql'), 'Cities');
        $this->importSql(database_path('SQL/districts.sql'), 'Districts');
        $this->importSql(database_path('SQL/addresses.sql'), 'Addresses');

        $this->info('All data has been imported successfully!');
    }

    protected function importSql($path, $type)
    {
        if (File::exists($path)) {
            $sql = File::get($path);
            DB::unprepared($sql);
            $this->info($type . ' imported successfully.');
        } else {
            $this->error($type . ' SQL file does not exist.');
        }
    }
}
