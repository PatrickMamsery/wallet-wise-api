<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExpense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'expense_id'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function expense() {
        return $this->belongsTo(Expense::class, 'expense_id', 'id');
    }
}
