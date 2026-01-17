<?php

namespace App\Observers;

use App\Models\UserSubscription;
use App\Enums\UserSubscriptionStatus;

class UserSubscriptionObserver
{


    public function creating(UserSubscription $subscription)
    {
        if ($subscription->status === UserSubscriptionStatus::ACTIVE) {
            UserSubscription::where('user_id', $subscription->user_id)
                ->where('status', UserSubscriptionStatus::ACTIVE)
                ->update([
                    'status' => UserSubscriptionStatus::EXPIRED,
                    'ends_at' => now(),
                ]);
        }
    }

}
