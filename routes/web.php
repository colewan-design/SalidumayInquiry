<?php

use App\Http\Controllers\InquiryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [InquiryController::class, 'index'])->name('inquiry');
Route::post('/', [InquiryController::class, 'submit'])->name('inquiry.submit');
