<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'question';
    protected $fillable = ['user_id','category_id','product_id','title','short_content','content','is_active'];
}
