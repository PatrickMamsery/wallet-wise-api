<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBudget extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'budget_item_id'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function budget() {
        return $this->belongsTo(BudgetItem::class, 'budget_item_id', 'id');
    }
}
