<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $prefix = config('brasil_ceps.db_prefix') ?? 'brasil_zip_codes_';

        Schema::create($prefix.'cities', function (Blueprint $table) use ($prefix){
            
            $table->id();
            $table->unsignedBigInteger('state_id');
            $table->string('name', 95);
            $table->string('slug', 95);
            $table->timestamps();
            $table->foreign('state_id')->references('id')->on($prefix.'states')->onDelete('cascade');

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

        Schema::dropIfExists($prefix.'cities');
    }
}