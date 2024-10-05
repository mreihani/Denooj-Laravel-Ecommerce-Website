<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\Questions\Entities\Question;

class NewQuestionSubmitted extends Notification
{
    use Queueable;
    public $question;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($question)
    {
        $this->question = $question;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if ($this->question->model_type == 'product'){
            $line1 = "یک پرسش جدید برای محصول (" . $this->question->product->title. ") ثبت شد.";
        }else{
            $line1 = "یک پرسش جدید در سایت ثبت شده است.";
        }
        $line2 = "از طرف: ". $this->question->user->getFullName();
        $line3 = "متن پرسش: ". $this->question->text;
        $count = Question::where('status','pending')->get()->count();
        $line4 = "هم اکنون $count پرسش در انتظار پاسخ هستند. لطفا بخش مدیریت را ببینید.";

        return (new MailMessage)
            ->from(env('MAIL_FROM_ADDRESS'),config('app.app_name_fa'))
            ->subject("پرسش جدید ثبت شد!")
            ->line($line1)
            ->line($line2)
            ->line($line3)
            ->line($line4)
            ->action("مشاهده پرسش ها", route('questions.index'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
