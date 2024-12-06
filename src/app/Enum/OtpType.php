<?php

namespace Nuri\Otp\app\Enum;

use Nuri\Otp\app\Models\OtpCode;

enum OtpType: string
{
    case EMAIL = 'Email';
    case PHONE = 'Phone';
    case GOOGLE = 'Google';
    case SLACK = 'Slack';

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

    public function getJob(): ?string
    {
        return config('otp.jobs.' . $this->value);
    }
}