<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Guestbook; // Pastikan ini mengacu pada model Anda di app/Models/Guestbook.php

class GuestbookController extends Controller
{
    /**
     * Menampilkan formulir buku tamu.
     */
    public function showForm()
    {
        return view('guestbook.form');
    }

    /**
     * Memproses pengiriman formulir buku tamu dan menyimpan data ke database.
     */
    public function submitForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Simpan data ke DATABASE
        $guestbookEntry = Guestbook::create([ // Menggunakan model Guestbook untuk membuat entri
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'message' => $request->input('message'),
        ]);

        // Ambil ID dari entri yang baru disimpan di database
        $lastSubmittedEntryId = $guestbookEntry->id;

        // Flash data untuk halaman result (untuk tampilan detail entri terakhir)
        session()->flash('lastSubmittedGuestbookData', [
            'name' => $guestbookEntry->name,
            'email' => $guestbookEntry->email,
            'message' => $guestbookEntry->message,
        ]);
        session()->flash('lastSubmittedEntryIndex', $lastSubmittedEntryId); // Ini adalah ID database

        // Mengarahkan ke halaman hasil
        return redirect()->route('guestbook.result');
    }

    /**
     * Menampilkan semua entri buku tamu dari database.
     */
    public function viewGuestbook()
    {
        // Ambil semua entri dari tabel guestbooks di database
        $guestbookEntries = Guestbook::all(); // Menggunakan model Guestbook untuk mengambil semua data

        return view('guestbook.view', ['mergedGuestbookData' => $guestbookEntries]);
    }

    /**
     * Menampilkan hasil entri buku tamu yang baru saja disubmit.
     */
    public function viewGuestbookResult()
    {
        $guestbookData = session('lastSubmittedGuestbookData');
        $lastSubmittedEntryIndex = session('lastSubmittedEntryIndex'); // Ini adalah ID dari database

        if (is_null($guestbookData) || is_null($lastSubmittedEntryIndex)) {
            // Jika halaman di-refresh atau diakses langsung, data mungkin hilang.
            return redirect()->route('home')->with('error', 'Data entri tidak ditemukan. Silakan isi formulir kembali.');
        }

        return view('guestbook.result', compact('guestbookData', 'lastSubmittedEntryIndex'));
    }

    /**
     * Menampilkan formulir edit untuk entri buku tamu tertentu berdasarkan ID database.
     * @param int $id ID dari entri di database.
     */
    public function edit($id)
    {
        $entry = Guestbook::findOrFail($id); // Menggunakan model Guestbook untuk mencari entri
        return view('guestbook.edit', compact('entry', 'id'));
    }

    /**
     * Memperbarui entri buku tamu tertentu di database.
     * @param Request $request Data yang dikirim dari formulir.
     * @param int $id ID dari entri di database.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $guestbookEntry = Guestbook::findOrFail($id); // Menggunakan model Guestbook
        $guestbookEntry->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'message' => $request->input('message'),
        ]);

        return redirect()->route('guestbook.view')->with('success', 'Entri berhasil diperbarui!');
    }

    /**
     * Menghapus entri buku tamu tertentu dari database.
     * @param int $id ID dari entri di database.
     */
    public function destroy($id)
    {
        $guestbookEntry = Guestbook::findOrFail($id); // Menggunakan model Guestbook
        $guestbookEntry->delete();
        return redirect()->route('guestbook.view')->with('success', 'Entri berhasil dihapus.');
    }

    /**
     * Menghapus semua entri buku tamu dari database (reset tabel).
     */
    /**public function resetGuestbook()
    {
        Guestbook::truncate(); // Menggunakan model Guestbook untuk menghapus semua record
        return redirect()->route('guestbook.view')->with('success', 'Tabel buku tamu berhasil direset!');
    }*/
}
