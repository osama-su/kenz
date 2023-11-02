<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Class Product
 * @package App\Models
 */
class Product extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'image',
        'qty',
        'size',
        'model',
        'color',
        'wholesale_price',
        'price',
        'type',
    ];

public function inventory()
    {
        return $this->hasMany(ProductQty::class, 'product_id');
    }
         public function orders(){
            return $this->hasMany(BillDetail::class, 'product_id');

     }

          public function qties(){
            return $this->hasMany(ProductQty::class, 'product_id');

     }

    public function setImageAttribute($value): void
    {
        if ($value != null) {
            if (!is_string($value)) {
                $this->image ? Storage::disk('public')->delete($this->image) : null;
                $value = Storage::disk('public')->putFile('product', $value);
            }
        }
        $this->attributes['image'] = $value;
    }

}
