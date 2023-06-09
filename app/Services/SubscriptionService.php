<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Article;
use App\Models\Subscription;
use App\Models\UserSubscription;

class SubscriptionService {
    
    const SUBSCRIPTION_DAYS = 30;
    
    private $errors = [];
    
    public static function buy(Subscription $subscription, $req){
        $paymentService = new PaymentService();
        if($paymentService->processPayment($req)){
            $user = Auth::user();
            SubscriptionService::createUserSubscription($user, $subscription);
            return true;
        }
        $this->errors = $paymentService->getErrors();
        return false;
    }
    
    public static function getUserSubscription(User $user){
        $user_subscription = UserSubscription::where('user_id', $user->id)
                ->whereDate('date_start', '<=', Carbon::today()->toDateString())
                ->whereDate('date_end', '>=', Carbon::today()->toDateString())
                ->orderBy('id', 'desc')
                ->first();
        
        if($user_subscription){
            $user_subscription->articles_left = $user_subscription->articles - self::getUserArticlesCount($user, $user_subscription->date_start, $user_subscription->date_end);
            return $user_subscription;
        }
        
        return false;
    }
    
    public static function getUserArticlesCount(User $user, $date_from, $date_to){
        return Article::where('user_id', $user->id)
            ->whereDate('created_at', '<=', $date_from)
            ->whereDate('created_at', '>=', $date_to)
            ->count();
    }
    
    public static function createUserSubscription(User $user, Subscription $subscription){
        //check if user has current subscription
        $user_subscription = SubscriptionService::getUserSubscription($user);
        if($user_subscription){
            $user_subscription->articles += $subscription->publications;
            $user_subscription->date_end = Carbon::createFromFormat('Y-m-d H:i:s', $user_subscription->date_end)->addDays(SubscriptionService::SUBSCRIPTION_DAYS)->format('Y-m-d H:i:s');
        } else {
            $user_subscription = new UserSubscription();
            $user_subscription->user_id = $user->id;
            $user_subscription->date_start = Carbon::now()->format('Y-m-d H:i:s');
            $user_subscription->date_end = Carbon::now()->addDays(SubscriptionService::SUBSCRIPTION_DAYS)->format('Y-m-d H:i:s');
            $user_subscription->articles = $subscription->publications;
        }
        $user_subscription->subscription_id = $subscription->id;
        $user_subscription->save();
        return true;
    }
    
    public function getErrors(){
        return $this->errors;
    }
}