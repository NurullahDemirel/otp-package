<?php


return [
    //useless now
    'otp_check_input_name' => 'otp_check',
    'otp_type_input_name' => 'otp_type',

    'force_delete_codes' => true,//OtpCode model use the soft deletes property,if you don't want to force delete you should set false
    'stop_first_fail' => true,//this package accept this value for FormRequest
    'expired_time' => 60,//code expired time as secconds

    'otp_resend_name' => 'resend_otp',
    'otp_code_input_name' => 'otp_code',

    //package supposes this model as owner of the codes, you can change this instead of a Eloquent model
    'otp_model' => \App\Models\User::class,
    'otp_type_enum' => \Nuri\Otp\app\Enum\OtpType::class,
    'otp_code_length' => 6,
    'guard_name' => 'web',
    'subjects' => [
        'email' => 'Otp Email',
    ],
    'requests' => [
        'auth_request' => \Nuri\Otp\app\Http\Requests\WhenLoginRequest::class,//this request used to want or check otp code for auth user
        'guest_request' => \Nuri\Otp\app\Http\Requests\CheckOtpCodeForProcess::class,//this request used to want or check otp code for guest user

    ],
    // Each of these corresponds to a job for o otp type in (OtpType eum)
    'jobs' => [
        'phone' => \Nuri\Otp\app\Jobs\SendOtpCodeToPhone::class,
        'email' => \Nuri\Otp\app\Jobs\SendOtpCodeToEmail::class,
    ],
    //this input used to define parameters when try to find user when login if one of them is not a column in table throw exception
    'login_inputs' => [
        'email',
//        'username',
//        'phone'
    ]
];