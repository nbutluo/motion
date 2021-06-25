<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AboutLoctek extends Model
{
    protected $table ='about_loctek';
    protected $fillable = ['type','title','content','media_lable','media_link','media_type','is_active','position'];
}
