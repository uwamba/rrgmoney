<?php
namespace App\Http\Traits;
use App\Models\Topup;
trait ClientTransactionsTrait {

    public function index() {
        // Fetch all the students from the 'student' table.
        $student = Student::all();
        return view('welcome')->with(compact('student'));
    }

     public function creditUserAccount($amount,$payment_type,$currency,$reference,$user_id,$balance_before,$balance_after) {
             $topup = Topup::create([
                'amount'    => $amount_local,
                'payment_type'   => $payment_type,
                'currency'  => $currency,
                'reference' => $reference,
                'user_id' => $user_id,
                'balance_before' => $balance_before,
                'balance_after' => $total_after,
            ]);

     }
}
