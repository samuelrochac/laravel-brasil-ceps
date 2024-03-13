<?php

namespace Samuelrochac\LaravelBrasilCeps\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CitiesSeeder extends Seeder
{
    public function run()
    {
        $sqlPath = database_path('SQL/cities.sql');
        $sql = File::get($sqlPath);
        DB::unprepared($sql);
    }
}
