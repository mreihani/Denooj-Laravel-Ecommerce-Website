<?php

use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use Modules\Orders\Entities\Order;
use Modules\Products\Entities\Product;
use Modules\Products\Entities\ProductColor;
use Modules\Products\Entities\ProductInventory;
use Modules\Products\Entities\ProductSize;

// user cart
if (!function_exists('cart')){
    function cart(){
        if (Auth::check()){
            return \Cart::session(Auth::user()->id);
        }
        if (session()->has('banta_uuid')){
            $sessionKey = session('banta_uuid');
        }else{
            $sessionKey = \Illuminate\Support\Str::orderedUuid();
            session()->put('banta_uuid',$sessionKey);
        }
        return \Cart::session($sessionKey);
    }
}

// not logged in user cart
if (!function_exists('get_guest_cart')){
    function get_guest_cart(){
        if (session()->has('banta_uuid')){
            $sessionKey = session('banta_uuid');
            return \Cart::session($sessionKey);
        }
        return null;
    }
}

// check if email information is valid and can connect to mail server
if (!function_exists('can_send_mail')){
    function can_send_mail(): bool
    {
        try{
            $transport = new Swift_SmtpTransport(env('MAIL_HOST'), env('MAIL_PORT'));
            $transport->setUsername(env('MAIL_USERNAME'));
            $transport->setPassword(env('MAIL_PASSWORD'));
            $mailer = new Swift_Mailer($transport);
            $mailer->getTransport()->start();
            return true;
        } catch (Swift_TransportException $e) {
        } catch (Exception $e) {
        }
        return false;
    }
}

// notification check functions
if (!function_exists('allow_product_comment_email')){
    function allow_product_comment_email(): bool
    {
        $notifSettings = \Modules\Settings\Entities\NotificationSetting::first();
        return $notifSettings->product_comment_email;
    }
}
if (!function_exists('allow_post_comment_email')){
    function allow_post_comment_email(): bool
    {
        $notifSettings = \Modules\Settings\Entities\NotificationSetting::first();
        return $notifSettings->post_comment_email;
    }
}
if (!function_exists('allow_question_email')){
    function allow_question_email(): bool
    {
        $notifSettings = \Modules\Settings\Entities\NotificationSetting::first();
        return $notifSettings->question_email;
    }
}
if (!function_exists('allow_new_order_email')){
    function allow_new_order_email(): bool
    {
        $notifSettings = \Modules\Settings\Entities\NotificationSetting::first();
        return $notifSettings->new_order_email;
    }
}
if (!function_exists('allow_product_comment_sms')){
    function allow_product_comment_sms(): bool
    {
        $notifSettings = \Modules\Settings\Entities\NotificationSetting::first();
        return $notifSettings->product_comment_sms;
    }
}
if (!function_exists('allow_post_comment_sms')){
    function allow_post_comment_sms(): bool
    {
        $notifSettings = \Modules\Settings\Entities\NotificationSetting::first();
        return $notifSettings->post_comment_sms;
    }
}
if (!function_exists('allow_question_sms')){
    function allow_question_sms(): bool
    {
        $notifSettings = \Modules\Settings\Entities\NotificationSetting::first();
        return $notifSettings->question_sms;
    }
}
if (!function_exists('allow_new_order_sms')){
    function allow_new_order_sms(): bool
    {
        $notifSettings = \Modules\Settings\Entities\NotificationSetting::first();
        return $notifSettings->new_order_sms;
    }
}
if (!function_exists('allow_user_order_submitted_sms')){
    function allow_user_order_submitted_sms(): bool
    {
        $notifSettings = \Modules\Settings\Entities\NotificationSetting::first();
        return $notifSettings->user_order_submitted_sms;
    }
}
if (!function_exists('allow_user_order_completed_sms')){
    function allow_user_order_completed_sms(): bool
    {
        $notifSettings = \Modules\Settings\Entities\NotificationSetting::first();
        return $notifSettings->user_order_completed_sms;
    }
}
if (!function_exists('allow_user_order_sent_sms')){
    function allow_user_order_sent_sms(): bool
    {
        $notifSettings = \Modules\Settings\Entities\NotificationSetting::first();
        return $notifSettings->user_order_sent_sms;
    }
}
if (!function_exists('allow_user_question_answered_sms')){
    function allow_user_question_answered_sms(): bool
    {
        $notifSettings = \Modules\Settings\Entities\NotificationSetting::first();
        return $notifSettings->user_question_answered_sms;
    }
}

function product_color_list() : array{
    return array(
        array('id' => '1','name' => 'جگری','code' => 'Indian_red','hex_code' => '#cd5c5c','created_at' => '2021-07-07 10:19:45','updated_at' => '2021-07-07 10:19:45'),
        array('id' => '2','name' => 'بژ تیره','code' => 'light_coral','hex_code' => '#f08080','created_at' => '2021-07-07 10:20:17','updated_at' => '2021-07-07 10:20:17'),
        array('id' => '3','name' => 'حنایی روشن','code' => 'salmon','hex_code' => '#fa8072','created_at' => '2021-07-07 10:20:46','updated_at' => '2021-07-07 10:20:46'),
        array('id' => '4','name' => 'قهوه‌ای حنایی','code' => 'dark_salmon','hex_code' => '#e9967a','created_at' => '2021-07-07 10:21:14','updated_at' => '2021-07-07 10:21:14'),
        array('id' => '5','name' => 'کرم نارنجی','code' => 'light_salmon','hex_code' => '#ff9f7a','created_at' => '2021-07-07 10:21:39','updated_at' => '2021-07-07 10:21:39'),
        array('id' => '6','name' => 'قرمز','code' => 'red','hex_code' => '#ff0000','created_at' => '2021-07-07 10:21:57','updated_at' => '2021-07-07 10:21:57'),
        array('id' => '7','name' => 'زرشکی','code' => 'crimson','hex_code' => '#dc133b','created_at' => '2021-07-07 10:22:20','updated_at' => '2021-07-07 10:22:20'),
        array('id' => '8','name' => 'شرابی','code' => 'fire_brick','hex_code' => '#b22222','created_at' => '2021-07-07 10:22:47','updated_at' => '2021-07-07 10:22:47'),
        array('id' => '9','name' => 'عنابی تند','code' => 'dark_red','hex_code' => '#8b0000','created_at' => '2021-07-07 10:23:07','updated_at' => '2021-07-07 10:23:07'),
        array('id' => '10','name' => 'صورتی','code' => 'pink','hex_code' => '#ffc0cb','created_at' => '2021-07-07 17:01:44','updated_at' => '2021-07-07 17:01:44'),
        array('id' => '11','name' => 'صورتی پر رنگ','code' => 'light_pink','hex_code' => '#ffb6c1','created_at' => '2021-07-07 17:03:12','updated_at' => '2021-07-07 17:03:12'),
        array('id' => '12','name' => 'شرابی روشن','code' => 'pale_violetRed','hex_code' => '#db6f93','created_at' => '2021-07-07 17:03:57','updated_at' => '2021-07-07 17:03:57'),
        array('id' => '13','name' => 'سرخابی','code' => 'hot_pink','hex_code' => '#ff69b3','created_at' => '2021-07-07 17:07:28','updated_at' => '2021-07-07 17:07:28'),
        array('id' => '14','name' => 'شفقی','code' => 'deep_pink','hex_code' => '#ff1392','created_at' => '2021-07-07 17:08:14','updated_at' => '2021-07-07 17:08:14'),
        array('id' => '15','name' => 'ارغوانی','code' => 'medium_violet_red','hex_code' => '#c71585','created_at' => '2021-07-07 17:09:40','updated_at' => '2021-07-07 17:11:12'),
        array('id' => '16','name' => 'نارنجی کرم','code' => 'light_salmon','hex_code' => '#ff9f7a','created_at' => '2021-07-07 17:12:17','updated_at' => '2021-07-07 17:12:17'),
        array('id' => '17','name' => 'نارنجی','code' => 'orange','hex_code' => '#ffa400','created_at' => '2021-07-07 17:12:47','updated_at' => '2021-07-07 17:12:47'),
        array('id' => '18','name' => 'نارنجی سیر','code' => 'dark_orange','hex_code' => '#ff8c00','created_at' => '2021-07-07 17:13:33','updated_at' => '2021-07-07 17:13:33'),
        array('id' => '19','name' => 'نارنجی پررنگ','code' => 'coral','hex_code' => '#ff7e50','created_at' => '2021-07-07 17:14:14','updated_at' => '2021-07-07 17:14:14'),
        array('id' => '20','name' => 'قرمز گوجه‌ای','code' => 'tomato','hex_code' => '#ff6347','created_at' => '2021-07-07 17:15:03','updated_at' => '2021-07-07 17:15:03'),
        array('id' => '21','name' => 'قرمز-نارنجی','code' => 'orange_red','hex_code' => '#ff4400','created_at' => '2021-07-07 17:15:51','updated_at' => '2021-07-07 17:15:51'),
        array('id' => '22','name' => 'شیری','code' => 'light_yellow','hex_code' => '#ffffe0','created_at' => '2021-07-07 17:16:31','updated_at' => '2021-07-07 17:16:31'),
        array('id' => '23','name' => 'شیرشکری','code' => 'lemon_chiffon','hex_code' => '#fff9cd','created_at' => '2021-07-07 17:17:24','updated_at' => '2021-07-07 17:17:24'),
        array('id' => '24','name' => 'لیمویی روشن','code' => 'light_goldenrod_yellow','hex_code' => '#fafad2','created_at' => '2021-07-07 17:18:32','updated_at' => '2021-07-07 17:18:32'),
        array('id' => '25','name' => 'هلویی روشن','code' => 'papaya_whip','hex_code' => '#ffeed5','created_at' => '2021-07-07 17:35:23','updated_at' => '2021-07-07 17:35:23'),
        array('id' => '26','name' => 'هلویی','code' => 'moccasin','hex_code' => '#ffe4b5','created_at' => '2021-07-07 17:36:03','updated_at' => '2021-07-07 17:36:03'),
        array('id' => '27','name' => 'هلویی پررنگ','code' => 'peach_puff','hex_code' => '#ffdab9','created_at' => '2021-07-07 17:36:34','updated_at' => '2021-07-07 17:36:34'),
        array('id' => '28','name' => 'نخودی','code' => 'pale_goldenrod','hex_code' => '#eee8aa','created_at' => '2021-07-07 17:37:56','updated_at' => '2021-07-07 17:37:56'),
        array('id' => '29','name' => 'خاکی','code' => 'khaki','hex_code' => '#f0e58c','created_at' => '2021-07-07 17:38:58','updated_at' => '2021-07-07 17:38:58'),
        array('id' => '30','name' => 'زرد','code' => 'yellow','hex_code' => '#ffff00','created_at' => '2021-07-07 17:43:52','updated_at' => '2021-07-07 17:43:52'),
        array('id' => '31','name' => 'کهربایی باز','code' => 'gold','hex_code' => '#ffd600','created_at' => '2021-07-07 17:44:14','updated_at' => '2021-07-07 17:44:14'),
        array('id' => '32','name' => 'ماشی','code' => 'dark_khaki','hex_code' => '#bdb76a','created_at' => '2021-07-07 17:46:00','updated_at' => '2021-07-07 17:46:00'),
        array('id' => '33','name' => 'مغزپسته‌ای','code' => 'green_yellow','hex_code' => '#acff2f','created_at' => '2021-07-07 17:46:49','updated_at' => '2021-07-07 17:56:16'),
        array('id' => '34','name' => 'سبز روشن','code' => 'chartreuse','hex_code' => '#7fff00','created_at' => '2021-07-07 17:57:45','updated_at' => '2021-07-07 17:57:45'),
        array('id' => '35','name' => 'مغزپسته‌ای پررنگ','code' => 'lawn_green','hex_code' => '#7cfc00','created_at' => '2021-07-07 18:01:08','updated_at' => '2021-07-07 18:01:08'),
        array('id' => '36','name' => 'مغزپسته‌ای تیره','code' => 'lime','hex_code' => '#00ff00','created_at' => '2021-07-07 18:06:33','updated_at' => '2021-07-07 18:06:33'),
        array('id' => '37','name' => 'سبز کمرنگ','code' => 'pale_green','hex_code' => '#98fb98','created_at' => '2021-07-07 18:07:07','updated_at' => '2021-07-07 18:07:07'),
        array('id' => '38','name' => 'سبز کدر','code' => 'light_green','hex_code' => '#90ee90','created_at' => '2021-07-07 18:07:51','updated_at' => '2021-07-07 18:07:51'),
        array('id' => '39','name' => 'یشمی سیر','code' => 'medium_spring_green','hex_code' => '#00fa99','created_at' => '2021-07-07 18:08:57','updated_at' => '2021-07-07 18:08:57'),
        array('id' => '40','name' => 'یشمی کمرنگ','code' => 'spring_green','hex_code' => '#00ff7f','created_at' => '2021-07-07 18:10:13','updated_at' => '2021-07-07 18:10:13'),
        array('id' => '41','name' => 'سبز لجنی','code' => 'yellow_green','hex_code' => '#9acd32','created_at' => '2021-07-07 18:10:44','updated_at' => '2021-07-07 18:10:44'),
        array('id' => '42','name' => 'سبز چمنی','code' => 'grassy','hex_code' => '#32cd32','created_at' => '2021-07-07 18:11:19','updated_at' => '2021-07-07 18:11:19'),
        array('id' => '43','name' => 'خزه‌ای','code' => 'medium_sea_green','hex_code' => '#3bb371','created_at' => '2021-07-07 18:12:26','updated_at' => '2021-07-07 18:12:26'),
        array('id' => '44','name' => 'خزه‌ای پررنگ','code' => 'sea_green','hex_code' => '#2e8b56','created_at' => '2021-07-07 18:13:21','updated_at' => '2021-07-07 18:13:21'),
        array('id' => '45','name' => 'شویدی','code' => 'forest_green','hex_code' => '#218b21','created_at' => '2021-07-07 18:14:58','updated_at' => '2021-07-07 18:14:58'),
        array('id' => '46','name' => 'سبز','code' => 'green','hex_code' => '#008000','created_at' => '2021-07-07 18:16:37','updated_at' => '2021-07-07 18:16:37'),
        array('id' => '47','name' => 'سبز ارتشی','code' => 'olive_drab','hex_code' => '#6a8e23','created_at' => '2021-07-07 18:17:25','updated_at' => '2021-07-07 18:17:25'),
        array('id' => '48','name' => 'زیتونی','code' => 'olive','hex_code' => '#808000','created_at' => '2021-07-07 18:17:58','updated_at' => '2021-07-07 18:17:58'),
        array('id' => '49','name' => 'زیتونی سیر','code' => 'dark_olive_green','hex_code' => '#546b2f','created_at' => '2021-07-07 18:18:38','updated_at' => '2021-07-07 18:18:38'),
        array('id' => '50','name' => 'سبز آووکادو','code' => 'dark_green','hex_code' => '#006400','created_at' => '2021-07-07 18:29:47','updated_at' => '2021-07-07 18:29:47'),
        array('id' => '51','name' => 'سبز دریایی','code' => 'medium_aquamarine','hex_code' => '#66cdaa','created_at' => '2021-07-07 18:30:48','updated_at' => '2021-07-07 18:30:48'),
        array('id' => '52','name' => 'سبز دریایی تیره','code' => 'dark_sea_green','hex_code' => '#8fbc8f','created_at' => '2021-07-07 18:31:20','updated_at' => '2021-07-07 18:31:20'),
        array('id' => '53','name' => 'سبز کبریتی روشن','code' => 'light_sea_green','hex_code' => '#20b2aa','created_at' => '2021-07-07 18:32:02','updated_at' => '2021-07-07 18:32:02'),
        array('id' => '54','name' => 'سبز کبریتی تیره','code' => 'dark_cyan','hex_code' => '#008b8b','created_at' => '2021-07-07 18:32:39','updated_at' => '2021-07-07 18:32:39'),
        array('id' => '55','name' => 'سبز دودی','code' => 'teal','hex_code' => '#008080','created_at' => '2021-07-07 18:34:05','updated_at' => '2021-07-07 18:34:05'),
        array('id' => '56','name' => 'فیروزه‌ای','code' => 'aqua','hex_code' => '#00ffff','created_at' => '2021-07-07 18:34:48','updated_at' => '2021-07-07 18:34:48'),
        array('id' => '57','name' => 'آبی آسمانی','code' => 'light_cyan','hex_code' => '#e0ffff','created_at' => '2021-07-07 18:35:27','updated_at' => '2021-07-07 18:35:27'),
        array('id' => '58','name' => 'فیروزه‌ای کدر','code' => 'pale_turquoise','hex_code' => '#afeeee','created_at' => '2021-07-07 18:36:05','updated_at' => '2021-07-07 18:36:05'),
        array('id' => '59','name' => 'آبی دریایی','code' => 'cyan','hex_code' => '#00ffff','created_at' => '2021-07-07 18:36:34','updated_at' => '2021-07-07 18:36:34'),
        array('id' => '60','name' => 'یشمی','code' => 'aquamarine','hex_code' => '#7fffd3','created_at' => '2021-07-07 18:37:02','updated_at' => '2021-07-07 18:37:02'),
        array('id' => '61','name' => 'سبز دریایی روشن','code' => 'turquoise','hex_code' => '#40e0cf','created_at' => '2021-07-07 18:37:29','updated_at' => '2021-07-07 18:37:29'),
        array('id' => '62','name' => 'فیروزه‌ای تیره','code' => 'medium_turquoise','hex_code' => '#48d1cb','created_at' => '2021-07-07 18:38:02','updated_at' => '2021-07-07 18:38:02'),
        array('id' => '63','name' => 'فیروزه‌ای سیر','code' => 'dark_turquoise','hex_code' => '#00ced1','created_at' => '2021-07-07 18:38:36','updated_at' => '2021-07-07 18:38:36'),
        array('id' => '64','name' => 'آبی کبریتی روشن','code' => 'powder_blue','hex_code' => '#b0e0e6','created_at' => '2021-07-07 18:39:22','updated_at' => '2021-07-07 18:39:22'),
        array('id' => '65','name' => 'بنفش مایل به آبی','code' => 'light_steel_blue','hex_code' => '#b0c3de','created_at' => '2021-07-07 18:44:00','updated_at' => '2021-07-07 18:44:00'),
        array('id' => '66','name' => 'آبی کبریتی','code' => 'light_blue','hex_code' => '#add7e6','created_at' => '2021-07-07 18:44:36','updated_at' => '2021-07-07 18:44:36'),
        array('id' => '67','name' => 'آبی آسمانی سیر','code' => 'sky_blue','hex_code' => '#87cdeb','created_at' => '2021-07-07 18:45:05','updated_at' => '2021-07-07 18:45:05'),
        array('id' => '68','name' => 'چند رنگی','code' => 'multi_color','hex_code' => '#33ada8','created_at' => '2021-07-07 18:47:10','updated_at' => '2021-07-07 18:47:10'),
        array('id' => '69','name' => 'آبی روشن','code' => 'light_sky_blue','hex_code' => '#87cefa','created_at' => '2021-07-07 18:48:06','updated_at' => '2021-07-07 18:48:06'),
        array('id' => '70','name' => 'آبی کمرنگ','code' => 'deep_sky_blue','hex_code' => '#00bfff','created_at' => '2021-07-07 18:49:06','updated_at' => '2021-07-07 18:49:06'),
        array('id' => '71','name' => 'آبی کدر','code' => 'cornflower_blue','hex_code' => '#6495ed','created_at' => '2021-07-07 18:49:51','updated_at' => '2021-07-07 18:49:51'),
        array('id' => '72','name' => 'نیلی متالیک','code' => 'steel_blue','hex_code' => '#4682b4','created_at' => '2021-07-07 18:50:47','updated_at' => '2021-07-07 18:50:47'),
        array('id' => '73','name' => 'آبی لجنی','code' => 'cadet_blue','hex_code' => '#5f9da0','created_at' => '2021-07-07 18:52:22','updated_at' => '2021-07-07 18:52:22'),
        array('id' => '74','name' => 'آبی متالیک روشن','code' => 'medium_slate_blue','hex_code' => '#7b68ee','created_at' => '2021-07-07 18:53:11','updated_at' => '2021-07-07 18:53:11'),
        array('id' => '75','name' => 'v','code' => 'dodger_blue','hex_code' => '#1e8fff','created_at' => '2021-07-07 18:53:40','updated_at' => '2021-07-07 18:53:40'),
        array('id' => '76','name' => 'فیروزه‌ای فسفری','code' => 'royal_blue','hex_code' => '#4169e1','created_at' => '2021-07-07 18:54:11','updated_at' => '2021-07-07 18:54:11'),
        array('id' => '77','name' => 'آبی','code' => 'blue','hex_code' => '#0000ff','created_at' => '2021-07-07 18:54:42','updated_at' => '2021-07-07 18:54:42'),
        array('id' => '78','name' => 'آبی سیر','code' => 'medium_blue','hex_code' => '#0000cd','created_at' => '2021-07-07 18:55:10','updated_at' => '2021-07-07 18:55:10'),
        array('id' => '79','name' => 'سرمه‌ای','code' => 'dark_blue','hex_code' => '#00008b','created_at' => '2021-07-07 18:55:47','updated_at' => '2021-07-07 18:55:47'),
        array('id' => '80','name' => 'لاجوردی','code' => 'navy','hex_code' => '#000080','created_at' => '2021-07-07 18:56:21','updated_at' => '2021-07-07 18:56:21'),
        array('id' => '81','name' => 'آبی نفتی','code' => 'midnight_blue','hex_code' => '#181870','created_at' => '2021-07-07 18:57:03','updated_at' => '2021-07-07 18:57:03'),
        array('id' => '82','name' => 'مشکی','code' => 'black','hex_code' => '#000000','created_at' => '2021-07-07 20:17:42','updated_at' => '2021-07-07 20:17:42'),
        array('id' => '83','name' => 'نیلی کمرنگ','code' => 'lavender','hex_code' => '#e6e6fa','created_at' => '2021-07-08 17:01:07','updated_at' => '2021-07-08 17:01:07'),
        array('id' => '84','name' => 'بادمجانی روشن','code' => 'thistle','hex_code' => '#d8bfd8','created_at' => '2021-07-08 17:01:26','updated_at' => '2021-07-08 17:01:26'),
        array('id' => '85','name' => 'بنفش کدر','code' => 'plum','hex_code' => '#dda0dd','created_at' => '2021-07-08 17:01:45','updated_at' => '2021-07-08 17:01:45'),
        array('id' => '86','name' => 'بنفش روشن','code' => 'Violet','hex_code' => '#ee82ee','created_at' => '2021-07-08 17:01:55','updated_at' => '2021-07-08 17:01:55'),
        array('id' => '87','name' => 'سرخابی','code' => 'fuchsia','hex_code' => '#ff00ff','created_at' => '2021-07-08 17:02:11','updated_at' => '2021-07-08 17:02:11'),
        array('id' => '88','name' => 'سرخابی روشن','code' => 'magenta','hex_code' => '#ff00ff','created_at' => '2021-07-08 17:02:47','updated_at' => '2021-07-08 17:02:47'),
        array('id' => '89','name' => 'ارکیده','code' => 'orchid','hex_code' => '#da70d5','created_at' => '2021-07-08 17:03:02','updated_at' => '2021-07-08 17:03:02'),
        array('id' => '90','name' => 'ارکیده سیر','code' => 'medium_orchid','hex_code' => '#b955d3','created_at' => '2021-07-08 17:03:21','updated_at' => '2021-07-08 17:03:21'),
        array('id' => '91','name' => 'آبی بنفش','code' => 'medium_purple','hex_code' => '#936fdb','created_at' => '2021-07-08 17:03:38','updated_at' => '2021-07-08 17:03:38'),
        array('id' => '92','name' => 'آبی فولادی','code' => 'slate_blue','hex_code' => '#695acd','created_at' => '2021-07-08 17:04:00','updated_at' => '2021-07-08 17:04:00'),
        array('id' => '93','name' => 'آبی-بنفش سیر','code' => 'blue_violet','hex_code' => '#8a2be2','created_at' => '2021-07-08 17:04:22','updated_at' => '2021-07-08 17:04:22'),
        array('id' => '94','name' => 'بنفش باز','code' => 'dark_violet','hex_code' => '#9300d3','created_at' => '2021-07-08 17:04:54','updated_at' => '2021-07-08 17:04:54'),
        array('id' => '95','name' => 'ارکیده بنفش','code' => 'amethyst','hex_code' => '#9831cc','created_at' => '2021-07-08 17:05:06','updated_at' => '2021-07-08 17:05:06'),
        array('id' => '96','name' => 'مخملی','code' => 'dark_magenta','hex_code' => '#8b008b','created_at' => '2021-07-08 17:05:23','updated_at' => '2021-07-08 17:05:23'),
        array('id' => '97','name' => 'بنفش','code' => 'purple','hex_code' => '#800080','created_at' => '2021-07-08 17:05:50','updated_at' => '2021-07-08 17:05:50'),
        array('id' => '98','name' => 'آبی دودی','code' => 'dark_slate_blue','hex_code' => '#473d8b','created_at' => '2021-07-08 17:06:07','updated_at' => '2021-07-08 17:06:07'),
        array('id' => '99','name' => 'نیلی سیر','code' => 'indigo','hex_code' => '#4b0082','created_at' => '2021-07-08 17:06:21','updated_at' => '2021-07-08 17:06:21'),
        array('id' => '100','name' => 'کاهی','code' => 'cornsilk','hex_code' => '#fff8dc','created_at' => '2021-07-08 17:47:51','updated_at' => '2021-07-08 17:47:51'),
        array('id' => '101','name' => 'کاهگلی','code' => 'blanched_almond','hex_code' => '#ffebcd','created_at' => '2021-07-08 17:48:25','updated_at' => '2021-07-08 17:49:21'),
        array('id' => '102','name' => 'کرم','code' => 'bisque','hex_code' => '#ffe4c4','created_at' => '2021-07-08 17:48:50','updated_at' => '2021-07-08 17:48:50'),
        array('id' => '103','name' => 'کرم سیر','code' => 'navajo_white','hex_code' => '#ffdead','created_at' => '2021-07-08 17:50:07','updated_at' => '2021-07-08 17:50:07'),
        array('id' => '104','name' => 'گندمی','code' => 'wheat','hex_code' => '#f5ddb3','created_at' => '2021-07-08 17:50:35','updated_at' => '2021-07-08 17:50:35'),
        array('id' => '105','name' => 'خاکی','code' => 'burly_wood','hex_code' => '#deb787','created_at' => '2021-07-08 17:51:37','updated_at' => '2021-07-08 17:51:37'),
        array('id' => '106','name' => 'برنزه کدر','code' => 'tan','hex_code' => '#d2b38c','created_at' => '2021-07-08 17:52:03','updated_at' => '2021-07-08 17:52:03'),
        array('id' => '107','name' => 'بادمجانی','code' => 'rosy_brown','hex_code' => '#bc8f8f','created_at' => '2021-07-08 17:52:34','updated_at' => '2021-07-08 17:52:34'),
        array('id' => '108','name' => 'هلویی سیر','code' => 'sandy_brown','hex_code' => '#f4a460','created_at' => '2021-07-08 17:53:51','updated_at' => '2021-07-08 17:53:51'),
        array('id' => '109','name' => 'خردلی','code' => 'goldenrod','hex_code' => '#daa420','created_at' => '2021-07-08 17:54:31','updated_at' => '2021-07-08 17:54:31'),
        array('id' => '110','name' => 'ماشی سیر','code' => 'dark_goldenrod','hex_code' => '#b8860a','created_at' => '2021-07-08 17:55:03','updated_at' => '2021-07-08 17:55:03'),
        array('id' => '111','name' => 'بادامی سیر','code' => 'peru','hex_code' => '#cd843f','created_at' => '2021-07-08 17:55:26','updated_at' => '2021-07-08 17:55:26'),
        array('id' => '112','name' => 'عسلی پررنگ','code' => 'chocolate','hex_code' => '#d2691e','created_at' => '2021-07-08 17:55:53','updated_at' => '2021-07-08 17:55:53'),
        array('id' => '113','name' => 'کاکائویی','code' => 'saddle_brown','hex_code' => '#8b4513','created_at' => '2021-07-08 17:56:48','updated_at' => '2021-07-08 17:56:48'),
        array('id' => '114','name' => 'قهوه‌ای متوسط','code' => 'sienna','hex_code' => '#a0512d','created_at' => '2021-07-08 17:57:44','updated_at' => '2021-07-08 17:57:44'),
        array('id' => '115','name' => 'قهوه‌ای','code' => 'brown','hex_code' => '#a52a2a','created_at' => '2021-07-08 17:58:26','updated_at' => '2021-07-08 17:58:26'),
        array('id' => '116','name' => 'آلبالویی','code' => 'maroon','hex_code' => '#800000','created_at' => '2021-07-08 17:58:57','updated_at' => '2021-07-08 17:58:57'),
        array('id' => '117','name' => 'سفید','code' => 'white','hex_code' => '#ffffff','created_at' => '2021-07-08 18:00:29','updated_at' => '2021-07-08 18:00:29'),
        array('id' => '118','name' => 'صورتی محو','code' => 'snow','hex_code' => '#fffafa','created_at' => '2021-07-08 18:00:51','updated_at' => '2021-07-08 18:00:51'),
        array('id' => '119','name' => 'یشمی محو','code' => 'honeydew','hex_code' => '#f0fff0','created_at' => '2021-07-08 18:01:28','updated_at' => '2021-07-08 18:01:28'),
        array('id' => '120','name' => 'سفید نعنائی','code' => 'mint_cream','hex_code' => '#f5fffa','created_at' => '2021-07-08 18:01:57','updated_at' => '2021-07-08 18:01:57'),
        array('id' => '121','name' => 'آبی محو','code' => 'azure','hex_code' => '#f0ffff','created_at' => '2021-07-08 18:02:26','updated_at' => '2021-07-08 18:02:26'),
        array('id' => '122','name' => 'نیلی محو','code' => 'alice_blue','hex_code' => '#f0f8ff','created_at' => '2021-07-08 18:05:48','updated_at' => '2021-07-08 18:05:48'),
        array('id' => '123','name' => 'سفید بنفشه','code' => 'ghost_white','hex_code' => '#f8f8ff','created_at' => '2021-07-08 18:06:16','updated_at' => '2021-07-08 18:06:16'),
        array('id' => '124','name' => 'خاکستری محو','code' => 'white_smoke','hex_code' => '#f5f5f5','created_at' => '2021-07-08 18:07:40','updated_at' => '2021-07-08 18:07:40'),
        array('id' => '125','name' => 'بژ باز','code' => 'seashell','hex_code' => '#fff5ee','created_at' => '2021-07-08 18:08:02','updated_at' => '2021-07-08 18:08:02'),
        array('id' => '126','name' => 'هِلی','code' => 'Beige','hex_code' => '#f5f5dc','created_at' => '2021-07-08 18:08:33','updated_at' => '2021-07-08 18:08:33'),
        array('id' => '127','name' => 'بژ روشن','code' => 'oldLace','hex_code' => '#fdf5e6','created_at' => '2021-07-08 18:08:55','updated_at' => '2021-07-08 18:08:55'),
        array('id' => '128','name' => 'پوست پیازی','code' => 'floral_white','hex_code' => '#fffaf0','created_at' => '2021-07-08 18:09:22','updated_at' => '2021-07-08 18:09:22'),
        array('id' => '129','name' => 'استخوانی','code' => 'lvory','hex_code' => '#fffff0','created_at' => '2021-07-08 18:09:47','updated_at' => '2021-07-08 18:09:47'),
        array('id' => '130','name' => 'بژ تیره','code' => 'antique_white','hex_code' => '#faead7','created_at' => '2021-07-08 18:10:16','updated_at' => '2021-07-08 18:10:16'),
        array('id' => '131','name' => 'کتانی','code' => 'linen','hex_code' => '#faf0e6','created_at' => '2021-07-08 18:10:39','updated_at' => '2021-07-08 18:10:39'),
        array('id' => '132','name' => 'صورتی مات','code' => 'lavender_blush','hex_code' => '#fff0f4','created_at' => '2021-07-08 18:11:08','updated_at' => '2021-07-08 18:11:08'),
        array('id' => '133','name' => 'بژ','code' => 'misty_rose','hex_code' => '#ffe4e1','created_at' => '2021-07-08 18:11:42','updated_at' => '2021-07-08 18:11:42'),
        array('id' => '134','name' => 'خاکستری مات','code' => 'gainsboro','hex_code' => '#dcdcdc','created_at' => '2021-07-08 18:12:29','updated_at' => '2021-07-08 18:12:29'),
        array('id' => '135','name' => 'نقره‌ای','code' => 'light_grey','hex_code' => '#d3d3d3','created_at' => '2021-07-08 18:12:58','updated_at' => '2021-07-08 18:12:58'),
        array('id' => '136','name' => 'طوسی','code' => 'silver','hex_code' => '#c0c0c0','created_at' => '2021-07-08 18:13:30','updated_at' => '2021-07-29 20:31:55'),
        array('id' => '137','name' => 'خاکستری سیر','code' => 'dark_gray','hex_code' => '#a9a9a9','created_at' => '2021-07-08 18:13:59','updated_at' => '2021-07-08 18:13:59'),
        array('id' => '138','name' => 'خاکستری','code' => 'gray','hex_code' => '#808080','created_at' => '2021-07-08 18:14:28','updated_at' => '2021-07-08 18:14:28'),
        array('id' => '139','name' => 'دودی','code' => 'dim_gray','hex_code' => '#696969','created_at' => '2021-07-08 18:15:03','updated_at' => '2021-07-08 18:15:03'),
        array('id' => '140','name' => 'سربی','code' => 'light_slate_gray','hex_code' => '#778899','created_at' => '2021-07-08 18:15:39','updated_at' => '2021-07-08 18:15:39'),
        array('id' => '141','name' => 'سربی تیره','code' => 'slate_gray','hex_code' => '#708090','created_at' => '2021-07-08 18:16:46','updated_at' => '2021-07-08 18:16:46'),
        array('id' => '142','name' => 'لجنی تیره','code' => 'dark_slate_gray','hex_code' => '#2f4f4f','created_at' => '2021-07-08 18:17:35','updated_at' => '2021-07-08 18:17:35'),
        array('id' => '144','name' => 'بدون رنگ','code' => 'without_color','hex_code' => '#000000','created_at' => '2021-07-20 19:31:41','updated_at' => '2021-07-20 19:31:41'),
        array('id' => '145','name' => 'یاسی','code' => 'jasmine','hex_code' => '#f2e7d7','created_at' => '2021-10-18 17:08:46','updated_at' => '2021-10-18 17:08:46'),
        array('id' => '146','name' => 'طوسی کمرنگ','code' => 'light_grey','hex_code' => '#808080','created_at' => '2021-10-18 17:18:37','updated_at' => '2021-10-18 17:18:37'),
        array('id' => '147','name' => 'کالباسی','code' => 'sausage','hex_code' => '#d598a3','created_at' => '2021-10-28 22:13:50','updated_at' => '2021-10-28 22:14:32')
    );
}

function increaseOrderItemStock(Order $order){
    foreach ($order->items as $item) {
        $product = Product::find($item->id);
        if ($product) {

            if ($product->product_type == 'simple' && $product->manage_stock){
                $product->update([
                    'stock' => $product->stock + $item->pivot->quantity
                ]);

            }else if($product->product_type == 'variation'){

                if ($item->pivot->color && $item->pivot->size){
                    // color and size
                    $color = ProductColor::where('label',$item->pivot->color)->first();
                    $size = ProductSize::where('label',$item->pivot->size)->first();
                    $inventory = ProductInventory::where('product_id',$product->id)->where('color_id',$color->id)->where('size_id',$size->id)->first();
                }else if($item->pivot->color && !$item->pivot->size){
                    // just color
                    $color = ProductColor::where('label',$item->pivot->color)->first();
                    $inventory = ProductInventory::where('product_id',$product->id)->where('color_id',$color->id)->first();
                }else if(!$item->pivot->color && $item->pivot->size){
                    // just color
                    $size = ProductSize::where('label',$item->pivot->size)->first();
                    $inventory = ProductInventory::where('product_id',$product->id)->where('size_id',$size->id)->first();
                }

                if (isset($inventory) && !empty($inventory) && $inventory->manage_stock){
                    $inventory->update([
                        'stock' => $inventory->stock + $item->pivot->quantity
                    ]);
                }
            }
        }
    }
}


