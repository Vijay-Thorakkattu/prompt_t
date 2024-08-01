<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;
    protected $fillable = ['vendor_id', 'name', 'price', 'description', 'image'];


    /**
     * Get the stocks for the product.
     */
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }
}
