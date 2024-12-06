<?php

namespace Nuri\Otp\app\Jobs;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Nuri\Otp\app\Enum\OtpType;
use Nuri\Otp\app\Models\OtpCode;
use Nuri\Otp\app\Services\OtpCodeService;

class SendOtpCode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public readonly OTPType $otpType, public readonly int|string $ownerId)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->otpType !== OtpType::GOOGLE) {
            OtpCodeService::deleteCode($this->ownerId);
            $code = OTPType::generateOtpCode();
            $otpCode = OtpCode::query()->create([
                'code' => $code,
                'owner_id' => $this->ownerId,
                'otp_type' => $this->otpType
            ]);

            /** @var Model $otpModel */
            $otpModel = (app(config('otp.otp.model')))->query()->findOrFail($this->ownerId);

            $job = $this->otpType->getJob();
            if (is_string($job)) {
                dispatch_sync(app($job, [$otpCode, $otpModel]));
            }

        }
    }
}
