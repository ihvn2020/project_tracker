<?php

namespace App\Http\Controllers;

use App\tracker;
use App\facilities;
use App\audit;
use Auth;
use Illuminate\Http\Request;
use DB;

class FacilitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $facilities = facilities::orderBy('facility_name', 'asc')->paginate(50);
        $all_facilities = facilities::select('id','facility_name', 'town', 'lga', 'state')->get();
        return view('facilities',compact('facilities'), ['all_facilities'=>$all_facilities]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('new_facility');
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
            'facility_name' => 'required|min:3'
        ]);

        DB::insert('insert into trackers ( state,lga,health_facility,datim_id,contactperson,phoneno,lga_instance) values (?, ?,?,?,?,?,?)', [$request->state,$request->lga,$request->facility_name,$request->facility_no,$request->contactperson,$request->phoneno,$request->lga_instance]);

/*
        facilities::create([
            'facility_name'=>$request->facility_name,
            'facility_no'=>$request->facility_no,
            'state'=>$request->state,
            'lga'=>$request->lga,
            'town'=>$request->town,
            'address'=>$request->address,
            'phone_number'=>$request->phone_number,
            'contact_person'=>$request->contact_person
        ]);
*/
        audit::create([
            'action'=>"Created New Facility ".$request->facility_name,
            'description'=>'A new user facility was created',
            'doneby'=>"Admin" // Auth::user()->id           
        ]);
        session()->flash('message','The New Facility: '.$request->facility_name.' has been added successfully!');
        
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\facilities  $facilities
     * @return \Illuminate\Http\Response
     */
    public function show(facilities $facilities)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\facilities  $facilities
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $facility = facilities::where('id','=',$id)->first();      
      
        return view('facility', ['facility'=>$facility]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\facilities  $facilities
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, facilities $facilities)
    {
       
        $facility = facilities::where('id','=', $request->id);
        $facility->update([
            'facility_name'=>$request->facility_name,
            'facility_no'=>$request->facility_no,
            'state'=>$request->state,
            'lga'=>$request->lga,
            'town'=>$request->town,
            'address'=>$request->address,
            'phone_number'=>$request->phone_number,
            'contact_person'=>$request->contact_person         
            
        ]);

        audit::create([
            'action'=>"Updated Facility ".$request->facility_name,
            'description'=>'A facility was updated',
            'doneby'=>"Admin" // Auth::user()->id           
        ]);

        session()->flash('message','The Facility: '.$request->facility_name.' has been updated successfully!');
        
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\facilities  $facilities
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        facilities::findOrFail($id)->delete();

        audit::create([
            'action'=>"Deleted Facility ".$request->id,
            'description'=>'A facility was deleted',
            'doneby'=>"Admin" // Auth::user()->id           
        ]);
 
        session()->flash('message','The the selected facility has been successfully deleted.');

        return redirect()->back();
    }
}
