<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category', 'price', 'stock', 'minimum_stock'];

    protected function casts(): array
    {
        return ['price' => 'decimal:2', 'stock' => 'integer', 'minimum_stock' => 'integer'];
    }

    public function orders() { return $this->hasMany(Order::class); }
}
