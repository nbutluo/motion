<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Companyprofile extends Model
{
    protected $table = 'company_profile_message';
    protected $fillable = ['title','content','media_link','is_active'];
}
