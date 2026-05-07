<?php

namespace Database\Seeders;

use App\Models\WebsitePolicy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $policies = [
            [
                'privacy_policy' => "Test policy",
                'terms_conditions' => "Test terms-conditions",
                'refund_policy' => "Test refund policy",
                'payment_policy' => "Test payment policy",
                'about_us' => "Test About us",
            ]
        ];

        WebsitePolicy::insert($policies);
    }
}
