<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Str;  // for str::lower
use Illuminate\Support\Collection; // for collections
use Illuminate\Support\Facades\Validator;  // for input validation

use App\Models\Discount;

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
        $validator = Validator::make($request->all(), [                        
            'currency' => ["required" , "max:3", "regex:(EGP|egp|USD|usd)"],
            'order' => "required"
        ]);

          if ($validator->fails()) {
            $errors = $validator->errors();
            return $errors;
                   
        }
        $order = $this->string_enhancement($request->order);     // pre-work enhancement on the order
        if ($order == false){
            return response()->json([
                'message' =>  '"There is item you entered in your order is not valid! \n 
                                Your order must be containing members of those words [T-shirt , Pants , Jacket , Shoes] \n 
                                Check your order and TRY AGAIN!!'], 422);   // data validation failed
        }
        $currency = Str::lower($request->currency);
        $counted = $order->countBy();  // count each item of the order

        $subtotal = $this->subtotal_calculation($order , $currency);
        $taxes = 0.14 * $subtotal;
        
        $num_Shoes   = $this->count_of_item( "Shoes" , $counted);

        $shoes_discount = $this->calculate_shoes_discount($num_Shoes , $currency);

        $num_Tshirts = $this->count_of_item( "Tshirt" , $counted);
        $num_Jackets = $this->count_of_item( "Jacket" , $counted);
        $jackets_discount = $this->calculate_Jacket_discount($num_Tshirts ,$num_Jackets , $currency );
        $total_discounts = $shoes_discount + $jackets_discount;
        $total_bill = $subtotal + $taxes +  $total_discounts;
        
        $new_order = new Order();
        $new_order->sub_total = $subtotal;
        $new_order->taxes = $taxes;
        $new_order->total_discounts = $total_discounts;
        $new_order->total = $total_bill;
        
        try {

            $new_order->save();
          
          } catch (\Exception $e) {
                abort(500, 'Could not submit your order to database!');
          }
        // make a link between the products or the order and the order itself  which automatically filles the pivot (order_product) table
        $this->attach_orders_with_products($order , $new_order); 
        
        // return $total_discounts;      
        try {  // try - catch of saving the discounts

                                 
            if($total_discounts !=0 )  {
                        $new_order->discounts()->create([
                        'discount_shoes' => $shoes_discount,
                        'discount_jacket' => $jackets_discount
                    ]); 
            }
        } catch (\Exception $e) {
            $new_order->destroy();
            abort(500, 'Could not submit your discount to database!');
        }    


        return new OrderResource($new_order);
    }

    
    private function attach_orders_with_products($orders , $new_order){  
      
        foreach($orders as $order){
            $product = Product::where('name' ,$order)->first();
           
            try {

                $new_order->products()->attach($product);
              
              } catch (\Exception $e) {
              
                  return $e->getMessage();
              }
        }

    }

    private function calculate_Jacket_discount($num_of_T_shirts , $num_of_Jackets , $currency){

        if($num_of_T_shirts >= 2 && $num_of_Jackets >=1){
            $product = Product::where('name' ,"Jacket")->first();

            $discounts = floor($num_of_T_shirts / 2);
            
            if($num_of_Jackets < $discounts){
                $discounts = $num_of_Jackets;
            }
            
            if($currency=="usd"){         
                return (-0.5) * $discounts * $product->usd_price;
            }
            else {
                return (-0.5) * $discounts * $product->egp_price;
            }
            
        }
        else {
            return 0;
        }
    }

    private function calculate_shoes_discount($num_of_shoes , $currency){

        $product = Product::where('name' ,"Shoes")->first();

        if($currency=="usd"){         
            return $num_of_shoes * -0.1 * $product->usd_price;
        }
        else {
            return $num_of_shoes * -0.1 * $product->egp_price;
        }

    }

    private function subtotal_calculation($orders , $currency){

        $subtotal = 0;
        foreach ($orders as $order){
            $product = Product::where('name' ,$order)->first();
            if($currency=="usd"){         
                $subtotal += $product->usd_price;
            }
            else {
                $subtotal += $product->egp_price;
            }
        }
        return $subtotal;

    }

    private function count_of_item($order , $counted){  // error handling of special case if you didn't order any item just to make it zero in its count
        try {
                return $counted[$order];
          
          } catch (\Exception $e) {
          
              return 0;
          }
    }

    private function string_enhancement($order_string){  
        $order_string = str_replace(' ', '', $order_string);  // removed any spaces from the order string
        $orders = explode(',', $order_string);  // remove the comma and put each item in index of an array
        
        $orders_collection = new collection();
        foreach($orders as $order){
            $order = Str::lower($order);  // lowercase all the characters
            $order = preg_replace('/[\W]/', '', $order); // remove any non alphabetical characters
            $order = Str::ucfirst($order);
            $orders_collection = $orders_collection->concat([$order]);
            if($order != "Tshirt" && $order != "Pants" && $order != "Jacket" && $order != "Shoes"){
                return false;
            }
        }
        return $orders_collection;
    }
}
