<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'icon'];

    // Relasi ke transaksi
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
