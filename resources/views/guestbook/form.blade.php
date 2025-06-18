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
        min-height: 100vh; /* */
        margin: 0;
        /* Using the user's provided background image path and
        darkening it */
        background-image: linear-gradient(rgba(0, 0, 0, 0.5),
                rgba(0, 0, 0, 0.5)), url('{{ asset('images/background-wedding-event.jpg') }}'); /* */
        background-size: cover; /* */
        background-position: center; /* */
        font-family: 'Inter', sans-serif; /* Using Inter font as per
        guidelines */ /* */
    }

    .card-container {
        /* Slightly
        transparent white card */
        background-color: rgba(255, 255, 255, 0.95); /* */
        border-radius: 15px; /* */
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* */
        display: flex; /* */
        width: 90%; /* Responsive width */
        max-width: 800px; /* */
        /* Max width for the card */
        overflow: hidden;
        flex-direction: column; /* Stack vertically on small screens */
        align-items: stretch; /* */
        /* Ensure children stretch to fill
        height */
    }

    @media (min-width: 768px) {
        .card-container {
            flex-direction: row; /* Side-by-side on larger screens */ /* */
        }
    }

    .left-section {
        flex: 1; /* */
        padding: 30px; /* Adjusted padding for symmetry */ /* */
        background-color: #f8f9fa; /* Light background for the RSVP
        image side */ /* */
        display: flex; /* */
        flex-direction: column; /* Allows vertical alignment of
        content */ /* */
        align-items: center; /* Centers image horizontally if smaller
        than section */ /* */
        border-bottom: 1px solid #eee; /* Separator for small screens */ /* */
        position: relative; /* */
        /* Added for absolute positioning of image */
    }

    @media (min-width: 768px) {
        .left-section {
            border-right: 1px solid #eee; /* Separator for larger
            screens */ /* */
            border-bottom: none; /* */
        }
    }

    .left-section img {
        /* Absolute positioning to align with content on the right */
        position: absolute; /* */
        top: 30px; /* */
        /* Aligns with top padding of right-section content */
        bottom: 42px; /* Adjusted to align with bottom of buttons */ /* */
        left: 30px; /* */
        /* Aligns with padding left */
        right: 30px; /* Aligns with padding right */ /* */
        max-width: unset; /* */
        /* Override max-width to allow filling the
        container */
        height: auto; /* Maintain aspect ratio */
        width: auto; /* Maintain aspect ratio */
        object-fit: contain; /* */
        /* Ensure it fits while maintaining
        aspect ratio: */
        border: 2px solid #623333; /* Updated border color */ /* */
        border-radius: 8px; /* */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* */
    }

    .right-section {
        flex: 1.5; /* Give more space to the form */ /* */
        padding: 30px; /* Adjusted padding for symmetry */ /* */
        display: flex; /* */
        flex-direction: column; /* */
        justify-content: space-between; /* */
        /* To push button-group to the
        bottom */
    }

    .form-content {
        /* Container for form fields to push them to the top */
        flex-grow: 1; /* */
    }

    h2 {
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
        display: block; /* */
        margin-bottom: 8px; /* */
        color: #555;
        font-weight: bold;
        font-size: 0.95rem;
    }

    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group input[type="tel"],
    .form-group textarea {
        width: 100%; /* */
        /* Make them fill the container */
        padding: 12px; /* */
        border: 1px solid #ccc; /* */
        border-radius: 8px; /* */
        font-size: 1rem; /* */
        background-color: #f9f9f9; /* */
        /* light background for inputs */
        transition: border-color 0.3s ease, box-shadow 0.3s ease; /* */
        box-sizing: border-box; /* */
        /* Crucial: Ensures padding doesn't
        add to width */
    }

    .form-group input[type="text"]:focus,
    .form-group input[type="email"]:focus,
    .form-group input[type="tel"]:focus,
    .form-group textarea:focus {
        /* Updated focus border color */
        border-color: #623333; /* */
        box-shadow: 0 0 5px rgba(98, 51, 51, 0.5); /* Updated focus
        shadow color */ /* */
        outline: none; /* */
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .button-group {
        display: flex;
        justify-content: space-between;
        margin-top: 20px; /* */
        /* Adjusted margin-top to reduce gap if
        needed */
        gap: 15px; /* Space between buttons */
        flex-wrap: wrap; /* */
        /* Allow buttons to wrap on smaller screens */
        width: 100%; /* Ensure button group spans full width */
        padding: 0 12px; /* */
        /* Add horizontal padding to match input's
        inner padding */
        box-sizing: border-box; /* Ensure padding doesn't add to width */
    }

    .btn {
        padding: 12px 25px;
        border: none; /* */
        border-radius: 8px; /* */
        cursor: pointer; /* */
        font-size: 1rem; /* */
        font-weight: bold; /* */
        text-decoration: none; /* */
        text-align: center; /* */
        transition: background-color 0.3s ease, transform 0.2s ease,
            box-shadow 0.2s ease; /* */
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15); /* Added more
        prominent shadow */
        flex-grow: 1; /* */
        /* Allow buttons to grow and fill space */
        min-width: 120px; /* */
        /* Minimum width for buttons */
    }

    .btn-secondary {
        background-color: #917373; /* Updated color for 'Kembali' */ /* */
        color: #ffffff; /* */
    }

    .btn-secondary:hover {
        background-color: #a08484; /* Darker hover color */ /* */
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* */
        /* More prominent
        hover shadow */
    }

    .btn-primary {
        background-color: #623333; /* Updated color for 'Simpan' */
        color: white; /* */
    }

    .btn-primary:hover {
        background-color: #7b4545; /* Darker hover color */
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
        {{-- This is where you'd put the RSVP image. --}}
        {{-- Make sure you have an image like image_f443d8.jpg
        in your public/images directory and rename it to
        'RSVP.png' --}}
        <img src="{{ asset('images/RSVP.png') }}" alt="RSVP Invitation">
    </div>

    <div class="right-section">
        {{-- Hapus judul "Form Tamu Undangan" --}}
        {{-- <h2>Form Tamu Undangan</h2> --}}
        <h2>Isi Buku Tamu</h2> {{-- Menambahkan kembali judul H2 di sini --}}

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('guestbook.submit') }}">
            @csrf
            <div class="form-content">
                <div class="form-group">
                    <label for="name">Nama Lengkap:</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        placeholder="Masukkan nama lengkap">
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        placeholder="Masukkan Email Anda">
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="message">Pesan:</label>
                    <textarea id="message" name="message" placeholder="Tuliskan pesan Anda">{{ old('message') }}</textarea>
                    @error('message')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="button-group">
                {{-- Assuming 'Kembali' button goes back to a home
                page or previous page --}}
                <a href="{{ route('home') }}" class="btn btn-secondary">Kembali</a> {{-- Menggunakan route('home') --}} 
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

@endsection
