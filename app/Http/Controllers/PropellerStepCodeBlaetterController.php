<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Auth;

use App\Models\PropellerModellBlatt;
use App\Models\PropellerStepCodeProfil;
use App\Models\PropellerStepCodeBlatt;

class PropellerStepCodeBlaetterController extends Controller
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
        $propellerStepCodeBlaetter = PropellerStepCodeBlatt::sortable()
            ->orderBy('name','asc')
            ->paginate(15);

        return view('propellerStepCodeBlaetter.index',
                compact(
                    'propellerStepCodeBlaetter'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $propellerModellBlaetter = PropellerModellBlatt::orderBy('name','asc')->get();
        $propellerProfile = PropellerStepCodeProfil::orderBy('name','asc')->get();


        //dd($propellerProfile);

        //dd($propellerModellBlaetter);
        return view('propellerStepCodeBlaetter.create', 
                compact(
                    'propellerModellBlaetter',
                    'propellerProfile'
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
            'propeller_modell_blatt_id' => 'required|unique:propeller_step_code_blaetter',
            'splineOrdnung_u' => 'required|numeric',
            'splineOrdnung_v' => 'required|numeric',
            'verdrehungwinkel_blattx' => 'required|numeric',
            'verdrehungwinkel_blatty' => 'required|numeric'
        ]);

        $inputBlatt[0][0] = $request->input("splineOrdnung_u");
        $inputBlatt[1][0] = $request->input("splineOrdnung_v");
        $inputBlatt[2][0] = $request->input("verdrehungwinkel_blattx");
        $inputBlatt[3][0] = $request->input("verdrehungwinkel_blatty");

        //schreiben des Datenbankeintrages für inputBlatt
        for($x=0;$x<=14;$x++){
            $i = $x + 1; 
            $inputBlatt[4][$x] = $request->input("radiusstation_x$i"); 
            $inputBlatt[5][$x] = $request->input("profiltiefe_l$i");
            $inputBlatt[6][$x] = $request->input("profildicke_s$i");
            $inputBlatt[7][$x] = $request->input("profilruecklage_$i");
            $inputBlatt[8][$x] = $request->input("profilvlage_$i");
            $inputBlatt[9][$x] = $request->input("dickeHK_$i");
            $inputBlatt[10][$x] = $request->input("steigung_$i");
            $inputBlatt[11][$x] = $request->input("verdrehwinkel_y_$i");
            $inputBlatt[12][$x] = $request->input("verdrehwinkel_z_$i");
            $inputBlatt[13][$x] = $request->input("referenzlinie_$i");
            $inputBlatt[14][$x] = $request->input("profil_$i");    
            $inputBlatt[15][$x] = $request->input("nc_offset_x_$i");  
            $inputBlatt[16][$x] = $request->input("nc_offset_y_$i");
            $inputBlatt[17][$x] = $request->input("twist-nc_$i");
            $inputBlatt[18][$x] = $request->input("z_offset_1_$i");
            $inputBlatt[19][$x] = $request->input("z_offset_2_$i");
        }

        $inputBlatt[20][0] = $request->input("begin_nc_x");  
        $inputBlatt[21][0] = $request->input("nc_thickness_trail");
        $inputBlatt[22][0] = $request->input("nc_thickness_bond");

            
        // for($x=0;$x<count($inputBlatt);$x++){
        //     $inputBlatt[$x] = array_filter($inputBlatt[$x], function($val) {
        //         return ($val!==null && $val!==false && $val!=='');
        //     });
        // }

        //dd($inputBlatt);

        $propeller_modell_blatt_id = $request->input('propeller_modell_blatt_id');
        $propellerModellBlatt = PropellerModellBlatt::find($propeller_modell_blatt_id);
        

        $propellerStepCodeBlatt = NEW PropellerStepCodeBlatt;
        $propellerStepCodeBlatt->name = $propellerModellBlatt->name;
        $propellerStepCodeBlatt->beschreibung = $request->input('beschreibung');
        $propellerStepCodeBlatt->propeller_modell_blatt_id = $propeller_modell_blatt_id;
        $propellerStepCodeBlatt->inputBlatt = json_encode($inputBlatt);
        $propellerStepCodeBlatt->user_id = auth()->user()->id;

        //dd($propellerStepCodeBlatt);
        $propellerStepCodeBlatt->save();

        return redirect("/propellerStepCodeBlaetter")->with('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $propellerStepCodeBlatt = PropellerStepCodeBlatt::find($id);
        $propellerProfile = PropellerStepCodeProfil::orderBy('name','asc')->get();
        $propellerModellBlaetter = PropellerModellBlatt::orderBy('name','asc')->get();

        $inputBlatt = json_decode($propellerStepCodeBlatt->inputBlatt);


        //dd($inputBlatt[14][0]);

        return view('propellerStepCodeBlaetter.show', 
                compact(
                        'propellerStepCodeBlatt',
                        'propellerProfile',
                        'propellerModellBlaetter',
                        'inputBlatt'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $propellerStepCodeBlatt = PropellerStepCodeBlatt::find($id);
        $propellerProfile = PropellerStepCodeProfil::orderBy('name','asc')->get();

        $inputBlatt = json_decode($propellerStepCodeBlatt->inputBlatt);


        //dd($inputBlatt[14][0]);

        return view('propellerStepCodeBlaetter.edit', 
                compact(
                        'propellerStepCodeBlatt',
                        'propellerProfile',
                        'inputBlatt'));
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
    
        //dd($request->input());

        $this->validate($request,[
            'splineOrdnung_u' => 'required|numeric',
            'splineOrdnung_v' => 'required|numeric',
            'verdrehungwinkel_blattx' => 'required|numeric',
            'verdrehungwinkel_blatty' => 'required|numeric',
            'beschreibung' => 'string|max:500|nullable'
        ]);

        $inputBlatt[0][0] = $request->input("splineOrdnung_u");
        $inputBlatt[1][0] = $request->input("splineOrdnung_v");
        $inputBlatt[2][0] = $request->input("verdrehungwinkel_blattx");
        $inputBlatt[3][0] = $request->input("verdrehungwinkel_blatty");

        //schreiben des Datenbankeintrages für inputBlatt
        for($x=0;$x<=14;$x++){
            $i = $x + 1; 
            $inputBlatt[4][$x] = $request->input("radiusstation_x$i"); 
            $inputBlatt[5][$x] = $request->input("profiltiefe_l$i");
            $inputBlatt[6][$x] = $request->input("profildicke_s$i");
            $inputBlatt[7][$x] = $request->input("profilruecklage_$i");
            $inputBlatt[8][$x] = $request->input("profilvlage_$i");
            $inputBlatt[9][$x] = $request->input("dickeHK_$i");
            $inputBlatt[10][$x] = $request->input("steigung_$i");
            $inputBlatt[11][$x] = $request->input("verdrehwinkel_y_$i");
            $inputBlatt[12][$x] = $request->input("verdrehwinkel_z_$i");
            $inputBlatt[13][$x] = $request->input("referenzlinie_$i");
            $inputBlatt[14][$x] = $request->input("profil_$i");
            $inputBlatt[15][$x] = $request->input("nc_offset_x_$i");  
            $inputBlatt[16][$x] = $request->input("nc_offset_y_$i");
            $inputBlatt[17][$x] = $request->input("twist-nc_$i");
            $inputBlatt[18][$x] = $request->input("z_offset_1_$i");
            $inputBlatt[19][$x] = $request->input("z_offset_2_$i");
        }

        //dd($inputBlatt);

        $inputBlatt[20][0] = $request->input("begin_nc_x");  
        $inputBlatt[21][0] = $request->input("nc_thickness_trail");
        $inputBlatt[22][0] = $request->input("nc_thickness_bond");

        // for($x=0;$x<count($inputBlatt);$x++){
        //     $inputBlatt[$x]  = array_filter($inputBlatt[$x], function($val) {
        //         return ($val!==null && $val!==false && $val!=='');
        //     });
        // }
        
        $propellerStepCodeBlatt = PropellerStepCodeBlatt::find($id);


        $propellerStepCodeBlatt->beschreibung = $request->input('beschreibung');
        $propellerStepCodeBlatt->inputBlatt = json_encode($inputBlatt);

        $propellerStepCodeBlatt->user_id = auth()->user()->id;

        //dd($propellerStepCodeBlatt);
        $propellerStepCodeBlatt->save();

        return redirect("/propellerStepCodeBlaetter")->with('success');


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
