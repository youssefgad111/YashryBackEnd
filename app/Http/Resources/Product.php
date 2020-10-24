<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    
    public $preserveKeys = true;  // let the APi Show the data of the products by Special order of keys i made
    public function toArray($request)
    {
        return [
            // 'id' => $this->id,
            'product_name' => $this->name,
            'egp_price' => $this->egp_price,
            'usd_price' => $this->usd_price,
        ];
    }


}
