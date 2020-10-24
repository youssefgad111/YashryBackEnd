<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['sub_total' ,'taxes' , 'total'] ;

    public function products(){
        return $this->belongsToMany(Product::class , 'order_product' , 'order_id' , 'product_id' );
    }
    
    public function discounts(){
        return $this->hasOne(Discount::class);  
    }
     
}
