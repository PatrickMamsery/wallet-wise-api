<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'budget_item_id',
    ];

    public function budgetItem() {
        return $this->belongsTo(BudgetItem::class, 'budget_item_id', 'id');
    }
}
