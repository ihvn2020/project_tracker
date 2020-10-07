<?php

namespace App\Http\Controllers;

use App\patients;
use App\samples;
use App\audit;
use App\sites;
use App\User;
use Auth;
use Illuminate\Http\Request;

class PatientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patients = patients::orderBy('first_name', 'asc')->paginate(50);
        $all_patients = patients::select('first_name','last_name', 'hosp_id')->get();
        return view('patients',compact('patients'), ['all_patients'=>$all_patients]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('new_patient');
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
            'first_name' => 'required|min:3'
        ]);

        $patient_id = "HOSPNo".substr(md5(uniqid(mt_rand(), true).microtime(true)),0, 8); 

        patients::create([
            'patient_id'=>$patient_id,
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'other_names'=>$request->other_names,
            'birthdate'=>$request->birthdate,
            'gender'=>$request->gender,
            'hosp_id'=>$request->hosp_id,
            'other_id'=>$request->other_id,
            'email'=>$request->email,
            'phone_no'=>$request->phone_no,
            'remarks'=>$request->remarks
        ]);

        audit::create([
            'action'=>"Created New Patiend ID: ".$patient_id,
            'description'=>'A new patient was created',
            'doneby'=>Auth::user()->id          
        ]);
        session()->flash('message','The New Patient: '.$request->first_name.' '.$request->last_name.' has been added successfully!');
        $patient_name = $request->first_name.' '.$request->last_name;
        $users = User::select('id','name')->get();
        $sites = sites::select('id','site_name')->get();

        return view('new_sample')->with(['patient_id'=>$patient_id,'patient_name'=>$patient_name,'users'=>$users,'sites'=>$sites]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\patients  $patients
     * @return \Illuminate\Http\Response
     */
    public function show(patients $patients)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\patients  $patients
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $patient = patients::where('id','=',$id)->first();  
        $patient_id = $patient->patient_id;    
        
        $samples = samples::where('patient_id','=',$patient_id)->get();      
      
        return view('patient', ['patient'=>$patient,'samples'=>$samples]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\patients  $patients
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, patients $patients)
    {
        $patient = patients::where('id','=', $request->id);
        $patient->update([
            'patient_id'=>$request->patient_id,
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'other_names'=>$request->other_names,
            'birthdate'=>$request->birthdate,
            'gender'=>$request->gender,
            'hosp_id'=>$request->hosp_id,
            'other_id'=>$request->other_id,
            'email'=>$request->email,
            'phone_no'=>$request->phone_no,
            'remarks'=>$request->remarks
        ]);

        audit::create([
            'action'=>"Updated Patient ID ".$request->patient_id,
            'description'=>'A patient was updated',
            'doneby'=>Auth::user()->id           
        ]);

        session()->flash('message','The Patient : '.$request->first_name.' '.$request->last_name.' has been updated successfully!');
        
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\patients  $patients
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        patients::findOrFail($id)->delete();
        /*        
         patients::findOrFail($id)->update([
             'voided'=>1,
             'date_voided'=>date("Y-m-d"),
             'voided_by'=>Auth::user()->id 
             ]);
             
        */
        audit::create([
            'action'=>"Deleted Patient ID ".$request->id,
            'description'=>'A Patient was deleted',
            'doneby'=>Auth::user()->id           
        ]);
 
        session()->flash('message','The the selected patient has been successfully deleted.');

        return redirect()->back();
    }
}
