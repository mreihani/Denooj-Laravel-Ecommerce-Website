<?php if (!isset($generalSettings)) $generalSettings = \Modules\Settings\Entities\GeneralSetting::first();?>

<a href="https://t.me/frmer" class="fixed-btn telegram-btn bg-primary">
    <i class="icon-telegram"></i>
    <span>تلگرام</span>
</a>

<a href="https://www.denooj.com/panel/tickets/" class="fixed-btn call-btn bg-warning">
    <i class="icon-headphones"></i>
    <span>تیکت</span>
</a>

<!-- @if($generalSettings->display_whatsapp_btn)
<a href="https://wa.me/{{$generalSettings->whatsapp_btn_number}}" class="fixed-btn whatsapp-btn">
    <i class="icon-whatsapp"></i>
    <span>{{$generalSettings->whatsapp_btn_title}}</span>
</a>
@endif -->

<!-- @if($generalSettings->display_call_btn)
<a href="tel:{{$generalSettings->call_btn_number}}" class="fixed-btn call-btn {{$generalSettings->display_whatsapp_btn ? '' : 'bottom-30'}}" title="تماس تلفنی">
    <i class="icon-phone"></i>
    <span>{{$generalSettings->call_btn_title}}</span>
</a>
@endif -->
