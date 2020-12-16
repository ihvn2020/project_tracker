<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\tracker;
use App\audit;
use App\dailyreport;
use DB;
use Illuminate\Support\Facades\Schema;

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

        if(auth()->user()->role=="Admin"){
           
            $all_variables = tracker ::all();
            $audits = audit::orderBy('updated_at','desc')->paginate(10);

            return view('dashboard')->with(['all_variables'=>$all_variables,'audits'=>$audits]);

        }else if(auth()->user()->role=="State Manager"){

            return $this->state_dashboard();

        }else if(auth()->user()->role=="Facility Manager"){

            return $this->facility_dashboard();

        }

    }

    public function state_dashboard()
    {

        $columns = Schema::getColumnListing('trackers');
        $facilities = tracker::where('state',auth()->user()->state)->orderBy('lga', 'asc')->orderBy('health_facility','asc')->get();
        $freports = dailyreport::select('health_facility','indicator','value')->distinct()->orderBy('updated_at','desc')->where('value','!=','')->get();

        $lgas = tracker::select('lga')->where('state',auth()->user()->state)->distinct()->get();
        return view('user_dashboard',['facilities'=>$facilities,'columns'=>$columns,'lgas'=>$lgas,'state'=>auth()->user()->state,'freports'=>$freports]);

    }

    public function facility_dashboard()
    {

        $columns = Schema::getColumnListing('trackers');
        $facilities = tracker::where('health_facility',auth()->user()->health_facility)->orderBy('lga', 'asc')->orderBy('health_facility','asc')->get();
        $freports = dailyreport::select('health_facility','indicator','value')->where('health_facility',auth()->user()->health_facility)->orderBy('updated_at','desc')->distinct()->get();
        $lgas = tracker::select('lga')->where('health_facility',auth()->user()->health_facility)->distinct()->get();
        return view('user_dashboard',['facilities'=>$facilities,'columns'=>$columns,'lgas'=>$lgas,'state'=>auth()->user()->state,'freports'=>$freports]);

    }
}
