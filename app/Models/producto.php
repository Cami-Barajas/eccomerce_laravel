<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = ['id', 'name', 'description','price', 'image', 'stock', 'category'];

   public $timestamps = false;
}
