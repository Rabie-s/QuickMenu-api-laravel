<?php

namespace App\Enums;

enum UserSubscriptionStatus: string
{
    case ACTIVE = 'active';
    case EXPIRED = 'expired';
    case CANCELED = 'canceled';
}
