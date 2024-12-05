<?php


return [
    'force_delete_codes' => true,
    'stop_first_fail' => true,
    'expired_time' => 60,

    'otp_check_input_name' => 'otp_check',
    'otp_resend_name' => 'resend_otp',
    'otp_type_input_name' => 'otp_type',
    'otp_code_input_name' => 'otp_code',

    'otp_model' => \App\Models\User::class,
    'otp_type_enum' => \Nuri\Otp\app\Enum\OtpType::class,
    'otp_code_length' => 6,
    'guard_name' => 'web',
    'subjects' => [
        'email' => 'Otp Email',
    ],
    'requests' => [
        'auth_request' => \Nuri\Otp\app\Http\Requests\WhenLoginRequest::class,
        'guest_request' => \Nuri\Otp\app\Http\Requests\CheckOtpCodeForProcess::class,

    ],
    'jobs' => [
        'phone' => \Nuri\Otp\app\Jobs\SendOtpCodeToPhone::class,
        'email' => \Nuri\Otp\app\Jobs\SendOtpCodeToEmail::class,
    ],
    'login_inputs' => [
        'email' => 'Email',
    ]
];