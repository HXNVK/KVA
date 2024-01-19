<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Auth;

use App\Models\PropellerStepCodeProfil;
use App\Models\PropellerModellKompatibilitaet;
use App\Models\PropellerModellWurzel;
use App\Models\PropellerStepCodeWurzelAV;

class PropellerStepCodeWurzelnAVController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $psc_WurzelnAV = PropellerStepCodeWurzelAV::sortable()
            ->orderBy('name','asc')
            ->paginate(15);

        return view('propellerStepCodeWurzelnAV.index',
                compact(
                    'psc_WurzelnAV'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $propellerModellWurzeln = PropellerModellWurzel::orderBy('name','asc')->get();
        $propellerModellKompatibilitaeten = PropellerModellKompatibilitaet::orderBy('name','asc')->get();


        //dd($propellerProfile);

        //dd($propellerModellBlaetter);
        return view('propellerStepCodeWurzelnAV.create', 
                compact(
                    'propellerModellWurzeln',
                    'propellerModellKompatibilitaeten'
                ));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'propeller_modell_wurzel_id' => 'required|unique:propeller_step_code_wurzeln_AV',
            'CAAV' => 'required',
            'RABAV' => 'required',
            'WTAV' => 'required',
            'ATAV' => 'required',
            'x_RPSAV' => 'required',
            'HTB' => 'required'


        ]);


        $inputWurzel_AV[0][0] = $request->input("CAAV");
        $inputWurzel_AV[1][0] = $request->input("RABAV");
        $inputWurzel_AV[2][0] = $request->input("WTAV");
        $inputWurzel_AV[3][0] = $request->input("ATAV");
        $inputWurzel_AV[4][0] = $request->input("x_RPSAV");
        $inputWurzel_AV[5][0] = $request->input("HTB");
        
        
        for($x=0;$x<15;$x++){
                $i = $x + 1; 
                $inputWurzel_AV[6][$x] = $request->input("Kreisebene$i"); 
                $inputWurzel_AV[7][$x] = $request->input("Kreis_x$i");
                $inputWurzel_AV[8][$x] = $request->input("Kreis_y$i");
                $inputWurzel_AV[9][$x] = $request->input("Kreis_z$i");  
                $inputWurzel_AV[10][$x] = $request->input("Kreis_D$i");        

        }
        for($x=0;$x<count($inputWurzel_AV);$x++){
            $inputWurzel_AV[$x] = array_filter($inputWurzel_AV[$x], function($val) {
                return ($val!==null && $val!==false && $val!=='');
            });
        }

        //dd($inputWurzel_AV);


        $propeller_modell_wurzel_id = $request->input('propeller_modell_wurzel_id');
        $propellerModellWurzel = PropellerModellWurzel::find($propeller_modell_wurzel_id);
        

        $psc_wurzelAV = NEW PropellerStepCodeWurzelAV;
        $psc_wurzelAV->name = $propellerModellWurzel->name;
        $psc_wurzelAV->beschreibung = $request->input('beschreibung');
        $psc_wurzelAV->propeller_modell_wurzel_id = $propeller_modell_wurzel_id;
        $psc_wurzelAV->inputWurzel_AV = json_encode($inputWurzel_AV);
        $psc_wurzelAV->user_id = auth()->user()->id;

        //dd($propellerStepCodeBlatt);
        $psc_wurzelAV->save();

        return redirect("/propellerStepCodeWurzelnAV")->with('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $propellerModellWurzeln = PropellerModellWurzel::orderBy('name','asc')->get();

        $psc_WurzelAV = PropellerStepCodeWurzelAV::find($id);
        $inputWurzelAV = json_decode($psc_WurzelAV->inputWurzel_AV);


        //dd($inputWurzelAV[6]);

        return view('propellerStepCodeWurzelnAV.show', 
                compact(
                        'propellerModellWurzeln',
                        'psc_WurzelAV',
                        'inputWurzelAV'
                    ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $psc_WurzelAV = PropellerStepCodeWurzelAV::find($id);
        $inputWurzelAV = json_decode($psc_WurzelAV->inputWurzel_AV);


        //dd($inputWurzelAV[6]);

        return view('propellerStepCodeWurzelnAV.edit', 
                compact(
                        'psc_WurzelAV',
                        'inputWurzelAV'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    
        $this->validate($request,[
            'CAAV' => 'required',
            'RABAV' => 'required',
            'WTAV' => 'required',
            'ATAV' => 'required',
            'x_RPSAV' => 'required',
            'HTB' => 'required'
        ]);


        $inputWurzel_AV[0][0] = $request->input("CAAV");
        $inputWurzel_AV[1][0] = $request->input("RABAV");
        $inputWurzel_AV[2][0] = $request->input("WTAV");
        $inputWurzel_AV[3][0] = $request->input("ATAV");
        $inputWurzel_AV[4][0] = $request->input("x_RPSAV");
        $inputWurzel_AV[5][0] = $request->input("HTB");
        
        
        for($x=0;$x<15;$x++){
                $i = $x + 1; 
                $inputWurzel_AV[6][$x] = $request->input("Kreisebene$i"); 
                $inputWurzel_AV[7][$x] = $request->input("Kreis_x$i");
                $inputWurzel_AV[8][$x] = $request->input("Kreis_y$i");
                $inputWurzel_AV[9][$x] = $request->input("Kreis_z$i");  
                $inputWurzel_AV[10][$x] = $request->input("Kreis_D$i");        

        }
        for($x=0;$x<count($inputWurzel_AV);$x++){
            $inputWurzel_AV[$x] = array_filter($inputWurzel_AV[$x], function($val) {
                return ($val!==null && $val!==false && $val!=='');
            });
        }

        //dd($inputWurzel_AV);


        $propeller_modell_wurzel_id = $request->input('propeller_modell_wurzel_id');
        $propellerModellWurzel = PropellerModellWurzel::find($propeller_modell_wurzel_id);
        

        $psc_wurzelAV = PropellerStepCodeWurzelAV::find($id);

        $psc_wurzelAV->beschreibung = $request->input('beschreibung');

        $psc_wurzelAV->inputWurzel_AV = json_encode($inputWurzel_AV);
        $psc_wurzelAV->user_id = auth()->user()->id;

        //dd($propellerStepCodeBlatt);
        $psc_wurzelAV->save();

        return redirect("/propellerStepCodeWurzelnAV")->with('success');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
