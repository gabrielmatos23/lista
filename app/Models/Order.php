<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['client_id', 'product_id', 'quantity', 'unit_price', 'total', 'status'];

    protected function casts(): array
    {
        return ['quantity' => 'integer', 'unit_price' => 'decimal:2', 'total' => 'decimal:2'];
    }

    public function client() { return $this->belongsTo(Client::class); }
    public function product() { return $this->belongsTo(Product::class); }
    public function freight() { return $this->hasOne(Freight::class); }
}
