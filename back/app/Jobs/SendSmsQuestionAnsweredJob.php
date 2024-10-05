<?php

namespace App\Jobs;

use App\Http\Custom\SmsApi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSmsQuestionAnsweredJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $mobile,$link;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mobile,$link)
    {
        $this->mobile = $mobile;
        $this->link = $link;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        SmsApi::sendQuestionAnswered($this->mobile,$this->link);
    }
}
