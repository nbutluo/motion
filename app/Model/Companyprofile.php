<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Companyprofile extends Model
{
    use SoftDeletes;
    protected $table = 'company_profile_message';
    protected $fillable = ['title','content','media_link','is_active','position'];
}
