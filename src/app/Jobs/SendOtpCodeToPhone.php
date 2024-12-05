<?php

namespace Nuri\Otp\app\Jobs;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Nuri\Otp\app\Exceptions\RequiredEmailInOtpModel;
use Nuri\Otp\app\Mail\OtpEmail;
use Nuri\Otp\app\Models\OtpCode;

class SendOtpCodeToPhone implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public readonly Model $otpModel, public readonly OtpCode $otpCode)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //write your business logic
        //yo can inject your message service  as parameter of this function
    }
}
