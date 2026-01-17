<?php

namespace App\Observers;

use App\Models\Menu;
use App\Models\User;
use App\Enums\ApiErrorCode;
use App\Exceptions\ApiException;

class MenuObserver
{

    public function creating(Menu $menu)
    {
        $user = User::find($menu->user_id);

        if (! $user) return;

        $subscription = $user->activeSubscription;
        if (! $subscription) return;

        $menuLimit = $subscription->subscription->menu_limit;
        $userMenuCount = $user->menus()->count();

        if ($userMenuCount >= $menuLimit && $menuLimit != null) {
            throw new ApiException(
                ApiErrorCode::MENU_LIMIT_EXCEEDED->value,
                'You have reached your menu limit.',
                403
            );
        }
    }
}
