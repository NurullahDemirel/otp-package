<?php

namespace Nuri\Otp\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nuri\Otp\app\Enum\OtpType;

class OtpCode extends Model
{
    use SoftDeletes;

    protected $casts = [
        'expired_at' => 'datetime',
        'otp_type' => OtpType::class
    ];


    static function boot(): void
    {
        static::creating(function (self $code) {
            $code->expired_at = now()->addSeconds(config('otp.expired_at'));
        });
    }

    public function owner(): Model
    {
        return $this->belongsTo(config('otp.otp_model'), 'owner_id');
    }

}