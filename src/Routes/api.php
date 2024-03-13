<?php

use Illuminate\Support\Facades\Route;
use Samuelrochac\LaravelBrasilCeps\Controllers\Http\CepsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your package. These
| routes are loaded by your ServiceProvider by including this file.
| Now create something great!
|
*/

Route::group(['prefix' => 'api/cep', 'middleware' => ['api']], function () {
    Route::get('/{zipcode}/json', [CepsController::class, 'json'])->name("laravel-brasil-cep.json");
});