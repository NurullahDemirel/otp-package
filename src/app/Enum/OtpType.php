<?php

namespace Nuri\Otp\app\Enum;

use Nuri\Otp\app\Models\OtpCode;

enum OtpType: string
{
    case EMAIL = 'Email';
    case PHONE = 'Phone';
    case GOOGLE = 'Google';

    public static function generateOtpCode(): string
    {
        $length = config('otp.otp_code_length');
        do {
            $code = '';
            foreach (range(1, $length) as $item) {
                $code .= fake()->numberBetween(0, 9);
            }
        } while (OtpCode::whereCode($code)->exists());
        return $code;
    }

    public function getJob(): string
    {
        return match ($this) {
            self::EMAIL => config('otp.jobs.email'),
            self::PHONE => config('otp.jobs.phone'),
        };
    }
}