<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // Tambahkan ini

class User extends Authenticatable
{
    use HasApiTokens, Notifiable; // Pastikan ini ada

    // ... kode lainnya
}
