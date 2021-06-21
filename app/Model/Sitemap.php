<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Sitemap extends Model
{
    protected $table = 'sitemap';
    protected $fillable = ['type','method','name','url','origin'];
}
