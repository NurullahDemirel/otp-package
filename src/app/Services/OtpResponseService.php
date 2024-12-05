<?php

namespace Nuri\Otp\app\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Nuri\Otp\app\Enum\OtpType;

class OtpResponseService
{
    function requireOtpCode(array $data = []): JsonResponse
    {
        $response = array_merge($data, [
            'error' => 1,
            'require_otp_check' => true,
            'messages' => ['general_error' => 'Frontend should make request with otp_code '],
        ]);
        return response()->json($response, Response::HTTP_PRECONDITION_REQUIRED);
    }

    function codeValid(array $data = []): JsonResponse
    {
        $response = array_merge($data, [
            'error' => false,
            'messages' => ['general_error' => 'Code is valid.'],
        ]);
        return response()->json($response, Response::HTTP_OK);
    }

    function registerGoogleAuth(array $data = []): JsonResponse
    {
        $response = array_merge($data, [
            'error' => 1,
            'require_otp_check' => true,
            'require_google_auth' => true,
            'messages' => ['general_error' => 'Google Authenticator should make request with otp_code'],
        ]);
        return response()->json($response, Response::HTTP_PRECONDITION_REQUIRED);
    }

    function notifyFrontForOtp(Model $model, array $data = []): JsonResponse
    {
        $response = array_merge($data, [
            'error' => 1,
            'require_otp_check' => true,
            'messages' => 'This user has two-factor',
            'otp_tpe' => $model->otp_type
        ]);

        return response()->json($response, Response::HTTP_PRECONDITION_REQUIRED);
    }

    function invalidOtpCode(array $data = []): JsonResponse
    {
        $response = array_merge($data, [
            'error' => 1,
            'messages' => ['general_error' => 'Otp code false'],
        ]);
        return response()->json($response, Response::HTTP_PRECONDITION_FAILED);
    }

    function authUserOtpType(): ?OtpType
    {
        return OtpType::from(auth(config('otp.guard_name'))->user()->otp_type);
    }

    function userOtpType(Model $model): ?OtpType
    {
        return OtpType::from($model->otp_type);
    }

}