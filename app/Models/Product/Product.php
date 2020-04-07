<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	public function productCategory()
	{
		return $this->belongsTo('App\Models\Product\ProductCategory', 'product_category_id');
	}

    public function monogram()
    {
        return $this->belongsToMany('App\Models\Product\ProductMonogram', 'product_monograms', 'product_id', 'monogram_id');
    }

    public function attributeValue()
    {
        return $this->belongsToMany('App\Models\Product\ProductAttributeValue', 'product_product_attributes', 'product_id', 'product_attribute_value_id');
    }

    public function umprofile()
    {
        return $this->belongsTo('App\Models\Measurement\UserMeasurementProfile', 'u_mp_id');
    }

    public function design()
    {
        return $this->belongsTo('App\Models\Product\ProductDesign', 'product_design_id');
    }

    public function fabric()
    {
        return $this->belongsTo('App\Models\Product\Fabric\Fabric', 'fabric_id');
    }

    public function pavsaves(){
        return $this->belongsToMany('App\Models\Product\ProductAttributeValue',  'product_attribute_value_saves', 'product_id', 'product_attribute_id', 'product_attribute_value_id');
    }

    public function items()
    {
        return $this->hasMany('App\Models\OrderItem', 'order_items', 'order_id');
    }

    public function attributes(){
        return $this->hasMany('App\Models\Product\ProductAttributeValue');
    }

    public function brand()
    {
        return $this->belongsTo('App\Models\Product\Brand', 'brand_id');
    }

    public function po_types()
    {
        return $this->belongsToMany('App\Models\Product\Order\PoType', 'product_po_type', 'product_id', 'po_type_id');
    }
}
