<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'expense_id',
        'amount'
    ];

    public function expense() {
        return $this->belongsTo(Expense::class, 'expense_id', 'id');
    }
}
