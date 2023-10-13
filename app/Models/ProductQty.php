<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Class Product
 * @package App\Models
 */
class ProductQty extends Model
{
    use HasFactory;

 
 protected $table='products_qty';
    /**
     * @var string[]
     */
    protected $fillable = [
        'product_id',
        'bill_id',
        'qty',
    ];

 
}
