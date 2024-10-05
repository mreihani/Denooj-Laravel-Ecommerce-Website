<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::create([
            'pay_with_zarinpal' => true,
            'pay_with_idpay' => true,
            'sms_provider' => 'farazsms'
        ]);
    }
}
