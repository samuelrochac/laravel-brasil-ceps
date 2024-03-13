<?php

namespace Samuelrochac\LaravelBrasilCeps\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class StatesSeeder extends Seeder
{
    public function run()
    {
        $sqlPath = database_path('SQL/states.sql');
        $sql = File::get($sqlPath);
        DB::unprepared($sql);
    }
}
