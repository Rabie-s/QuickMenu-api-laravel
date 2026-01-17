<?php

namespace App\Http\Controllers\User\Subscription;

use App\Http\Controllers\Controller;
use App\Services\User\Subscription\SubscriptionService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{

    public function __construct(protected SubscriptionService $subscriptionService) {}
    public function upgrade(Request $request)
    {
        $this->subscriptionService->upgrade($request->subscription_id);

        return $this->respondWithSuccess(['message'=>'Subscription upgraded successfully']);
 
    }
}
