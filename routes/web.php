<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestbookController; //

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home'); //
})->name('home'); //

// HAPUS ATAU KOMENTARI BARIS INI:
//Route::get('/guestbook-reset', function () {
//     request()->session()->flush();
//     return redirect()->route('guestbook.view');
//})->name('guestbook.reset');

Route::get('/guestbook-create', [GuestbookController::class, 'showForm'])->name('guestbook.form'); //
Route::get('/guestbook-view', [GuestbookController::class, 'viewGuestbook'])->name('guestbook.view'); //
Route::post('/guestbook', [GuestbookController::class, 'submitForm'])->name('guestbook.submit'); //
Route::get('/guestbook-result', [GuestbookController::class, 'viewGuestbookResult'])->name('guestbook.result'); //

Route::get('/guestbook/{index}/edit', [GuestbookController::class, 'edit'])->name('guestbook.edit'); //
// UBAH DARI POST MENJADI PUT UNTUK OPERASI UPDATE YANG BENAR
Route::put('/guestbook/{index}', [GuestbookController::class, 'update'])->name('guestbook.update'); // Menggunakan PUT untuk update, lebih sesuai RESTful

Route::delete('/guestbook/{index}', [GuestbookController::class, 'destroy'])->name('guestbook.destroy'); //

// Ini adalah satu-satunya rute untuk reset yang kita inginkan:
Route::post('/guestbook/reset', [GuestbookController::class, 'resetGuestbook'])->name('guestbook.reset'); //