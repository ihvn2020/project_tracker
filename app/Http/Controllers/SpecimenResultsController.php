<?php

namespace App\Http\Controllers;

use App\specimen_results;
use App\drug_resistance;
use App\samples;
use App\audit;
use App\sites;
use App\sresults;
use App\patients;
use App\User;
use Auth;
use PDF;
use Illuminate\Http\Request;

use App\Mail\Allmails;
use Illuminate\Support\Facades\Mail;



class SpecimenResultsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $specimens = specimen_results::orderBy('result_date', 'asc')->where('voided','!=',1)->paginate(50);
        $all_specimens = specimen_results::select('sample_id','processing_site_id')->where('voided','!=',1)->with('sresults')->get();
        return view('specimen_results',compact('specimens'), ['all_specimens'=>$all_specimens]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $samples = samples::select('sample_id','patient_id', 'specimen_id')->get();
        $sites = sites::select('id','site_name')->get();

        $users = User::select('id','name')->get();

        return view('add_specimenresult')->with(['samples'=>$samples, 'users'=>$users,'sites'=>$sites]);
   
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
            'sample_id' => 'required|min:3'
        ]);

        $uuid = bin2hex(random_bytes(6));

        if($request->hasFile('fasta'))
        {
            $files = $request->file('fasta');

            $fastafile = $files->getClientOriginalName();
           
        }else{
            $fastafile = "";
        }

        if($request->hasFile('abi'))
        {
            $files = $request->file('abi');

            $abifile = $files->getClientOriginalName();
           
        }else{
            $abifile = "";
        }


        $result_id = specimen_results::create([
            'sample_id'=>$request->sample_id,
            'specimen_result'=>$request->specimen_result,
            'result_date'=>date("Y-m-d", strtotime($request->result_date)),
            'processing_site_id'=>$request->processing_site_id,
            'result_signatures'=>$request->result_signatures, 
            'fasta_file_path'=>$fastafile,
            'fasta_file_text'=>$request->fasta_file_text,
            'abi_file_path'=>$abifile, 
            'voided'=>0,
            'voided_by'=>"",
            'date_entered'=>date("Y-m-d"),
            'updated_by'=>Auth::user()->id,
            'uuid'=>$uuid,
        ])->id;


        if($request->hasFile('fasta'))
        {
        $files = $request->file('fasta');

                $filename = $files->getClientOriginalName();
                
                $files->move('uploads/'.$result_id, $filename.".txt");
                
        
        }

        if($request->hasFile('abi'))
        {
        $files = $request->file('abi');

                $filename = $files->getClientOriginalName();
                
                $files->move('uploads/'.$result_id, $filename.".txt");
                

        
        }

        $i = 0;
        if(isset($request->property)){
            foreach ($request->property as $pp){
            // RECORD SPECS
            
                sresults::create([
                    'obs'=>$pp,
                    'value'=>$request->value[$i],
                    'result_id'=>$result_id                
                    ]);
                    $i++;
            }
        }

        audit::create([
            'action'=>"Created New Specimen Result Sample ID: ".$request->sample_id,
            'description'=>'A new Specimen Result was created',
            'doneby'=>Auth::user()->id          
        ]);
        session()->flash('message','The New Specimen Result: '.$request->sample_id.' has been added successfully!');
        
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\specimen_results  $specimen_results
     * @return \Illuminate\Http\Response
     */
    public function show(specimen_results $specimen_results)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\specimen_results  $specimen_results
     * @return \Illuminate\Http\Response
     */
    public function edit(specimen_results $specimen_results)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\specimen_results  $specimen_results
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, specimen_results $specimen_results)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\specimen_results  $specimen_results
     * @return \Illuminate\Http\Response
     */
    public function destroy(specimen_results $specimen_results)
    {
        //
    }

    public function add_results($id)
    {
        $samples = samples::select('sample_id','patient_id', 'specimen_id')->where('id',$id)->get();
        $sites = sites::select('id','site_name')->get();

        $users = User::select('id','name')->get();

        return view('add_specimenresult')->with(['samples'=>$samples, 'users'=>$users,'sites'=>$sites]);
   
    }

    public function specimen_result($id)
    {
        $res = specimen_results::where('id',$id)->first();
        $dresistance = drug_resistance::where('result_id',$id)->get();
        return view('specimen_result')->with(['res'=>$res, 'dresistance'=>$dresistance]);
    }

    public function download_pdfresult($id){
        $res = specimen_results::where('id',$id)->first();
        $dresistance = drug_resistance::where('result_id',$id)->get();
        $hide_controls = "yes";
        // Set extra option
        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        // pass view file
        $pdf = PDF::loadView('specimen_resultpdf',compact('res','dresistance','hide_controls'))->save('./uploads/results/'.$id.'-result.pdf');
        // download pdf
        return $pdf->stream($id.'-result.pdf');
    }

    public function sendresultTomail($id){
       

        $data = (object)[
            "subject"=>"Your Result",
            "file"=>$id.'-result.pdf'
        ]; 
        
        $res = specimen_results::where('id',$id)->first();
        $dresistance = drug_resistance::where('result_id',$id)->get();
        
        // Set extra option
        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        // pass view file
        $pdf = PDF::loadView('specimen_resultpdf',compact('res','dresistance'))->save('./uploads/results/'.$id.'-result.pdf');
        // download pdf
        
        $email = samples::select('patient_id')->with('patients')->where('sample_id',$res->sample_id)->first()->patients->email;
        
        Mail::to($email)->send(new Allmails($data));

        session()->flash('message','The result has been mailed to :'.$email);

        return redirect()->back();

    }

}
