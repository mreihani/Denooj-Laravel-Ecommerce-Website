<?php

namespace Modules\Products\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductInventory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'color_id',
        'size_id',
        'price',
        'sale_price',
        'discount_percent',
        'stock',
        'manage_stock',
        'stock_status'
    ];

    protected $appends = ['stock_quantity'];

    public function getStockQuantityAttribute(){
        return $this->getStockQuantity();
    }

    public function color()
    {
        return $this->belongsTo(ProductColor::class);
    }

    public function size()
    {
        return $this->belongsTo(ProductSize::class);
    }

    public function getStockQuantity(){
        if ($this->manage_stock){
            return $this->stock;
        }else if ($this->stock_status == 'out_of_stock'){
            return 0;
        }
        return 99999999999;
    }
}
