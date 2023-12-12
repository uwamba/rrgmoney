<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IncomeController extends Controller
{
 public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:earning-list|earning-create|earning-edit|earning-delete', ['only' => ['index']]);
        $this->middleware('permission:earning-create', ['only' => ['create','store']]);
        $this->middleware('permission:earning-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:earning-delete', ['only' => ['destroy']]);

    }

    public function index()
        {
            //captal

            ///history
              $income = Income::all()->orderBy('id','DESC')->paginate(10);


           // earning
            return view('earning.add);
        }
    //
}
