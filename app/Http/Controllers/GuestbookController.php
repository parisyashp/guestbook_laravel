<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Guestbook; // Menggunakan model Guestbook.php

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

        // Simpan data ke DATABASE (menggunakan model Guestbook)
        $guestbookEntry = Guestbook::create([
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
        session()->flash('lastSubmittedEntryIndex', $lastSubmittedEntryId); // Sekarang ini adalah ID database

        return redirect()->route('guestbook.result');
    }

    /**
     * Menampilkan semua entri buku tamu dari database.
     */
    public function viewGuestbook()
    {
        // Ambil semua entri dari tabel guestbooks di database (menggunakan model Guestbook)
        $guestbookEntries = Guestbook::all();

        // Gunakan nama variabel yang konsisten dengan view Anda
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
        // Ambil data dari database berdasarkan ID (menggunakan model Guestbook)
        $entry = Guestbook::findOrFail($id); // Mencari entri berdasarkan ID, atau 404 jika tidak ditemukan

        return view('guestbook.edit', compact('entry', 'id')); // Lewatkan 'id' dan 'entry' (sebagai objek Eloquent)
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

        // Update data di DATABASE (menggunakan model Guestbook)
        $guestbookEntry = Guestbook::findOrFail($id);
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
        // Hapus data dari DATABASE (menggunakan model Guestbook)
        $guestbookEntry = Guestbook::findOrFail($id);
        $guestbookEntry->delete();
        return redirect()->route('guestbook.view')->with('success', 'Entri berhasil dihapus.');
    }

    /**
     * Menghapus semua entri buku tamu dari database (reset tabel).
     */
    /*public function resetGuestbook()
    {

        Guestbook::truncate(); // Ini akan menghapus semua record dan me-reset auto-increment ID
        return redirect()->route('guestbook.view')->with('success', 'Tabel buku tamu berhasil di-reset.');
    }*/
}
