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
        ], 'two-factor');

        $this->mergeConfigFrom(
            __DIR__ . '/app/config/otp.php',
            'otp'
        );


    }

}