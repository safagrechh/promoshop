<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'items', 'total_amount', 'address', 'phone'];
    
    public function items()
    {
        return $this->hasMany(CommandeItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Other methods and scopes as needed

}
