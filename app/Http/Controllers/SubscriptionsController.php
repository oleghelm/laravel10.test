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
        return view('subscriptions/list', compact('subscriptions'));
    }
    
    public function buyPage(Subscription $subscription){
        return view('subscriptions/form', compact('subscription'));
    }
    
    public function processPay(Subscription $subscription, Request $req){
        $paymentService = new PaymentService();
        $response = [];
        if($paymentService->processPayment($req)){
            $response['success'] = 1;
            $user = Auth::user();
            SubscriptionService::createUserSubscription($user, $subscription);
        } else {
            $response['success'] = 0;
            $response['errors'] = $paymentService->getErrors();
        }
        
        return response()->json($response);
    }
}
