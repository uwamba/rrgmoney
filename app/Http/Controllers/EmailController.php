<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IncomeController extends Controller
{


        public function index()
        {
         $income = Income::all()->orderBy('id','DESC')->paginate(10);
         return view('earning.add');
        }

         public function sendEmail(Request $request){

                Mail::to($request->email)->send(new sendmail($request->title,$request->content));
                return back();
         }

}
