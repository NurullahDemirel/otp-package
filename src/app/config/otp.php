<?php


return [
    //useless now
    'otp_check_input_name' => 'otp_check',
    'otp_type_input_name' => 'otp_type',

    'force_delete_codes' => true,//OtpCode model use the soft deletes property,if you don't want to force delete you should set false
    'stop_first_fail' => true,//this package accept this value for FormRequest
    'expired_time' => 60,//code expired time as seconds

    'otp_resend_name' => 'resend_otp',
    'otp_code_input_name' => 'otp_code',

    //package supposes this model as owner of the codes, you can change this instead of an Eloquent model
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
        \Nuri\Otp\app\Enum\OtpType::PHONE->value => \Nuri\Otp\app\Jobs\SendOtpCodeToPhone::class,
        \Nuri\Otp\app\Enum\OtpType::EMAIL->value => \Nuri\Otp\app\Jobs\SendOtpCodeToEmail::class,
        //if you have different option from these options;
        //1- you have to create a job that extends Nuri\Otp\app\Abstracts\SendOtpCode
        //2- copy my (Nuri\Otp\app\Enum\OtpType) my enum, and pastes to your project
        //3- add your enum namespace for otp_type_enum
        //4- add your option
        //5- define job for this option here
        //6- I have added for different option
        //7- \Nuri\Otp\app\Enum\OtpType::SLACK->value => \Nuri\Otp\app\Jobs\SendOtpCodeToSlack::class,
    ],
    //this input used to define parameters when try to find user when login if one of them is not a column in table throw exception
    'login_inputs' => [
        'email',
        'username',
        'phone',
    ]
];