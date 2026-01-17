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

}
