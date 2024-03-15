<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $prefix = config('brasil_ceps.db_prefix') ?? 'brasil_zip_codes_';

        Schema::create($prefix.'districts', function (Blueprint $table) use ($prefix){

            $table->id();
            $table->unsignedBigInteger('city_id');
            $table->string('name', 95);
            $table->string('slug', 95);
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on($prefix.'cities')->onDelete('cascade');
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

        Schema::dropIfExists($prefix.'districts');
    }
}