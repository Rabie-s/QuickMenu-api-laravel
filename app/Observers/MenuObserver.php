<?php

namespace App\Observers;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Validation\ValidationException;

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

            throw ValidationException::withMessages([
                'menu' => "You've reached your menu limit",
            ]);
        }
    }
    /**
     * Handle the Menu "created" event.
     */
    public function created(Menu $menu): void {}

    /**
     * Handle the Menu "updated" event.
     */
    public function updated(Menu $menu): void
    {
        //
    }

    /**
     * Handle the Menu "deleted" event.
     */
    public function deleted(Menu $menu): void
    {
        //
    }

    /**
     * Handle the Menu "restored" event.
     */
    public function restored(Menu $menu): void
    {
        //
    }

    /**
     * Handle the Menu "force deleted" event.
     */
    public function forceDeleted(Menu $menu): void
    {
        //
    }
}
