<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DistrictsSeeder extends Seeder
{
    public function run()
    {
        $sqlPath = database_path('SQL/districts.sql');
        $sql = File::get($sqlPath);
        DB::unprepared($sql);
    }
}
