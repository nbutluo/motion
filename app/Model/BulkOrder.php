<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BulkOrder extends Model
{
    protected $fillable = [
        'name', 'email', 'company', 'message', 'blog_id',
    ];
}
