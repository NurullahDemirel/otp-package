<?php

namespace Nuri\Otp\app\Http\Requests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Nuri\Otp\app\Facade\OtpResponse;
use Nuri\Otp\app\Jobs\SendOtpCode;
use Nuri\Otp\app\Services\OtpCodeService;

class BaseOtpCheck extends FormRequest
{

    public function __construct(protected readonly bool $sendAgain = false)
    {
        parent::__construct();
        $this->stopFirstFail();
    }

    public function stopFirstFail(): void
    {
        $this->stopOnFirstFailure = config('otp.stop_first_fail');
    }

    public function checkOtpWithUser(Model $otpModel)
    {
        $otpType = OtpCodeService::getUserOtpType($otpModel);

        $resendInput = config('otp.otp_resend_name');
        if ($this->filled($resendInput) && $this->input($resendInput)) {
            dispatch(new SendOtpCode($otpType, $otpModel->id));
            return true;
        }

        if (!is_null($otpType) && !($this->filled(config('otp.otp_code_input_name')))) {
            return throw ValidationException::withMessages(OtpResponse::notifyFrontForOtp($otpModel)->getData());
        }

        //if user has otp control, and input contains(otp_code) check otp code
        if (!is_null($otpType) && !$this->filled(config('otp.otp_code_input_name'))) {
            //send otp code
            dispatch(new SendOtpCode($otpType, $otpModel->id));
            throw ValidationException::withMessages([
                config('otp.otp_code_input_name') . 'required' => 'OTP code is required.',
                'otp_type' => $otpModel->otp_type
            ]);

        }
        $checkResponse = OtpCodeService::checkOtpIsValid($otpModel, $this->input(config('otp.otp_code_input_name')));
        if (!$checkResponse->isSuccessful()) {
            throw ValidationException::withMessages($checkResponse->getData());
        }
    }
}