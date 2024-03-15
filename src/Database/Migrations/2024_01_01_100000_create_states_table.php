<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $prefix = config('brasil_ceps.db_prefix') ?? 'brasil_zip_codes_';

        Schema::create($prefix.'states', function (Blueprint $table) {
            $table->id();
            $table->string('name', 95)->unique();
            $table->string('initials', 10)->unique(); 
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $prefix = config('brasil_ceps.db_prefix') ?? 'brasil_zip_codes_';

        Schema::dropIfExists($prefix.'states');
    }
}