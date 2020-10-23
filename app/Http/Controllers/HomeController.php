<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\inventory;
use App\audit;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        /*

        DB::table('usermetas')
                 ->select('browser', DB::raw('count(*) as total'))
                 ->groupBy('browser')
                 ->get();
        */

        if(auth()->user()->role=="SL"){
            return redirect('nl_samples');
        }else{
            $computercount = inventory ::select(DB::raw("count(*) as count"))
            ->where('category','Computers')        
            ->groupBy(DB::raw("facility_id"))
            ->orderBy("facility_id")
            ->get()->toArray();

            $computers = array_column($computercount, 'count');

            $furniturecount = inventory ::select(DB::raw("count(*) as count")) 
            ->where('category','Furnitures')        
            ->groupBy(DB::raw("facility_id"))
            ->orderBy("facility_id")
            ->get()->toArray();

            $furnitures = array_column($furniturecount, 'count');

            $audits = audit::orderBy('created_at', 'desc')->paginate(10);
        
            return view('dashboard')
            ->with('audits',$audits)
            ->with('computers',json_encode($computers,JSON_NUMERIC_CHECK))
            ->with('furnitures',json_encode($furnitures,JSON_NUMERIC_CHECK));
        }

    }

    public function user_dashboard()
    {
        if(auth()->user()->role=="SL"){
            return route('nl_samples');
        }else{

            return route('nl_samples');
        }
    }
}
