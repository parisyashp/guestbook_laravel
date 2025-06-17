@extends('app')

@section('content')
    <style>
        /* General styling for the body/background, inheriting from app.blade if possible */
        body {
            background-color: #f0f2f5; /* Fallback light grey - will be overridden if app.blade has its own */
            display: flex;
            flex-direction: column; /* Changed to column to stack header and container */
            justify-content: flex-start; /* Align content to the top */
            align-items: center; /* Center horizontally */
            min-height: 100vh;
            margin: 0;
            /* Removed background-image and darkening */
            font-family: 'Inter', sans-serif; /* Using Inter font as per guidelines */
            color: #333; /* Default text color */
            padding-top: 0; /* Remove top padding as the header will handle spacing */
        }
        .header-bar {
            background-color: #623333; /* Warna sesuai dengan button-primary */
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between; /* Memisahkan elemen ke ujung */
            align-items: center;
            width: 100%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-bottom-left-radius: 8px; /* Rounded bottom corners */
            border-bottom-right-radius: 8px; /* Rounded bottom corners */
            position: sticky; /* Membuat header tetap di atas saat digulir */
            top: 0;
            z-index: 1000; /* Memastikan header di atas konten lain */
        }
        .header-bar h2 {
            margin: 0 auto; /* Menengahkan judul */
            color: white;
            font-size: 1.8rem;
            flex-grow: 1; /* Memungkinkan judul mengisi ruang di antara tombol */
            text-align: center;
        }
        .header-bar .btn-back {
            background-color: #917373; /* Warna tombol kembali */
            color: white;
            padding: 8px 15px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            display: flex; /* Untuk ikon dan teks */
            align-items: center;
            gap: 8px; /* Meningkatkan jarak antara ikon dan teks untuk kerapian */
            white-space: nowrap; /* Memastikan teks tidak wrap */
        }
        .header-bar .btn-back:hover {
            background-color: #a08484;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
        /* Style for the SVG icon */
        .header-bar .btn-back svg {
            fill: currentColor; /* Inherit color from parent */
            width: 1.2em; /* Adjust size */
            height: 1.2em;
            /* Tambahkan margin kanan pada SVG untuk pemisahan yang lebih jelas */
            margin-right: -3px; /* Sesuaikan ini untuk mengatur jarak */
        }
        /* Style for Reset Table button in header */
        .header-bar .btn-danger {
            background-color: #e09090; /* Consistent with danger color */
            color: white;
            padding: 8px 15px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            white-space: nowrap; /* Memastikan teks tidak wrap */
        }
        .header-bar .btn-danger:hover {
            background-color: #d18282;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .container {
            padding: 20px; /* Reduced padding */
            width: 95%; /* Wider table */
            max-width: 1200px; /* Increased max-width for wider table */
            text-align: center;
            margin-bottom: 30px; /* Add margin at the bottom */
            margin-top: 0; /* REMOVED margin-top to bring it closer to header */
        }
        p.lead {
            color: #555;
            margin-bottom: 20px; /* Diperkecil jarak */
        }
        /* Removed original .button-group as it's now in header */

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.95rem;
            font-weight: bold;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: white; /* Default white text for buttons */
        }
        .btn-primary {
            background-color: #917373;
        }
        .btn-primary:hover {
            background-color: #a08484;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        .btn-secondary {
            background-color: #623333;
        }
        .btn-secondary:hover {
            background-color: #7b4545;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        .btn-info { /* Style for Edit button */
            background-color: #e0bc59;
            min-width: 90px; /* Lebar minimum untuk teks 1 baris */
            flex-shrink: 0;
            white-space: nowrap; /* Memastikan teks tidak wrap */
            padding: 10px 15px;
        }
        .btn-info:hover {
            background-color: #d1a84f;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        .btn-danger { /* Style for Delete button */
            background-color: #e09090;
            min-width: 90px; /* Lebar minimum untuk teks 1 baris */
            flex-shrink: 0;
            white-space: nowrap; /* Memastikan teks tidak wrap */
            padding: 10px 15px;
        }
        .btn-danger:hover {
            background-color: #d18282;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        .table-responsive {
            margin-top: 20px; /* Keep a small margin from the top of the container */
            overflow-x: auto; /* Ensures table is scrollable on small screens */
            border-radius: 8px; /* Rounded corners for the table container */
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); /* Keep shadow for the table itself */
            background-color: #fff; /* Added white background for the table content */
        }
        .table {
            width: 100%;
            border-collapse: collapse; /* Collapse table borders */
            margin-bottom: 0;
            table-layout: fixed; /* Penting: Memaksa kolom mengikuti lebar yang ditentukan */
            /* background-color: #fff; /* Moved to .table-responsive for consistent background with shadow */ */
        }
        .table th, .table td {
            padding: 12px 15px;
            text-align: left; /* Default text alignment for table cells */
            border-bottom: 1px solid #ddd; /* Light border for rows */
            word-wrap: break-word; /* Mencegah teks terlalu panjang membuat kolom melebihi batas */
        }
        /* No column header and data */
        .table th:nth-child(1) {
            width: 8%; /* Adjusted width for "No" to prevent wrap */
            text-align: center; /* Center "No" header */
            white-space: nowrap; /* Memastikan teks "No" tidak wrap */
            padding: 12px 5px; /* Reduced padding for "No" column */
        }
        .table td:nth-child(1) {
            width: 8%; /* Adjusted width for "No" data */
            text-align: center; /* Center "No" data */
            padding: 12px 5px; /* Reduced padding for "No" column */
        }

        .table th:nth-child(2), .table td:nth-child(2) { /* Nama Lengkap column */
            width: 22%; /* Adjusted width */
        }
        .table th:nth-child(3), .table td:nth-child(3) { /* Email column */
            width: 25%;
        }
        .table th:nth-child(4), .table td:nth-child(4) { /* Pesan column */
            width: 25%; /* Adjusted width for Pesan */
        }
        .table th:nth-child(5) { /* Aksi column header */
            width: 20%; /* Adjusted width for Aksi to accommodate buttons */
            text-align: left; /* Header 'Aksi' rata kiri */
        }
        .table td:nth-child(5) { /* Aksi column data */
            width: 20%; /* Adjusted width for Aksi to accommodate buttons */
            text-align: left; /* Data 'Aksi' rata kiri */
        }
        .table th {
            background-color: #f2f2f2; /* Light header background */
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
            font-size: 0.9em;
        }
        /* Apply text-align center for all headers except Aksi */
        .table th:not(:nth-child(5)) {
            text-align: center;
        }

        .table tr:nth-child(even) {
            background-color: #f9f9f9; /* Zebra striping for readability */
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

        /* Styling for the custom confirmation modal */
        #confirmationModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        #confirmationModal > div {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            text-align: center;
            max-width: 400px;
            width: 90%;
        }
        #confirmationModal p {
            font-size: 1.1em;
            margin-bottom: 20px;
        }
        /* Updated modal button styles to match .btn, then override specific colors */
        #confirmationModal button {
            padding: 10px 20px;
            border: none;
            border-radius: 8px; /* Consistent with other buttons */
            cursor: pointer;
            margin-right: 10px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Consistent with other buttons */
        }
        #confirmationModal #confirmDeleteBtn {
            background-color: #e09090;
            color: white;
        }
        #confirmationModal #confirmDeleteBtn:hover {
            background-color: #d18282;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        #confirmationModal button:last-child {
            background-color: #ccc;
            color: #333;
            margin-right: 0;
        }
        #confirmationModal button:last-child:hover {
            background-color: #bbb;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        /* Styling for the custom confirmation modal for Reset Table (mirroring Delete modal styles) */
        #resetConfirmationModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        #resetConfirmationModal > div {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            text-align: center;
            max-width: 400px;
            width: 90%;
        }
        #resetConfirmationModal p {
            font-size: 1.1em;
            margin-bottom: 20px;
        }
        /* Updated modal button styles for reset modal as well */
        #resetConfirmationModal button {
            padding: 10px 20px;
            border: none;
            border-radius: 8px; /* Consistent with other buttons */
            cursor: pointer;
            margin-right: 10px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Consistent with other buttons */
        }
        #resetConfirmationModal #confirmResetBtn {
            background-color: #e09090;
            color: white;
        }
        #resetConfirmationModal #confirmResetBtn:hover {
            background-color: #d18282;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        #resetConfirmationModal button:last-child {
            background-color: #ccc;
            color: #333;
            margin-right: 0;
        }
        #resetConfirmationModal button:last-child:hover {
            background-color: #bbb;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
    </style>

    {{-- Header Bar --}}
    <div class="header-bar">
        <a href="{{ route('home') }}" class="btn-back">
            {{-- SVG icon for a minimalist home --}}
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2L2 12h3v8h6v-6h2v6h6v-8h3L12 2z"/>
            </svg>
            Kembali
        </a>
        <h2>Daftar Tamu</h2>
        {{-- Tombol Reset Tabel --}}
        {{-- Pastikan Anda memiliki route 'guestbook.reset' dan method di controller Anda --}}
        {{-- <form action="{{ route('guestbook.reset') }}" method="POST" style="display:inline;"> --}}
            {{-- @csrf --}}
            {{-- @method('POST')--}} {{-- Atau DELETE jika route reset menggunakan DELETE --}}
            {{-- <button type="button" class="btn btn-danger" onclick="showResetConfirmation('{{ route('guestbook.reset') }}')">Reset Tabel</button> --}}
        {{-- </form> --}}
    </div>

    {{-- Main content container --}}
    <div class="container">
        @if (isset($mergedGuestbookData) && $mergedGuestbookData->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Pesan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mergedGuestbookData as $guestbookEntry)
                            <tr>
                                <td>{{ $loop->iteration }}</td> {{-- Gunakan $loop->iteration untuk nomor urut --}}
                                <td>{{ $guestbookEntry->name ?? '-' }}</td> {{-- Akses sebagai objek ->name --}}
                                <td>{{ $guestbookEntry->email ?? '-' }}</td> {{-- Akses sebagai objek ->email --}}
                                <td>{{ $guestbookEntry->message ?? '-' }}</td> {{-- Akses sebagai objek ->message --}}
                                <td class="action-buttons">
                                    <a href="{{ route('guestbook.edit', $guestbookEntry->id) }}" class="btn btn-info">Edit</a> {{-- Gunakan $guestbookEntry->id --}}
                                    {{-- Menggunakan modal konfirmasi kustom untuk hapus --}}
                                    <form action="{{ route('guestbook.destroy', $guestbookEntry->id) }}" method="POST" style="display:inline;"> {{-- Gunakan $guestbookEntry->id --}}
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger" onclick="showDeleteConfirmation('{{ route('guestbook.destroy', $guestbookEntry->id) }}')">Hapus</button> {{-- Gunakan $guestbookEntry->id --}}
                                    </form>
    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                Belum ada data di buku tamu.
            </div>
        @endif
    </div>

    {{-- Custom Confirmation Modal for Delete --}}
    <div id="confirmationModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
        <div style="background-color: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); text-align: center; max-width: 400px; width: 90%;">
            <p style="font-size: 1.1em; margin-bottom: 20px;">Apakah Anda yakin ingin menghapus data ini?</p>
            <button id="confirmDeleteBtn" class="btn btn-danger">Ya, Hapus</button>
            <button onclick="hideDeleteConfirmation()" class="btn btn-secondary">Batal</button>
        </div>
    </div>

    {{-- Custom Confirmation Modal for Reset Table --}}
    <div id="resetConfirmationModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
        <div style="background-color: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); text-align: center; max-width: 400px; width: 90%;">
            <p style="font-size: 1.1em; margin-bottom: 20px;">Apakah Anda yakin ingin me-reset seluruh tabel buku tamu?</p>
            <button id="confirmResetBtn" class="btn btn-danger">Ya, Reset</button>
            <button onclick="hideResetConfirmation()" class="btn btn-secondary">Batal</button>
        </div>
    </div>


    <script>
        // DIKOREKSI: Bungkus kode JavaScript dalam IIFE (Immediately Invoked Function Expression)
        // untuk mencegah kesalahan deklarasi ulang variabel
        (function() {
            let deleteFormAction = '';
            let resetFormAction = '';

            window.showDeleteConfirmation = function(actionUrl) { // Jadikan global
                deleteFormAction = actionUrl;
                document.getElementById('confirmationModal').style.display = 'flex';
            };

            window.hideDeleteConfirmation = function() { // Jadikan global
                document.getElementById('confirmationModal').style.display = 'none';
            };

            window.showResetConfirmation = function(actionUrl) { // Jadikan global
                resetFormAction = actionUrl;
                document.getElementById('resetConfirmationModal').style.display = 'flex';
            };

            window.hideResetConfirmation = function() { // Jadikan global
                document.getElementById('resetConfirmationModal').style.display = 'none';
            };

            // Event listener for "Ya, Hapus" button in delete modal
            document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = deleteFormAction;
                form.style.display = 'none';

                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                form.appendChild(csrfInput);

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);

                document.body.appendChild(form);
                form.submit();
            });

            // Event listener for "Ya, Reset" button in reset modal
            document.getElementById('confirmResetBtn').addEventListener('click', function() {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = resetFormAction;
                form.style.display = 'none';

                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                form.appendChild(csrfInput);

                document.body.appendChild(form);
                form.submit();
            });
        })(); // Akhir dari IIFE
    </script>
@endsection
