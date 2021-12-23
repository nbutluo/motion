<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomepageBanner extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'description', 'media_url_pc', 'media_url_mobile', 'banner_alt', 'is_active', 'order', 'link_url'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
