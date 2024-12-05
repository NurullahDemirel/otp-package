<?php

namespace Nuri\Otp\app\Http\Requests;

use Illuminate\Database\Eloquent\Model;
use Nuri\Otp\app\Services\OtpCodeService;

class CheckOtpCodeForProcess extends BaseOtpCheck
{
    public function stopFirstFail(bool $value = true): void
    {
        $this->stopOnFirstFailure = $value;
    }

    protected function passedValidation()
    {
        /** @var Model $otpModel */
        $otpModel = auth()->guard(config('otp.guard_name'))->user();
        $this->checkOtpWithUser($otpModel);
    }
}