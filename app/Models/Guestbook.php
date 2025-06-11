<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guestbook extends Model
{
    use HasFactory;

    // Nama tabel yang terkait dengan model ini.
    // Laravel secara default akan menggunakan nama plural dari model (Guestbook -> guestbooks).
    // Jadi, ini opsional jika nama tabel Anda memang 'guestbooks'.
    protected $table = 'guestbooks';

    // Properti fillable mendefinisikan kolom yang bisa diisi secara massal (mass assignable).
    // Ini adalah fitur keamanan penting di Laravel.
    protected $fillable = [
        'name',
        'email',
        'message',
    ];
}
