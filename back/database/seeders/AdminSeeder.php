<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Modules\Admins\Entities\Admin::create([
            'name' => 'کاژه استوک',
            'email' => 'info@kazhestoke.com',
            'password' => \Illuminate\Support\Facades\Hash::make('kazhe_@1234'),
            'bio' => '',
            'instagram' => '#',
            'twitter' => '#',
        ]);
    }
}
