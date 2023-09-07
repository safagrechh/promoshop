<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['titre', 'description'];

    
    public function products() : HasMany
    {
        return $this->hasMany(Product::class);
    }
}