<?php

// app/Http/Controllers/Frontend/SubscriptionController.php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::orderBy('price')->get();
        return view('frontend.subscription.index', compact('plans'));
    }

    public function applyCoupon(Request $request)
    {
        // Coupon logic (Filament मा Coupons छ भने integrate गर्नुहोस्)
        $coupon = Coupon::where('code', $request->code)->first();
        if ($coupon) {
            return back()->with('success', 'Coupon applied!');
        }
        return back()->with('error', 'Invalid coupon');
    }
}