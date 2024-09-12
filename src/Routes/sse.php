<?php

use Illuminate\Support\Facades\Route;
use LuizFabianoNogueira\SseNotify\Http\Controllers\SseController;

Route::controller(SseController::class)->group(function () {
    Route::get('/connect/{user_id}', 'connect')->name('sse.connect');
    Route::post('/', 'send')->name('sse.send');
});
