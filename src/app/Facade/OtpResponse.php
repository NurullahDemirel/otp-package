<?php

namespace Nuri\Otp\app\Facade;

use Illuminate\Support\Facades\Facade;
use Nuri\Otp\app\Services\OtpResponseService as OtpResponseService;

class OtpResponse extends Facade
{
    protected static function getFacadeAccessor()
    {
        return OtpResponseService::class;
    }
}