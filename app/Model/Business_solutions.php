<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business_solutions extends Model
{
    use SoftDeletes;
    protected $table = 'business_solutions';
    protected $fillable = ['category_type','title','content','media_link','position','is_active','media_alt','media_type'];
}
