<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SalesOrderItem extends Model
{
    protected $table = 'sales_order_item';
    protected $fillable = ['order_id','product_id','sku','name','description','product_options','qty_ordered','price'];
}
