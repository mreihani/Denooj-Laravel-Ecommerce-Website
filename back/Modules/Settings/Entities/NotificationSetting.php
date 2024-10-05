<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    protected $fillable = [
        'product_comment_email',
        'post_comment_email',
        'question_email',
        'new_order_email',
        'product_comment_sms',
        'post_comment_sms',
        'question_sms',
        'new_order_sms',
        'user_order_submitted_sms',
        'user_order_completed_sms',
        'user_order_sent_sms',
        'user_question_answered_sms',
    ];
}
