<?php

namespace App\Jobs;

use App\Http\Custom\SmsApi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSmsOrderSentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $mobile,$postalCode;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mobile,$postalCode)
    {
        $this->mobile = $mobile;
        $this->postalCode = $postalCode;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        SmsApi::sendOrderSent($this->mobile,$this->postalCode);
    }
}
