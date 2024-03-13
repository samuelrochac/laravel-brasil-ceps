<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AddressesSeeder extends Seeder
{
    public function run()
    {
        $sqlPath = database_path('SQL/addresses.sql');
        $sql = File::get($sqlPath);
        DB::unprepared($sql);
    }
}
