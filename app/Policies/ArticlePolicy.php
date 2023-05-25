<?php

namespace App\Policies;

use App\Services\SubscriptionService;

class ArticlePolicy {

    public function create() {
        $user = \Auth::user();
        if ($user) {
            $subscription = SubscriptionService::getUserSubscription($user);
            if ($subscription && $subscription->articles_left > 0) {
                return true;
            }
        }
        return false;
    }

}
