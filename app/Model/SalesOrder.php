<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    protected $table = 'sales_order';
    protected $fillable = ['status','customer_id','customer_name','customer_email','total_qty_orderd'];
}
