<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    public function products()
    {
    	return $this->belongsToMany('App\Product', 'product_order');
    }
}
