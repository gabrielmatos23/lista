<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Freight extends Model
{
    protected $fillable = ['order_id', 'address', 'fee', 'expected_date', 'tracking_code', 'status'];

    protected function casts(): array
    {
        return ['fee' => 'decimal:2', 'expected_date' => 'date'];
    }

    public function order() { return $this->belongsTo(Order::class); }
}
