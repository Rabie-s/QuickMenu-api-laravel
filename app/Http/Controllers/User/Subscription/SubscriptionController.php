<?php

namespace App\Http\Controllers\User\Subscription;

use App\Http\Controllers\Controller;
use App\Services\User\Subscription\SubscriptionService;
use Illuminate\Http\Request;
use LaraUtilX\Traits\ApiResponseTrait;

class SubscriptionController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected SubscriptionService $subscriptionService) {}
    public function upgrade(Request $request)
    {
        $this->subscriptionService->upgrade($request->subscription_id);

        return $this->successResponse(message:'Subscription upgraded successfully');
 
    }
}
