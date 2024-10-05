<?php

namespace App\Jobs;

use App\Http\Custom\SmsApi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSmsProductCommentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $mobile,$title;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mobile,$title)
    {
        $this->mobile = $mobile;
        $this->title = $title;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        SmsApi::sendProductCommentSubmitted($this->mobile,$this->title);
    }
}
