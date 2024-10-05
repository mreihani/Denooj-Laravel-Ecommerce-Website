<?php


namespace App\Http\Custom;

use Ghasedak\GhasedakApi;
use Kavenegar\Exceptions\ApiException;
use Kavenegar\Exceptions\HttpException;
use Kavenegar\KavenegarApi;
use Modules\Settings\Entities\SmsSetting;
use SoapClient;

class SmsApi
{

    // sms providers
    public static function sendViaFarazsms($mobiles, $patternCode, $params, $settings = null)
    {
        if ($settings == null) $settings = SmsSetting::first();
        $context = stream_context_create([
            'ssl' => [
                // set some SSL/TLS specific options
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ]);
        $client = new SoapClient("https://ippanel.com/class/sms/wsdlservice/server.php?wsdl", [
            'stream_context' => $context
        ]);

        $user = $settings->farazsms_username;
        $pass = $settings->farazsms_password;
        $fromNum = $settings->farazsms_number;
        $toNum = array($mobiles);
        $pattern_code = $patternCode;
        $input_data = $params;
        $client->sendPatternSms($fromNum, $toNum, $user, $pass, $pattern_code, $input_data);
    }

    public static function sendViaGhasedak($mobile, $param, $template, $settings = null)
    {
        if ($settings == null) $settings = SmsSetting::first();
        try {
            $api = new GhasedakApi($settings->ghasedak_api);
            $api->Verify($mobile, $template, $param);
        } catch (\Ghasedak\Exceptions\ApiException $e) {
            echo $e->errorMessage();
        } catch (\Ghasedak\Exceptions\HttpException $e) {
            echo $e->errorMessage();
        }
    }

//    public static function sendViaGhasedakApi($mobile, $param, $pattern, $settings = null)
//    {
//        if ($settings == null) $settings = SmsSetting::first();
//        $curl = curl_init();
//        curl_setopt_array($curl,
//            array(
//                CURLOPT_URL => "https://api.ghasedak.me/v2/verification/send/simple",
//                CURLOPT_RETURNTRANSFER => true,
//                CURLOPT_ENCODING => "",
//                CURLOPT_MAXREDIRS => 10,
//                CURLOPT_TIMEOUT => 30,
//                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//                CURLOPT_CUSTOMREQUEST => "POST",
//                CURLOPT_POSTFIELDS => "receptor=$mobile&template=$pattern&type=1&param1=$param",
//                CURLOPT_HTTPHEADER => array(
//                    "apikey: " . $settings->ghasedak_api,
//                    "cache-control: no-cache",
//                    "content-type: application/x-www-form-urlencoded",
//                ),
//            )
//        );
//        $response = curl_exec($curl);
//        $err = curl_error($curl);
//        curl_close($curl);
////        if ($err) {
////            return "cURL Error #:" . $err;
////        } else {
////            return $response;
////        }
//
////        try{
////            $api = new GhasedakApi($settings->ghasedak_api);
////            $api->Verify($mobile, $pattern, $param);
////        }
////        catch(\Ghasedak\Exceptions\ApiException $e){
////            echo $e->errorMessage();
////        }
////        catch(\Ghasedak\Exceptions\HttpException $e){
////            echo $e->errorMessage();
////        }
//    }

    public static function sendViaKavenegar($mobile, $param, $pattern, $settings = null)
    {
        if ($settings == null) $settings = SmsSetting::first();
        try {
            $api = new KavenegarApi($settings->kavenegar_api);
            $receptor = $mobile;
            $token = $param;
            $token2 = "";
            $token3 = "";
            $template = $pattern;
            $type = "sms"; //sms | call
            $result = $api->VerifyLookup($receptor, $token, $token2, $token3, $template, $type);
            if ($result) {
                var_dump($result);
            }
        } catch (ApiException $e) {
            echo $e->errorMessage();
        } catch (HttpException $e) {
            echo $e->errorMessage();
        }
    }

    // auth code
    public static function sendAuthCode($mobile, $authCode)
    {
        $settings = SmsSetting::firstOrCreate();
        if ($settings->sms_provider == 'farazsms') {
            $patternCode = $settings->farazsms_signin_pattern;
            self::sendViaFarazsms($mobile, $patternCode, ['code' => $authCode], $settings);

        } elseif ($settings->sms_provider == 'ghasedak') {
            $patternCode = $settings->ghasedak_signin_pattern;
            self::sendViaGhasedak($mobile, $authCode, $patternCode, $settings);

        } elseif ($settings->sms_provider == 'kavenegar') {
            $token = $settings->kavenegar_signin_pattern;
            self::sendViaKavenegar($mobile, $authCode, $token, $settings);

        } else {
            return false;
        }
        return true;
    }


    // notifications

    public static function sendQuestionAnswered($mobile, $link)
    {
        $settings = SmsSetting::first();
        if ($settings->sms_provider == 'farazsms') {
            $pattern = $settings->farazsms_question_answered_pattern;
            self::sendViaFarazsms($mobile, $pattern, ['link' => $link], $settings);

        } elseif ($settings->sms_provider == 'ghasedak') {
            $pattern = $settings->ghasedak_question_answered_pattern;
            self::sendViaGhasedak($mobile, $link, $pattern, $settings);

        } elseif ($settings->sms_provider == 'kavenegar') {
            $pattern = $settings->kavenegar_question_answered_pattern;
            self::sendViaKavenegar($mobile, $link, $pattern, $settings);

        } else {
            return false;
        }
        return true;
    }

    public static function sendOrderSubmitted($mobile, $param)
    {
        $settings = SmsSetting::first();
        if ($settings->sms_provider == 'farazsms') {
            $pattern = $settings->farazsms_order_submitted_pattern;
            self::sendViaFarazsms($mobile, $pattern, ['number' => substr($param,-6)], $settings);

        } elseif ($settings->sms_provider == 'ghasedak') {
            $template = $settings->ghasedak_order_submitted_pattern;

            self::sendViaGhasedak($mobile, $param, $template, $settings);

        } elseif ($settings->sms_provider == 'kavenegar') {
            $pattern = $settings->kavenegar_order_submitted_pattern;
            self::sendViaKavenegar($mobile, $param, $pattern, $settings);

        } else {
            return false;
        }
        return true;
    }

    public static function sendOrderSubmittedDenoojPost($mobile, $param, $last_name)
    {
        $settings = SmsSetting::first();
        if ($settings->sms_provider == 'farazsms') {
            $pattern = $settings->denooj_post;
            self::sendViaFarazsms($mobile, $pattern, ['order_id' => substr($param,-6), 'name' => $last_name], $settings);
        } 
        return true;
    }

    public static function sendOrderSubmittedDenoojFreightage($mobile, $param, $last_name)
    {
        $settings = SmsSetting::first();
        if ($settings->sms_provider == 'farazsms') {
            $pattern = $settings->denooj_ordinary_freightage;
            self::sendViaFarazsms($mobile, $pattern, ['order_id' => substr($param,-6), 'name' => $last_name], $settings);
        } 
        return true;
    }

    public static function sendOrderSubmittedDenoojFreightageCoupon($mobile, $param, $last_name)
    {
        $settings = SmsSetting::first();
        if ($settings->sms_provider == 'farazsms') {
            $pattern = $settings->denooj_coupon_freightage;
            self::sendViaFarazsms($mobile, $pattern, ['order_id' => substr($param,-6), 'name' => $last_name], $settings);
        } 
        return true;
    }

    public static function sendOrderSubmittedDenoojThreeDays($mobile)
    {
        $settings = SmsSetting::first();
        if ($settings->sms_provider == 'farazsms') {
            $pattern = $settings->denooj_three_days;
            self::sendViaFarazsms($mobile, $pattern, [], $settings);
        } 
        return true;
    }

    public static function sendOrderSubmittedDenoojFifteenDays($mobile, $param, $last_name)
    {
        $settings = SmsSetting::first();
        if ($settings->sms_provider == 'farazsms') {
            $pattern = $settings->denooj_fifteen_days;
            $link = $settings->denooj_fifteen_days_link;
            self::sendViaFarazsms($mobile, $pattern, ['link' => $link, 'name' => $last_name], $settings);
        } 
        return true;
    }

    public static function sendOrderSubmittedDenoojFourtyDays($mobile, $param, $last_name)
    {
        $settings = SmsSetting::first();
        if ($settings->sms_provider == 'farazsms') {
            $pattern = $settings->denooj_fourty_days;
            $link = $settings->denooj_fourty_days_link;
            self::sendViaFarazsms($mobile, $pattern, ['link' => $link, 'name' => $last_name], $settings);
        } 
        return true;
    }

    public static function sendOrderCompleted($mobile, $number)
    {
        $settings = SmsSetting::first();
        if ($settings->sms_provider == 'farazsms') {
            $pattern = $settings->farazsms_order_completed_pattern;
            self::sendViaFarazsms($mobile, $pattern, ['number' => substr($number,-6)], $settings);

        } elseif ($settings->sms_provider == 'ghasedak') {
            $pattern = $settings->ghasedak_order_completed_pattern;
            self::sendViaGhasedak($mobile, $number, $pattern, $settings);

        } elseif ($settings->sms_provider == 'kavenegar') {
            $pattern = $settings->kavenegar_order_completed_pattern;
            self::sendViaKavenegar($mobile, $number, $pattern, $settings);

        } else {
            return false;
        }
        return true;
    }

    public static function sendOrderSent($mobile, $postalCode)
    {
        $settings = SmsSetting::first();
        if ($settings->sms_provider == 'farazsms') {
            $pattern = $settings->farazsms_order_sent_pattern;
            self::sendViaFarazsms($mobile, $pattern, ['number' => $postalCode], $settings);

        } elseif ($settings->sms_provider == 'ghasedak') {
            $pattern = $settings->ghasedak_order_sent_pattern;
            self::sendViaGhasedak($mobile, $postalCode, $pattern, $settings);

        } elseif ($settings->sms_provider == 'kavenegar') {
            $pattern = $settings->kavenegar_order_sent_pattern;
            self::sendViaKavenegar($mobile, $postalCode, $pattern, $settings);

        } else {
            return false;
        }
        return true;
    }

    public static function sendProductCommentSubmitted($mobile, $param)
    {
        $settings = SmsSetting::first();
        if ($settings->sms_provider == 'farazsms') {
            $pattern = $settings->farazsms_product_comment_pattern;
            self::sendViaFarazsms($mobile, $pattern, ['title' => substr($param,-6)], $settings);

        } elseif ($settings->sms_provider == 'ghasedak') {
            $pattern = $settings->ghasedak_product_comment_pattern;
            self::sendViaGhasedak($mobile, $param, $pattern, $settings);

        } elseif ($settings->sms_provider == 'kavenegar') {
            $pattern = $settings->kavenegar_product_comment_pattern;
            self::sendViaKavenegar($mobile, $param, $pattern, $settings);

        } else {
            return false;
        }
        return true;
    }

    public static function sendPostCommentSubmitted($mobile, $param)
    {
        $settings = SmsSetting::first();
        if ($settings->sms_provider == 'farazsms') {
            $pattern = $settings->farazsms_post_comment_pattern;
            self::sendViaFarazsms($mobile, $pattern, ['title' => substr($param,-6)], $settings);

        } elseif ($settings->sms_provider == 'ghasedak') {
            $pattern = $settings->ghasedak_post_comment_pattern;
            self::sendViaGhasedak($mobile, $param, $pattern, $settings);

        } elseif ($settings->sms_provider == 'kavenegar') {
            $pattern = $settings->kavenegar_post_comment_pattern;
            self::sendViaKavenegar($mobile, $param, $pattern, $settings);

        } else {
            return false;
        }
        return true;
    }

    public static function sendQuestionSubmitted($mobile, $param)
    {
        $settings = SmsSetting::first();
        if ($settings->sms_provider == 'farazsms') {
            $pattern = $settings->farazsms_question_pattern;
            self::sendViaFarazsms($mobile, $pattern, ['title' => substr($param,-6)], $settings);

        } elseif ($settings->sms_provider == 'ghasedak') {
            $pattern = $settings->ghasedak_question_pattern;
            self::sendViaGhasedak($mobile, $param, $pattern, $settings);

        } elseif ($settings->sms_provider == 'kavenegar') {
            $pattern = $settings->kavenegar_question_pattern;
            self::sendViaKavenegar($mobile, $param, $pattern, $settings);

        } else {
            return false;
        }
        return true;
    }

    public static function sendAdminOrderSubmitted($mobile, $param)
    {
        $settings = SmsSetting::first();
        if ($settings->sms_provider == 'farazsms') {
            $pattern = $settings->farazsms_admin_order_submitted_pattern;
            self::sendViaFarazsms($mobile, $pattern, ['number' => substr($param,-6)], $settings);

        } elseif ($settings->sms_provider == 'ghasedak') {
            $template = $settings->ghasedak_admin_order_submitted_pattern;
            self::sendViaGhasedak($mobile, '00', $template, $settings);

        } elseif ($settings->sms_provider == 'kavenegar') {
            $pattern = $settings->kavenegar_admin_order_submitted_pattern;
            self::sendViaKavenegar($mobile, $param, $pattern, $settings);

        } else {
            return false;
        }
        return true;
    }


}
