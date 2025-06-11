@extends('app')

@section('content')

<style>
    /* General styling for the body/background, inheriting from
    app.blade if possible */
    body {
        background-color: #f0f2f5; /* Fallback light grey */
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
        /* Using the user's provided background image path and
        darkening it */
        background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0,
                0, 0, 0.5)), url('{{ asset('images/background-wedding-event.jpg') }}');
        background-size: cover;
        background-position: center;
        font-family: 'Inter', sans-serif; /* Using Inter font as per
        guidelines */
        color: #333; /* Default text color */
    }

    .container {
        background-color: rgba(255, 255, 255, 0.95); /* */
        /* Slightly
        transparent white card */
        border-radius: 15px; /* */
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* */
        padding: 30px; /* */
        width: 90%; /* */
        max-width: 900px; /* */
        /* Adjusted max-width for table content */
    }

    h2 {
        text-align: center;
        color: #333;
        margin-bottom: 10px; /* Diperkecil jarak */
        font-size: 2rem;
        font-weight: 600;
    }

    p.lead {
        color: #555;
        margin-bottom: 20px; /* Diperkecil jarak */
        text-align: center; /* <<<--- PERUBAHAN DI SINI: Menjadikan teks rata tengah */
    }

    .button-group {
        margin-bottom: 30px;
        display: flex;
        justify-content: center; /* Memastikan tombol selalu di tengah */
        gap: 15px;
        flex-wrap: wrap;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 0.95rem;
        font-weight: bold;
        text-decoration: none;
        text-align: center;
        transition: background-color 0.3s ease, transform 0.2s ease,
            box-shadow 0.2s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        color: white;
        /* Default white text for buttons */
    }

    .btn-primary {
        background-color: #917373; /* Updated to brownish-grey for
        'Kembali' */
    }

    .btn-primary:hover {
        background-color: #a08484; /* */
        /* Darker hover for brownish-grey */
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-secondary {
        background-color: #623333; /* Updated to darker brown/red for
        'Lihat Buku Tamu' */
    }

    .btn-secondary:hover {
        background-color: #7b4545; /* Darker hover for darker
        brown/red */
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-info {
        /* Style for Edit button */
        background-color: #e0bc59; /* Updated to yellowish-orange */
        min-width: 70px; /* */
        /* Lebar minimum untuk teks 1 baris */
        flex-shrink: 0; /* Mencegah tombol menyusut pada layar kecil */
        white-space: nowrap; /* */
        /* Memastikan teks tidak wrap */
        padding: 10px 15px; /* Mengurangi padding horizontal agar
        lebih ringkas */
    }

    .btn-info:hover {
        background-color: #d1a84f; /* */
        /* Darker hover for
        yellowish-orange */
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-danger {
        /* Style for Delete button */
        background-color: #e09090; /* Updated to pinkish-red */
        min-width: 70px; /* */
        flex-shrink: 0; /* */
        /* Lebar minimum untuk teks 1 baris */
        /* Mencegah tombol menyusut pada layar kecil */
        white-space: nowrap; /* */
        /* Memastikan teks tidak wrap */
        padding: 10px 15px; /* Mengurangi padding horizontal agar
        lebih ringkas */
    }

    .btn-danger:hover {
        background-color: #d18282; /* */
        /* Darker hover for pinkish-red */
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .table-responsive {
        margin-top: 20px;
        overflow-x: auto; /* Ensures table is scrollable on small
        screens */
        border-radius: 8px; /* Rounded corners for the table container */
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .table {
        width: 100%;
        border-collapse: collapse; /* Collapse table borders */
        margin-bottom: 0;
        table-layout: fixed; /* */
        /* Penting: Memaksa kolom mengikuti lebar
        yang ditentukan */
    }

    .table th,
    table td {
        padding: 12px 15px;
        text-align: left;
        /* Default text alignment for table cells */
        border-bottom: 1px solid #ddd; /* Light border for rows */
        word-wrap: break-word;
        /* Mencegah teks terlalu panjang
        membuat kolom melebihi batas */
    }

    .table th:nth-child(1) {
        /* No column header */
        width: 5%;
        /* Adjusted width */
        text-align: center; /* Center "No" header */
        white-space: nowrap;
        /* Memastikan teks "No" tidak wrap */
    }

    .table td:nth-child(1) {
        /* No column data */
        width: 5%; /* Adjusted width */
        text-align: center; /* Center "No" data */
    }

    .table th:nth-child(2),
    table td:nth-child(2) {
        /* Nama Lengkap
        column */
        width: 23%; /* Adjusted width */
    }

    .table th:nth-child(3),
    table td:nth-child(3) {
        /* Email column */
        width: 25%;
    }

    .table th:nth-child(4),
    table td:nth-child(4) {
        /* Pesan column */
        width: 22%; /* Adjusted width for Pesan */
    }

    .table th:nth-child(5),
    table td:nth-child(5) {
        /* Aksi column */
        width: 25%; /* Adjusted width for Aksi to accommodate buttons */
        text-align: left; /* Header 'Aksi' rata kiri */
    }

    .table th {
        background-color: #f2f2f2; /* Light header background */
        font-weight: bold;
        color: #333;
        text-transform: uppercase;
        font-size: 0.9em;
        text-align: center;
        /* Center all table headers for better
        symmetry */
    }

    .table tr:nth-child(even) {
        background-color: #f9f9f9;
        /* Zebra striping for readability */
    }

    .table tr:hover {
        background-color: #f1f1f1; /* Hover effect for rows */
    }

    .table tbody tr:last-child td {
        border-bottom: none; /* No border for the last row */
    }

    .action-buttons {
        display: flex;
        gap: 8px; /* Space between action buttons */
        justify-content: flex-start; /* Menggeser tombol ke kiri */
    }
</style>

<div class="container">
    <h2>Data Berhasil Disimpan</h2>
    <p class="lead">Terimakasih atas kehadiran anda.</p>

    <div class="button-group">
        <a href="{{ route('home') }}" class="btn btn-primary">Kembali</a>
        <a href="{{ route('guestbook.view') }}" class="btn btn-secondary">Lihat Buku Tamu</a>
    </div>

    @if ($guestbookData)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Pesan</th>
                        {{-- <th>Aksi</th> --}}
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>{{ $guestbookData['name'] ?? '-' }}</td>
                        <td>{{ $guestbookData['email'] ?? '-' }}</td>
                        <td>{{ $guestbookData['message'] ?? '-' }}</td>
                        <td class="action-buttons">
                            {{-- Tombol Edit --}}
                            {{-- Menggunakan $lastSubmittedEntryIndex yang diteruskan dari controller --}}
                            <a href="{{ route('guestbook.edit', $lastSubmittedEntryIndex) }}"
                                class="btn btn-info">Edit</a>
                            {{-- Tombol Hapus (menggunakan form DELETE) --}}
                            {{-- Menggunakan $lastSubmittedEntryIndex yang diteruskan dari controller --}}
                            <form action="{{ route('guestbook.destroy', $lastSubmittedEntryIndex) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">
            Tidak ada data yang tersedia. Silakan isi formulir terlebih dahulu.
        </div>
    @endif
</div>

@endsection
