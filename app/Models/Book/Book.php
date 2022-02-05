<?php

namespace App\Models\Book;

use Database\Factories\BookFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author'];

    protected static function newFactory() : Factory
    {
        return BookFactory::new();
    }
}
