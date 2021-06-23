<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MediumBanner extends Model
{
    protected $table = 'medium_banner';
    protected $fillable = ['page_name','description','is_active','media_url','banner_alt'];
}
