<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'amount',
        'image',
        'created_by',
        'expense_type_id',
    ];

    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class);
    }
}
