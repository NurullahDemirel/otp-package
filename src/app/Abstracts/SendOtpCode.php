<?php

namespace Nuri\Otp\app\Abstracts;

use Illuminate\Database\Eloquent\Model;
use Nuri\Otp\app\Models\OtpCode;

abstract class SendOtpCode
{
    public function __construct(public readonly Model $otpModel, public readonly OtpCode $otpCode)
    {
        //
    }
}