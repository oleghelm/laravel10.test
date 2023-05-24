<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Article;
use App\Models\Subscription;
use App\Models\UserSubscription;

class SubscriptionService {
    
    const SUBSCRIPTION_DAYS = 30;
    
    public static function getUserSubscription(User $user){
        $user_subscription = UserSubscription::where('user_id', $user->id)
                ->whereDate('date_start', '<=', Carbon::today()->toDateString())
                ->whereDate('date_end', '>=', Carbon::today()->toDateString())->last();
        
        if($user_subscription){
            $subscription = $user_subscription->subscription;
            $subscription->articles_left = self::getUserArticlesCount($user, $user_subscription->date_start, $user_subscription->date_end);

            return $subscription;
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
        /*
         * Will we check user for active subscription in this moment and add new for dates when in will ends?
         */
        $user_subscription = new UserSubscription();
        $user_subscription->user_id = $user->id;
        $user_subscription->subscription_id = $subscription->id;
        $user_subscription->date_start = Carbon::now()->format('Y-m-d H:i:s');
        $user_subscription->date_end = Carbon::now()->addDays(SubscriptionService::SUBSCRIPTION_DAYS)->format('Y-m-d H:i:s');
        $user_subscription->save();
        return true;
    }
}