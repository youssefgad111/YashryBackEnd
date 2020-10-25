<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::create([
            'sub_total' =>'1200.00',
            'taxes' => '20.00',
            'total' => '1220.00'
        ]);
            
        Order::create([
            'sub_total' =>'1800.00',
            'taxes' => '180.00',
            'total' => '1980.00'
        ]);
    }
}
