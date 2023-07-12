<?php

use App\Http\Controllers\Firebase\ContactController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('contacts',[ContactController::class,'index'])->name('contacts');
Route::post('contact-store', [ContactController::class, 'store'])->name('contact.store');
Route::put('contact-update/{id}', [ContactController::class, 'update'])->name('contact.update');
Route::get('delete-contacts/{id}',[ContactController::class,'destroy'])->name('contact.delete');

Route::get('/', function () {
    return view('welcome');
});
