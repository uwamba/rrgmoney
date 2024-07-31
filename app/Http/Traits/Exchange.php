<?php
namespace App\Http\Traits;
use App\Models\Currency;
trait Exchange {



     public function convert($amount, $fromCurrency, $toCurrency) {
        $fromRate=getRate($fromCurrency);
        $toRate=getRate($toCurrency);

        return $amount * ($toRate/$fromRate);

     }
     public function getRate($currency){
        return Currency::where('currency_name',$currency)->pluck('currency_buying_rate');
     }
}
