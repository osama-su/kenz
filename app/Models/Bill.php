<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Bill
 * @package App\Models
 */
class Bill extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'price',
        'print',
        'company_id',
        'delivery_status',
        'note',
        'discount_percentage',
        'price_after',
        'delivery_fee',
        'delivery_receive',
        'date_receive',
        'deleted_type',
        'deleted_at',
        'created_by',
        'supplier_id'

    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
      public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function billDetails()
    {
        return $this->hasMany(BillDetail::class, 'bill_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    
     public function wallet()
    {
        return $this->hasMany(CompanyWallet::class, 'bill_id');
    }
}
