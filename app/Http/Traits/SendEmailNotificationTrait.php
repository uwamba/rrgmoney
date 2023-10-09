<?php
namespace App\Http\Traits;
use App\Models\Topup;
trait SendEmailNotificationTrait {

    public function index() {
        // Fetch all the students from the 'student' table.
        $student = Student::all();
        return view('welcome')->with(compact('student'));
    }

     public function sendEmail($Subject,$body,$link) {


     }
}
