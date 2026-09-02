<?php

use App\Http\Controllers\TransactionController;

Route::get('/', [TransactionController::class, 'index'])->name('dashboard');
Route::resource('transactions', TransactionController::class);

