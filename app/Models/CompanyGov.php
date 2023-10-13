<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyGov extends Model
{
    use HasFactory;

    protected $table = 'company_govs';

    protected $fillable = [
        'company_id', 'gov', 'price',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
