<?php

namespace App\Jobs;

use App\Http\Custom\SmsApi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSmsOrderSubmittedDenoojFreightageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $mobile,$orderNumber,$last_name;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mobile,$orderNumber,$last_name)
    {
        $this->mobile = $mobile;
        $this->orderNumber = $orderNumber;
        $this->last_name = $last_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        SmsApi::sendOrderSubmittedDenoojFreightage($this->mobile,$this->orderNumber,$this->last_name);
    }
}
