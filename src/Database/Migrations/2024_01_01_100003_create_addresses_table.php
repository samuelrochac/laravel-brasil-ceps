<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $prefix = config('brasil_ceps.db_prefix') ?? 'brasil_zip_codes_';

        Schema::create($prefix.'addresses', function (Blueprint $table) use ($prefix){

            $table->id();
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('district_id')->nullable();
            $table->string('address', 255)->nullable();
            $table->string('postal_code', 15)->index();
            $table->string('latitude', 20)->nullable();
            $table->string('longitude', 20)->nullable();
            $table->unsignedInteger('ddd')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('city_id')->references('id')->on($prefix.'cities')->onDelete('cascade');
            $table->foreign('district_id')->references('id')->on($prefix.'districts')->onDelete('set null');

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

        Schema::dropIfExists($prefix.'addresses');
    }
}