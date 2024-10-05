<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderSubmitted extends Notification
{
    use Queueable;

    public $userPayment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($userPayment)
    {
        $this->userPayment = $userPayment;
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
        $subject = "سفارش جدید";
        $text = "یک سفارش جدید ثبت شد! برای مشاهده جزئیات روی دکمه زیر کلیک کنید!";
        if ($this->userPayment->type == 'wallet'){
            $subject = "شارژ کیف پول";
            $text = "یکی از کاربران کیف پول خود را شارژ کرد! برای مشاهده جزئیات پرداخت روی دکمه زیر کلیک کنید.";
            $actionUrl = route('users.show_payments',$this->userPayment->user);
        }else{
            $actionUrl = route('orders.edit',$this->userPayment->order);
        }

        return (new MailMessage)
            ->from(env('MAIL_FROM_ADDRESS'),config('app.app_name_fa'))
            ->subject($subject)
            ->line($text)
            ->action("مشاهده جزئیات", $actionUrl);
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
