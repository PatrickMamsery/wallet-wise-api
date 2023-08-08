<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserIncome extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'income_id'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function income() {
        return $this->belongsTo(Income::class, 'income_id', 'id');
    }
}
