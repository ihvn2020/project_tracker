<?php

namespace App\Http\Controllers;

use App\drug_resistance;
use App\specimen_results;
use App\samples;
use App\audit;
use App\sites;
use App\sresults;
use App\User;
use Auth;
use Illuminate\Http\Request;

class DrugResistanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resistances = drug_resistance::orderBy('id', 'desc')->where('voided','!=',1)->paginate(50);
        $all_resistances = drug_resistance::select('result_id','drug_name')->where('voided','!=',1)->get();
        return view('resistances',compact('resistances'), ['all_resistances'=>$all_resistances]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $specimen_results = specimen_results::select('id','sample_id')->where('id',$id)->get();
        return view('add_drugresistance')->with(['specimen_results'=>$specimen_results]);
   
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
            'sample_id'=>$request->specimen_id,
            'specimen_result'=>$request->specimen_result,
            'result_date'=>date("Y-m-d", strtotime($request->result_date)),
            'processing_site_id'=>$request->processing_site_id,
           // 'result_signatures'=>$request->result_signatures, 
            'fasta_file_path'=>$fastafile,
            'fasta_file_text'=>$request->fasta_file_text,
            'abi_file_path'=>$abifile, 
            'voided'=>0,
            'voided_by'=>"",
            'date_entered'=>date("Y-m-d"),
            'updated_by'=>Auth::user()->id,
            'uuid'=>$uuid,
        ])->id;
        
        // Update Sample Info
        $sample = samples::where('id','=', $request->id);
        $sample->update([           
            'sample_status'=>'Result Added'           
        ]);

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
        // END RESULT

        
        
        foreach($request->drug_name as $key => $drug_name){
            $uuid = bin2hex(random_bytes(6));        
            drug_resistance::create([
                'result_id'=>$result_id,
                'drug_name'=>$drug_name,
                // 'result_date'=>date("Y-m-d", strtotime($request->result_date)),
                'gene_mutation'=>$request->gene_mutation[$key],
                'locus'=>$request->locus[$key], 
                'interpretation'=>$request->interpretation[$key],
                'comments'=>$request->comments[$key],
                'number_of_isolates'=>$request->number_of_isolates[$key],
                'accuracy_value_sensitivity'=>$request->accuracy_value_sensitivity[$key], 
                'accuracy_value_specificity'=>$request->accuracy_value_specificity[$key],
                'sample_id'=>$request->sample_id,
                'entered_by'=>Auth::user()->id,
                'date_entered'=>date("Y-m-d"),
                'uuid'=>$uuid,
            ]);
    
        }

        audit::create([
            'action'=>"Created New Drug Resistance for Result ID: ".$result_id,
            'description'=>'A new Drug Resistance was created',
            'doneby'=>Auth::user()->id          
        ]);
        session()->flash('message','The New Drug Resistance for Result ID: '.$result_id.' has been added successfully!');
        
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\drug_resistance  $drug_resistance
     * @return \Illuminate\Http\Response
     */
    public function show(drug_resistance $drug_resistance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\drug_resistance  $drug_resistance
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $drug_resistance = drug_resistance::where('id','=',$id)->first();  
        return view('drug_resistance', ['drug_resistance'=>$drug_resistance]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\drug_resistance  $drug_resistance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, drug_resistance $drug_resistance)
    {
        $drug_resistance = $drug_resistance::where('id','=', $request->id);
        $drug_resistance->update([
            'result_id'=>$request->result_id,
            'drug_name'=>$request->drug_name,
            'gene_mutation'=>$request->gene_mutation,
            'locus'=>$request->locus, 
            'interpretation'=>$request->interpretation,
            'comments'=>$request->comments,
            'number_of_isolates'=>$request->number_of_isolates,
            'accuracy_value_sensitivity'=>$request->accuracy_value_sensitivity, 
            'accuracy_value_specificity'=>$request->accuracy_value_specificity,
            'sample_id'=>$request->sample_id,
            'updated_by'=>Auth::user()->id,
            'date_updated'=>date("Y-m-d")            
        ]);

        audit::create([
            'action'=>"Updated Drug Resistance for Result ID ".$request->result_id,
            'description'=>'A Drug Resistance was updated',
            'doneby'=>Auth::user()->id           
        ]);

        session()->flash('message','The Drug Resistance for Result ID : '.$request->result_id.' has been updated successfully!');
        
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\drug_resistance  $drug_resistance
     * @return \Illuminate\Http\Response
     */
    public function destroy(drug_resistance $drug_resistance, $id)
    {
        drug_resistance::findOrFail($id)->delete();
       
        audit::create([
            'action'=>"Deleted Drug Resistance ID ".$request->id,
            'description'=>'A Drug resistance was deleted',
            'doneby'=>Auth::user()->id           
        ]);
 
        session()->flash('message','The the selected drug resistance has been successfully deleted.');

        return redirect()->back();
    }
}
