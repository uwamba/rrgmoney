<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Currency;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currency = Currency::create([
            'currency_name'    => 'RWF',
            'currency_buying_rate'     => '0.004',
            'currency_selling_rate'         =>  '0.003',
            'currency_reference' =>  'USD',
            'currency_country' =>  'Rwanda',
            'pricing_plan' =>  'percentage',
            'charges_percentage'      => '5',

        ]);
    }
}
