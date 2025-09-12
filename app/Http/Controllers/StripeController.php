<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripeController extends Controller
{
     public function createPaymentIntent(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        try {
            $payment = PaymentIntent::create([
                'amount' => 2000,
                'currency' => 'usd',
                'payment_method_types' => ['card', 'klarna', 'afterpay_clearpay'],
            ]);

            return response()->json(['clientSecret' => $payment->client_secret]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
