<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use app\Models\LiveChannel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LiveStream extends Model
{
    //
    protected $fillable = [
        'live_channel_id','stream_url','backup_stream_url','drm_key_id','is_active'
    ];

    public function channel()
    {
        return $this->belongsTo(LiveChannel::class, 'live_channel_id');
    }
}
