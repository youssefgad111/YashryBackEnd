<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'usd_price' , 'egp_price'];

    public function orderItem()
    {
        return $this->belongsTo('App\Models\OrderItem');
    }

}
