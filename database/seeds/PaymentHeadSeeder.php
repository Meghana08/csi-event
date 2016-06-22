<?php

use App\PaymentHead;
use Illuminate\Database\Seeder;

class PaymentHeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_heads');
        $data = [
			['membership_period_id' => 1, 'currency_id' => 1, 'service_tax_class_id' => 1, 'amount' => 6000],
			['membership_period_id' => 2, 'currency_id' => 1, 'service_tax_class_id' => 1, 'amount' => 11000],
			['membership_period_id' => 3, 'currency_id' => 1, 'service_tax_class_id' => 1, 'amount' => 16000],
			['membership_period_id' => 4, 'currency_id' => 1, 'service_tax_class_id' => 1, 'amount' => 21000],
			['membership_period_id' => 5, 'currency_id' => 1, 'service_tax_class_id' => 1, 'amount' => 25000],
			['membership_period_id' => 6, 'currency_id' => 1, 'service_tax_class_id' => 1, 'amount' => 48000],
			['membership_period_id' => 7, 'currency_id' => 1, 'service_tax_class_id' => 1, 'amount' => 70000],
			['membership_period_id' => 8, 'currency_id' => 1, 'service_tax_class_id' => 1, 'amount' => 90000],
			['membership_period_id' => 9, 'currency_id' => 1, 'service_tax_class_id' => 1, 'amount' => 10000],
			['membership_period_id' => 10, 'currency_id' => 1, 'service_tax_class_id' => 1, 'amount' => 19000],
			['membership_period_id' => 11, 'currency_id' => 1, 'service_tax_class_id' => 1, 'amount' => 28000],
			['membership_period_id' => 12, 'currency_id' => 1, 'service_tax_class_id' => 1, 'amount' => 36000],
			['membership_period_id' => 13, 'currency_id' => 1, 'service_tax_class_id' => 1, 'amount' => 45000],
			['membership_period_id' => 14, 'currency_id' => 1, 'service_tax_class_id' => 1, 'amount' => 85000],
			['membership_period_id' => 15, 'currency_id' => 1, 'service_tax_class_id' => 1, 'amount' => 125000],
			['membership_period_id' => 16, 'currency_id' => 1, 'service_tax_class_id' => 1, 'amount' => 150000],
			['membership_period_id' => 17, 'currency_id' => 1, 'service_tax_class_id' => 1, 'amount' => 1000],
			['membership_period_id' => 18, 'currency_id' => 1, 'service_tax_class_id' => 1, 'amount' => 1800],
			['membership_period_id' => 19, 'currency_id' => 1, 'service_tax_class_id' => 1, 'amount' => 2600],
			['membership_period_id' => 20, 'currency_id' => 1, 'service_tax_class_id' => 1, 'amount' => 3500],
			['membership_period_id' => 17, 'currency_id' => 2, 'service_tax_class_id' => 2, 'amount' => 60],
			['membership_period_id' => 18, 'currency_id' => 2, 'service_tax_class_id' => 2, 'amount' => 110],
			['membership_period_id' => 19, 'currency_id' => 2, 'service_tax_class_id' => 2, 'amount' => 150],
			['membership_period_id' => 20, 'currency_id' => 2, 'service_tax_class_id' => 2, 'amount' => 180],
			['membership_period_id' => 21, 'currency_id' => 1, 'service_tax_class_id' => 1, 'amount' => 1000],
			['membership_period_id' => 22, 'currency_id' => 1, 'service_tax_class_id' => 1, 'amount' => 1800],
			['membership_period_id' => 23, 'currency_id' => 1, 'service_tax_class_id' => 1, 'amount' => 2600],
			['membership_period_id' => 24, 'currency_id' => 1, 'service_tax_class_id' => 1, 'amount' => 3500],
			['membership_period_id' => 25, 'currency_id' => 1, 'service_tax_class_id' => 1, 'amount' => 10000],
			['membership_period_id' => 21, 'currency_id' => 2, 'service_tax_class_id' => 2, 'amount' => 60],
			['membership_period_id' => 22, 'currency_id' => 2, 'service_tax_class_id' => 2, 'amount' => 110],
			['membership_period_id' => 23, 'currency_id' => 2, 'service_tax_class_id' => 2, 'amount' => 150],
			['membership_period_id' => 24, 'currency_id' => 2, 'service_tax_class_id' => 2, 'amount' => 180],
			['membership_period_id' => 25, 'currency_id' => 2, 'service_tax_class_id' => 2, 'amount' => 650]
        ];

        foreach ($data as $value) {
        	PaymentHead::create($value);
        }
    }
}