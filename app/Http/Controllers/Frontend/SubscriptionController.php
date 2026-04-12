<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Models\Coupon; // यदि Coupon model छ भने
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    // ===================== WEB METHODS (पुराना, Blade view return गर्छन्) =====================

    public function index()
    {
        $plans = SubscriptionPlan::orderBy('price')->get();
        return view('frontend.subscription.index', compact('plans'));
    }

    public function applyCoupon(Request $request)
    {
        // Coupon logic (Filament मा Coupons छ भने integrate गर्नुहोस्)
        $coupon = Coupon::where('code', $request->code)->first();

        if (!$coupon) {
            return back()->with('error', 'Invalid coupon code.');
        }

        // Coupon validation (expiry, usage limit आदि)
        if (!$coupon->isValid()) {
            return back()->with('error', 'Coupon has expired or reached usage limit.');
        }

        // Coupon apply logic (session मा store गर्ने वा user को subscription मा apply गर्ने)
        session()->put('applied_coupon', $coupon->code);

        return back()->with('success', 'Coupon applied successfully!');
    }

    // ===================== API METHODS (नयाँ, JSON return गर्छन्) =====================

    /**
     * API: Get list of all subscription plans
     * URL: /api/subscriptions
     * Method: GET
     */
    public function indexApi(Request $request)
    {
        $plans = SubscriptionPlan::orderBy('price')
            ->get()
            ->map(function ($plan) {
                return [
                    'id' => $plan->id,
                    'name' => $plan->name,
                    'slug' => $plan->slug,
                    'price' => $plan->price,
                    'duration_days' => $plan->duration_days,
                    'description' => $plan->description,
                    'features' => $plan->features ? json_decode($plan->features, true) : [],
                    'is_popular' => $plan->is_popular ?? false,
                    'currency' => $plan->currency ?? 'NPR',
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => $plans
        ]);
    }

    /**
     * API: Apply coupon code (authenticated user को लागि)
     * URL: /api/subscriptions/coupon
     * Method: POST
     * Body: { "code": "SUMMER2025" }
     */
    public function applyCouponApi(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50',
        ]);

        if (!Auth::check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'You must be logged in to apply a coupon.'
            ], 401);
        }

        $coupon = Coupon::where('code', $request->code)->first();

        if (!$coupon) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid coupon code.'
            ], 400);
        }

        // Coupon validation (expiry, usage limit, user-specific आदि)
        if (!$coupon->isValidForUser(Auth::id())) {
            return response()->json([
                'status' => 'error',
                'message' => 'Coupon has expired, reached usage limit, or is not applicable.'
            ], 400);
        }

        // Coupon apply logic (session वा database मा store)
        // यहाँ तपाईंको logic अनुसार change गर्न सकिन्छ
        // उदाहरण: user को cart/session मा coupon apply
        session()->put('applied_coupon', [
            'code' => $coupon->code,
            'discount' => $coupon->discount_value,
            'type' => $coupon->discount_type, // percentage or fixed
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Coupon applied successfully!',
            'coupon' => [
                'code' => $coupon->code,
                'discount' => $coupon->discount_value,
                'type' => $coupon->discount_type,
                'expires_at' => $coupon->expires_at ? $coupon->expires_at->format('Y-m-d') : null,
            ]
        ]);
    }

    /**
     * API: Get current user's active subscription (optional)
     * URL: /api/subscriptions/current
     * Method: GET
     * Requires: auth:sanctum
     */
    public function currentApi(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }

        $subscription = Auth::user()->activeSubscription(); // तपाईंको User model मा यो method बनाउनुहोस्

        if (!$subscription) {
            return response()->json([
                'status' => 'success',
                'data' => null,
                'message' => 'No active subscription'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'plan_name' => $subscription->plan->name,
                'start_date' => $subscription->start_date->format('Y-m-d'),
                'end_date' => $subscription->end_date->format('Y-m-d'),
                'status' => $subscription->status,
                'remaining_days' => $subscription->remainingDays(),
            ]
        ]);
    }

    public function subscribe(Request $request)
    {
        $planId = $request->plan_id;

        // Example logic
        // You can modify according to your subscription system

        return redirect()->back()->with('success', 'Subscription successful!');
    }
}