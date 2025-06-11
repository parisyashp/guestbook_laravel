@extends('app')

@section('content')
    <div class="background-container">
        <div class="container d-flex flex-column justify-content-center align-items-center vh-100">
            <div class="text-center">
                <h1 class="display-4 fw-bold text-white">Selamat Datang!</h1>
                <p class="lead text-white">Silahkan isi buku tamu ini dan jadi bagian dari cerita kami.</p>
                <div class="my-4">
                    <a href="{{ route('guestbook.form') }}" class="btn btn-lg btn-primary mx-2">Isi Buku Tamu</a>
                    <a href="{{ route('guestbook.view') }}" class="btn btn-lg btn-secondary mx-2">Lihat Buku Tamu</a>
                </div>
            </div>
        </div>
    </div>
@endsection
