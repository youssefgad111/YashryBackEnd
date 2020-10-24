<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\Products as ProductCollection;

use App\Models\Order;
use App\Http\Resources\Order as OrderResource;
use App\Http\Resources\Orders as OrderCollection;

class OrderController extends Controller
{
    public function create_order(Request $request)
    {
        return new OrderResource(Order::find(1));
    }
}
