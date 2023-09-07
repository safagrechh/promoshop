<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

     protected $fillable = [
        'titre',
        'prix',
        'description',
        'category_id',
        'imagePr',
     ];

     public function category() : BelongsTo
     {
         return $this->belongsTo(Category::class);
     }
}
