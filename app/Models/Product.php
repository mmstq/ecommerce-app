<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'discount',
        'image_url',
    ];

    protected $appends = [
        'price_after_discount',
    ];

    /**
     * Get the price after discount.
     */
    public function getPriceAfterDiscountAttribute()
    {
        $price = $this->price;
        $discount = $this->discount; // Percentage

        if ($discount > 0) {
            return round($price * (1 - $discount / 100), 2);
        }

        return $price;
    }
}
