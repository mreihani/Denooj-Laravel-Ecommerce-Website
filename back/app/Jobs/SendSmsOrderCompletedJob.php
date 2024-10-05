<?php

namespace App\Jobs;

use App\Http\Custom\SmsApi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSmsOrderCompletedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $mobile,$orderNumber;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mobile,$orderNumber)
    {
        $this->mobile = $mobile;
        $this->orderNumber = $orderNumber;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        SmsApi::sendOrderCompleted($this->mobile,$this->orderNumber);
    }
}
