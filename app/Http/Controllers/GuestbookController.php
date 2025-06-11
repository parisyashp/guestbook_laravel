<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// use Faker\Factory; // Tidak lagi dibutuhkan jika tidak membuat data palsu lagi
use App\Models\Guestbook; // Pastikan model Guestbook diimpor

class GuestbookController extends Controller
{
    /**
     * Menampilkan formulir buku tamu.
     * Tidak ada perubahan signifikan di sini, hanya memastikan view yang benar.
     */
    public function showForm()
    {
        // Pastikan view 'guestbook.form' ada
        return view('guestbook.form');
    }

    /**
     * Memproses pengiriman formulir buku tamu dan menyimpan data ke database.
     */
    public function submitForm(Request $request)
    {
        // Validasi data input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // --- Perubahan di sini: Menyimpan data ke database ---
        // Gunakan model Guestbook untuk membuat record baru
        Guestbook::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'message' => $request->input('message'),
        ]);

        // Redirect ke halaman tampilan buku tamu setelah berhasil menyimpan
        return redirect()->route('guestbook.view')->with('success', 'Pesan Anda telah berhasil disimpan!');
    }

    /**
     * Menampilkan semua entri buku tamu dari database.
     */
    public function viewGuestbook()
    {
        // --- Perubahan di sini: Mengambil data dari database ---
        // Ambil semua entri buku tamu dari database menggunakan model Guestbook
        // Hasilnya adalah koleksi Eloquent, bukan array sesi.
        $mergedGuestbookData = Guestbook::all();

        // Kirim data ke view 'guestbook.view'
        return view('guestbook.view', compact('mergedGuestbookData'));
    }

    /**
     * Menampilkan hasil entri buku tamu yang baru saja disubmit.
     * Karena sekarang kita menyimpan ke database, logika 'lastSubmittedEntryIndex'
     * dan 'lastSubmittedGuestbookData' dari sesi menjadi tidak relevan untuk
     * melihat data yang baru disimpan. Halaman 'viewGuestbook' sudah akan menampilkan
     * data terbaru. Jika Anda masih ingin halaman 'result' yang terpisah,
     * mungkin tampilannya perlu diadaptasi (misalnya menampilkan entri terbaru dari DB).
     * Untuk kesederhanaan, kita akan mengarahkan ke viewGuestbook karena dia menampilkan semua data.
     */
    public function viewGuestbookResult()
    {
        // Kita bisa langsung mengarahkan ke viewGuestbook karena dia akan fetch data terbaru.
        // Atau, jika ingin menampilkan hanya yang terakhir, Anda bisa fetch dari DB.
        // Contoh fetch terakhir: $lastEntry = Guestbook::latest()->first();
        // Namun, rute 'guestbook.result' dan view-nya mungkin akan digabung dengan 'guestbook.view'
        // atau dihapus jika tidak ada kebutuhan khusus.
        // Untuk sekarang, kita arahkan saja ke viewGuestbook
        return redirect()->route('guestbook.view');
    }

    /**
     * Menampilkan formulir edit untuk entri buku tamu tertentu berdasarkan ID dari database.
     *
     * @param int $id ID dari entri di database.
     */
    public function edit($id)
    {
        // --- Perubahan di sini: Mencari entri berdasarkan ID database ---
        // Temukan entri berdasarkan ID, atau tampilkan 404 jika tidak ditemukan
        $guestbookEntry = Guestbook::findOrFail($id);

        // Kirim objek model $guestbookEntry ke view edit
        // View 'edit.blade.php' Anda harus menerima 'guestbookEntry' dan bukan 'entry' dan 'index'
        return view('guestbook.edit', compact('guestbookEntry'));
    }

    /**
     * Memperbarui entri buku tamu tertentu di database.
     *
     * @param \Illuminate\Http\Request $request Data yang dikirim dari formulir.
     * @param int $id ID dari entri di database.
     */
    public function update(Request $request, $id)
    {
        // Validasi data input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // --- Perubahan di sini: Memperbarui data di database ---
        // Temukan entri berdasarkan ID, atau tampilkan 404 jika tidak ditemukan
        $guestbookEntry = Guestbook::findOrFail($id);

        // Perbarui atribut-atribut entri dengan data baru
        $guestbookEntry->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'message' => $request->input('message'),
        ]);

        // Redirect kembali ke tampilan buku tamu dengan pesan sukses
        return redirect()->route('guestbook.view')->with('success', 'Entri berhasil diperbarui!');
    }

    /**
     * Menghapus entri buku tamu tertentu dari database.
     *
     * @param int $id ID dari entri di database.
     */
    public function destroy($id)
    {
        // --- Perubahan di sini: Menghapus data dari database ---
        // Temukan entri berdasarkan ID, atau tampilkan 404 jika tidak ditemukan
        $guestbookEntry = Guestbook::findOrFail($id);

        // Hapus entri dari database
        $guestbookEntry->delete();

        // Redirect kembali ke tampilan buku tamu dengan pesan sukses
        return redirect()->route('guestbook.view')->with('success', 'Entri berhasil dihapus.');
    }

    /**
     * Mereset (menghapus semua) data buku tamu dari database.
     */
    public function resetGuestbook()
    {
        // --- Perubahan di sini: Menghapus semua data dari tabel database ---
        // Hapus semua data dari tabel 'guestbooks'
        Guestbook::truncate(); // Ini akan menghapus semua record dan mereset ID auto-increment

        // Redirect kembali ke tampilan buku tamu dengan pesan sukses
        return redirect()->route('guestbook.view')->with('success', 'Tabel buku tamu berhasil direset!');
    }
}
