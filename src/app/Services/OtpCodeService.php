<?php

namespace Nuri\Otp\app\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Nuri\Otp\app\Enum\OtpType;
use Nuri\Otp\app\Exceptions\RelationNotFoundInOtpModel;
use Nuri\Otp\app\Facade\OtpResponse;
use Nuri\Otp\app\Models\OtpCode;
use PragmaRX\Google2FAQRCode\Google2FA;
use Throwable;

class OtpCodeService
{

    public function __construct(protected Model $otpModel)
    {
        $this->otpModel = config('otp.otp_model');
    }

    public static function getUserOtpType(Model $otpModel): ?OtpType
    {
        if ($otpModel->otp_type instanceof OtpType) {
            return $otpModel->otp_type;
        }
        return OtpType::from($otpModel->otpModel);
    }

    public static function checkExistsOtpRule(Throwable $exception): ?JsonResponse
    {
        if ($exception instanceof ValidationException) {
            $errors = $exception->errors();
            $rules = array_keys($errors);
            $inputName = config('otp.otp_code_input_name');
            if (in_array($inputName, $rules) and str_contains($errors[$inputName][0], 'required')) {
                return OtpResponse::requireOtpCode();
            }
            if (in_array($inputName, $rules) and str_contains($errors[$inputName][0], 'invalid')) {
                return OtpResponse::invalidOtpCode();
            }
        }
        return null;
    }

    public function getUserWithParams(Request|FormRequest $request): ?Model
    {
        $params = config('otp.login_inputs');
        $query = $this->otpModel->newQuery();
        foreach ($params as $param) {
            $query = $query->when($request->filled($param), function ($query) use ($request, $param) {
                $query->orWhere($param, trim($request->input($param)));
            });
        }
        return $query->first();
    }

    public static function checkOtpIsValid(Model $otpModel, $otpCode): JsonResponse
    {

        if ($otpModel->otp_type != OTPType::GOOGLE) {
            $code = OtpCode::query()
                ->where('owner_id', $otpModel->id)
                ->where('code', $otpCode)
                ->first();

            if (!$code) {
                return OtpResponse::invalidOtpCode(); // code is invalid
            }

            if (now()->gt($code->expired_at)) {
                return OtpResponse::invalidOtpCode(['message' => 'Otp code expired']); // code expired time
            }
        } else {

            if (is_null($otpModel->google_otp_secret_key)) {
                return OtpResponse::registerGoogleAuth();
            }

            //if exists google_otp_secret_key we can test with this key
            $secretKey = $otpModel->google_otp_secret_key;
            $google2fa = new Google2FA();
            $valid = $google2fa->verifyKey($secretKey, $otpCode);
            if (!$valid) {
                return OtpResponse::invalidOtpCode(); // code is invalid
            }
        }
        return OtpResponse::codeValid(['message' => 'Otp code is valid']);
    }

    public static function deleteCode(string|int $ownerId): void
    {
        $query = OtpCode::query()->where('owner_id', $ownerId);
        if (config('otp.force_delete_codes')) {
            $query->forceDelete();
        } else {
            $query->delete();
        }

    }
}