<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\VoteController;

Route::get('/', [VoteController::class, 'index'])->name('index');
Route::post('/votes', [VoteController::class, 'submit'])->name('submit');
Route::get('/votes/results', [VoteController::class, 'result'])->name('results');

