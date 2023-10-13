<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BillDetail
 * @package App\Models
 */
class BillDetail extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string
     */
    protected $table = "bill_details";

    /**
     * @var string[]
     */
    protected $fillable = [
        'bill_id',
        'product_id',
        'size',
        'color',
        'model',
        'qty',
        'delivery_status',
        'price',
        'discount_type',
        'deleted_at',
    ];

    /**
     * @return BelongsTo
     */
    public function bill(): BelongsTo
    {
        return $this->belongsTo(Bill::class, 'bill_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
