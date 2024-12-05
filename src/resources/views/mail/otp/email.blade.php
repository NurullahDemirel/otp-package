<x-mail::message>
    # Introduction

    Your OTP Code : {{$otpCode->code}}
    Expired At : {{$otpCode->expired_at->format('d.m.Y H:i:s')}}

    Thanks
    {{ config('app.name') }}
</x-mail::message>
