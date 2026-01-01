<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{


    protected $fillable = [
        'title',
        'description',
        'price',
        'menu_limit',
        'show_ads',
        'duration_days',
        'is_available',
    ];

    public function userSubscriptions(): HasMany
    {
        return $this->hasMany(UserSubscription::class);
    }
}
