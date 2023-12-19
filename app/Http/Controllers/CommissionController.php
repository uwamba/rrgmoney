<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Commission;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;


class CommissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:commission-list|commission-create|commission-edit|commission-delete', ['only' => ['index']]);
        $this->middleware('permission:commission-create', ['only' => ['create','store']]);
        $this->middleware('permission:commission-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:commission-delete', ['only' => ['destroy']]);

    }



    public function index()
    {
       $commission = Commission::orderBy('id','DESC')->paginate(10);
        return view('Commission.index', ['commission' => $commission]);
    }

    public function create()
    {
    return view('Commission.add');
    }

    public function store(Request $request)
    {
        // Validations
        $request->validate([
            'rate'    => 'required',
        ]);

        DB::beginTransaction();
        try {

        //store in database
            $user = Commission::create([
                'rate'    => $request->rate,
                'user_id'    => Auth::user()->id,
            ]);

            DB::commit();

            return redirect()->route('commission.index')->with(['success','Successfully Created.']);

        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

}
