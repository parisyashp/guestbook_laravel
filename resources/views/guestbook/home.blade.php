@extends('app')

@section('content')
<style>
    body {
        background-color: #f0f2f5;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
        background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('images/background-wedding-event.jpg') }}');
        background-size: cover;
        background-position: center;
        font-family: 'Inter', sans-serif;
        color: #fff; /* Teks putih agar terlihat di background gelap */
        text-align: center;
    }
    .container-home {
        background-color: rgba(255, 255, 255, 0.1); /* Sedikit transparan untuk efek */
        border-radius: 15px;
        padding: 40px;
        max-width: 600px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(5px); /* Efek blur pada background */
        -webkit-backdrop-filter: blur(5px); /* Kompatibilitas Safari */
    }
    h1 {
        font-size: 3rem;
        margin-bottom: 20px;
        font-weight: 700;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }
    p {
        font-size: 1.2rem;
        margin-bottom: 30px;
        line-height: 1.6;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
    }
    .button-group {
        display: flex;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap; /* Agar responsif di layar kecil */
    }
    .btn {
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 1.1rem;
        font-weight: bold;
        text-decoration: none;
        text-align: center;
        transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        color: white;
    }
    .btn-fill {
        background-color: #623333; /* Warna gelap sesuai tema */
    }
    .btn-fill:hover {
        background-color: #7b4545;
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
    }
    .btn-view {
        background-color: #917373; /* Warna lebih terang sesuai tema */
    }
    .btn-view:hover {
        background-color: #a08484;
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
    }
</style>

<div class="container-home">
    <h1>Selamat Datang!</h1>
    <p>Silahkan isi buku tamu ini dan jadi bagian dari cerita kami.</p>
    <div class="button-group">
        <a href="{{ route('guestbook.create') }}" class="btn btn-fill">Isi Buku Tamu</a>
        <a href="{{ route('guestbook.view') }}" class="btn btn-view">Lihat Buku Tamu</a>
    </div>
</div>
@endsection
