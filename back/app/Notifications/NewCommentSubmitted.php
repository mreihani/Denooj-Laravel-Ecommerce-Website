<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\Comments\Entities\Comment;

class NewCommentSubmitted extends Notification
{
    use Queueable;
    public $comment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($comment)
    {
        $this->comment = $comment;
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
        $title = "";
        if ($this->comment->product){
            $title = $this->comment->product->title;
        }elseif ($this->comment->post){
            $title = $this->comment->post->title;
        }

        $line1 = "یک دیدگاه جدید برای (" . $title. ") ثبت شد.";
        $line2 = "از طرف: ". $this->comment->user->getFullName();
        $line3 = "متن دیدگاه: ". $this->comment->comment;
        $count = Comment::where('status','pending')->get()->count();
        $line4 = "هم اکنون $count دیدگاه در انتظار بررسی هستند. لطفا بخش مدیریت را ببینید.";

        return (new MailMessage)
            ->from(env('MAIL_FROM_ADDRESS'),config('app.app_name_fa'))
            ->subject("دیدگاه جدید ثبت شد!")
            ->line($line1)
            ->line($line2)
            ->line($line3)
            ->line($line4)
            ->action("مشاهده دیدگاه‌ها", route('comments.index'));
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
