<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\Product;
use App\Http\Resources\Products as ProductCollection;
use App\Http\Resources\Product as ProductResource;

use App\Models\Discount;
use App\Http\Resources\Discount as DiscountResource;
use App\Http\Resources\Discounts as DiscountCollection;

class Order extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $array_data = [
            'id' => $this->id,
            'sub_total' => $this->sub_total,
            'taxes' => $this->taxes,
            'total' => $this->total,
            'products' => ProductResource::collection($this->products),
           
        ];
        if($this->total_discounts != null){
           $array_data['discounts'] =  new DiscountResource($this->discounts);
        }
        return $array_data;
    }
}
