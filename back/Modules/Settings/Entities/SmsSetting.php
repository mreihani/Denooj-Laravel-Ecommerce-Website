<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class SmsSetting extends Model
{
    protected $fillable = [
        'sms_provider',

        'farazsms_username',
        'farazsms_password',
        'farazsms_number',
        'farazsms_signin_pattern',
        'farazsms_question_answered_pattern',
        'farazsms_order_submitted_pattern',
        'farazsms_order_completed_pattern',
        'farazsms_product_comment_pattern',
        'farazsms_post_comment_pattern',
        'farazsms_question_pattern',
        'farazsms_admin_order_submitted_pattern',
        'farazsms_order_sent_pattern',

        'ghasedak_api',
        'ghasedak_signin_pattern',
        'ghasedak_question_answered_pattern',
        'ghasedak_order_submitted_pattern',
        'ghasedak_order_completed_pattern',
        'ghasedak_product_comment_pattern',
        'ghasedak_post_comment_pattern',
        'ghasedak_question_pattern',
        'ghasedak_admin_order_submitted_pattern',
        'ghasedak_order_sent_pattern',

        'kavenegar_api',
        'kavenegar_signin_pattern',
        'kavenegar_question_answered_pattern',
        'kavenegar_order_submitted_pattern',
        'kavenegar_order_completed_pattern',
        'kavenegar_product_comment_pattern',
        'kavenegar_post_comment_pattern',
        'kavenegar_question_pattern',
        'kavenegar_admin_order_submitted_pattern',
        'kavenegar_order_sent_pattern',

        'denooj_post',
        'denooj_ordinary_freightage',
        'denooj_coupon_freightage',
        'denooj_three_days',
        'denooj_fifteen_days',
        'denooj_fifteen_days_link',
        'denooj_fourty_days',
        'denooj_fourty_days_link'
    ];
}
