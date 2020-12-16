<?php

namespace App\Http\Controllers;

use App\dailyreport;
use App\tracker;
use App\audit;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\DB;
use Illuminate\Support\Facades\Schema;

class DailyreportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $freports = dailyreport::orderBy('state', 'asc')->get();
        $lgas = tracker::select('lga')->distinct()->get();
        return view('daily_reports',['freports'=>$freports,'lgas'=>$lgas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tracker = tracker::where('id',$request->id)->first();

        if($request->indicator=='total_bio_captured'){
            $tracker->update([
                'total_bio_captured'=>$request->value
            ]);
        }

        if($request->indicator=='total_valid_bio'){
            $tracker->update([
                'total_valid_bio'=>$request->value
            ]);
        }

        if($request->indicator=='tx_curr'){
            $tracker->update([
                'tx_curr'=>$request->value
            ]);
        }

        if($request->indicator=='limsemr_manifests_sent'){
            $tracker->update([
                'limsemr_manifests_sent'=>$request->value
            ]);
        }

        if($request->indicator=='total_patients'){
            $tracker->update([
                'total_patients'=>$request->value
            ]);
        }
        
        dailyreport::create([
            'state'=>$request->state,
            'lga'=>$request->lga,
            'health_facility'=>$request->health_facility,
            'from'=>$request->from,
            'to'=>$request->to,
            'indicator'=>$request->indicator,
            'value'=>$request->value,
            'initial_value'=>$request->initial_value,
            'entered_by'=>$request->entered_by,
            'user_id'=>$request->user_id,
            'remarks'=>$request->remarks,
        ]);

        audit::create([
            'action'=>Auth::user()->name." Updated ".ucwords(str_replace("_"," ",$request->indicator))." for ".$request->health_facility." ".$request->lga." ".$request->state.", From :".$request->initial_value." To:".$request->value,
            'description'=>'An Indicator record was updated',
            'doneby'=>Auth::user()->id           
        ]);

        session()->flash('message','The Indicaor: '.ucwords(str_replace("_"," ",$request->indicator)).' has been updated successfully!');
        
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\dailyreport  $dailyreport
     * @return \Illuminate\Http\Response
     */
    public function show(dailyreport $dailyreport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\dailyreport  $dailyreport
     * @return \Illuminate\Http\Response
     */
    public function edit(dailyreport $dailyreport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\dailyreport  $dailyreport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, dailyreport $dailyreport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\dailyreport  $dailyreport
     * @return \Illuminate\Http\Response
     */
    public function destroy(dailyreport $dailyreport)
    {
        //
    }

    public function indicators_reporting()
    {
        
        $columns = Schema::getColumnListing('trackers');
        $indicatorreports = dailyreport::orderBy('updated_at','desc')->get();
        $lgas = dailyreport::select('lga')->distinct()->get();
        $health_facilities = dailyreport::select('health_facility')->distinct()->get();
        return view('indicators_tracking',['indicatorreports'=>$indicatorreports,'columns'=>$columns,'lgas'=>$lgas,'health_facilities'=>$health_facilities]);
    }

    public function filtered_indicators(Request $request)
    {
        
        if($request->state=="All"){
            $soperator="!=";
            $state=$request->state;
        }else{
            $soperator="=";
            $state = $request->state;
        }

        if($request->lga=="All"){
            $loperator="!=";
            $lga=$request->lga;
        }else{
            $loperator="=";
            $lga = $request->lga;
        }

        if($request->health_facility=="All"){
            $hoperator="!=";
            $health_facility=$request->health_facility;
        }else{
            $hoperator="=";
            $health_facility = $request->health_facility;
        }
        
        /* $facilities = tracker::select($select)->where('state',$operator,$state)->where('lga',$operator,$lga)->where('health_facility',$operator,$health_facility)->get();
        
        $facilities = \DB::select("SELECT FROM dailyreports WHERE `state` $soperator '$state' AND `lga` $loperator '$lga' AND `health_facility` $hoperator '$health_facility'");
        
        $columns = $request->trackfilters;
        */
        $from = date($request->from);
        $to = date($request->to);

        $indicatorreports = dailyreport::whereBetween('from', [$from, $to])->whereBetween('to', [$from, $to])->where([
            ['state',$soperator,$state],
            ['lga',$loperator,$lga],
            ['health_facility',$hoperator,$health_facility]
        ])->get();
        

        return view('filtered_indicators', ['indicatorreports'=>$indicatorreports,"from"=>$request->from,"to"=>$request->to]);
    }

}
