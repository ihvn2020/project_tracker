<?php

namespace App\Http\Controllers;

use App\shipping;
use App\samples;
use App\audit;
use App\sites;
use App\User;
use Auth;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shippings = shipping::where('voided','!=',1)->orderBy('shipping_date', 'asc')->paginate(50);
        $all_shippings = shipping::select('shipping_manifest_id','shipping_site_id', 'tracking_waybill_number')->where('voided','!=',1)->get();
        if(auth()->user()->role=="NL"){
            return view('nlshippings',compact('shippings'), ['all_shippings'=>$all_shippings]);

        }else{
        return view('shippings',compact('shippings'), ['all_shippings'=>$all_shippings]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $samples = samples::select('shipping_manifest_id')->get();
        $sites = sites::select('id','site_name')->get();

        $users = User::select('id','name')->get();

        return view('new_shipping')->with(['samples'=>$samples, 'users'=>$users,'sites'=>$sites]);

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
            'shipping_manifest_id' => 'required|min:3'            
        ]);

        $uuid = bin2hex(random_bytes(6));

        $shipping = shipping::where('shipping_manifest_id',$request->shipping_manifest_id);

        $relatedManifests = samples::where('shipping_manifest_id','=', $request->shipping_manifest_id);

        $shipping->update([
            'shipping_site_id'=>$request->shipping_site_id,
            'shipping_date'=>$request->shipping_date,
            'shipping_site_contact_person'=>$request->shipping_site_contact_person,
            'shipping_laboratory_phone'=>$request->shipping_laboratory_phone,
            'shipping_laboratory_email'=>$request->shipping_laboratory_email, 
            'shipping_officer_name'=>$request->shipping_officer_name,
            'shipping_officer_phone'=>$request->shipping_officer_phone,
            'number_of_cryovial_tubes'=>$request->number_of_cryovial_tubes,
            'tracking_waybill_number'=>$request->tracking_waybill_number,
            'processing_site_id'=>$request->processing_site_id,
            /*
            'receiving_lab_officer_name'=>$request->receiving_lab_officer_name,
            'receiving_lab_officer_phone'=>$request->receiving_lab_officer_phone,
            
            */
            'manifest_status'=>$request->manifest_status,
            'voided'=>0,
            'date_voided'=>"",
            'voided_by'=>"",
            'date_entered'=>date("Y-m-d"),
            'updated_by'=>Auth::user()->id,
            'date_updated'=>"",
            'uuid'=>$uuid
        ]);

          
        $relatedManifests->update([
            'date_specimen_shipped'=>$request->shipping_date,
            'sample_status'=>'Delivered To Shipping Site',
            /* 'date_specimen_arrived_sequence_lab'=>$request->date_specimen_arrived_sequence_lab,
            'receiving_lab_officer'=>$request->receiving_lab_officer_name,
            'receiving_lab_officer_phone'=>$request->receiving_lab_officer_phone,
            */
            // Bring down some values here         
            'updated_by'=>Auth::user()->id,
            'date_updated'=>date("Y-m-d")            
        ]);


        audit::create([
            'action'=>"Created New Shipping, Manifest ID: ".$request->shipping_manifest_id,
            'description'=>'A new Shipping Record was created',
            'doneby'=>Auth::user()->id          
        ]);
        session()->flash('message','The New Shipping Record with Manifest ID : '.$request->shipping_manifest_id.' has been added successfully!');
        
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function show(shipping $shipping)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $samples = samples::select('shipping_manifest_id')->get();
        $sites = sites::select('id','site_name')->get();

        $users = User::select('id','name')->get();
        $shipping = shipping::where('id',$id)->first();

        return view('shipping')->with(['samples'=>$samples, 'users'=>$users,'sites'=>$sites,'shipping'=>$shipping]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, shipping $shipping)
    {
         $shipping = shipping::where('id','=', $request->id);

        $relatedManifests = samples::where('shipping_manifest_id','=', $request->shipping_manifest_id);

        $shipping->update([
            'shipping_site_id'=>$request->shipping_site_id,
            'shipping_date'=>$request->shipping_date,
            'shipping_site_contact_person'=>$request->shipping_site_contact_person,
            'shipping_laboratory_phone'=>$request->shipping_laboratory_phone,
            'shipping_laboratory_email'=>$request->shipping_laboratory_email, 
            'shipping_officer_name'=>$request->shipping_officer_name,
            'shipping_officer_phone'=>$request->shipping_officer_phone,
            'number_of_cryovial_tubes'=>$request->number_of_cryovial_tubes,
            'tracking_waybill_number'=>$request->tracking_waybill_number,
            'processing_site_id'=>$request->processing_site_id,
            /*
            'receiving_lab_officer_name'=>$request->receiving_lab_officer_name,
            'receiving_lab_officer_phone'=>$request->receiving_lab_officer_phone,
            
            */
            'manifest_status'=>$request->manifest_status,
            'voided'=>0,
            'date_voided'=>"",
            'voided_by'=>"",
            'updated_by'=>Auth::user()->id,
            'date_updated'=>date("Y-m-d")
        ]);
        
        $relatedManifests->update([
            'date_specimen_shipped'=>$request->shipping_date,
            'sample_status'=>'Delivered To Shipping Site',
            /* 'date_specimen_arrived_sequence_lab'=>$request->date_specimen_arrived_sequence_lab,
            'receiving_lab_officer'=>$request->receiving_lab_officer_name,
            'receiving_lab_officer_phone'=>$request->receiving_lab_officer_phone,
            */
            // Bring down some values here         
            'updated_by'=>Auth::user()->id,
            'date_updated'=>date("Y-m-d")            
        ]);


        audit::create([
            'action'=>"Updated New Shipping, Manifest ID: ".$request->shipping_manifest_id,
            'description'=>'A Shipping Record was created',
            'doneby'=>Auth::user()->id          
        ]);
        session()->flash('message','The Shipping Record with Manifest ID : '.$request->shipping_manifest_id.' was updated successfully!');
        
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
         // shipping::findOrFail($id)->delete();
         shipping::findOrFail($id)->update([
            'voided'=>1,
            'date_voided'=>date("Y-m-d"),
            'voided_by'=>Auth::user()->id 
        ]);

        audit::create([
            'action'=>"Deleted Shipping Record with ID ".$request->id,
            'description'=>'A Shipping Record was deleted',
            'doneby'=>Auth::user()->id           
        ]);
 
        session()->flash('message','The the selected shipping record has been successfully deleted.');

        return redirect()->back();
    }

    public function changesmStatus(Request $request){
        $shipping = shipping::where('id','=', $request->id);

        $shipping->update([
            'manifest_status'=>$request->manifest_status,
            'updated_by'=>Auth::user()->id,
            'date_updated'=>date("Y-m-d")            
        ]);

        session()->flash('message','Manifest '.$request->id.' Status changed successfully');

        return redirect()->back();

    }

    public function reception($id)
    {
        $samples = samples::select('shipping_manifest_id')->get();
        $sites = sites::select('id','site_name')->get();

        $users = User::select('id','name')->get();
        $shipping = shipping::where('id',$id)->first();

        return view('manifest_reception')->with(['samples'=>$samples, 'users'=>$users,'sites'=>$sites,'shipping'=>$shipping]);

    }

    public function postreception(Request $request, shipping $shipping)
    {
         $shipping = shipping::where('id','=', $request->id);

        

        $shipping->update([
            'receiving_lab_officer_name'=>$request->receiving_lab_officer_name,
            'receiving_lab_officer_phone'=>$request->receiving_lab_officer_phone,
            'manifest_status'=>$request->manifest_status,
            'remarks'=>$request->remarks,
            'voided'=>0,
            'date_voided'=>"",
            'voided_by'=>"",
            'updated_by'=>Auth::user()->id,
            'date_updated'=>date("Y-m-d")
        ]);

        $relatedManifests = samples::where('shipping_manifest_id','=', $request->shipping_manifest_id);

        $relatedManifests->update([
            'sample_status'=>'Delivered To Sequence Lab',
            'date_specimen_arrived_sequence_lab'=>$request->arrival_date,
            'updated_by'=>Auth::user()->id,
            'date_updated'=>date("Y-m-d")            
        ]);


        audit::create([
            'action'=>"Updated Manifest Reception, Manifest ID: ".$request->shipping_manifest_id,
            'description'=>'A Manifest Was Recieved',
            'doneby'=>Auth::user()->id          
        ]);
        session()->flash('message','The Manifest / Shipping Record with Manifest ID : '.$request->shipping_manifest_id.' was updated successfully!');
        
        return redirect()->back();
    }
}
