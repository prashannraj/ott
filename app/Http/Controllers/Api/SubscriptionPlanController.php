<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;

class SubscriptionPlanController extends Controller
{
    //
    public function index()
    {
        $plans = SubscriptionPlan::where('is_active', true)->get();

        return response()->json($plans);
    }
}
