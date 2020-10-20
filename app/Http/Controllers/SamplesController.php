<?php

namespace App\Http\Controllers;

use App\samples;
use App\patients;
use App\audit;
use App\sites;
use App\shipping;
use App\specimen_results;
use App\User;
use Auth;
use Illuminate\Http\Request;

class SamplesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $samples = samples::orderBy('sample_id', 'asc')->where('voided','!=',1)->paginate(50);
        $all_samples = samples::select('sample_id','patient_id', 'specimen_id')->where('voided','!=',1)->get();
        return view('samples',compact('samples'), ['all_samples'=>$all_samples]);

    }

    public function nl_samples(){
        $samples = samples::orderBy('sample_id', 'asc')->where('voided','!=',1)->paginate(50);
        $all_samples = samples::select('sample_id','patient_id', 'specimen_id')->where('voided','!=',1)->where('sample_status','Delivered To Shipping Site')->where('sample_status','Delivered To Sequence Lab')->get();
        return view('nl_samples',compact('samples'), ['all_samples'=>$all_samples]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $patients = patients::select('patient_id','first_name', 'last_name', 'other_names')->get();
        $sites = sites::select('id','site_name')->get();

        $users = User::select('id','name')->get();

        return view('new_sample')->with(['patients'=>$patients, 'users'=>$users,'sites'=>$sites]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'specimen_id' => 'required|min:3'
        ]);
        

        $patient_id = "HOSPNo".substr(md5(uniqid(mt_rand(), true).microtime(true)),0, 8); 

        patients::create([
            'patient_id'=>$patient_id,
            'birthdate'=>$request->birthdate,
            'gender'=>$request->gender,
            'hosp_id'=>$request->hosp_id,
            'other_id'=>$request->other_id,           
        ]);


        $sample_id = "SNo".substr(md5(uniqid(mt_rand(), true).microtime(true)),0, 8); 
        $uuid = bin2hex(random_bytes(6));
        
        /*
        shipping::updateOrCreate(['shipping_manifest_id'=>$request->shipping_manifest_id],[
            'shipping_manifest_id'=>$request->shipping_manifest_id,
            'voided'=>0
        ]);
        */

        samples::create([
            'sample_id'=>$sample_id,
            'patient_id'=>$request->patient_id,
            // 'shipping_manifest_id'=>$request->shipping_manifest_id,
            'specimen_type'=>$request->specimen_type,
            'sample_collection_date'=>$request->sample_collection_date, 
            // 'laboratory_id'=>$request->laboratory_id,
            'specimen_id'=>$request->specimen_id,
            'collection_site_id'=>$request->collection_site_id, 
            'remark'=>$request->remark,
            'sample_status'=>'Collected at NRL',
            'collected_by'=>Auth::user()->id,
            // 'sample_signature'=>$request->sample_signature,
            'date_specimen_shipped'=>"",
            'date_specimen_arrived_sequence_lab'=>"",
            'receiving_lab_officer'=>"",
            'receiving_lab_officer_phone'=>"",
            'specimen_temperature_arrival'=>"",
            'receiving_lab_officer_remark'=>"",
            'quality_check'=>$request->quality_check,
            'gridbox_number'=>$request->gridbox_number,
            'voided'=>0,
            'date_voided'=>"",
            'voided_by'=>"",
            'date_entered'=>date("Y-m-d"),
            'updated_by'=>Auth::user()->id,
            'date_updated'=>"",
            'uuid'=>$uuid,
        ]);

        audit::create([
            'action'=>"Created New Sample ID: ".$sample_id." for Patient ID: ".$request->patient_id,
            'description'=>'A new Sample was created',
            'doneby'=>Auth::user()->id          
        ]);
        session()->flash('message','The New Sample: '.$request->sample_id.' has been added successfully!');
        
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\samples  $samples
     * @return \Illuminate\Http\Response
     */
    public function show(samples $samples)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\samples  $samples
     * @return \Illuminate\Http\Response
     */
    public function edit(samples $samples)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\samples  $samples
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, samples $samples)
    {
        $sample = samples::where('id','=', $request->id);

        $relatedManifests = samples::where('shipping_manifest_id','=', $request->shipping_manifest_id);

        $sample->update([
            'sample_id'=>$request->sample_id,
            'patient_id'=>$request->patient_id,
            'shipping_manifest_id'=>$request->shipping_manifest_id,
            'specimen_type'=>$request->specimen_type,
            'sample_collection_date'=>$request->sample_collection_date, 
            'laboratory_id'=>$request->laboratory_id,
            'specimen_id'=>$request->specimen_id,
            'collection_site_id'=>$request->collection_site_id, 
            'remark'=>$request->remark,
            'sample_status'=>$request->sample_status,
            'collected_by'=>$request->collected_by,
            'sample_signature'=>$request->sample_signature,     
            // The Below data can be entered individually as already done here or as a group in the related manifest
            'specimen_temperature_arrival'=>$request->specimen_temperature_arrival,
            'receiving_lab_officer_remark'=>$request->receiving_lab_officer_remark,
            'quality_check'=>$request->quality_check,
            'gridbox_number'=>$request->gridbox_number
        ]);
        
        $relatedManifests->update([
            'date_specimen_shipped'=>$request->date_specimen_shipped,
            'date_specimen_arrived_sequence_lab'=>$request->date_specimen_arrived_sequence_lab,
            'receiving_lab_officer'=>$request->receiving_lab_officer,
            'receiving_lab_officer_phone'=>$request->receiving_lab_officer_phone,
            // Bring down some values here         
            'updated_by'=>Auth::user()->id,
            'date_updated'=>date("Y-m-d")            
        ]);


        audit::create([
            'action'=>"Updated Sample ID ".$request->sample_id,
            'description'=>'A Sample Record was updated',
            'doneby'=>Auth::user()->id           
        ]);

        session()->flash('message','The Sample : '.$request->sample_id.' - Manifest ID: '.$request->shipping_manifest_id.' has been updated successfully!');
        
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\samples  $samples
     * @return \Illuminate\Http\Response
     */
    public function destroy(samples $samples)
    {
        // samples::findOrFail($id)->delete();
        samples::findOrFail($id)->update([
            'voided'=>1,
            'date_voided'=>date("Y-m-d"),
            'voided_by'=>Auth::user()->id 
        ]);

        audit::create([
            'action'=>"Deleted Sample ID ".$request->id,
            'description'=>'A Sample was deleted',
            'doneby'=>Auth::user()->id           
        ]);
 
        session()->flash('message','The the selected sample has been successfully deleted.');

        return redirect()->back();
    }

    public function addSample($id){
        $patients = patients::select('patient_id','first_name','last_name','other_names')->where('id',$id)->get();
        $users = User::select('id','name')->get();
        $sites = sites::select('id','site_name')->get();
        $sample = samples::where('id','=', $id)->first();

        if(isset($sample->id)){    
            $specimens = specimen_results::where('sample_id',$sample->specimen_id)->get();     
            session()->flash('message','Note: All samples related to this Shipment manifest ID will be updated with shipping information.');
            return view('sample')->with(['patients'=>$patients,'users'=>$users,'sample'=>$sample,'sites'=>$sites,'specimens'=>$specimens]);   
        }else{
            return redirect()->route('add_sample');
        }

    }

    public function changesStatus(Request $request){
        $sample = samples::where('id','=', $request->id);

        $sample->update([
            'sample_status'=>$request->sample_status,
            'updated_by'=>Auth::user()->id,
            'date_updated'=>date("Y-m-d")            
        ]);

        session()->flash('message','Sample '.$request->id.' Status changed successfully');

        return redirect()->back();

    }

    public function addManifests(){
        $samples = samples::orderBy('sample_id', 'asc')->where([['voided','!=',1],['shipping_manifest_id','=',NULL]])->paginate(50);
        $all_samples = samples::select('sample_id','patient_id', 'specimen_id')->where('voided','!=',1)->get();
        return view('add_manifests',compact('samples'), ['all_samples'=>$all_samples]);
    }

    public function postManifests(Request $request){

        $manifest_id = $request->manifest_id;

        $shippingid = shipping::updateOrCreate(['shipping_manifest_id'=>$manifest_id],[
            'shipping_manifest_id'=>$manifest_id,
            'number_of_cryovial_tubes'=>count($request->id),
            'voided'=>0
        ])->id;

        
        if(isset($request->id)){
            foreach ($request->id as $key => $id) {
                $sample = samples::where('id','=', $id);
                $sample->update([
                    'shipping_manifest_id'=>$manifest_id,
                    'sample_status'=>'Manifest Created'
                ]);

            }
        }
        

        audit::create([
            'action'=>"Created New Manifest ID: ".$manifest_id." for Samples ID: ".var_dump($request->sampleids),
            'description'=>'A new Manifest was created',
            'doneby'=>Auth::user()->id          
        ]);
        session()->flash('message','The New Manifest ID: '.$manifest_id.' has been added successfully!');
        
        return redirect()->route('shipping',$shippingid);

    }
}
