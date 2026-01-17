<?php

namespace App\Services\User\Subscription;

use App\Enums\UserSubscriptionStatus;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Enums\ApiErrorCode;
use App\Exceptions\ApiException;

class SubscriptionService
{
    public function upgrade(int $subscriptionId): void
    {
        $user = Auth::user();

        $activeSubscription = $user->activeSubscription;
        if (! $activeSubscription) {
            throw new ApiException(
                ApiErrorCode::NO_ACTIVE_SUBSCRIPTION->value,
                'You do not have an active subscription.',
                400
            );
        }

        if ($activeSubscription->subscription_id === $subscriptionId) {
            throw new ApiException(
                ApiErrorCode::SAME_SUBSCRIPTION->value,
                'You already have this subscription plan.',
                409
            );
        }

        $newSubscription = Subscription::find($subscriptionId);
        if (! $newSubscription) {

            throw new ApiException(
                ApiErrorCode::SUBSCRIPTION_NOT_FOUND->value,
                'Subscription not found.',
                404
            );
        }

        DB::transaction(function () use ($user, $activeSubscription, $newSubscription) {

            $activeSubscription->update([
                'status' => UserSubscriptionStatus::EXPIRED,
                'ends_at' => Carbon::now(),
            ]);

            $user->userSubscriptions()->create([
                'subscription_id' => $newSubscription->id,
                'starts_at'       => Carbon::now(),
                'ends_at'         => $newSubscription->duration_days
                    ? now()->addDays($newSubscription->duration_days)
                    : null,
                'status'          => UserSubscriptionStatus::ACTIVE,
            ]);
        });
    }
}
