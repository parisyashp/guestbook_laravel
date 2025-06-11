<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Faker\Factory; // Pastikan ini diimpor jika Anda masih menggunakan Faker di tempat lain

class GuestbookController extends Controller
{
    /**
     * Menampilkan formulir buku tamu.
     */
    public function showForm()
    {
        return view('guestbook.form'); //
    }

    /**
     * Memproses pengiriman formulir buku tamu dan menyimpan data ke sesi.
     */
    public function submitForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $guestbookData = [ //
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'message' => $request->input('message'), //
        ];

        // Ambil data buku tamu dari sesi
        $guestbook = session('guestbook', []); //

        // Hitung indeks untuk entri baru sebelum menambahkannya
        $lastSubmittedEntryIndex = count($guestbook); //

        // Tambahkan entri baru ke array buku tamu
        $guestbook[] = $guestbookData; //

        // Simpan kembali array buku tamu yang sudah diperbarui ke sesi
        session(['guestbook' => $guestbook]); //

        // Simpan data entri terakhir dan index-nya ke sesi flash
        session()->flash('lastSubmittedGuestbookData', $guestbookData); //
        session()->flash('lastSubmittedEntryIndex', $lastSubmittedEntryIndex); //

        return redirect()->route('guestbook.result'); //
    }

    /**
     * Menampilkan semua entri buku tamu dari sesi.
     * Tidak lagi menghasilkan data palsu secara otomatis di sini.
     */
    public function viewGuestbook() //
    {
        // Ambil data buku tamu dari sesi.
        // Jika sesi 'guestbook' kosong, maka akan kembali array kosong.
        $guestbook = session('guestbook', []); //

        // Jika Anda masih ingin data palsu sebagai 'dummy' saat pertama kali kosong,
        // Anda bisa tambahkan logika di sini untuk HANYA menghasilkan data palsu
        // jika sesi benar-benar kosong dan belum pernah ada data yang dimasukkan.
        // Contoh:
        // if (empty($guestbook) && !session()->has('has_initial_fake_data')) { //
        //     $faker = Factory::create(); //
        //     for ($i = 0; $i < 10; $i++) { //
        //         $guestbook[] = [ //
        //             'name' => $faker->name(), //
        //             'email' => $faker->email(), //
        //             'message' => ucwords($faker->catchPhrase . ' ' . $faker->bs), //
        //         ];
        //     }
        //     session(['guestbook' => $guestbook]); // Simpan data palsu ini ke sesi //
        //     session()->put('has_initial_fake_data', true); // Penanda bahwa data palsu awal sudah dibuat //
        // }

        // Sekarang $guestbook berisi data asli pengguna. //
        // Jika Anda ingin data palsu muncul lagi setelah reset,
        // logika di atas bisa dipertimbangkan, atau Anda bisa menampilkan pesan 'kosong'.
        return view('guestbook.view', ['mergedGuestbookData' => $guestbook]); //
    }

    /**
     * Menampilkan hasil entri buku tamu yang baru saja disubmit.
     */
    public function viewGuestbookResult()
    {
        $guestbookData = session('lastSubmittedGuestbookData'); //
        $lastSubmittedEntryIndex = session('lastSubmittedEntryIndex'); //

        if (is_null($guestbookData) || is_null($lastSubmittedEntryIndex)) {
            return redirect()->route('home')->with('error', 'Data entri tidak ditemukan. Silakan isi formulir kembali.'); //
        }

        return view('guestbook.result', compact('guestbookData', 'lastSubmittedEntryIndex')); //
    }

    /**
     * Menampilkan formulir edit untuk entri buku tamu tertentu berdasarkan index.
     * @param int $index Index dari entri di array sesi. //
     */
    public function edit($index)
    {
        $guestbook = session('guestbook', []); //
        if (isset($guestbook[$index])) {
            $entry = $guestbook[$index]; //
            return view('guestbook.edit', compact('entry', 'index')); //
        }
        return redirect()->back()->with('error', 'Entri tidak ditemukan.'); //
    }

    /**
     * Memperbarui entri buku tamu tertentu di sesi.
     * @param Request $request Data yang dikirim dari formulir. //
     * @param int $index Index dari entri di array sesi. //
     */
    public function update(Request $request, $index) //
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput(); //
        }

        $guestbook = session('guestbook', []); //
        if (isset($guestbook[$index])) {
            $guestbook[$index] = [ //
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'message' => $request->input('message'),
            ];
            session(['guestbook' => $guestbook]); //
            return redirect()->route('guestbook.view')->with('success', 'Entri berhasil diperbarui!'); //
        }
        return redirect()->back()->with('error', 'Entri tidak ditemukan.'); //
    }

    /**
     * Menghapus entri buku tamu tertentu dari sesi.
     * @param int $index Index dari entri di array sesi. //
     */
    public function destroy($index) //
    {
        $guestbook = session('guestbook', []); //
        if (isset($guestbook[$index])) {
            array_splice($guestbook, $index, 1); //
            session(['guestbook' => $guestbook]); //
            return redirect()->route('guestbook.view')->with('success', 'Entri berhasil dihapus.'); //
        }
        return redirect()->back()->with('error', 'Entri tidak ditemukan.'); //
    }

    /**
     * Menghapus semua entri buku tamu dari sesi (reset tabel).
     */
    public function resetGuestbook() //
    {
        session()->forget('guestbook'); // Hapus semua data 'guestbook' dari sesi //
        // Jika Anda menggunakan penanda 'has_initial_fake_data' di viewGuestbook(), //
        // Anda juga harus menghapusnya di sini agar data palsu bisa dibuat lagi. //
        // session()->forget('has_initial_fake_data'); //
        return redirect()->route('guestbook.view')->with('success', 'Tabel buku tamu berhasil di-reset.'); //
    }
}