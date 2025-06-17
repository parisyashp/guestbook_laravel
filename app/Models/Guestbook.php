<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guestbook extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak sesuai dengan konvensi Laravel (plural dari nama model)
    // Jika tabel Anda bernama 'guestbooks', baris ini opsional tapi bagus untuk kejelasan.
    protected $table = 'guestbooks';

    // Tentukan kolom yang bisa diisi secara massal (mass assignable)
    protected $fillable = [
        'name',
        'email',
        'message',
    ];
}
