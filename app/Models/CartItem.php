<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'product_id',
        'user_id'
    ];

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
