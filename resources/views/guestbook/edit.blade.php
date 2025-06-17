@extends('app')

@section('content')

<style>
    /* General styling for the body/background, consistent with
    form.blade.php */
    body {
        background-color: #f0f2f5; /* Fallback light grey */
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
        background-image: linear-gradient(rgba(0, 0, 0, 0.5),
                rgba(0, 0, 0, 0.5)), url('{{ asset('images/background-wedding-event.jpg') }}');
        background-size: cover;
        background-position: center;
        font-family: 'Inter', sans-serif;
        color: #333;
    }

    .card-container {
        background-color: rgba(255, 255, 255, 0.95); /* */
        /* Slightly
        transparent white card */
        border-radius: 15px; /* */
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* */
        display: flex;
        width: 90%; /* */
        max-width: 800px; /* */
        overflow: hidden; /* */
        flex-direction: column; /* */
        align-items: stretch; /* */
    }

    @media (min-width: 768px) {
        .card-container {
            flex-direction: row;
        }
    }

    .left-section {
        flex: 1;
        padding: 30px;
        background-color: #f8f9fa;
        display: flex;
        flex-direction: column;
        align-items: center;
        border-bottom: 1px solid #eee;
        position: relative;
    }

    @media (min-width: 768px) {
        .left-section {
            border-right: 1px solid #eee;
            border-bottom: none;
        }
    }

    .left-section img {
        position: absolute;
        top: 30px;
        bottom: 30px;
        /* Adjusted to try and align with form content bottom */
        left: 30px;
        right: 30px;
        max-width: unset;
        height: auto;
        width: auto;
        object-fit: contain;
        border: 2px solid #623333;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .right-section {
        flex: 1.5;
        padding: 30px;
    }

    h2 {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        text-align: center;
        color: #333;
        margin-bottom: 25px;
        font-size: 1.8rem;
        font-weight: 600;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #555;
        font-weight: bold;
        font-size: 0.95rem;
    }

    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group input[type="tel"],
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 1rem;
        background-color: #f9f9f9;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        box-sizing: border-box;
    }

    .form-group input[type="text"]:focus,
    .form-group input[type="email"]:focus,
    .form-group input[type="tel"]:focus,
    .form-group textarea:focus {
        border-color: #623333;
        box-shadow: 0 0 5px rgba(98, 51, 51, 0.5);
        outline: none;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .button-group {
        display: flex;
        justify-content: space-between;
        margin-top: auto;
        gap: 15px;
        flex-wrap: wrap;
        width: 100%;
        padding: 0 12px;
        box-sizing: border-box;
    }

    .btn {
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 1rem;
        font-weight: bold;
        text-decoration: none;
        text-align: center;
        transition: background-color 0.3s ease, transform 0.2s ease,
            box-shadow 0.2s ease;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        flex-grow: 1;
        min-width: 120px;
    }

    .btn-primary {
        background-color: #623333;
        color: white;
    }

    .btn-primary:hover {
        background-color: #764545;
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .btn-secondary {
        background-color: #917373;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #a08484;
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .error-message {
        color: #dc3545;
        font-size: 0.85em;
        margin-top: 5px;
        background-color: #ffeaea;
        border-left: 3px solid #dc3545;
        padding: 8px 10px;
        border-radius: 4px;
    }

    .alert-danger {
        background-color: #ffeaea;
        color: #dc3545;
        border: 1px solid #dc3545;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }

    .alert-danger ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .alert-danger ul li {
        margin-bottom: 5px;
    }
</style>

<div class="card-container">
    <div class="left-section">
        <img src="{{ asset('images/RSVP.png') }}" alt="RSVP Invitation">
    </div>
    <div class="right-section">
        <h2>Edit Entri Buku Tamu</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form action harus menggunakan $index, bukan $id --}}
        {{-- Method harus disesuaikan dengan route update di Guestbook Controller (PUT) --}}
        <form action="{{ route('guestbook.update', $id) }}" method="POST">
            @csrf
            @method('POST') {{-- Gunakan POST jika route Anda Route::post() --}}
            <div class="form-group">
                <label for="name">Nama Lengkap:</label>
                
                <input type="text" id="name" name="name" class="form-control"
                    value="{{ old('name', $entry->name ?? '') }}" placeholder="Masukkan nama lengkap" required>
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                {{-- Menggunakan $entry['email'] --}}
                <input type="email" id="email" name="email" class="form-control"
                    value="{{ old('email', $entry->email ?? '') }}" placeholder="Masukkan email Anda" required>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="message">Pesan: </label>
                {{-- Menggunakan $entry->message --}}
                <textarea id="message" name="message" class="form-control" rows="5" placeholder="Tuliskan pesan Anda"
                    required>{{ old('message', $entry->message ?? '') }}</textarea>
                @error('message')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('guestbook.view') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection