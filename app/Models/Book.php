<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'author',
    ];
//
//    public function user()
//    {
//        return $this->belongsTo(User::class);
//    }
}
