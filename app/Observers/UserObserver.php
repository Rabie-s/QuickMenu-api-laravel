<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Subscription;
use App\Models\UserSubscription;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // prevent duplicate subscription
        if ($user->activeSubscription()->exists()) {
            return;
        }
        
        $freePlan = Subscription::where('title', 'Free Plan')->first();
    

        if (! $freePlan) {
            return;
        }

         UserSubscription::create([
            'user_id' => $user->id,
            'subscription_id' => $freePlan->id,
            'starts_at' => now(),
            'is_active' => true,
        ]);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
