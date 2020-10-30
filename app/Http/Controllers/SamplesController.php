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
        $samples = samples::orderBy('sample_id', 'asc')->where([['voided','!=',1],['sample_status','=','Delivered To Shipping Site']])->paginate(50);
        $all_samples = samples::select('sample_id','patient_id', 'specimen_id')->where([['voided','!=',1],['sample_status','=','Delivered To Shipping Site']])->get();
        return view('nl_samples',compact('samples'), ['all_samples'=>$all_samples]);
    }

    public function sample_results(){
        $samples = samples::orderBy('sample_id', 'asc')->where([['voided','!=',1],['sample_status','=','Result Added']])->paginate(50);
        $all_samples = samples::select('sample_id','patient_id', 'specimen_id')->where([['voided','!=',1],['sample_status','=','Result Added']])->get();
        $results = specimen_results::select('id', 'sample_id')->where('voided','!=',1)->get();

        return view('sample_results',compact('samples'), ['all_samples'=>$all_samples,'results'=>$results]);
    }

    public function print_manifest(Request $request){
        $manifest_id = $request->shipping_manifest_id;
        $samples = samples::orderBy('sample_id', 'asc')->where('shipping_manifest_id','=',$manifest_id)->get();
        $processing_site = shipping::select('processing_site_id')->where('shipping_manifest_id','=',$manifest_id)->first()->processing_site_id;

        return view('sample_print',compact('samples'))->with(['processing_site'=>$processing_site]);
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
        
        if(isset($request->age) && $request->age!=''){
            $age = $request->age;
        }elseif(isset($request->birthdate)){
            // $age = $request->birthdate->diffInYears(\Carbon::now());
            $age = 12;
        }else{
            $age = $request->age;
        }

        patients::create([
            'patient_id'=>$patient_id,
            'birthdate'=>$request->birthdate,
            'age'=>$age,
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
            'patient_id'=>$patient_id,
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
            'nrl_arrival_date'=>$request->nrl_arrival_date,
            'dna_extracted'=>$request->dna_extracted,
            'dna_extraction_date'=>$request->dna_extraction_date,
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

        $patient = patients::where('patient_id','=', $request->pid);
        $patient->update([
            'birthdate'=>$request->birthdate,
            'age'=>$request->age,
            'gender'=>$request->gender,
            'hosp_id'=>$request->hosp_id,
            'other_id'=>$request->other_id,           
        ]);

        $sample = samples::where('id','=', $request->id);
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
            'gridbox_number'=>$request->gridbox_number,
            'nrl_arrival_date'=>$request->nrl_arrival_date,
            'dna_extracted'=>$request->dna_extracted,
            'dna_extraction_date'=>$request->dna_extraction_date
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
        $users = User::select('id','name')->get();
        $sites = sites::select('id','site_name')->get();
        $sample = samples::where('id','=', $id)->first();

        if(isset($sample->id)){    
            $specimens = specimen_results::where('sample_id',$sample->specimen_id)->get();     
            session()->flash('message','Note: All samples related to this Shipment manifest ID will be updated with shipping information.');
            return view('sample')->with(['users'=>$users,'sample'=>$sample,'sites'=>$sites,'specimens'=>$specimens]);   
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
        $manifest_id = "NG/PLJ/CDC/IHVN/S".substr(md5(uniqid(mt_rand(), true).microtime(true)),0, 6); 
        return view('add_manifests',compact('samples'), ['all_samples'=>$all_samples,'manifest_id'=>$manifest_id]);
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

    public function workload(){
        return view('workload_indicators');
    }

    public function workload_indicators(Request $request){
        $this->validate($request, [
            'from' => 'required',
            'to' => 'required'
        ]);

            $from = date($request->from);
            $to = date($request->to);

            $get_samples = samples::whereBetween('sample_collection_date', [$from, $to])->get();
            
            $number_of_isolates = count($get_samples);            
            
            $liquid_isolates = $get_samples->where('isolate_type','Liquid')->count();
            $solid_isolates = $get_samples->where('isolate_type','Solid')->count();

            $young = $get_samples->where('age','<=',15)->count();
            $adult = $get_samples->where('age','>=',15)->count();

            $males = $get_samples->where('gender','M')->count();
            $females = $get_samples->where('gender','F')->count();
            
            $mdr = $get_samples->where('result_type','MDR')->count();
            $prexdr = $get_samples->where('result_type','preXDR')->count();
            $xdr = $get_samples->where('result_type','XDR')->count();

            $dnas = $get_samples->where('dna_extracted','on')->count();
            $dnashipped = $get_samples->where('date_specimen_shipped','!=','')->where('dna_extracted','on')->count();
            
            $results_generated = $get_samples->where('sample_status','Result Added')->count();

            
        return view('workload_indicators')->with([
            'from'=>$from,
            'to'=>$to,
            'number_of_isolates'=>$number_of_isolates,
            'liquid_isolates'=>$liquid_isolates,
            'solid_isolates'=>$solid_isolates,
            'young'=>$young,
            'adult'=>$adult,
            'males'=>$males,
            'females'=>$females,
            'mdr'=>$mdr,
            'prexdr'=>$prexdr,
            'xdr'=>$xdr,
            'dnas'=>$dnas,
            'dnashipped'=>$dnashipped,
            'results_generated'=>$results_generated
        ]);
    }

    
}
