<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Product::truncate();
      
        Product::create([
            'name' =>'T-shirt',
            'usd_price' => '10.99',
            'egp_price' => '175.84'
        ]);

        Product::create([
            'name' =>'Pants',
            'usd_price' => '14.99',
            'egp_price' => '239.84'
        ]);

        Product::create([
            'name' =>'Jacket',
            'usd_price' => '19.99',
            'egp_price' => '319.84'
        ]);

        Product::create([
            'name' =>'Shoes',
            'usd_price' => '24.99',
            'egp_price' => '399.84'
        ]);
    }
}
