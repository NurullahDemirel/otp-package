<?php

namespace Nuri\Otp;

use Carbon\Laravel\ServiceProvider;
use function Illuminate\Filesystem\join_paths;

class OTPServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            //config
            __DIR__ . '/app/config/otp.php' => config_path('otp.php'),
//            //mails
//            __DIR__ . '/app/Mail/OtpEmail.php' => app_path('Mails/OtpEmail.php'),
//
            //requests
            __DIR__ . '/app/Http/Requests/BaseOtpCheck.php' => app_path('Http/Requests/OtpPhoneEmail.php'),
            __DIR__ . '/app/Http/Requests/CheckOtpCodeForProcess.php' => app_path('OHttp/Requests/CheckOtpCodeForProcess.php'),
            __DIR__ . '/app/Http/Requests/WhenLoginRequest.php' => app_path('Http/Requests/WhenLoginRequest.php'),

//            __DIR__ . '/app/Jobs/SendOtpCodeToEmail.php' => app_path('Jobs/SendOtpCodeToEmail.php'),
//            __DIR__ . '/app/Jobs/SendOtpCodeToPhone.php' => app_path('Jobs/SendOtpCodeToPhone.php'),


        ], 'two-factor');

        $this->mergeConfigFrom(
            __DIR__ . '/app/config/otp.php',
            'otp'
        );


    }

}