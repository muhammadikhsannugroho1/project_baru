<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class userResep extends Model
{
    use HasFactory;
    protected $fillable = ['name','deskripsi','bahan','pembuatan','image','kategori'];
    protected $table = 'userresep_tabel'; 

  
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
