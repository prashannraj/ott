<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',             // subscription, rental
        'amount',
        'currency',
        'status',           // pending, paid, failed
        'payment_gateway',
        'payment_reference',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // यदि rental सँग order_id जोड्नुभएको छ भने:
    public function rental()
    {
        return $this->hasOne(Rental::class);
    }

    public function couponUsages()
    {
        return $this->hasMany(CouponUsage::class);
    }
}
