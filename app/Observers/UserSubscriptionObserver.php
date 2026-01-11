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

    /**
     * Handle the UserSubscription "created" event.
     */
    public function created(UserSubscription $userSubscription): void
    {
        //
    }

    /**
     * Handle the UserSubscription "updated" event.
     */
    public function updated(UserSubscription $userSubscription): void
    {
        //
    }

    /**
     * Handle the UserSubscription "deleted" event.
     */
    public function deleted(UserSubscription $userSubscription): void
    {
        //
    }

    /**
     * Handle the UserSubscription "restored" event.
     */
    public function restored(UserSubscription $userSubscription): void
    {
        //
    }

    /**
     * Handle the UserSubscription "force deleted" event.
     */
    public function forceDeleted(UserSubscription $userSubscription): void
    {
        //
    }
}
