<?php

namespace Nuri\Otp\app\Http\Requests;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Nuri\Otp\app\Services\OtpCodeService;

class WhenLoginRequest extends BaseOtpCheck
{
    public function stopFirstFail(bool $value = true): void
    {
        $this->stopOnFirstFailure = $value;
    }

    protected function passedValidation()
    {
        //set true to stop first fail
        $this->stopFirstFail();
        $otpModel = app(OtpCodeService::class)->getUserWithParams($this);

        if (!$otpModel) {
            $loginParams = config('otp.login_inputs');
            $params = implode(',', $loginParams);
            $table = config('otp.otp_model')->getTable();
            throw ValidationException::withMessages([
                'general_error' => 'Data not found in table ' . $table . ' in ' . $params . ' columns/column'
            ]);
        }

        //check password
        if (!(Hash::check($otpModel->password, trim($this->input('password'))))) {
            throw ValidationException::withMessages([
                'password' => 'The provided password is incorrect.',
            ]);
        }
        $this->checkOtpWithUser($otpModel);
    }
}