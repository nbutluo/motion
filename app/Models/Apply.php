<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Apply extends Model
{
    protected $fillable = [
        'user_id', 'cureent_level', 'apply_reason', 'is_audit'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
