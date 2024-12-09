<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\RentalController;

Route::apiResource('clients', ClientController::class);
Route::apiResource('medias', MediaController::class);
Route::post('medias/{media}/rent', [MediaController::class, 'rent']);
Route::post('medias/{media}/return', [MediaController::class, 'return']);
Route::post('rentals/rent', [RentalController::class, 'rent']);
Route::post('rentals/{id}/return', [RentalController::class, 'return']);
Route::post('webhook/job-completed', function (Request $request) {
    $data = $request->all();
    return response()->json(['message' => 'Webhook received successfully', 'data' => $data]);
});