<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\User;
Use App\Models\Product;
use Stripe;
use Session;
use Exception;

class SubscriptionController extends Controller
{

    public function view()
    {
        try{
            $data['products'] = Product::orderBy('created_at', 'desc')->get(); 
            return view('subscription.view', $data ?? NULL);
        }
        Catch(\Exception $e)
        { 
            DB::rollback();
            return redirect()->route('view')->with('error', $e->getMessage());
        }
    }

    public function create($id)
    {
        try{ 
            $data['product'] = Product::where('id', $id)->first(); $data['intent'] = auth()->user()->createSetupIntent();
            return view('subscription.create', $data ?? NULL);
        }
        Catch(\Exception $e)
        { 
            DB::rollback();
            return redirect()->route('view')->with('error', $e->getMessage());
        }
    }

    public function post(Request $request)
    {
            $user = auth()->user();
            $input = $request->all();  
            $token =  $request->stripeToken;
            $paymentMethod = "pm_card_visa"; 
            try {

                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                
                if (is_null($user->stripe_id)) {
                    $stripeCustomer = $user->createAsStripeCustomer();
                } 

                \Stripe\Customer::createSource(
                    $user->stripe_id,
                    ['source' => $token]
                ); 

                $user->newSubscription('default', $input['plane'])
                ->quantity(1)
                ->create($paymentMethod, [
                    'email' => $user->email,
                ]); 

                return redirect()->route('view')->with('success','Subscription is completed.');
            } catch (Exception $e) {
                return redirect()->route('view')->with('error',$e->getMessage());
            }
            
    }

}