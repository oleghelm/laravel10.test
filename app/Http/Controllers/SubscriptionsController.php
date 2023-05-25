<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Services\PaymentService;
use App\Services\SubscriptionService;

class SubscriptionsController extends Controller
{
    public function list(Request $req){
        $subscriptions = Subscription::where('active',1)->paginate(20);
        return response()->json(['subscriptions' => $subscriptions->toArray()]);
    }
    
    public function buyPage(Subscription $subscription){
        return response()->json(['subscription' => $subscription->toArray()]);
    }
    
    public function processPay(Subscription $subscription, Request $req, SubscriptionService $subscriptionService){
        $response = $subscriptionService->buy($subscription, $req);
        return response()->json($response);
    }
}
