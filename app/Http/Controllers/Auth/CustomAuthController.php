<?php
namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Country;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rules\Password;
class CustomAuthController extends Controller
{
    public function index()
    {
        $countries = DB::table('countries')->get(); 
        //$countries = Country::get();
    
        return view('auth.register')->with(['countries'=>$countries]);
    }  
      
    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                        ->withSuccess('Signed in');
        }
        return redirect("login")->withSuccess('Login details are not valid');
    }

    public function registration()
    {
        return view('auth.registration');
    }
      
    public function validation(Request $request){
        $request->validate([
            'fname'    => 'required',
            'lname'     => 'required',
            'email'         => 'required|unique:users,email',
            'country'       => 'required',
            'phone' => 'required|numeric',
            'password' => 'required|string|min:8|confirmed',
        ]);
       $row= DB::table('countries')
           ->where('country_name', '=', $request->country)
           ->first();
           $code=$row->country_code;
           $phone=$code.$request->phone;
           $html = view('auth/verification')->with(['data'=>$request,'phone'=>$phone])->render();
           return $html;
        //return view('Firebase/firebasePhoneVerification')->with(['data'=>$request,'phone'=>$phone]);
    }
   
    public function create(Request $request)
    {
       // return response()->json(['success'=>'Got Simple Ajax Request.']);
     //dd('start');
        // Validations
       
      //verfiy phone

        DB::beginTransaction();
        try {

            // Store Data
            $user = User::create([
                'first_name'    => $request->fname,
                'last_name'     => $request->lname,
                'email'         => $request->email,
                'mobile_number' => $request->phone,
                'country'       => $request->country,
                'password'      => Hash::make($request->password),
                'address'       => $request->country,
                'role_id'       => '3',
                'status'        => '0',
            ]);

            


            //dd('start222');
            DB::table('model_has_roles')->where('model_id',$user->id)->delete();
            
            // Assign Role To User
            $user->assignRole($user->role_id);


            // Commit And Redirected To Listing
            DB::commit();
            return redirect("login")->withSuccess('Account Successfully created');

        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            //dd($th->getMessage());
            return redirect('register')->withInput()->with('error', $th->getMessage());
        }
    }  
    
    public function dashboard()
    {
        if(Auth::check()){
            return view('dashboard');
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }
    
    public function signOut() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }
}
