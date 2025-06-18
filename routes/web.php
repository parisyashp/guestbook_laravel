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

// Home page (setelah home.blade.php dipindahkan ke resources/views/guestbook/)
Route::get('/', function () {
    return view('guestbook.home'); //
})->name('home'); //

// Form untuk membuat entri baru
Route::get('/guestbook-create', [GuestbookController::class, 'showForm'])->name('guestbook.create'); //

// Menampilkan semua entri buku tamu
Route::get('/guestbook-view', [GuestbookController::class, 'viewGuestbook'])->name('guestbook.view'); //

// Handle pengiriman form (akan menyimpan ke database)
Route::post('/guestbook', [GuestbookController::class, 'submitForm'])->name('guestbook.submit'); //

// Halaman hasil setelah submit form
Route::get('/guestbook-result', [GuestbookController::class, 'viewGuestbookResult'])->name('guestbook.result'); //

// Menampilkan form edit untuk entri tertentu (menggunakan ID database)
Route::get('/guestbook/{id}/edit', [GuestbookController::class, 'edit'])->name('guestbook.edit'); //

// Memperbarui entri di database (menggunakan ID database dan POST method)
Route::post('/guestbook/{id}', [GuestbookController::class, 'update'])->name('guestbook.update'); 

// Menghapus entri dari database
Route::delete('/guestbook/{id}', [GuestbookController::class, 'destroy'])->name('guestbook.destroy'); //

// Menghapus semua entri di database
//Route::post('/guestbook/reset', [GuestbookController::class, 'resetGuestbook'])->name('guestbook.reset'); //
