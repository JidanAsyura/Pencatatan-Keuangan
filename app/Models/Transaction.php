<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'date',
        'type',
        'amount',
        'description',
        'method_id',
        'category_id',
    ];

    // Relasi ke tabel methods
    public function method()
    {
        return $this->belongsTo(Method::class);
    }

    // Relasi ke tabel categories
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
