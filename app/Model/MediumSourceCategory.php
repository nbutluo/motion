<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MediumSourceCategory extends Model
{
    use SoftDeletes;
    protected $table = 'medium_source_category';
    protected $fillable = ['name','parent_id','identity','is_active','media_type'];
}
