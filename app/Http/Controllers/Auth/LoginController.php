<?php

namespace App\Http\Controllers\Auth;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App;

class LoginController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */

    public function __construct()
    {

        $this->username = $this->findUsername();
    }
    protected $username;

    public function findUsername()
    {
        $login = request()->input('login');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile_number';

        return $fieldType;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function userLogin(Request $request){
        $row= DB::table('users')
        ->where('email', '=', $request->login)
        ->orWhere('mobile_number', '=', $request->login)
        ->first();
        if(!$row){
         return redirect("login")->with('error','You have not allowed to use this system, please contact administrator');
        }

        $login = request()->input('login');

       $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile_number';
       request()->merge([$fieldType => $login]);
      if($fieldType=='email'){
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect("home");

          } else {
              return redirect("login")->with('error','You have entered invalid credentials');
          }


      }else{
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect("home");

          } else {
              return redirect("login")->with('error','You have entered invalid credentials');
          }

      }



    }

    public function username()
    {
        return $fieldType;
    }



    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        if(Auth::check()){
           //return view('home');
            $redirectTo = RouteServiceProvider::HOME;
        }

        return redirect("login")->withSuccess('Opps! You do not have access');
    }


    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout() {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }
}









