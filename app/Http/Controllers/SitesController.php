<?php

namespace App\Http\Controllers;

use App\sites;
use App\audit;
use Auth;
use Illuminate\Http\Request;

class SitesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sites = sites::orderBy('site_name', 'asc')->paginate(50);
        return view('sites',compact('sites'));
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
        $this->validate($request, [
            'site_name' => 'required|min:2'
        ]);

        sites::create([
            'site_name'=>$request->site_name,
            'site_type'=>$request->site_type,
            'site_lga'=>$request->site_lga,
            'site_ward'=>$request->site_ward,
            'site_state'=>$request->site_state,
            'site_code'=>$request->site_code,
            'site_address'=>$request->site_address,
            'site_longitude'=>$request->longitude,
            'site_latitude'=>$request->latitude
        ]);

        audit::create([
            'action'=>"Created New Site ".$request->site_name,
            'description'=>'A new site was created',
            'doneby'=>Auth::user()->id           
        ]);
        session()->flash('message','The New Site: '.$request->site_name.' has been added successfully!');
        
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\sites  $sites
     * @return \Illuminate\Http\Response
     */
    public function show(sites $sites)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\sites  $sites
     * @return \Illuminate\Http\Response
     */
    public function edit(sites $sites)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\sites  $sites
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, sites $sites)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\sites  $sites
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        sites::findOrFail($id)->delete();

        audit::create([
            'action'=>"Deleted site ".$request->id,
            'description'=>'A site was deleted',
            'doneby'=>Auth::user()->id           
        ]);
 
        session()->flash('message','The the selected site has been successfully deleted.');

        return redirect()->back();
    }
}
