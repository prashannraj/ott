<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\Order;

class SubscriptionController extends Controller
{
    //
    public function me(Request $request)
    {
        $user = $request->user();

        $subscription = $user->subscriptions()
            ->with('plan')
            ->where('status', 'active')
            ->where('ends_at', '>=', now())
            ->latest('ends_at')
            ->first();

        return response()->json($subscription);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
            'payment_gateway' => 'required|string',
            'payment_reference' => 'required|string',
            'amount' => 'required|numeric',
            'currency' => 'required|string',
        ]);

        $user = $request->user();
        $plan = SubscriptionPlan::findOrFail($data['plan_id']);

        // Create order
        $order = Order::create([
            'user_id' => $user->id,
            'type' => 'subscription',
            'amount' => $data['amount'],
            'currency' => $data['currency'],
            'status' => 'paid', // realistically set after verifying
            'payment_gateway' => $data['payment_gateway'],
            'payment_reference' => $data['payment_reference'],
        ]);

        $startsAt = now();
        $endsAt = now()->addDays($plan->duration_days);

        $subscription = Subscription::create([
            'user_id' => $user->id,
            'subscription_plan_id' => $plan->id,
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'status' => 'active',
            'payment_gateway' => $data['payment_gateway'],
            'payment_reference' => $data['payment_reference'],
        ]);

        return response()->json([
            'message' => 'Subscription created',
            'subscription' => $subscription->load('plan'),
        ], 201);
    }
}
