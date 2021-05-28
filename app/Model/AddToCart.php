<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddToCart extends Model
{
    use SoftDeletes;
    protected $table = 'loctek_cart';
    protected $fillable = ['product_id','user_id','qty','options','token'];
}
