<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class userResep extends Model
{
    use HasFactory;
    protected $fillable = ['name','deskripsi','bahan','pembuatan','image','kategori'];
    protected $table = 'userresep_tabel'; 

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($image) => url('/storage/posts/' . $image),
        );
    }
}
