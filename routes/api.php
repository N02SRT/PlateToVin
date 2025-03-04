<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group([
    'prefix' => 'v1',
], function () {

    Route::post('decode_plate', [App\Http\Controllers\PlateDataController::class, 'plateToVin'])->middleware(\App\Http\Middleware\ApiKey::class); // EnsureTokenIsValid is a custom middleware

});
