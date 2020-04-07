<?php

namespace App\Models\Product\Order;

use Illuminate\Database\Eloquent\Model;

class PoType extends Model
{
	public function products()
	{
		return $this->belongsToMany('App\Models\Product\Product', 'product_po_type', 'po_type_id', 'product_id');
	}
}
