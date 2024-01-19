<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Auth;

use App\Models\PropellerStepCodeProfil;
use App\Models\PropellerModellKompatibilitaet;
use App\Models\PropellerModellWurzel;
use App\Models\PropellerStepCodeWurzelF;

class PropellerStepCodeWurzelnFController extends Controller
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
        $psc_WurzelnF = PropellerStepCodeWurzelF::sortable()
            ->orderBy('name','asc')
            ->paginate(15);

        return view('propellerStepCodeWurzelnF.index',
                compact(
                    'psc_WurzelnF'
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
        return view('propellerStepCodeWurzelnF.create', 
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
            'propeller_modell_wurzel_id' => 'required|unique:propeller_step_code_wurzeln_F'
        ]);


        $input_Wurzel_F[0] = $request->input("z_E1");                          //z-Höhe Flansch 1 (ungedreht)
        $input_Wurzel_F[1] = $request->input("z_E2");                            //z-Höhe Flansch 2 (ungedreht)
        $input_Wurzel_F[2] = $request->input("z_E3");                          //z-Höhe Flansch 3 (ungedreht)
        $input_Wurzel_F[3] = $request->input("R_F");                             //Flanschradius
        $input_Wurzel_F[4] =  $request->input("S_p");                          //Spaltmaß 
        $input_Wurzel_F[5] =   $request->input("p_w");                         //y-Verschiebung der Drehachse
        $AngleofIncidence = $request->input("AOE");                             //Einstellwinkel der Wurzel
        $input_Wurzel_F[6] =  $AngleofIncidence/180*pi();
        $Cone_Angle =  $request->input("CA");                                    //V-Winkel der Wurzel
        $input_Wurzel_F[7] =  -$Cone_Angle/180*pi();
        $RotationAngleBlock =   $request->input("RAB");                         //Verdrehwinkel in die Blockebene
        $input_Wurzel_F[8] =  $RotationAngleBlock/180*pi(); 
        $input_Wurzel_F[9] =   $request->input("WT");                           //Abstand erste Ebene der Flanschflächen
        $input_Wurzel_F[10] =  $request->input("AT");                           //Abstand Ebene Tangentenausrichtung zu x_RPS             
        $input_Wurzel_F[11] = $request->input("x_RPS");                         //x-Wert der Trennstelle
        //$x_Extension = [12];  // Verlängerung der geraden Blattfläche zu x_RPS
        $input_Wurzel_F[12] = $request->input('Komp');
        //$input_Wurzel_F[14] = ($AngleofIncidence + $RotationAngleBlock); //Verdrehwinkel gesamt
        $input_Wurzel_F[13] = $request->input("newKomp");
        $input_Wurzel_F[14] = $request->input("L_F");
        for ($i = 0; $i < 4; $i++){
            $a = $i +1;
            $input_Wurzel_F[15][$i] = $request->input("vy$a");
            $input_Wurzel_F[16][$i] = $request->input("vz$a");

        }




        $propeller_modell_wurzel_id = $request->input('propeller_modell_wurzel_id');
        $propellerModellWurzel = PropellerModellWurzel::find($propeller_modell_wurzel_id);
        

        $psc_wurzelF = NEW PropellerStepCodeWurzelF;
        $psc_wurzelF->name = $propellerModellWurzel->name;
        $psc_wurzelF->beschreibung = $request->input('beschreibung');
        $psc_wurzelF->propeller_modell_wurzel_id = $propeller_modell_wurzel_id;
        $psc_wurzelF->inputWurzel_F = json_encode($input_Wurzel_F);
        $psc_wurzelF->user_id = auth()->user()->id;

        //dd($propellerStepCodeBlatt);
        $psc_wurzelF->save();

        return redirect("/propellerStepCodeWurzelnF")->with('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $psc_WurzelF = PropellerStepCodeWurzelF::find($id);
        $propellerModellWurzeln = PropellerModellWurzel::orderBy('name','asc')->get();
        $propellerModellKompatibilitaeten = PropellerModellKompatibilitaet::orderBy('name','asc')->get();
        $inputWurzelF = json_decode($psc_WurzelF->inputWurzel_F);


        //dd($inputWurzelF[12]);

        return view('propellerStepCodeWurzelnF.show', 
                compact(
                        'psc_WurzelF',
                        'propellerModellWurzeln',
                        'propellerModellKompatibilitaeten',
                        'inputWurzelF'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $psc_WurzelF = PropellerStepCodeWurzelF::find($id);
        $propellerModellKompatibilitaeten = PropellerModellKompatibilitaet::orderBy('name','asc')->get();
        $inputWurzelF = json_decode($psc_WurzelF->inputWurzel_F);


        //dd($inputWurzelF[12]);

        return view('propellerStepCodeWurzelnF.edit', 
                compact(
                        'psc_WurzelF',
                        'propellerModellKompatibilitaeten',
                        'inputWurzelF'));
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
    
        // $this->validate($request,[
        //     'propeller_modell_wurzel_id' => 'required|unique:propeller_step_code_F_wurzeln'
        // ]);


        $input_Wurzel_F[0] = $request->input("z_E1");                          //z-Höhe Flansch 1 (ungedreht)
        $input_Wurzel_F[1] = $request->input("z_E2");                            //z-Höhe Flansch 2 (ungedreht)
        $input_Wurzel_F[2] = $request->input("z_E3");                          //z-Höhe Flansch 3 (ungedreht)
        $input_Wurzel_F[3] = $request->input("R_F");                             //Flanschradius
        $input_Wurzel_F[4] =  $request->input("S_p");                          //Spaltmaß 
        $input_Wurzel_F[5] =   $request->input("p_w");                         //y-Verschiebung der Drehachse
        $AngleofIncidence = $request->input("AOE");                             //Einstellwinkel der Wurzel
        $input_Wurzel_F[6] =  $AngleofIncidence/180*pi();
        $Cone_Angle =  $request->input("CA");                                    //V-Winkel der Wurzel
        $input_Wurzel_F[7] =  -$Cone_Angle/180*pi();
        $RotationAngleBlock =   $request->input("RAB");                         //Verdrehwinkel in die Blockebene
        $input_Wurzel_F[8] =  $RotationAngleBlock/180*pi(); 
        $input_Wurzel_F[9] =   $request->input("WT");                           //Abstand erste Ebene der Flanschflächen
        $input_Wurzel_F[10] =  $request->input("AT");                           //Abstand Ebene Tangentenausrichtung zu x_RPS             
        $input_Wurzel_F[11] = $request->input("x_RPS");                         //x-Wert der Trennstelle
        //$x_Extension = [12];  // Verlängerung der geraden Blattfläche zu x_RPS
        $input_Wurzel_F[12] = $request->input('Komp');
        //$input_Wurzel_F[14] = ($AngleofIncidence + $RotationAngleBlock); //Verdrehwinkel gesamt
        $input_Wurzel_F[13] = $request->input("newKomp");
        $input_Wurzel_F[14] = $request->input("L_F");
        for ($i = 0; $i < 4; $i++){
            $a = $i +1;
            $input_Wurzel_F[15][$i] = $request->input("vy$a");
            $input_Wurzel_F[16][$i] = $request->input("vz$a");

        }




        $propeller_modell_wurzel_id = $request->input('propeller_modell_wurzel_id');
        $propellerModellWurzel = PropellerModellWurzel::find($propeller_modell_wurzel_id);
        

        $psc_wurzelF = PropellerStepCodeWurzelF::find($id);

        $psc_wurzelF->beschreibung = $request->input('beschreibung');

        $psc_wurzelF->inputWurzel_F = json_encode($input_Wurzel_F);
        $psc_wurzelF->user_id = auth()->user()->id;

        //dd($propellerStepCodeBlatt);
        $psc_wurzelF->save();

        return redirect("/propellerStepCodeWurzelnF")->with('success');


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
