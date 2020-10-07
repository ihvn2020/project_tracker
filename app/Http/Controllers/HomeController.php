<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\inventory;
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

        return view('dashboard')
        ->with('computers',json_encode($computers,JSON_NUMERIC_CHECK))
        ->with('furnitures',json_encode($furnitures,JSON_NUMERIC_CHECK));

    }

    public function user_dashboard()
    {
        $inventories = inventory::where('user_id',auth()->user()->id)->orderBy('item_name', 'asc')->paginate(100);
        return view('user_dashboard', compact('inventories'));
    }
}
