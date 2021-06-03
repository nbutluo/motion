<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Business_solutions extends Model
{
    protected $table = 'business_solutions';
    protected $fillable = ['category_type','title','content','media_link','position','is_active'];
}
