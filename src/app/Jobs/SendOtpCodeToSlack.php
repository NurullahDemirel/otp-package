<?php

namespace Nuri\Otp\app\Jobs;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Nuri\Otp\app\Abstracts\SendOtpCode as SendOtpCodeAbstract ;
class SendOtpCodeToSlack extends SendOtpCodeAbstract implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $otpModel = $this->otpModel;
        $otpCode = $this->otpCode;
        // continue your business logic with this values
    }
}
