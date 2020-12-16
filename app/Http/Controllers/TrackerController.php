<?php

namespace App\Http\Controllers;

use App\tracker;
use App\audit;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\DB;
use Illuminate\Support\Facades\Schema;

class TrackerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $columns = Schema::getColumnListing('trackers');
        $facilities = tracker::orderBy('state', 'asc')->get();
        $lgas = tracker::select('lga')->distinct()->get();
        return view('tracking',['facilities'=>$facilities,'columns'=>$columns,'lgas'=>$lgas]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\tracker  $tracker
     * @return \Illuminate\Http\Response
     */
    public function show(tracker $tracker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tracker  $tracker
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $facility = tracker::where('id','=',$id)->first();

        return view('new_tracking', ['facility'=>$facility]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tracker  $tracker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tracker $tracker)
    {
        $tracker = tracker::where('id','=', $request->id);
        $tracker->update([
            'state'=>$request->state,
            'lga'=>$request->lga,
            'total_patients'=>$request->total_patients,
            'pcr_lab_linked'=>$request->pcr_lab_linked,
            'datim_id'=>$request->datim_id,
            'tx_curr'=>$request->tx_curr,
            'central_database_upload'=>$request->central_database_upload,
            'bio_service_update'=>$request->bio_service_update,
            'cmm_module'=>$request->cmm_module,
            'cmm_reporting_ndr'=>$request->cmm_reporting_ndr,
            'bio_data_capture'=>$request->bio_data_capture,
            'enterprise_nmrs'=>$request->enterprise_nmrs,
            'total_bio_captured'=>$request->total_bio_captured,
            'total_valid_bio'=>$request->total_valid_bio,
            'lims_emr_module'=>$request->lims_emr_module,
            'limsemr_manifests_sent'=>$request->limsemr_manifests_sent, 
            'rsldeployed'=>$request->rsldeployed,
            'rsl_used'=>$request->rsl_used,
            'comments'=>$request->comments,
            'updated_by'=>Auth::user()->id,
            'date_updated'=>Date("Y-m-d H:m:s"),
            'facilityid'=>$request->facilityid,
            'remarks'=>$request->remarks,
        ]);

        audit::create([
            'action'=>"Updated Facility Record ".$request->health_facility,
            'description'=>'A facility record was updated',
            'doneby'=>Auth::user()->id           
        ]);

        session()->flash('message','The Facility: '.$request->health_facility.' has been updated successfully!');
        
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tracker  $tracker
     * @return \Illuminate\Http\Response
     */
    public function destroy(tracker $tracker)
    {
        //
    }

    public function broadsheet()
    {
        if(auth()->user()->role=="State Manager"){
            $facilities = tracker::where('state',auth()->user()->state)->orderBy('state', 'asc')->get();
        }else{
            $facilities = tracker::orderBy('state', 'asc')->get();
        }
        
        $columns = Schema::getColumnListing('trackers');

        

        return view('tracking_broad_sheet', ['facilities'=>$facilities,'columns'=>$columns]);
    }

    

    public function filtered_tracking(Request $request)
    {
        $select = "";
        $arraykeys = array_keys($request->trackfilters);
        $lastfilter = array_pop($arraykeys);
        
        foreach($request->trackfilters as $key => $column){
            if($key==$lastfilter){
                $select.=$column;
            }else{
                $select.=$column.",";
            } 
        }

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
        
        // $facilities = tracker::select($select)->where('state',$operator,$state)->where('lga',$operator,$lga)->where('health_facility',$operator,$health_facility)->get();
        
        $facilities = \DB::select("SELECT $select FROM trackers WHERE `state` $soperator '$state' AND `lga` $loperator '$lga' AND `health_facility` $hoperator '$health_facility'");
        
        $columns = $request->trackfilters;

        return view('filtered_tracking', ['facilities'=>$facilities,'columns'=>$columns]);
    }
}
