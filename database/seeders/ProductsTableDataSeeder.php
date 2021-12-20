<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use DB;

class ProductsTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    protected $stripe;

    public function __construct() 
    {
        $this->stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
    }


    public function run()
    {  
        for ($i=0; $i < 2; $i++) { 

            $stripeProduct = $this->stripe->products->create([
                'name' => "Product ".$i,
            ]);
            $stripePlanCreation = $this->stripe->plans->create([
                'amount' => "100".$i,
                'currency' => 'inr',
                'interval' => 'month', //  it can be day,week,month or year
                'product' => $stripeProduct->id,
            ]); 

	    	DB::table('products')->insert([
                'stripe_product_id' => $stripeProduct->id,
                'stripe_price_id' => $stripePlanCreation->id,
	            'name' => "Product ".Str::random(4),
	            'price' => "100".$i,
	            'description' => "Description".Str::random(10),
	        ]);
    	}
    }
}
