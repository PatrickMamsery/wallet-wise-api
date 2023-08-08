<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'total_expense',
        'total_budget',
        'total_income',
        'saved_amount',
        'spent_amount',
    ];
}
