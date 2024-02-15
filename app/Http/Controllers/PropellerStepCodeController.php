<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\PropellerModellBlatt;
use App\Models\PropellerModellWurzel;
use App\Models\PropellerModellKompatibilitaet;
use App\Models\PropellerStepCode;
use App\Models\PropellerStepCodeProfil;
use App\Models\PropellerStepCodeBlatt;
use App\Models\PropellerStepCodeBlattBlock;
use App\Models\PropellerStepCodeWurzelF;
use App\Models\PropellerStepCodeWurzelAV;
use App\Models\PropellerStepCodeWurzelBlock;

use PDF;

class PropellerStepCodeController extends Controller
{

    public function __construct()       //wird ausgeführt, wenn die Klasse erzeugt wird
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
        $propellerStepCodes = PropellerStepCode::sortable()
                                ->orderBy('name','asc')
                                ->paginate(5);

        //dd($files);
        

        return view('propellerStepCode.index', compact('propellerStepCodes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $propellerModellBlaetter = PropellerModellBlatt::orderBy('name','asc')->get();
        $propellerModellWurzel = PropellerModellWurzel::orderBy('name','asc')->get();
        $propellerProfile = PropellerStepCodeProfil::orderBy('name','asc')->get();
        $propellerModellKompatibilitaeten = PropellerModellKompatibilitaet::orderBy('name','asc')->get();

        $psc_blaetter = PropellerStepCodeBlatt::orderBy('name','asc')->get();
        $psc_blattBloecke = PropellerStepCodeBlattBlock::orderBy('name','asc')->get();
        $psc_wurzeln_F = PropellerStepCodeWurzelF::orderBy('name','asc')->get();
        $psc_wurzeln_AV = PropellerStepCodeWurzelAV::orderBy('name','asc')->get();
        $psc_wurzelBloecke = PropellerStepCodeWurzelBlock::orderBy('name','asc')->get();

        //dd($propellerProfile);

        //dd($propellerModellBlaetter);
        return view('propellerStepCode.create', 
                compact(
                    'propellerModellBlaetter',  
                    'propellerModellWurzel',
                    'propellerProfile',
                    'propellerModellKompatibilitaeten',
                    'psc_blaetter',
                    'psc_blattBloecke',
                    'psc_wurzeln_F',
                    'psc_wurzeln_AV',
                    'psc_wurzelBloecke'
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

        //dd($request->input());

        $this->validate($request,[
            'name' => 'bail|required|min:2|max:50|string|unique:propeller_step_code',
            'formhaelfte' => 'required',
            'wurzeltyp' => 'required',
            'splineOrdnung_u' => 'numeric|nullable',
            'splineOrdnung_v' => 'numeric|nullable'
        ]);


        $psc_blatt = PropellerStepCodeBlatt::find($request->input("psc_blatt_id"));
        $psc_blattBlock = PropellerStepCodeBlattBlock::find($request->input("psc_blattBlock_id"));
        $psc_wurzel_F = PropellerStepCodeWurzelF::find($request->input("psc_wurzel_F_id"));
        $psc_wurzel_AV = PropellerStepCodeWurzelAV::find($request->input("psc_wurzel_AV_id"));
        $psc_wurzelBlock = PropellerStepCodeWurzelBlock::find($request->input("psc_wurzelBlock_id"));


        $inputBlatt = json_decode($psc_blatt->inputBlatt);
        for($x=0;$x<count($inputBlatt);$x++){
            $inputBlatt[$x]  = array_filter($inputBlatt[$x], function($val) {
                return ($val!==null && $val!==false && $val!=='');
            });
        }



        $propellerStepCode = NEW PropellerStepCode;
        $propellerStepCode->name = $request->input('name');
        $propellerStepCode->inputBlatt_name = $psc_blatt->name;
        $propellerStepCode->inputBlatt = $inputBlatt;



        $propellerStepCode->user_id = auth()->user()->id;
        $propellerStepCode->save();

        return redirect("/propellerStepCode")->with('success');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function Main_Step_Code(Request $request){              //Steuerung des Step Codes
        //**********************************INPUT*************************************************
            
            //dd($request->input());


            //..........................Allgemeine Angaben..........................................
                $Name = $request->input("name");
                $Side = $request->input("formhaelfte");              //oben oder unten
                $Turn_Direction = $request->input("drehrichtung");  //Drehrichtung bestimmen. Standard links, rechts wird gespiegelt
                $includeBlade = $request->input("include_blatt");     //Block ausgeben
                $includeRoot = $request->input("include_wurzel");       //Wurzel ausgeben
              
                $Roottyp = $request->input("wurzeltyp");            //Wurzeltypen Abfrage
                if ($Roottyp == "F" and $includeRoot == "ja"){
                    $includeRootF = "ja"; 
                } else {
                    $includeRootF = "nein"; 
                }
                if ($Roottyp == "V" and $includeRoot == "ja"){
                    $includeRootAV = "ja"; 
                } else {
                    $includeRootAV = "nein"; 
                }
                if ($Roottyp == "K" or $Roottyp == "S" and $includeRoot == "ja"){
                    $includeRootK = "ja"; 
                } else {
                    $includeRootK = "nein"; 
                }         
                $includeExtension = $request->input("include_verlaengerung"); // Verlängerung einbeziehen
                $includeblock =  $request->input("include_Block");  //Blatt einbeziehen
                $includeCam = $request->input("include_CAM");       //Cam Hilfen einbeziehen
                $include_NC =  $request->input("include_NC"); //NC Kante integrieren
                $includePropCalc = $request->input("include_javaprop"); //Javaprop input
                $includeFreeSurface = $request->input("include_freieF"); // freie Fläche
                $SwitchVKHK =  $request->input("VK_HK_switch"); //VK und HK tauschen (für Fremdentwürfe)
                $DFB = $request->input("DFB"); //Durchmesser Fräser Blockrand
                $includeFreeSpline = $request->input("include_freieFK");
                $showSplines = $request->input("show_Splines");

            //..........................Input Blatt..........................................
            

                $propellerStepCodeBlatt = PropellerStepCodeBlatt::find($request->input('psc_blatt_id'));
                $inputBlatt = json_decode($propellerStepCodeBlatt->inputBlatt);

                dd($inputBlatt);

                $inputBlatt[0][0] = $request->input("splineOrdnung_u");
                $inputBlatt[1][0] = $request->input("splineOrdnung_v");
                $inputBlatt[2][0] = $request->input("verdrehungwinkel_blattx");
                $inputBlatt[3][0] = $request->input("verdrehungwinkel_blatty");
                for($x=0;$x<15;$x++){
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

                    
                for($x=0;$x<count($inputBlatt);$x++){
                    $inputBlatt[$x]  = array_filter($inputBlatt[$x], function($val) {
                        return ($val!==null && $val!==false && $val!=='');
                    });
                }
               
               


            
            //..........................Input Blatt Block..........................................
                for($x=0;$x<15;$x++){
                    $i = $x + 1; 
                    $inputBlatt_Block[0][$x] = $request->input("zKW$i"); 
                }
                $inputBlatt_Block[1][0] = $request->input("bTR");
                $inputBlatt_Block[2][0] = $request->input("bB");
                $inputBlatt_Block[3][0] = $request->input("Blockx");
                $inputBlatt_Block[3][1] = $request->input("Blocky");
                $inputBlatt_Block[3][2] = $request->input("Blockz");
                $inputBlatt_Block[4][0] = $request->input("Blockx0"); 
                $inputBlatt_Block[4][1] = $request->input("Blocky0");
                $inputBlatt_Block[4][2] = $request->input("Blockz0");
                $inputBlatt_Block[5][0] = $request->input("Konusx");
                $inputBlatt_Block[5][1] = $request->input("Konusy");
                $inputBlatt_Block[5][2] = $request->input("Konusz");
                $inputBlatt_Block[6][0] = $request->input("DFB");
                $inputBlatt_Block[7][0] = $request->input("include_tip_tangent");
                if ($inputBlatt_Block[7][0] == "ja"){
                } else {
                    $inputBlatt_Block[7][0] ="nein";
                }
            
                for($x=0;$x<count($inputBlatt_Block);$x++){
                    $inputBlatt_Block[$x]  = array_filter($inputBlatt_Block[$x], function($val) {
                        return ($val!==null && $val!==false && $val!=='');
                    });
                }
              
        
            //..........................Input Wurzel F, K, S........................................
               
        
        
                $input_Wurzel_F[0] = $request->input("z_E1");                          //z-Höhe Flansch 1 (ungedreht)
                $input_Wurzel_F[1] = $request->input("z_E2");                            //z-Höhe Flansch 2 (ungedreht)
                $input_Wurzel_F[2] = $request->input("z_E3");                          //z-Höhe Flansch 3 (ungedreht)
                $input_Wurzel_F[3] = $request->input("R_F");                             //Flanschradius
                $input_Wurzel_F[4] =  $request->input("S_p");                          //Spaltmaß 
                $input_Wurzel_F[5] =   $request->input("p_w");                         //y-Verschiebung der Drehachse
                $AngleofIncidence = $request->input("AOE");              //Einstellwinkel der Wurzel
                $input_Wurzel_F[6] =  $AngleofIncidence/180*pi();
                $Cone_Angle =  $request->input("CA");                  //V-Winkel der Wurzel
                $input_Wurzel_F[7] =  -$Cone_Angle/180*pi();
                $RotationAngleBlock =   $request->input("RAB");          //Verdrehwinkel in die Blockebene
                $input_Wurzel_F[8] =  $RotationAngleBlock/180*pi(); 
                $input_Wurzel_F[9] =   $request->input("WT");          //Abstand erste Ebene der Flanschflächen
                $input_Wurzel_F[10] =  $request->input("AT");  //Abstand Ebene Tangentenausrichtung zu x_RPS             
                $input_Wurzel_F[11] = $request->input("x_RPS");        //x-Wert der Trennstelle
                //$x_Extension = [12];  // Verlängerung der geraden Blattfläche zu x_RPS
                $input_Wurzel_F[12] = $request->input('Kom');
                //$input_Wurzel_F[14] = ($AngleofIncidence + $RotationAngleBlock); //Verdrehwinkel gesamt
                $input_Wurzel_F[13] = $request->input("newKomp");
                $input_Wurzel_F[14] = $request->input("L_F");
                for ($i = 0; $i < 4; $i++){
                    $a = $i +1;
                    $input_Wurzel_F[15][$i] = $request->input("vy$a");
                    $input_Wurzel_F[16][$i] = $request->input("vz$a");

                }
                 
        
            //..........................Input Wurzel AV..........................................

                $inputWurzel_AV[0][0]=  $request->input("CAAV");
                $inputWurzel_AV[1][0]=  $request->input("RABAV");
                $inputWurzel_AV[2][0]=  $request->input("WTAV");
                $inputWurzel_AV[3][0]=  $request->input("ATAV");
                $inputWurzel_AV[4][0]=  $request->input("x_RPSAV");
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
                        $inputWurzel_AV[$x]  = array_filter($inputWurzel_AV[$x], function($val) {
                            return ($val!==null && $val!==false && $val!=='');
                        });
                    }
            
                
            //..........................Input Wurzel Block..........................................
                for($x=0;$x<5;$x++){
                    $i = $x + 1; 
                    $inputWurzel_Block[0][$x] = $request->input("zKWW1"); 
                }
                
               
                $inputWurzel_Block[1][0] = $request->input("bTRW");
                $inputWurzel_Block[2][0] = $request->input("bBW");
                $inputWurzel_Block[3][0] = $request->input("BlockWx");
                $inputWurzel_Block[3][1] = $request->input("BlockWy");
                $inputWurzel_Block[3][2] = $request->input("BlockWz");
                $inputWurzel_Block[4][0] = $request->input("BlockWx0"); 
                $inputWurzel_Block[4][1] = $request->input("BlockWy0");
                $inputWurzel_Block[4][2] = $request->input("BlockWz0");
                $inputWurzel_Block[5][0] = $request->input("KonusWx");
                $inputWurzel_Block[5][1] = $request->input("KonusWy");
                $inputWurzel_Block[5][2] = $request->input("KonusWz");
                $inputWurzel_Block[6][0] = $request->input("DFB");
       
       
            //..........................Input freie Fläche..........................................
                $input_free_Surface[0][0] = $request->input("splineOrdnung_uFF");
                $input_free_Surface[1][0] = $request->input("splineOrdnung_vFF");
                $input_free_Surface[2][0] = $request->input("verdrehungwinkel_xFF");
                $input_free_Surface[3][0] = $request->input("verdrehung_yFF");
                $input_free_Surface[4][0] = $request->input("verdrehungwinkel_yFF");
                $input_free_Surface[5][0] = $request->input("verdrehung_xFF");
                $input_free_Surface[6] = $request->input("freepoints");
                $input_free_Surface[6] = str_replace('[','',$input_free_Surface[6]);
                $input_free_Surface[6] = str_replace('"','',$input_free_Surface[6]);
                $input_free_Surface[6]= str_replace(']','',$input_free_Surface[6]);
                $input_free_Surface[6]= str_replace(' ',"\t",$input_free_Surface[6]);
                $tempvar = $input_free_Surface[6];
                
                $tempvar2 =  explode("\r\n", $tempvar); 
                $mplus1 = count($tempvar2)/2; //Anzahl der Ebenen
                
                for ($i_1 = 0; $i_1 < $mplus1*2; $i_1++ ){
                    $tempvar3 = $tempvar2[$i_1]; 
                    
                    $row = explode("\t", $tempvar3 );
                    
                    //$row = explode(" ", $row );
                    $tempvar4[$i_1] =  $row; 
                }
                $input_free_Surface[6] = $tempvar4;




            //..........................Input freie Linie..........................................
                $input_free_Spline[0][0] = $request->input("splineOrdnung_uFK");
                $input_free_Spline[1][0] = $request->input("verdrehungwinkel_xFK");
                $input_free_Spline[2][0] = $request->input("verdrehung_yFK");
                $input_free_Spline[3][0] = $request->input("verdrehungwinkel_yFK");
                $input_free_Spline[4][0] = $request->input("verdrehung_xFK");
                $input_free_Spline[5] = $request->input("freepointsfK");
              
                $input_free_Spline[5] = str_replace('[','',$input_free_Spline[5]);
                $input_free_Spline[5] = str_replace('"','',$input_free_Spline[5]);
                $input_free_Spline[5]= str_replace(']','',$input_free_Spline[5]);
                $input_free_Spline[5]= str_replace("\t",' ',$input_free_Spline[5]);
                $tempvar4 = $input_free_Spline[5];
                
                $tempvar5 =  explode("\r\n", $tempvar4); 
                $mplus1 = count($tempvar5)/2; //Anzahl der Ebenen

                for ($i_1 = 0; $i_1 < $mplus1*2; $i_1++ ){
                    $row = explode(" ", $tempvar5[$i_1] );
                    $tempvar6[$i_1] =  $row; 
                }
                $input_free_Spline[5] = $tempvar6;
           


            
        //************************Steuerung Funktionen*************************************
                global $EntityCounter;
                $EntityCounter = 30;


                $filename = $Name;
                if ($include_NC == "ja"){ //hinzufügen oben oder unten zum Dateinamen, wenn der Block mit ausgespuckt wird
                    $filename_with_Side = $filename."-_NC";
                }
                if ($includeblock == "ja"){             
                    $filename_with_Side = $filename."_".$Side;
                } else {
                    $filename_with_Side = $filename;  
                }
                if ($includeCam == "ja"){
                    $filename_with_Side = $filename."_".$Side."_Fraesdatei";
                }
                // Abfragen welche Modelle erstellt werden sollen
                
                if ($includeBlade == "ja"){
                    if ( $inputBlatt[0][0] > count($inputBlatt[4])){
                        print_r("Achtung! Spline Ordnung u zu hoch, Wert kleiner als Anzahl Ebenen angeben!");
                        exit;
                    }    
                    $Punkte_Blatt = $this->Geometry_Calculation_Blade($include_NC, $includeblock, $inputBlatt, $inputBlatt_Block, $Side, $Turn_Direction , $SwitchVKHK);
                    $Point_Array[0] = $Punkte_Blatt;
                } 
                if ($includeRootF == "ja"){
                    $Punkte_Wurzel_F = $this -> Geometry_Calculation_RootF($includeblock ,$input_Wurzel_F, $inputWurzel_Block, $Side, $Turn_Direction);
                    $Point_Array[1] = $Punkte_Wurzel_F;    
                } 
                if ($includeRootAV == "ja"){
                    $Punkte_Blatt = $this -> Geometry_Calculation_Blade($include_NC, $includeblock, $inputBlatt, $inputBlatt_Block, $Side, $Turn_Direction, $SwitchVKHK);
                    $Punkte_Wurzel_AV = $this -> Geometry_Calculation_RootAV($Punkte_Blatt, $includeblock , $inputWurzel_AV, $inputWurzel_Block, $Side, $Turn_Direction);
                    $Point_Array[2] = $Punkte_Wurzel_AV;    
                } 
                
                
                if ($includeExtension == "ja"){
                    $Punkte_Verlaengerung = $this -> Geometry_Calculation_Extension($inputBlatt, $inputBlatt_Block,  $Side, $Turn_Direction, $includeblock);
                    $Point_Array[3] = $Punkte_Verlaengerung;
                } 
                
                if ($includeFreeSurface == "ja"){
                    $Point_Array[4] = $this -> GeometryCalculationfreeSurface($input_free_Surface);
                } 
                
                if ($includeRootK == "ja") {
                    $Point_Array[5] = $this -> Geometry_Calculation_RootK($includeblock ,$input_Wurzel_F, $inputWurzel_Block, $Side, $Turn_Direction, $Roottyp);
                }
                if ($includeFreeSpline == "ja"){
                    $Point_Array[6] = $this -> GeometryCalculationfreeSpline($input_free_Spline);
                } 

                $list = array();
                
                foreach($Point_Array as $arr){
                    if(is_array($arr)){
                        $list = array_merge($list, $arr);
                    }
                }
                
                
                if ($includeCam == "ja"){
                    if ($includeBlade == "ja") {
                        $Points = $Point_Array[0];
                    } elseif  ($includeRootF == "ja") {
                        $Points = $Point_Array[1];
                    } elseif  ($includeRootAV == "ja") {
                        $Points = $Point_Array[2];
                    }                                     
                    $Point_Array_CAM = $this -> Geometry_Calculation_CAM($list, $Side, $includeBlade, $includeRoot, $Roottyp,  $Turn_Direction, $inputWurzel_Block, $inputBlatt_Block, $DFB, $includeExtension);
                    $Point_Array = $Point_Array_CAM[0];
                    $Punkte_CAM = $Point_Array_CAM[1];
                    $list = array_merge(  $Point_Array, $Punkte_CAM );
                    
                }
                
                $Step_Output =  $this-> StepPostProcessor($list, $filename_with_Side, $Side, $showSplines);
                if ($includeBlade == "ja" and $includePropCalc == "ja") {
                   $this -> WriteCalculationInput($list, $filename);
                }

                //print($Step_Output);
            
            /*
                print "Datei $filename wurde erstellt!! 
                Drehrichtung $Turn_Direction
                Erstellt wurden:
                Blatt: $includeBlade
                Wurzel F: $includeRootF
                Wurzel AV: $includeRootAV
                Block: $includeblock
                Cam Hilfen: $includeCam
                NC-Kante: $include_NC
                
                Java Prop Geometrie: $includePropCalc
                
                ";
            */
            
            //schreibe Java Prop Input Deck
    }
    function WriteCalculationInput($Point_Array, $filename){            //Geometrieberechnung und Output (Profiltiefe und Winkel lokal)
        //findet Punkte der Blatt VK
        $counter = 0;
        for ($i= 0 ; $i < count($Point_Array);$i++){                //durchsucht alle Flächen nach  Blattflaeche_Hauptflaeche_oben
            $Surface_Name[$i] =  $Point_Array[$i][3];
            if (substr_compare($Surface_Name[$i], "Blattflaeche_Hauptflaeche_oben", 0, 30) == 0){
                $k = $Point_Array[$i][1];
                $Num_of_Levels = count($Point_Array[$i][0]);
                for ($j= 0; $j <  $Num_of_Levels; $j++){                            //Ebenenschleife
                    $Num_of_Points = count($Point_Array[$i][0][$j]);        
            
                    $Polpoints_VK[$counter][0] = $Point_Array[$i][0][$j][0][1];   //Punkte der VK für VK Spline
                    $Polpoints_VK[$counter][1] = $Point_Array[$i][0][$j][0][2];
                    $Polpoints_VK[$counter][2] = $Point_Array[$i][0][$j][0][3];

                    $Polpoints_HK[$counter][0] = $Point_Array[$i][0][$j][$Num_of_Points-1][1]; //Punkte der HK für HK Spline
                    $Polpoints_HK[$counter][1] = $Point_Array[$i][0][$j][$Num_of_Points-1][2];
                    $Polpoints_HK[$counter][2] = $Point_Array[$i][0][$j][$Num_of_Points-1][3];
                    $counter++;
                // }
                }
            }
        }
        
        $Knot_Vector = $this -> Knot_Vector_Calculator($k, $Num_of_Levels);
        $Points_on_Spline_VK =  $this -> Spline_Calculator($Polpoints_VK, $Knot_Vector, $k, $Num_of_Levels);
        $Points_on_Spline_HK = $this -> Spline_Calculator($Polpoints_HK, $Knot_Vector, $k, $Num_of_Levels);


        //Geometriedaten für Javaprop
        for ($i = 0; $i < count($Points_on_Spline_VK); $i++){
            $r[$i] = $Points_on_Spline_VK[$i][0];  //lokaler Radius
            $c[$i] = sqrt(($Points_on_Spline_VK[$i][1] - $Points_on_Spline_HK[$i][1])**2+ ($Points_on_Spline_VK[$i][2]- $Points_on_Spline_HK[$i][2] )**2);
            $beta[$i] = atan(($Points_on_Spline_VK[$i][2]-$Points_on_Spline_HK[$i][2])/($Points_on_Spline_VK[$i][1]-$Points_on_Spline_HK[$i][1]))/pi()*180;
            $Out[$i+1][0] = $r[$i];
            $Out[$i+1][1] = $c[$i];
            if ($i == count($Points_on_Spline_VK)-1){    //Schutz für negative Werte an Blattspitze bei Props mit sehr kleiner Profiltiefe am Rand
                if ($beta[$i] < $beta[$i-1]-10){
                    $beta[$i] = $beta[$i-1];
                }   
            }
            $Out[$i+1][2] = $beta[$i];
        }

        
        $Out[0][0] = 0;
        $Out[0][1] = $Out[1][1];
        $Out[0][2] = $Out[1][2];
    
        sort($Out);
        //for ($i = 0; $i < $a; $i++){
        $Output ="";
        
        foreach ($Out as list($r_out, $c_out, $beta_out)) {
            $Output =  $Output." 
            $r_out $c_out $beta_out";
        }
        
        
    
        

        $OutputName = $filename."_Output_Geometrie.txt";

        //$Output = "$r_out $c_out $beta_out";
        Storage::disk('public')->put("$OutputName", " $Output");
        
               
    }

    // public function downloadFile($Output) {
    //     $file_path = public_path('files/'.$Output);
    //     return response()->download($file_path);
    // }

    function Knot_Vector_Calculator($k, $numberofcontrolpoints){
    
        $kplusnplus1 = $k + $numberofcontrolpoints;
        $h = 1 / ($kplusnplus1 - 2 * $k + 1);
        For ($i = 1; $i <= $kplusnplus1; $i++){
           If ($i <= $k){
                $KnotVector[$i] = 0;
           }
           If ($k < $i and $i <= $kplusnplus1 - $k){
                $KnotVector[$i] = $h;
                $h = $h + 1 / ($kplusnplus1 - 2 * $k + 1);
           }
           If ($kplusnplus1 - $k < $i){
                $KnotVector[$i] = 1;
           }
        }
        
        return($KnotVector);
        
    }
    function Spline_Calculator($Polpoints, $tKnot, $k, $nplus1){
        $NumPointsOnSpline = 27; //Anzahl der Punkte auf dem Spline
        $kplusnplus1 = $k+$nplus1;
        $t[0] = 0;
   
        //berechnen der Basisfunktionen
        for ($j = 1; $j <= $k; $j++){ 
             for ($i = 1; $i <= ($kplusnplus1- $j); $i++){
                       for ($h = 1; $h <= $NumPointsOnSpline; $h++){
                            if ($j == 1) {
                                 $t[$h] = $t[$h - 1] + 1 / $NumPointsOnSpline;
                                 if ($tKnot[$i] <= $t[$h] and $t[$h] < $tKnot[$i + 1]) {
                                      $N[$i][1][$h] = 1;
                                 }
                                 else {
                                      $N[$i][1] [$h] = 0;
                                 }  
                            }
                            else {
                                 $A = $t[$h] - $tKnot[$i];
                                 $B = $tKnot[$i + $j - 1] - $tKnot[$i];
                                 $C = $tKnot[$i + $j] - $t[$h];
                                 $D = $tKnot[$i + $j] - $tKnot[$i + 1];
                                 if ($B == 0) {$B = 1E-10;}
                                 if ($D == 0) {$D = 1E-10;}
                                 $N[$i] [$j] [$h] = $A / $B * $N[$i][ $j - 1][ $h] + $C / $D * $N[$i + 1][ $j - 1][ $h];
                            }
                       }
                  }
             }
        
        //setzen des 1. Stützpunktes
        $Px[0] = $Polpoints[0][0];
        $Py[0] = $Polpoints[0][1];
        $Pz[0] = $Polpoints[0][2];
   
        for ($h = 1; $h< $NumPointsOnSpline ; $h++){      
             $Px[$h]= 0;
             $Py[$h]= 0;
             $Pz[$h]= 0;
             }
        
        //berechnen der VK Punkte
        for ($i = 1; $i<= $nplus1; $i++)
        {    
             for ($h = 1; $h<= $NumPointsOnSpline - 1; $h++){       
                  $Px[$h] = $Px[$h] + $N[$i][$k][$h] * $Polpoints[$i-1][0];
                  $Py[$h] = $Py[$h] + $N[$i][$k][ $h] * $Polpoints[$i-1][1];
                  $Pz[$h] = $Pz[$h] + $N[$i][$k][ $h] * $Polpoints[$i-1][2];
             }    
        }
        //setzen des letzten Stützpunktes
        
   
        $Px[$NumPointsOnSpline-1] = $Polpoints[$nplus1-1][0];
        $Py[$NumPointsOnSpline-1] = $Polpoints[$nplus1-1][1];
        $Pz[$NumPointsOnSpline-1] = $Polpoints[$nplus1-1][2];
        
        for ($h = 0; $h< $NumPointsOnSpline ; $h++){
             $Points_on_Spline[$h][0] = $Px[$h];
             $Points_on_Spline[$h][1] = $Py[$h];
             $Points_on_Spline[$h][2] = $Pz[$h];
        }
       /*
        for ($h = 1; $h< $NumPointsOnSpline ; $h++){      
             $Px[$h]= 0;
             $Py[$h]= 0;
             $Pz[$h]= 0;
             }
        
      
   
         //berechnen der HK Punkte
        for ($i = 1; $i<= $nplus1; $i++)
        {    
             for ($h = 1; $h <= $NumPointsOnSpline - 1; $h++){       
                  $Px[$h] = $Px[$h] + $N[$i][$k][$h] * $Polpoints[$i-1][$nplus1-1][1];
                  $Py[$h] = $Py[$h] + $N[$i][$k][ $h] * $Polpoints[$i-1][$nplus1-1][2];
                  $Pz[$h] = $Pz[$h] + $N[$i][$k][ $h] * $Polpoints[$i-1][$nplus1-1][3];
             }    
        }
     
        //setzen des 1. und letzten Stützpunktes
         $Px[0] = $Polpoints[0][$nplus1-1][1];
         $Py[0] = $Polpoints[0][$nplus1-1][2];
         $Pz[0] = $Polpoints[0][$nplus1-1][3];
    
         $Px[$NumPointsOnSpline-1] = $Polpoints[$mplus1-1][$nplus1-1][1];
         $Py[$NumPointsOnSpline-1] = $Polpoints[$mplus1-1][$nplus1-1][2];
         $Pz[$NumPointsOnSpline-1] = $Polpoints[$mplus1-1][$nplus1-1][3];
   
         for ($h = 0; $h< $NumPointsOnSpline ; $h++){
             $HK_Spline[$h][0] = $Px[$h];
             $HK_Spline[$h][1] = $Py[$h];
             $HK_Spline[$h][2] = $Pz[$h];
        }
      */
       // $Umrisskurve[0] = $VK_Spline;
        //$Umrisskurve[1] = $HK_Spline;
        return ($Points_on_Spline);
    }    
    private function Geometry_Calculation_Blade($include_NC, $includeblock, $inputBlatt, $inputBlatt_Block, $Side, $Turn_Direction, $SwitchVKHK){        //Geometrieberechnung des Blattes
        //............................Scope........................................
            /*

            Autor:			Helix-Design

            Programmname:	Geometry_Calculation_Blade

            Modulname:		Geometry_Calculation_Blade.php

            Änderungsstand:	13.04.2021

            Namenskürzel:		PM	


            Beschreibung:				berechnet Geometriepunkte des Blattes und bei Auswahl des Blockes, Blockpunkte für CAM Anwendung. Berechnungsschritte sind im Design Rulebook beschrieben
                            

            Der Programmablauf kommt von:		Main.php


            Benötigte Werte:			siehe Design Rulebook

            Der Programmablauf wird übergeben an:	StepPostprocessor.php


            Übergebene Werte:			Alle Geometriepunkte

            -------------------------------------------------------------------------------------
            */


        //............................Input........................................

            $u_Blade = $inputBlatt[0][0];                          //Ordnung der Spline-Fläche x Richtung
            $v_Blade = $inputBlatt[1][0];                          //Ordnung der Spline-Fläche y Richtung  
            $RotationAngleBlock = $inputBlatt[2][0]/180*pi();             //Drehwinkel um x-Achse in Blockebene
            $RotationAngleBlocky = $inputBlatt[3][0]/180*pi();             //Drehwinkel um y-Achse in Blockebene      
            $r = $inputBlatt[4];             //lokaler Radius
            $l = $inputBlatt[5];             //Profiltiefe
            $d = $inputBlatt[6];             //Profildicke
            $p = $inputBlatt[7];             //Profilrücklage
            $q = $inputBlatt[8];             //Profil V-Lage
            $s =  $inputBlatt[9];             //Dicke der Hinterkante
            $t = $inputBlatt[10];             //lokale Steigung
            for ($i=0; $i < count($inputBlatt[11]); $i++){
                $yTwistAngle[$i] = $inputBlatt[11][$i]/180*pi() ; //Verdrehwinkel y-Achse in rad
                $zTwistAngle[$i] = $inputBlatt[12][$i]/180*pi(); //Verdrehwinkel z-Achse in rad
            };
            $RfP =  $inputBlatt[13]; 
            $Profilnum = $inputBlatt[14];
            $mplus1 = count($r);
           
            $x_RPS =  $r[0];
            //Input Block
            if ($includeblock == "ja") {
                $zKW = $inputBlatt_Block[0];                   //z-Verschiebung Tangentenrand
                $bTR = $inputBlatt_Block[1][0];              //Trennfläche_Tangentenrand Breite
                $bB = $inputBlatt_Block[2][0];               //Blockrand Breite
                $PB = $inputBlatt_Block[3];                    //Blockabmaße
                $P0B = $inputBlatt_Block[4];                   //Blocknullpunkt
                $PZK = $inputBlatt_Block[5];                   //Punkt Zentrierkonus
                $DFB = $inputBlatt_Block[6][0];             //Fräserdurchmesser Blockrand
                $include_Curved_Tangent_Tip = $inputBlatt_Block[7][0];    //Tangentenrand Spitze folgt Profilkontur Spitze
            }
            //NC-Daten laden

            if ($include_NC == "ja"){
               
            
                $NC_Offset_x = $inputBlatt[15]; 
                $NC_Offset_y = $inputBlatt[16];             //y-Offset der NC-Kante
                $NC_twist = $inputBlatt[17];            //Verdrehung der Schnittfläche gegenüber Profilsehne
                $NC_z_Offset_1 =  $inputBlatt[18];   //Offset Fläche 1 des jeweils 3. Stützpunktes (Maß für Wangenabstand)
                $NC_z_Offset_2 =  $inputBlatt[19];   //Offset Fläche 2 des jeweils 3. Stützpunktes (Maß für Wangenabstand)
                $begin_NC_x = $inputBlatt[20][0];     //Anfang der NC-Kante
                $NC_Thickness_Lead = $inputBlatt[21][0]; //Dicke der NC-Kante Spitze
                $NC_Bonding_Gap = $inputBlatt[22][0];     //Dicke Klebespalt (an der Spitze)
                          
                
            }
          
              

            


        //............................Blattflaeche_Hauptflaeche........................................ 
            for ($i=0; $i < $mplus1; $i++){                     //Ebenenschleife

                //if ($Profilnum[$i] == 1){                      //Abfrage des Profils in der Ebene
                    $a = $Profilnum[$i];
                    
                    $ProfilName = PropellerStepCodeProfil::where('name', '=', "$a")->pluck('inputProfil');
                //dd($ProfilName);
                $ProfilName = str_replace('[','',$ProfilName);
                $ProfilName = str_replace('"','',$ProfilName);
                $ProfilName = str_replace(']','',$ProfilName);
                $ProfilName = str_replace('\t','',$ProfilName);
                
                    $BasicProfilpoints2 =  explode('\r\n', $ProfilName); 
                    
                    $nplus1 = count($BasicProfilpoints2)/2; //Anzahl der Profilpunktestützpunkte
                    for ($i_1 = 0; $i_1 < $nplus1*2; $i_1++ ){
                        $row = explode(' ',$BasicProfilpoints2[$i_1] );
                        $BasicProfilpoints[$i_1] =  $row; 
                    }
           
                    // $Profilname = "Profil$a.txt";
                    //$BasicProfilpoints = $ProfilName;
                
                    //$i = 0;
                    //foreach ($ProfilName as $row){
                    //   $row1[$i] =  explode( ' ', $row );
                    //  $i++;
                // }
                                                                    
                    
                   // global $nplus1;
                // $nplus1 = count($BasicProfilpoints)/2; 
                    $AngleofIncidence[$i] = -atan ($t[$i]/(2*pi()*$r[$i]))+$RotationAngleBlock; // Berechnung des lokalen Einstellwinkels aus Steigung
                    //$nplus1 = 5;
                

                    for ($j=0; $j < $nplus1;$j ++){                                                                 //Schleife Profilpunkte
                        $a = $j+1;
                        $b = $i+1;
                        $BasicProfilpoints_oben[$j] = $BasicProfilpoints[$j];
                        $BasicProfilpoints_unten[$j] = $BasicProfilpoints[$j+$nplus1]; 
                        
                        $temp_BasicProfilpoints_oben[$j] = $BasicProfilpoints_oben[$j];
                        $temp_BasicProfilpoints_unten[$j] = $BasicProfilpoints_unten[$j];
                        $Punkte_Blattflaeche_Hauptflaeche_oben[$i][$j][0] = "Blattflaeche_Hauptflaeche_oben-E$b-P$a";    //Zuweisung der Punktnamen
                    }
                    
                    
                    for ($j=0; $j < $nplus1;$j ++){                                                                 //Schleife Profilpunkte
                        $a = $j+1;
                        $b = $i+1;
                        
                        if ($SwitchVKHK == "ja"){                
                            
                            $BasicProfilpoints_oben[$j] =  $temp_BasicProfilpoints_oben[$nplus1-1-$j];              //hinzufügen zu Hilfsarray um Drehmatrizen in Schleife zu durchlaufen
                            $BasicProfilpoints_unten[$j] =  $temp_BasicProfilpoints_unten[$nplus1-1-$j]; 
                        } 
                        
                        $BasicProfilpoints_oben[$j][0] = $BasicProfilpoints_oben[$j][0]-$RfP[$i];                                            // verschieben der Basispunkte auf Referenzlinie
                        $BasicProfilpoints_unten[$j][0] = $BasicProfilpoints_unten[$j][0]-$RfP[$i];
                
                            
                        $Punkte_Blattflaeche_Hauptflaeche_unten[$i][$j][0] = "Blattflaeche_Hauptflaeche_unten-E$b-P$a";
                        if (count($BasicProfilpoints[0]) == 3){                                                                     //Abfrage um auch x-Werte (z.B. von bestehenden Modellen einzulsen)
                            $Punkte_Blattflaeche_Hauptflaeche_oben[$i][$j][1] = $BasicProfilpoints_oben[$j][0];
                            $Punkte_Blattflaeche_Hauptflaeche_oben[$i][$j][2] = $BasicProfilpoints_oben[$j][1];
                            $Punkte_Blattflaeche_Hauptflaeche_oben[$i][$j][3] = $BasicProfilpoints_oben[$j][2];

                            $Punkte_Blattflaeche_Hauptflaeche_unten[$i][$j][1] = $BasicProfilpoints_unten[$j][0];
                            $Punkte_Blattflaeche_Hauptflaeche_unten[$i][$j][2] = $BasicProfilpoints_unten[$j][1];
                            $Punkte_Blattflaeche_Hauptflaeche_unten[$i][$j][3] = $BasicProfilpoints_unten[$j][2];

                        } else {
                            $Punkte_Blattflaeche_Hauptflaeche_oben[$i][$j][1] = $r[$i];                                                      //zuweisen des x-Wertes
                            $Punkte_Blattflaeche_Hauptflaeche_unten[$i][$j][1] = $r[$i];

                            $Punkte_Blattflaeche_Hauptflaeche_oben[$i][$j][2] = $BasicProfilpoints_oben[$j][0];
                            $Punkte_Blattflaeche_Hauptflaeche_oben[$i][$j][3] = $BasicProfilpoints_oben[$j][1];

                            $Punkte_Blattflaeche_Hauptflaeche_unten[$i][$j][2] = $BasicProfilpoints_unten[$j][0];
                            $Punkte_Blattflaeche_Hauptflaeche_unten[$i][$j][3] = $BasicProfilpoints_unten[$j][1];
                        }

                    
                       
                        $Punkte_Blattflaeche_Hauptflaeche_oben[$i][$j][2] = $Punkte_Blattflaeche_Hauptflaeche_oben[$i][$j][2]*$l[$i];                            //skalieren der y-Werte mit Profiltiefe
                        $Punkte_Blattflaeche_Hauptflaeche_unten[$i][$j][2] = $Punkte_Blattflaeche_Hauptflaeche_unten[$i][$j][2]*$l[$i];
                        $Punkte_Blattflaeche_Hauptflaeche_oben[$i][$j][3] = $Punkte_Blattflaeche_Hauptflaeche_oben[$i][$j][3] *$l[$i]*$d[$i];                            //skalieren der z-Werte mit Profiltiefe
                        
                    
                        $Punkte_Blattflaeche_Hauptflaeche_unten[$i][$j][3] = $Punkte_Blattflaeche_Hauptflaeche_unten[$i][$j][3]*$l[$i]*$d[$i];
                        if ($j == $nplus1-1){ 
                        $Punkte_Blattflaeche_Hauptflaeche_oben[$i][$j][3] = $Punkte_Blattflaeche_Hauptflaeche_oben[$i][$j][3]+$s[$i]/2; //versetzen des letzten Punktes der Blattfläche  
                        $Punkte_Blattflaeche_Hauptflaeche_unten[$i][$j][3] = $Punkte_Blattflaeche_Hauptflaeche_unten[$i][$j][3]-$s[$i]/2; //versetzen des letzten Punktes der Blattfläche                                                                                 
                        }
                        $Punkte_Blattflaeche_Hauptflaeche_oben[$i][$j][2] = $Punkte_Blattflaeche_Hauptflaeche_oben[$i][$j][2] + $p[$i];  // Verschiebung entlang der y-Achse
                        $Punkte_Blattflaeche_Hauptflaeche_unten[$i][$j][2] = $Punkte_Blattflaeche_Hauptflaeche_unten[$i][$j][2] + $p[$i];
                        $Punkte_Blattflaeche_Hauptflaeche_oben[$i][$j][3] = $Punkte_Blattflaeche_Hauptflaeche_oben[$i][$j][3] +$q[$i];  // Verschiebung entlang der z-Achse
                        $Punkte_Blattflaeche_Hauptflaeche_unten[$i][$j][3] = $Punkte_Blattflaeche_Hauptflaeche_unten[$i][$j][3] +$q[$i];

                        $Punkte_Drehung[0][$i][$j] =   $Punkte_Blattflaeche_Hauptflaeche_oben[$i][$j];              //hinzufügen zu Hilfsarray um Drehmatrizen in Schleife zu durchlaufen
                        $Punkte_Drehung[1][$i][$j] =   $Punkte_Blattflaeche_Hauptflaeche_unten[$i][$j];
                    }                                   //Ende Punktschleife
                                                        //Ende Ebenenschleife
                }      
                
                
                
            
        //............................NC-Kante........................................ 
            if ($include_NC == "ja"){                           //hinzufügen von Flächen für NC-Kanten Integration                                        
                            
                for ($k = 0; $k < count($Punkte_Blattflaeche_Hauptflaeche_oben); $k++){
                    $Punkte_Schnittflaeche_NC_1[$k][1] =  $Punkte_Blattflaeche_Hauptflaeche_oben[$k][0];  //übernehmen der Punkte der VK
                    $Punkte_Schnittflaeche_NC_1[$k][1][1] = $Punkte_Schnittflaeche_NC_1[$k][1][1]+$NC_Offset_x[$k];       //Verschieben der Stützpunkte um Eingabewerte
                    $Punkte_Schnittflaeche_NC_1[$k][1][2] = $Punkte_Schnittflaeche_NC_1[$k][1][2]-$NC_Offset_y[$k];
                    $Punkte_Schnittflaeche_NC_1[$k][0] = $Punkte_Schnittflaeche_NC_1[$k][1];
                    $Punkte_Schnittflaeche_NC_1[$k][0][3] = $Punkte_Schnittflaeche_NC_1[$k][1][3]-30;
                    $Punkte_Schnittflaeche_NC_1[$k][2] = $Punkte_Schnittflaeche_NC_1[$k][1];
                    $Punkte_Schnittflaeche_NC_1[$k][2][3] = $Punkte_Schnittflaeche_NC_1[$k][1][3]+30;
                    $Turn_NC_Points =  $Punkte_Schnittflaeche_NC_1; //Hilfsvariable zum Drehen der Schnittfläche
                    $tempcount = count($Punkte_Blattflaeche_Hauptflaeche_oben[$k]);
                    for ($i = 0; $i < $tempcount ; $i++){
                        $Punkte_Blattflaeche_Hauptflaeche_oben_Offset1[$k][$i] =  $Punkte_Blattflaeche_Hauptflaeche_oben[$k][$i];  
                        $Punkte_Blattflaeche_Hauptflaeche_unten_Offset1[$k][$i] =  $Punkte_Blattflaeche_Hauptflaeche_unten[$k][$i];  
                        //if ($i < count($Punkte_Blattflaeche_Hauptflaeche_oben[$k])-1){          //versetzen der Blattfläche_Offset_1 (alle bis auf HK Punkte)
                            $Punkte_Blattflaeche_Hauptflaeche_oben_Offset1[$k][$i][2] = $Punkte_Blattflaeche_Hauptflaeche_oben_Offset1[$k][$i][2] + $NC_Thickness_Lead ;
                            $Punkte_Blattflaeche_Hauptflaeche_unten_Offset1[$k][$i][2] = $Punkte_Blattflaeche_Hauptflaeche_unten_Offset1[$k][$i][2] + $NC_Thickness_Lead ;
                        //  }
                        if ($i < $tempcount-1){
                            $Punkte_Blattflaeche_Hauptflaeche_oben_Offset1[$k][$i][3] =     $Punkte_Blattflaeche_Hauptflaeche_oben_Offset1[$k][$i][3]-$NC_z_Offset_1[$k];           //versetzen des z-Wertes des 3. Stützpunktes
                            $Punkte_Blattflaeche_Hauptflaeche_unten_Offset1[$k][$i][3] =     $Punkte_Blattflaeche_Hauptflaeche_unten_Offset1[$k][$i][3]+$NC_z_Offset_1[$k];
                        }
                        $Punkte_Blattflaeche_Hauptflaeche_oben_Offset2[$k][$i] =  $Punkte_Blattflaeche_Hauptflaeche_oben[$k][$i];
                        $Punkte_Blattflaeche_Hauptflaeche_unten_Offset2[$k][$i] =  $Punkte_Blattflaeche_Hauptflaeche_unten[$k][$i];
                        //if ($i < count($Punkte_Blattflaeche_Hauptflaeche_oben[$k])-1){ 
                                                //versetzen der Blattfläche_Offset_2 (alle bis auf HK Punkte) 
                            $Punkte_Blattflaeche_Hauptflaeche_oben_Offset2[$k][$i][2] = $Punkte_Blattflaeche_Hauptflaeche_oben_Offset2[$k][$i][2] + $NC_Thickness_Lead + $NC_Bonding_Gap;                
                            $Punkte_Blattflaeche_Hauptflaeche_unten_Offset2[$k][$i][2] = $Punkte_Blattflaeche_Hauptflaeche_unten_Offset2[$k][$i][2] + $NC_Thickness_Lead + $NC_Bonding_Gap;
                        //}
                        if ($i == 2){
                            $Punkte_Blattflaeche_Hauptflaeche_oben_Offset2[$k][$i][3] = $Punkte_Blattflaeche_Hauptflaeche_oben_Offset2[$k][$i][3]-$NC_z_Offset_2[$k]-$NC_z_Offset_1[$k];           //versetzen des z-Wertes des 3. Stützpunktes
                            $Punkte_Blattflaeche_Hauptflaeche_unten_Offset2[$k][$i][3] =     $Punkte_Blattflaeche_Hauptflaeche_unten_Offset2[$k][$i][3]+$NC_z_Offset_1[$k]+$NC_z_Offset_1[$k];
                        }

                    }
                                    
                    for ($o=0; $o < 3; $o++){               //drehen der Fläche. Fläche wird um die Achse der versetzen VK gedreht, nicht um y=0                                   
                        $Punkte_Schnittflaeche_NC_1[$k][$o][2] =  ($Turn_NC_Points[$k][$o][2]-$Punkte_Schnittflaeche_NC_1[$k][1][2])*cos($NC_twist[$k]/180*pi()) - ($Turn_NC_Points[$k][$o][3]-$Punkte_Schnittflaeche_NC_1[$k][1][3])*sin($NC_twist[$k]/180*pi()) + $Turn_NC_Points[$k][$o][2];
                        $Punkte_Schnittflaeche_NC_1[$k][$o][3] = ($Turn_NC_Points[$k][$o][2]-$Punkte_Schnittflaeche_NC_1[$k][1][2])*sin($NC_twist[$k]/180*pi()) + ($Turn_NC_Points[$k][$o][3]-$Punkte_Schnittflaeche_NC_1[$k][1][3])*cos($NC_twist[$k]/180*pi()) + $Punkte_Schnittflaeche_NC_1[$k][1][3];
                    }
                                            
                }
                                
                $Punkte_Schnittflaeche_NC_2[0][0] = $Punkte_Blattflaeche_Hauptflaeche_oben[1][0];  //Schnittfläche 2, gerade Fläeche, setzen der Stützpunkte
                $Punkte_Schnittflaeche_NC_2[0][0][1] = $begin_NC_x;
                $Punkte_Schnittflaeche_NC_2[0][0][3] = $Punkte_Schnittflaeche_NC_2[0][0][3]-40;
                $Punkte_Schnittflaeche_NC_2[0][1] = $Punkte_Schnittflaeche_NC_2[0][0];
                $Punkte_Schnittflaeche_NC_2[0][1][3] =  $Punkte_Schnittflaeche_NC_2[0][1][3]+80;

                $Punkte_Schnittflaeche_NC_2[1][0] = $Punkte_Schnittflaeche_NC_2[0][0];
                $Punkte_Schnittflaeche_NC_2[1][0][2] = $Punkte_Schnittflaeche_NC_2[0][0][2]+100;

                $Punkte_Schnittflaeche_NC_2[1][1] = $Punkte_Schnittflaeche_NC_2[0][1];
                $Punkte_Schnittflaeche_NC_2[1][1][2] = $Punkte_Schnittflaeche_NC_2[1][1][2]+100;
            }       //Ende NC if Abfrage                                           
            
            if ($include_NC == "ja"){                                //hinzufügen von Flächen für NC-Kanten Integration (außerhalb der Schleife)
                $Punkte_Drehung[2] =   $Punkte_Schnittflaeche_NC_1;                                 //verpacken in Array für Drehmatrizen
                $Punkte_Drehung[3] =   $Punkte_Blattflaeche_Hauptflaeche_oben_Offset1;
                $Punkte_Drehung[4] =    $Punkte_Blattflaeche_Hauptflaeche_unten_Offset1; 
                $Punkte_Drehung[5] =   $Punkte_Blattflaeche_Hauptflaeche_oben_Offset2;
                $Punkte_Drehung[6] =    $Punkte_Blattflaeche_Hauptflaeche_unten_Offset2;  
                    
            }


        //............................Drehmatrizen für Blattfläche Schnittfläche NC usw. (alles was gedreht wird)

            for ($k = 0; $k < count($Punkte_Drehung); $k++){
                for ($i=0; $i <  count($Punkte_Drehung[$k]); $i++){
                    for ($j=0; $j < count($Punkte_Drehung[$k][$i]);$j ++){ 

                        $TurnProfilpoints =$Punkte_Drehung[$k][$i];                                                  //Hilfsvariable zum drehen der Flächen
                        $Punkte_Drehung[$k][$i][$j][2] = $TurnProfilpoints[$j][2]*cos($AngleofIncidence[$i]) - $TurnProfilpoints[$j][3]*sin($AngleofIncidence[$i]); //Drehamtrix um x-Achse
                        $Punkte_Drehung[$k][$i][$j][3] = $TurnProfilpoints[$j][2]*sin($AngleofIncidence[$i]) + $TurnProfilpoints[$j][3]*cos($AngleofIncidence[$i]);                     

                    
                        
                        //Drehen der Profilpunkte um y-Achse bei x_RPS
                        if ($i == 0){
                            //if ($Punkte_Drehung[$k][$i][$j][3] >= 0){
                            $Punkte_Drehung[$k][$i][$j][3] = $Punkte_Drehung[$k][$i][$j][3]*(1/cos($RotationAngleBlocky));          //Dickenskalierung von 1. Profilschnitt, da dieser nicht gedreht wird (und parallel zur z-Achse der Fräse steht)
                        // }      
                        } else {
                            $TurnProfilpoints = $Punkte_Drehung[$k][$i];                                                  //Hilfsvariable zum drehen des Profils mit aktuellen Punkten
                            $TurnProfilpoints[$j][1] = $Punkte_Drehung[$k][$i][$j][1] - $x_RPS;                           //Abziehen des x-Wertes um in der lokalen Ebene zu drehen
                            $Punkte_Drehung[$k][$i][$j][1] =  $TurnProfilpoints[$j][1]*cos($RotationAngleBlocky) - $TurnProfilpoints[$j][3]*sin($RotationAngleBlocky); //Drehamtrix um y-Achse
                            $Punkte_Drehung[$k][$i][$j][3] =   $TurnProfilpoints[$j][1]*sin($RotationAngleBlocky) + $TurnProfilpoints[$j][3]*cos($RotationAngleBlocky); 
                            $TurnProfilpoints[$j][1] = $Punkte_Drehung[$k][$i][$j][1] + $x_RPS; 
                            $Punkte_Drehung[$k][$i][$j][1] = $TurnProfilpoints[$j][1]*cos($RotationAngleBlocky);         //skalieren der x-Werte, damit Blatt beim Drehen nicht länger wird
                        }

                        //lokale Drehung der Profilschnitte
                        $TurnProfilpoints = $Punkte_Drehung[$k][$i];                                                  //Hilfsvariable zum drehen des Profils mit aktuellen Punkten
                        $TurnProfilpoints[$j][1] = $Punkte_Drehung[$k][$i][$j][1] - $r[$i];                           //Abziehen des x-Wertes um in der lokalen Ebene zu drehen
                        $Punkte_Drehung[$k][$i][$j][3] =  $TurnProfilpoints[$j][3]*cos($yTwistAngle[$i]) - $TurnProfilpoints[$j][1]*sin($yTwistAngle[$i]); //Drehamtrix um y-Achse
                        $Punkte_Drehung[$k][$i][$j][1] =   $TurnProfilpoints[$j][3]*sin($yTwistAngle[$i]) + $TurnProfilpoints[$j][1]*cos($yTwistAngle[$i]);   
                                    
                        $TurnProfilpoints = $Punkte_Drehung[$k][$i];                                                  //Hilfsvariable zum drehen des Profils mit aktuellen Punkten
                        $TurnProfilpoints_unten = $Punkte_Blattflaeche_Hauptflaeche_unten[$i];
                        $Punkte_Drehung[$k][$i][$j][2] =  $TurnProfilpoints[$j][2]*cos($zTwistAngle[$i]) - $TurnProfilpoints[$j][1]*sin($zTwistAngle[$i]); //Drehamtrix um z-Achse                        
                        $Punkte_Drehung[$k][$i][$j][1] =   $TurnProfilpoints[$j][2]*sin($zTwistAngle[$i]) + $TurnProfilpoints[$j][1]*cos($zTwistAngle[$i]);                        
                        $Punkte_Drehung[$k][$i][$j][1] = $Punkte_Drehung[$k][$i][$j][1] + $r[$i];                              //Addieren des x-Wertes der lokalen Ebene nach Drehung   
                    }
                }
            }                     
            $Punkte_Blattflaeche_Hauptflaeche_oben =  $Punkte_Drehung[0];           //entpacken nach Drehung für größere Nachvollziehbarkeit anhand des Variablennames
            $Punkte_Blattflaeche_Hauptflaeche_unten =  $Punkte_Drehung[1];

                          
                

        //............................Blattflaeche_HK........................................
            for ($i=0; $i < $mplus1; $i++){                     //Ebenenschleife
                for ($j=0; $j < $nplus1;$j ++){                 //Schleife Profilpunkte 
                    $Punkte_Blattflaeche_HK[$i][0] = $Punkte_Blattflaeche_Hauptflaeche_oben[$i][$nplus1-1];                //setzen der HK Punkte
                    $Punkte_Blattflaeche_HK[$i][1] = $Punkte_Blattflaeche_Hauptflaeche_unten[$i][$nplus1-1];                   
                    $Punkte_Blattflaeche_HK[$i][0][0] = "Blattflaeche_HK-E$b-P1";                                           //Namenszuweisung HK Punkte
                    $Punkte_Blattflaeche_HK[$i][1][0] = "Blattflaeche_HK-E$b-P2";
                    if ($includeblock == "ja"){
        //............................Trennflaeche_Tangentenrand_vorne........................................ 
                        $Punkte_Trennflaeche_Tangentenrand_vorne[$i][0] = $Punkte_Blattflaeche_Hauptflaeche_oben[$i][0];         //übernehme Punkte von VK
                        $Punkte_Trennflaeche_Tangentenrand_vorne[$i][0][0] = "Trennflaeche_Tangentenrand_vorne-E$b-P2";
                        $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1] = $Punkte_Blattflaeche_Hauptflaeche_oben[$i][0];
                        if ($i < $mplus1-1){
                            $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][2] = $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][2]-$bTR;      //versetzen der VK Punkte um Blockbreite
                        }
                        else{
                            $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][1] = $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][1]+$bTR/sqrt(2);
                            $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][2] = $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][2]-$bTR/sqrt(2);
                        }

                        
                        $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][3] = $Punkte_Blattflaeche_Hauptflaeche_oben[$i][0][3]+$zKW[$i];          //z-Korrektur
                        $Punkte_Trennflaeche_Tangentenrand_vorne[$i][0][3] = $Punkte_Blattflaeche_Hauptflaeche_oben[$i][0][3]+$zKW[$i];          //z-Korrektur
                        $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][0] = "Trennflaeche_Tangentenrand_vorne-E$b-P1";
        //............................Trennflaeche_Tangentenrand_hinten........................................ 
                        $Punkte_Trennflaeche_Tangentenrand_hinten[$i][1][0] = "Trennflaeche_Tangentenrand_hinten-E$b-P2";   
                        $Punkte_Trennflaeche_Tangentenrand_hinten[$i][1][1] = $Punkte_Blattflaeche_HK[$i][0][1];
                        $Punkte_Trennflaeche_Tangentenrand_hinten[$i][1][2] = ($Punkte_Blattflaeche_HK[$i][0][2]+$Punkte_Blattflaeche_HK[$i][1][2])/2;
                        $Punkte_Trennflaeche_Tangentenrand_hinten[$i][1][3] = ($Punkte_Blattflaeche_HK[$i][0][3]+$Punkte_Blattflaeche_HK[$i][1][3])/2;        //zuweisen und berechnen der Mitte der HK
                        $Punkte_Trennflaeche_Tangentenrand_hinten[$i][0] = $Punkte_Trennflaeche_Tangentenrand_hinten[$i][1];
                        if ($i < $mplus1-1){
                            $Punkte_Trennflaeche_Tangentenrand_hinten[$i][0][2] = $Punkte_Trennflaeche_Tangentenrand_hinten[$i][1][2]+$bTR;  //versetzen der HK um Tangentenrand Blockbreite
                        }
                        else {
                            $Punkte_Trennflaeche_Tangentenrand_hinten[$i][0][1] = $Punkte_Trennflaeche_Tangentenrand_hinten[$i][1][1]+$bTR/sqrt(2);
                            $Punkte_Trennflaeche_Tangentenrand_hinten[$i][0][2] = $Punkte_Trennflaeche_Tangentenrand_hinten[$i][1][2]+$bTR/sqrt(2);   
                        }
                        $Punkte_Trennflaeche_Tangentenrand_hinten[$i][0][0] = "Trennflaeche_Tangentenrand_hinten-E$b-P1";
                    }
                }
            }


        


        //............................Blattflaeche_Spitze........................................ 


            $Punkte_Blattflaeche_Spitze[0] = $Punkte_Blattflaeche_Hauptflaeche_oben[$mplus1-1];
            $Punkte_Blattflaeche_Spitze[1] = $Punkte_Blattflaeche_Hauptflaeche_unten[$mplus1-1];


        if ($includeblock == "ja"){            
        //............................Trennflaeche_Tangentenrand_Spitze........................................
            if ($include_Curved_Tangent_Tip == "ja"){                                                                           // Tangentenrand folgt Kontur
                $Punkte_Trennflaeche_Tangentenrand_Spitze[0][0] =  $Punkte_Trennflaeche_Tangentenrand_vorne[$mplus1-1][0];   //übernehme Punkte von Tangentenrand vorne/hinten                       //übernehmen des Punktes der VK Blattspitze
                $Punkte_Trennflaeche_Tangentenrand_Spitze[0][0][0] = "Trennflaeche_Tangentenrand_Spitze-E1-P1";
                $Punkte_Trennflaeche_Tangentenrand_Spitze[0][1] =  $Punkte_Trennflaeche_Tangentenrand_vorne[$mplus1-1][1];
                $Punkte_Trennflaeche_Tangentenrand_Spitze[0][1][0] = "Trennflaeche_Tangentenrand_Spitze-E1-P2";

                $Num_of_Points = count($Punkte_Blattflaeche_Spitze[0]);
                
                for ($i = 1; $i < $Num_of_Points-1; $i++) {
                    $Punkte_Trennflaeche_Tangentenrand_Spitze[$i][0] = $Punkte_Blattflaeche_Spitze[0][$i]; 
                    $Punkte_Trennflaeche_Tangentenrand_Spitze[$i][0][3] = ($Punkte_Blattflaeche_Spitze[0][$i][3]+$Punkte_Blattflaeche_Spitze[1][$i][3])/2; 

                    $Punkte_Trennflaeche_Tangentenrand_Spitze[$i][1] = $Punkte_Trennflaeche_Tangentenrand_Spitze[$i][0]; 
                    $Punkte_Trennflaeche_Tangentenrand_Spitze[$i][1][1] = $Punkte_Trennflaeche_Tangentenrand_Spitze[$i][1][1]+$bTR;

                }
                
                    /*
                for ($i = 1; $i < $mplus1; $i++){
                    $Punkte_Trennflaeche_Tangentenrand_Spitze[$i][0] = $Punkte_Blattflaeche_Spitze[0];
                    $Punkte_Trennflaeche_Tangentenrand_Spitze[$i][0][2] = ($Punkte_Blattflaeche_Spitze[0][$i][2] + $Punkte_Blattflaeche_Spitze[1][$i][2])/2;
                    $Punkte_Trennflaeche_Tangentenrand_Spitze[$i][1] = $Punkte_Trennflaeche_Tangentenrand_Spitze[$i][0];
                    $Punkte_Trennflaeche_Tangentenrand_Spitze[$i][1][1] = $Punkte_Trennflaeche_Tangentenrand_Spitze[$i][1][1]+$btR;
                }           $Num_of_Points-
                */
                $Punkte_Trennflaeche_Tangentenrand_Spitze[$Num_of_Points-1][0] = $Punkte_Trennflaeche_Tangentenrand_hinten[$mplus1-1][1];
                $Punkte_Trennflaeche_Tangentenrand_Spitze[$Num_of_Points-1][0][0] = "Trennflaeche_Tangentenrand_Spitze-E2-P1";
                $Punkte_Trennflaeche_Tangentenrand_Spitze[$Num_of_Points-1][1] = $Punkte_Trennflaeche_Tangentenrand_hinten[$mplus1-1][0];
                $Punkte_Trennflaeche_Tangentenrand_Spitze[$Num_of_Points-1][1][0] = "Trennflaeche_Tangentenrand_Spitze-E2-P2";
            } else {                                                                                                          //Tangentenrand geht  von Spitze bis zum Ende
                $Punkte_Trennflaeche_Tangentenrand_Spitze[0][0] =  $Punkte_Trennflaeche_Tangentenrand_vorne[$mplus1-1][0];   //übernehme Punkte von Tangentenrand vorne/hinten                       //übernehmen des Punktes der VK Blattspitze
                $Punkte_Trennflaeche_Tangentenrand_Spitze[0][0][0] = "Trennflaeche_Tangentenrand_Spitze-E1-P1";
                $Punkte_Trennflaeche_Tangentenrand_Spitze[0][1] =  $Punkte_Trennflaeche_Tangentenrand_vorne[$mplus1-1][1];
                $Punkte_Trennflaeche_Tangentenrand_Spitze[0][1][0] = "Trennflaeche_Tangentenrand_Spitze-E1-P2";
                
                $Punkte_Trennflaeche_Tangentenrand_Spitze[1][0] = $Punkte_Trennflaeche_Tangentenrand_hinten[$mplus1-1][1];
                $Punkte_Trennflaeche_Tangentenrand_Spitze[1][0][0] = "Trennflaeche_Tangentenrand_Spitze-E2-P1";
                $Punkte_Trennflaeche_Tangentenrand_Spitze[1][1] = $Punkte_Trennflaeche_Tangentenrand_hinten[$mplus1-1][0];
                $Punkte_Trennflaeche_Tangentenrand_Spitze[1][1][0] = "Trennflaeche_Tangentenrand_Spitze-E2-P2";

            }

        //............................Trennflaeche_Blockrand........................................                                                                                //setzen der Blockrand Punkte
            $Punkte_Trennflaeche_Blockrand[0][0][0] = "Trennflaeche_Blockrand-E1-P1";                               
            $Punkte_Trennflaeche_Blockrand[0][0][1] = $P0B[0];
            $Punkte_Trennflaeche_Blockrand[0][0][2] = $P0B[1];
            $Punkte_Trennflaeche_Blockrand[0][0][3] =0;

            $Punkte_Trennflaeche_Blockrand[0][1][0] = "Trennflaeche_Blockrand-E1-P2";
            $Punkte_Trennflaeche_Blockrand[0][1][1] = $P0B[0];
            $Punkte_Trennflaeche_Blockrand[0][1][2] = $P0B[1]-$bB;
            $Punkte_Trennflaeche_Blockrand[0][1][3] = 0;

            $Punkte_Trennflaeche_Blockrand[3][1][0] = "Trennflaeche_Blockrand-E4-P2";
            $Punkte_Trennflaeche_Blockrand[3][1][1] = $P0B[0];
            $Punkte_Trennflaeche_Blockrand[3][1][2] = $P0B[1]+$bB-$PB[1];
            $Punkte_Trennflaeche_Blockrand[3][1][3] = 0;

            $Punkte_Trennflaeche_Blockrand[3][0][0] = "Trennflaeche_Blockrand-E4-P1";
            $Punkte_Trennflaeche_Blockrand[3][0][1] = $P0B[0];
            $Punkte_Trennflaeche_Blockrand[3][0][2] = $P0B[1]-$PB[1];
            $Punkte_Trennflaeche_Blockrand[3][0][3] = 0;


            $Punkte_Trennflaeche_Blockrand[1][0] = $Punkte_Trennflaeche_Blockrand[0][0];
            $Punkte_Trennflaeche_Blockrand[1][0][1] = $Punkte_Trennflaeche_Blockrand[0][0][1]*1+$PB[0];
            $Punkte_Trennflaeche_Blockrand[2][0][0] = "Trennflaeche_Blockrand-E2-P1";


            $Punkte_Trennflaeche_Blockrand[1][1] = $Punkte_Trennflaeche_Blockrand[0][1];
            $Punkte_Trennflaeche_Blockrand[1][1][1] = $Punkte_Trennflaeche_Blockrand[0][0][1]+$PB[0]-$bB;
            $Punkte_Trennflaeche_Blockrand[1][1][0] = "Trennflaeche_Blockrand-E2-P2";


            $Punkte_Trennflaeche_Blockrand[2][1] = $Punkte_Trennflaeche_Blockrand[3][1];
            $Punkte_Trennflaeche_Blockrand[2][1][1] = $Punkte_Trennflaeche_Blockrand[3][1][1]+$PB[0]-$bB;
            $Punkte_Trennflaeche_Blockrand[2][1][0] = "Trennflaeche_Blockrand-E3-P2";


            $Punkte_Trennflaeche_Blockrand[2][0] = $Punkte_Trennflaeche_Blockrand[3][0];
            $Punkte_Trennflaeche_Blockrand[2][0][1] = $Punkte_Trennflaeche_Blockrand[3][0][1]+$PB[0];
            $Punkte_Trennflaeche_Blockrand[2][0][0] = "Trennflaeche_Blockrand-E3-P1";

        //............................Blockrand_aussen.....................................
                                                                                            
            for ($i = 0; $i < 4; $i++){
                $a = $i+1;
                $Punkte_Trennflaeche_Blockrand_aussen[$i][0] = $Punkte_Trennflaeche_Blockrand[$i][0]; //übernehmen von Trennfläche_Blockrand 
                $Punkte_Trennflaeche_Blockrand_aussen[$i][0][0] = "Trennflaeche_Blockrand_außen-E$a-P1";
                if ($i == 0){
                    $b = 0;
                    $c = $DFB;
                } elseif ($i == 1){
                    $b = $DFB;
                    $c = $DFB;
                } elseif ($i == 2){
                    $b = $DFB;
                    $c = -$DFB;
                }  elseif ($i == 3){
                    $b = 0;
                    $c = -$DFB;            
                }
               
                $Punkte_Trennflaeche_Blockrand_aussen[$i][1] = $Punkte_Trennflaeche_Blockrand[$i][0];
                $Punkte_Trennflaeche_Blockrand_aussen[$i][1][1] = $Punkte_Trennflaeche_Blockrand[$i][0][1] + $b;
                $Punkte_Trennflaeche_Blockrand_aussen[$i][1][2] = $Punkte_Trennflaeche_Blockrand[$i][0][2] + $c;
                $Punkte_Trennflaeche_Blockrand_aussen[$i][1][0] = "Trennflaeche_Blockrand_außen-E$a-P2";               
            }
        //............................Distanzflaeche_Hauptflaeche........................................
            if ($Side == 'oben')                                                                //Offset für oben oder unten setzen um Spalt zu generieren
                {$Distanzflaechen_zOffset = 0.6;}     //0.6                       
            else
                {$Distanzflaechen_zOffset = -0.6;}

            $Distanzflaechen_yOffset = 2;
            $Distanzflaechen_xOffset = 2;

            for ($i=0; $i < $mplus1; $i++){                                                     //Schleife zum Durchlaufen der Ebenen, übernommen von Blattflaeche_Hauptflaeche
                $b = $i +1;
                
                if ($i == $mplus1-1){  
        //............................Distanzflaeche_Hauptflaeche_vorne........................................
                            //erster Punkt, letzte Ebene auf Blockrand, die restlichen mit x-Werten der Blattflächen_Hauptfläche Ebenen
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][0] = $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1];
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][0][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P1"; //P1 aufBlockrand
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5] = $Punkte_Trennflaeche_Blockrand[2][1];    
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P6";

                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5]; //P5  mit versetzter y-Koordinate, bei letzter Ebene ebenfalls versetzer x-Wert
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P5";
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4][1] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5][1]- $Distanzflaechen_xOffset;
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4][2] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5][2]+ $Distanzflaechen_yOffset;  
                }
                else {
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P6";
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5][1] = $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][1];       
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5][2]= $Punkte_Trennflaeche_Blockrand[2][1][2];
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5][3]= $Punkte_Trennflaeche_Blockrand[2][1][3];
                
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5]; //P5  mit versetzter y-Koordinate
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P5";
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4][2] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4][2]+ $Distanzflaechen_yOffset;
                    }
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][3] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4]; //P4  mit versetzter z-Koordinate
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][3][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P4";
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][3][3] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][3][3] + $Distanzflaechen_zOffset;

                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][0] = $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1];
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][0][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P1"; //P1 aufBlockrand

                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][1] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][0]; //P2  mit versetzter y-Koordinate
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][1][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P2";
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][1][2] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][0][2]- $Distanzflaechen_yOffset;


                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][2] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][1]; //P3  mit versetzter z-Koordinate
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][2][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P3";
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][2][3] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][1][3] + $Distanzflaechen_zOffset;
            


        //............................Distanzflaeche_Hauptflaeche_hinten........................................
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][5] = $Punkte_Trennflaeche_Tangentenrand_hinten[$i][0];   //P6 auf Tangentenrand
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][5][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P6";   
                if ($i == $mplus1-1){  
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0] = $Punkte_Trennflaeche_Blockrand[1][1];    
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P1";

                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0]; 
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P2";
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1][1] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0][1]- $Distanzflaechen_xOffset;
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1][2] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0][2]- $Distanzflaechen_yOffset;

                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][5];  //5. Punkt mit versetzter x und y-Koordinate
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P2";
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4][2] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][5][2]+ $Distanzflaechen_yOffset;
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4][1] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][5][1]+ $Distanzflaechen_xOffset;
                        
                    }
                else {
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P1";
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0][1] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][5][1];       
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0][2]= $Punkte_Trennflaeche_Blockrand[1][1][2];
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0][3]= $Punkte_Trennflaeche_Blockrand[1][1][3];

                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0]; 
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P2";
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1][2] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0][2]- $Distanzflaechen_yOffset;
                        
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][5];  //5. Punkt mit versetzter y-Koordinate
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P2";
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4][2] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][5][2]+ $Distanzflaechen_yOffset;
                    }
                

            

                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][3] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4]; //4. Punkt  mit versetzter z-Koordinate
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][3][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P3";
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][3][3] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4][3] + $Distanzflaechen_zOffset;

                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][2] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1]; //3. Punkt  mit versetzter z-Koordinate
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][2][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P4";
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][2][3] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1][3] + $Distanzflaechen_zOffset;
            }

        //............................Distanzflaeche_Spitze_Spitzenverlängerung........................................
            if ($include_Curved_Tangent_Tip == "ja"){
            } else {
                $Num_of_Points = 2;
            }


            for ($i = 0; $i <  $Num_of_Points; $i++){
                $b = $i+1;
            
                $Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[0][$i] = $Punkte_Trennflaeche_Tangentenrand_Spitze[$i][1];            //1. Punkt übernommen von Trennflaeche_Tangentenrand_Spitze
                $Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[0][$i][0] = "Distanzflaeche_Spitze_Spitzenverlaengerung-E1-P1";

                //$Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[0][1] = $Punkte_Trennflaeche_Tangentenrand_Spitze[$Num_of_Points-2][1];            //2. Punkt übernommen von Trennflaeche_Tangentenrand_Spitze
                //$Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[0][1][0] = "Distanzflaeche_Spitze_Spitzenverlaengerung-E1-P2";

                $Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[5][$i] = $Punkte_Trennflaeche_Blockrand[1][1];            //E6-P1 Ebene auf Trennflaeche_Blockrand
                $Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[5][$i][2] = $Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[0][$i][2];
                $Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[5][$i][0] = "Distanzflaeche_Spitze_Spitzenverlaengerung-E6-P1";

                //$Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[5][1] = $Punkte_Trennflaeche_Blockrand[1][1];            //E6-P2 auf Trennflaeche_Blockrand
                //$Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[5][1][2] = $Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[0][1][2];
                //$Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[5][1][0] = "Distanzflaeche_Spitze_Spitzenverlaengerung-E6-P2";


                //for ($i = 0; $i<2; $i++){
                    
                    $Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[1][$i] = $Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[0][$i];            //2. Ebene mit x-Offset
                    $Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[1][$i][1] = $Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[0][$i][1]+$Distanzflaechen_xOffset;
                    $Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[1][$i][0] = "Distanzflaeche_Spitze_Spitzenverlaengerung-E2-P$b";
                    
                    $Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[2][$i] = $Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[1][$i];            //3. Ebene mit z-Offset
                    $Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[2][$i][3] = $Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[0][$i][3]+$Distanzflaechen_zOffset;
                    $Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[2][$i][0] = "Distanzflaeche_Spitze_Spitzenverlaengerung-E3-P$b";
                    
                    $Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[4][$i] = $Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[5][$i];            //5. Ebene mit x-Offset
                    $Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[4][$i][1] = $Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[5][$i][1]-$Distanzflaechen_xOffset;
                    $Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[4][$i][0] = "Distanzflaeche_Spitze_Spitzenverlaengerung-E5-P$b";

                    $Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[3][$i] = $Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[4][$i];            //4. Ebene mit z-Offset
                    $Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[3][$i][3] = $Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[4][$i][3]+$Distanzflaechen_zOffset;
                    $Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[3][$i][0] = "Distanzflaeche_Spitze_Spitzenverlaengerung-E4-P$b";
                }


        //............................Distanzflaeche_Spitze_vorne........................................

            
            $Punkte_Distanzflaeche_Spitze_vorne[0] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$mplus1-1];// übernehmen der letzten Ebene von Distanzflaeche_Hauptflaeche_vorne
            for ($i=0; $i < 6; $i++){
                $Punkte_Distanzflaeche_Spitze_vorne[1][$i]  =  $Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[$i][0];
            }
       
        //............................Distanzflaeche_Spitze_hinten........................................
            $Punkte_Distanzflaeche_Spitze_hinten[0] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$mplus1-1];// übernehmen der letzten Ebene von Distanzflaeche_Hauptflaeche_vorne  $Num_of_Points-2
            $a = 5;
            for ($i=0; $i < 6; $i++){
                $Punkte_Distanzflaeche_Spitze_hinten[1][$i]  =  $Punkte_Distanzflaeche_Spitze_Spitzenverlängerung[$a-$i][$Num_of_Points-1];
            }

        //............................Zentrierung_Konus........................................
            
            
            $Punkte_Zentrierung_Konus[0][0][0] = "Zentrierung_Konus E1-P1";                               //Mittelpunkte Kreis 1, kleiner Kreis
            $Punkte_Zentrierung_Konus[0][0][1] = $Punkte_Trennflaeche_Blockrand[2][1][1]-$PZK[0];  
            $Punkte_Zentrierung_Konus[0][0][2] = $Punkte_Trennflaeche_Blockrand[2][1][2]+$PZK[1];
            $Punkte_Zentrierung_Konus[0][0][3] = $PZK[2];
                                
            $Punkte_Zentrierung_Konus[0][1] =   $Punkte_Zentrierung_Konus[0][0];         //E1P2 Punkt auf Kreis 1 
            $Punkte_Zentrierung_Konus[0][1][0] = "Zentrierung_Konus E1-P2"; 
            $Punkte_Zentrierung_Konus[0][1][1] = $Punkte_Zentrierung_Konus[0][0][1]+10;     

            $Punkte_Zentrierung_Konus[1][0] =   $Punkte_Zentrierung_Konus[0][0];         //E2P1 Mittelpunkt Kreis 2 
            $Punkte_Zentrierung_Konus[1][0][0] = "Zentrierung_Konus E2-P1"; 
            $Punkte_Zentrierung_Konus[1][0][3] = $Punkte_Zentrierung_Konus[1][0][3]-30;

            $Punkte_Zentrierung_Konus[1][1] =   $Punkte_Zentrierung_Konus[1][0];         //E2P2 Punkt auf Kreis 2
            $Punkte_Zentrierung_Konus[1][1][0] = "Zentrierung_Konus E2-P2"; 
            $Punkte_Zentrierung_Konus[1][1][1] = $Punkte_Zentrierung_Konus[1][0][1]+10;



        } //Ende include_Block Abfrage
        //............................Output........................................


            $Punkte_Blatt[0][0] = $Punkte_Drehung[0];
            $Punkte_Blatt[1][0] =  $Punkte_Drehung[1];
            $Punkte_Blatt[2][0] = $Punkte_Blattflaeche_HK;
            $Punkte_Blatt[3][0] = $Punkte_Blattflaeche_Spitze;
            if ($includeblock == "ja"){
                $Punkte_Blatt[4][0] = $Punkte_Trennflaeche_Tangentenrand_vorne;
                $Punkte_Blatt[5][0] = $Punkte_Trennflaeche_Tangentenrand_hinten;
                $Punkte_Blatt[6][0] = $Punkte_Trennflaeche_Tangentenrand_Spitze;
                $Punkte_Blatt[7][0] = $Punkte_Trennflaeche_Blockrand;
                $Punkte_Blatt[8][0] = $Punkte_Distanzflaeche_Hauptflaeche_vorne;
                $Punkte_Blatt[9][0] = $Punkte_Distanzflaeche_Hauptflaeche_hinten;
                $Punkte_Blatt[10][0] = $Punkte_Distanzflaeche_Spitze_Spitzenverlängerung;
                $Punkte_Blatt[11][0] = $Punkte_Distanzflaeche_Spitze_vorne;
                $Punkte_Blatt[12][0] = $Punkte_Distanzflaeche_Spitze_hinten;
                $Punkte_Blatt[13][0] = $Punkte_Zentrierung_Konus;
                $Punkte_Blatt[14][0] = $Punkte_Trennflaeche_Blockrand_aussen;
            } else {
                $Punkte_Blatt[4][0] = "";
                $Punkte_Blatt[5][0] = "";
                $Punkte_Blatt[6][0] = "";
                $Punkte_Blatt[7][0] = "";
                $Punkte_Blatt[8][0] = "";
                $Punkte_Blatt[9][0] = "";
                $Punkte_Blatt[10][0] = "";
                $Punkte_Blatt[11][0] = "";
                $Punkte_Blatt[12][0] = "";
                $Punkte_Blatt[13][0] = "";
                $Punkte_Blatt[14][0] = "";

            }
            if ($include_NC == "ja"){
                $Punkte_Blatt[15][0] = $Punkte_Drehung[2];
                $Punkte_Blatt[16][0] = $Punkte_Schnittflaeche_NC_2;
                $Punkte_Blatt[17][0] = $Punkte_Drehung[3];
                $Punkte_Blatt[18][0] = $Punkte_Drehung[4];
                $Punkte_Blatt[19][0] = $Punkte_Drehung[5];
                $Punkte_Blatt[20][0] = $Punkte_Drehung[6];
            } else {
                $Punkte_Blatt[15][0] = "";
                $Punkte_Blatt[16][0] = "";
                $Punkte_Blatt[17][0] = "";
                $Punkte_Blatt[18][0] = "";
                $Punkte_Blatt[19][0] = "";
                $Punkte_Blatt[20][0] = "";
            }

            


            

            for ($i = 0; $i < count($Punkte_Blatt); $i++){
            //if ($Objekt == "Blatt"){               //Abfrage für welches Teil Step Entities erzeugt werden sollen
                if ($i == 0){
                    $u = $u_Blade;
                    $v = $v_Blade;
                    $Surface_Name[$i]="Blattflaeche_Hauptflaeche_oben";                                              //Spline Ordnung der verschiedenen Flächen setzen
                    $Surface_Colour[$i] = "('NONE',1,0,0)";
                } elseif($i == 1){
                    $u = $u_Blade;
                    $v = $v_Blade;
                    $Surface_Name[$i]="Blattflaeche_Hauptflaeche_unten";                                              //Spline Ordnung der verschiedenen Flächen setzen
                    $Surface_Colour[$i] = "('NONE',0,0,1)";
                } elseif($i == 2){
                    $u = $u_Blade;
                    $v=2;
                    $Surface_Name[$i]="Blattflaeche_HK";
                    $Surface_Colour[$i] = "('NONE',0,0.5,1)";
                } elseif($i == 3){
                    $u =2;
                    $v=$v_Blade;
                    $Surface_Name[$i]="Blattflaeche_Spitze";
                    $Surface_Colour[$i] = "('NONE',0,1,0)";
                } elseif($i == 4){
                    $u = $u_Blade;
                    $v=2;
                    $Surface_Name[$i]="Trennflaeche_Tangentenrand_vorne";
                    $Surface_Colour[$i] = "('NONE',0,1,1)";
                } elseif($i == 5){
                    $u = $u_Blade;
                    $v=2;
                    $Surface_Name[$i]="Trennflaeche_Tangentenrand_hinten";
                    $Surface_Colour[$i] = "('NONE',0,1,1)";
                } elseif($i == 6){
                    $u = 2; 
                    if ($includeblock == "ja"){
                        if ($include_Curved_Tangent_Tip == "ja"){
                            $u=$v_Blade;
                        } else {
                            $u=2;
                        }
                    }                    
                    $v=2;
                    $Surface_Name[$i]="Trennflaeche_Tangentenrand_Spitze";
                    $Surface_Colour[$i] = "('NONE',0,1,1)";
                } elseif($i == 7){
                    $u=2;
                    $v=2;
                    $Surface_Name[$i]="Trennflaeche_Blockrand";
                    $Surface_Colour[$i] = "('NONE',1,1,1)";
                } elseif($i == 8){
                    $u = $u_Blade; 
                    $v=4;
                    $Surface_Name[$i]="Distanzflaeche_Hauptflaeche_vorne";
                    $Surface_Colour[$i] = "('NONE',0,0.5,0)";
                } elseif($i == 9){
                    $u = $u_Blade;
                    $v=4;
                    $Surface_Name[$i]="Distanzflaeche_Hauptflaeche_hinten";
                    $Surface_Colour[$i] = "('NONE',0,0.5,0)";
                } elseif($i == 10){
                    $u = 4;
                    $v=2;
                    if ($includeblock == "ja"){
                        if ($include_Curved_Tangent_Tip == "ja"){
                            $v=$v_Blade;
                        } else {
                            $v=2;
                        } 
                    }
                    $Surface_Name[$i]="Distanzflaeche_Spitze_Spitzenverlängerung";
                    $Surface_Colour[$i] = "('NONE',0,0.5,0)";
                } elseif($i == 11){
                    $u=2;
                    $v=4;
                    $Surface_Name[$i]="Distanzflaeche_Spitze_vorne";
                    $Surface_Colour[$i] = "('NONE',0,0.5,0)";
                } elseif($i == 12){
                    $u=2;
                    $v=4;
                    $Surface_Name[$i]="Distanzflaeche_Spitze_hinten";
                    $Surface_Colour[$i] = "('NONE',0,0.5,0)";
                } elseif($i == 13) {
                    $Surface_Name[$i]="Zentrierung_Konus";
                    $Surface_Colour[$i] = "('NONE',0.5,0,0.5)";
                    
                } elseif($i == 14) {
                    $u=2;
                    $v=2;
                    $Surface_Name[$i]="Trennflaeche_Blockrand_aussen";
                    $Surface_Colour[$i] = "('NONE',0.2,0.1,0.8)";
                    
                }  elseif($i == 15) {
                    $u=$u_Blade;
                    $v=2;
                    $Surface_Name[$i]="Schnittflaeche_NC_1";
                    $Surface_Colour[$i] = "('NONE',0,0.5,1)";
                    
                } elseif($i == 16) {
                    $u=2;
                    $v=2;
                    $Surface_Name[$i]="Schnittflaeche_NC_2";
                    $Surface_Colour[$i] = "('NONE',1,0.5,1)";
                    
                } elseif($i == 17) {
                    $u=$u_Blade;
                    $v=$v_Blade;
                    $Surface_Name[$i]="Blattflaeche_Hauptflaeche_oben_Offset1";
                    $Surface_Colour[$i] = "('NONE',0,0.5,1)";
                    
                } elseif($i == 18) {
                    $u=$u_Blade;
                    $v=$v_Blade;
                    $Surface_Name[$i]="Blattflaeche_Hauptflaeche_unten_Offset1";
                    $Surface_Colour[$i] = "('NONE',1,0,1)";
                } elseif($i == 19) {
                    $u=$u_Blade;
                    $v=$v_Blade;
                    $Surface_Name[$i]="Blattflaeche_Hauptflaeche_oben_Offset2";
                    $Surface_Colour[$i] = "('NONE',1,0.5,0.8)";
                } elseif($i == 20) {
                    $u=$u_Blade;
                    $v=$v_Blade;
                    $Surface_Name[$i]="Blattflaeche_Hauptflaeche_unten_Offset2";
                    $Surface_Colour[$i] = "('NONE',0.4,0.5,1)";
                }

                if ($Punkte_Blatt[$i][0] == ""){    //wenn keine Punkte zugewiesen, werden alle Werte auf leer gesetzt und herausgefiltert
                    $Punkte_Blatt[$i] = "";   
                } else {
                    $Punkte_Blatt[$i][1] = $u;
                    $Punkte_Blatt[$i][2] = $v;
                    $Punkte_Blatt[$i][3] = $Surface_Name[$i];
                    $Punkte_Blatt[$i][4] = $Surface_Colour[$i];      
                    }
                }
            $Punkte_Blatt = array_filter($Punkte_Blatt);
            $Punkte_Blatt = array_merge($Punkte_Blatt);

            //Drehen der Punkte für Rechtsdreher
            if ($Turn_Direction == "rechts"){
                for ($i = 0; $i < count($Punkte_Blatt); $i++){               //jede Fläche
                    for ($j = 0; $j < count($Punkte_Blatt[$i][0]);$j++){             //jede Flächenebene
                        for ($k = 0; $k < count($Punkte_Blatt[$i][0][$j]); $k++){      //jeder Punkt
                            $Punkte_Blatt[$i][0][$j][$k][2]= - $Punkte_Blatt[$i][0][$j][$k][2];
                        }
                    }
                }
            }





            
            return ($Punkte_Blatt);
    }
    function Geometry_Calculation_RootF($includeblock ,$input_Wurzel_F, $inputWurzel_Block, $Side, $Turn_Direction){         //Geometrieberechnung der Wurzel Typ F

        //............................Input.........................................
     
        
        
            //Input Block

              
            
            $zKW = $inputWurzel_Block[0];             //z-Verschiebung Tangentenrand
            $bTR = $inputWurzel_Block[1][0];             //Trennfläche_Tangentenrand Breite
            $bB = $inputWurzel_Block[2][0];              //Blockrand Breite
            $PB = $inputWurzel_Block[3];              //Blockabmaße
            $P0B = $inputWurzel_Block[4];             //Blocknullpunkt
            $PZK = $inputWurzel_Block[5];             //Punkt Zentrierkonus
            $DFB = $inputWurzel_Block[6][0];             //Fräserdurchmesser Blockrand
                //$RotationAngleBlock = $inputWurzel_Block[6][$i]/180*pi();             //Drehwinkel in Blockebene
                
            
            
            
            
           
            
            $z_E1 = $input_Wurzel_F[0];                          //z-Höhe Flansch 1 (ungedreht)
            $z_E2 = $input_Wurzel_F[1];                          //z-Höhe Flansch 2 (ungedreht)
            $z_E3 = $input_Wurzel_F[2];                          //z-Höhe Flansch 3 (ungedreht)
            $R_F = $input_Wurzel_F[3];                            //Flanschradius
            $S_p =  $input_Wurzel_F[4];                          //Spaltmaß 
            $p_w =   $input_Wurzel_F[5];                         //y-Verschiebung der Drehachse
            $AngleofIncidence = $input_Wurzel_F[6];              //Einstellwinkel der Wurzel
            $Cone_Angle =  $input_Wurzel_F[7];                 //V-Winkel der Wurzel
            $RotationAngleBlock =   $input_Wurzel_F[8];          //Verdrehwinkel in die Blockebene
            $WT =   $input_Wurzel_F[9];          //Abstand erste Ebene der Flanschflächen
            $AT =  $input_Wurzel_F[10];  //Abstand Ebene Tangentenausrichtung zu x_RPS             
            $x_RPS = $input_Wurzel_F[11];        //x-Wert der Trennstelle
            $RotationAngle = ($AngleofIncidence + $RotationAngleBlock); //Verdrehwinkel gesamt
            //$x_Extension = [12];  // Verlängerung der geraden Blattfläche zu x_RPS
            $Kompatibility = $input_Wurzel_F[12]; 
            
            if ($input_Wurzel_F[13] == null){
                $Kompatibility_Points = PropellerModellKompatibilitaet::where('name', '=', "$Kompatibility")->pluck('inputKompatibilitaet');
                
                $Kompatibility_Points = str_replace('[','',$Kompatibility_Points);
                $Kompatibility_Points = str_replace('"','',$Kompatibility_Points);
                $Kompatibility_Points = str_replace(']','',$Kompatibility_Points);
                $Kompatibility_Points = str_replace("\t",' ',$Kompatibility_Points);
       
                $Kompatibility_Points =  explode('\r\n', $Kompatibility_Points); 
            
                $counter_1 = count($Kompatibility_Points); //Anzahl der Profilpunktestützpunkte
                for ($i_1 = 0; $i_1 < $counter_1; $i_1++ ){
                    $row = explode(' ',$Kompatibility_Points[$i_1] );
                    $Kompatibility_Points[$i_1] =  $row; 
                }
            } else {
                $Kompatibility_Points = $input_Wurzel_F[13]; 
                $Kompatibility_Points = str_replace("\t",' ',$Kompatibility_Points);
                $Kompatibility_Points = explode("\r\n", $Kompatibility_Points);
                for ($j=0; $j < count($Kompatibility_Points); $j++){
                    $Kompatibility_Points[$j] = explode(" ", $Kompatibility_Points[$j]);
                }
    
            }
           
            $delta_y_round = $input_Wurzel_F[15];
            $delta_z_round = $input_Wurzel_F[16];

            
            
            
           
           
           
            for ($j=0;$j < 4; $j++){
                for ($i=0;$i < count($Kompatibility_Points)/8; $i++){                         
                    $RPS_Points[$j][$i] = $Kompatibility_Points[$i+($j)*count($Kompatibility_Points)/4];
                    $RPS_AT_Points[$j][$i] = $Kompatibility_Points[$i+($j)*count($Kompatibility_Points)/4+count($Kompatibility_Points)/8];
                }    
            }

          


            



        //............................Flansche......................................
            $Rf1 = 1.496;             //Rundfaktor zur Spline-Halbkreis-Wandlung 5.Ordnung mitte außen
            $Rf2 = 0.88;
            $Rf3 = 0.7815;             //Rundfaktor zur Spline-Viertelkreis-Wandlung 4.Ordnung mitte außen
            $Rf4 = 0.2627;
            $Rf5 = 0.7913;             //Rundfaktor zur Spline-Halbkreis-Wandlung 5.Ordnung mitte außen
            $Rf6 = 0.3916;    


            for ($i = 0; $i < 4; $i++){              //Flanschebenen Schleife
                    $c = $i +1;
                    if($i == 0){                           //Ebene 1
                        $y1 = -$R_F;
                        $z = $z_E1;
                    } elseif($i == 1){                     //Ebene 2
                        $y1 = -$R_F;
                        $z = $z_E2+$S_p;
                    } elseif ($i == 2){                    //Ebene 2 mit Spalt
                        $y1 = $R_F;
                        $z = $z_E2-$S_p;
                    } elseif ($i == 3){                     //Ebene 3
                        $y1 = $R_F;
                        $z = $z_E3;
                    }
                    for ($j = 0; $j < 5; $j++){          //Ebenenschleife
                        $a = $j+1;
                        if ($j == 0){
                            $x = -$R_F;
                            $yE = 0;
                        }elseif ($j == 1){
                            $x = -$R_F;
                            $yE = $y1 * $Rf2;
                        }elseif ($j == 2){
                            $x = 0;
                            $yE = $y1 * $Rf1;
                        }elseif ($j == 3){
                            $x = $R_F;
                            $yE = $y1 * $Rf2;
                        }elseif ($j == 4){
                            $x = $R_F;
                            $yE = 0;
                        }
                        for ($k = 0; $k < 2; $k++){       //Punkteschleife
                            $b = $k+1;
                            if ($k == 0){
                                $y = 0;
                            } else {
                                $y = $yE;
                            }
                            $Punkte_Flanschflaeche[$i][$j][$k][0] = "Flanschflaeche_Ebene$c-E$a-P$b";                               //Drehung um x-Achse
                            $Punkte_Flanschflaeche[$i][$j][$k][1] = $x;
                            $Punkte_Flanschflaeche[$i][$j][$k][2] = $y*cos($RotationAngle)-$z*sin($RotationAngle)+$p_w;
                            $Punkte_Flanschflaeche[$i][$j][$k][3] = $y*sin($RotationAngle) + $z*cos($RotationAngle);
                            
                            $deltax = $Punkte_Flanschflaeche[$i][$j][$k][1]- $x_RPS; // $x_RPS -  Abstand zwischen Punkt und Drehachse (Achse liegt bei RPS)
                            $Punkte_Flanschflaeche[$i][$j][$k][1] = $deltax*cos($Cone_Angle)-$Punkte_Flanschflaeche[$i][$j][$k][3]*sin($Cone_Angle);    //Drehung um y-Achse
                            $Punkte_Flanschflaeche[$i][$j][$k][3] = $deltax*sin($Cone_Angle)+$Punkte_Flanschflaeche[$i][$j][$k][3]*cos($Cone_Angle);
                            $Punkte_Flanschflaeche[$i][$j][$k][1] = $Punkte_Flanschflaeche[$i][$j][$k][1] +$x_RPS;


                        }

                }
            }


        //............................Verbindungsflächen.........................................

            for ($j = 0; $j < count($Punkte_Flanschflaeche[0]); $j++){                                         
                    $Punkte_Verbindungsflaeche_1_2_aussen[$j][0] = $Punkte_Flanschflaeche[0][$j][1];                       //Verbindungsfläche 1-2 außen       
                    $Punkte_Verbindungsflaeche_1_2_aussen[$j][0][0] = "Punkte_Verbindungsflaeche_1_2_aussen_E$j P1";           //übernehmen der P2 von Flanschebene 1 und 2
                    $Punkte_Verbindungsflaeche_1_2_aussen[$j][1] = $Punkte_Flanschflaeche[1][$j][1];
                    $Punkte_Verbindungsflaeche_1_2_aussen[$j][0][0] = "Punkte_Verbindungsflaeche_1_2_aussen_E$j P2";

                    $Punkte_Verbindungsflaeche_1_2_stufe[$j][0] = $Punkte_Flanschflaeche[0][$j][0];                       //Verbindungsfläche 1-2 Stufe       
                    $Punkte_Verbindungsflaeche_1_2_stufe[$j][0][0] = "Punkte_Verbindungsflaeche_1_2_stufe_E$j P1";           //übernehmen der P2 von Flanschebene 1 und 2
                    $Punkte_Verbindungsflaeche_1_2_stufe[$j][1] = $Punkte_Flanschflaeche[1][$j][0];
                    $Punkte_Verbindungsflaeche_1_2_stufe[$j][1][0] = "Punkte_Verbindungsflaeche_1_2_stufe_E$j P2";

                    $Punkte_Verbindungsflaeche_2_3_aussen[$j][0] = $Punkte_Flanschflaeche[2][$j][1];                       //Verbindungsfläche 1-2 außen       
                    $Punkte_Verbindungsflaeche_2_3_aussen[$j][0][0] = "Punkte_Verbindungsflaeche_2_3_aussen_E$j P1";           //übernehmen der P2 von Flanschebene 2 und 3
                    $Punkte_Verbindungsflaeche_2_3_aussen[$j][1] = $Punkte_Flanschflaeche[3][$j][1];
                    $Punkte_Verbindungsflaeche_2_3_aussen[$j][1][0] = "Punkte_Verbindungsflaeche_2_3_aussen_E$j P2";

                    $Punkte_Verbindungsflaeche_2_3_stufe[$j][0] = $Punkte_Flanschflaeche[2][$j][0];                       //Verbindungsfläche 1-2 Stufe       
                    $Punkte_Verbindungsflaeche_2_3_stufe[$j][0][0] = "Punkte_Verbindungsflaeche_2_3_stufe_E$j P1";           //übernehmen der P2 von Flanschebene 3 und 3
                    $Punkte_Verbindungsflaeche_2_3_stufe[$j][1] = $Punkte_Flanschflaeche[3][$j][0];
                    $Punkte_Verbindungsflaeche_2_3_stufe[$j][1][0] = "Punkte_Verbindungsflaeche_2_3_stufe_E$j P2";}
        //............................Blattfläche...................................
            for ($i = 0; $i < 4; $i++){              //Blattflächen-Schleife
                $Number_of_Profile_Points =  count($RPS_Points[0]);
                $c = $i +1;
                if($i == 0){         //
                    $y1 = -$R_F;
                    $z1 = $z_E1;

                } elseif($i == 1){
                    $y1 = -$R_F;
                    $z1 = $z_E2+$S_p;
                } elseif ($i == 2){
                    $y1 = $R_F;
                    $z1 = $z_E2-$S_p;
                } elseif ($i == 3){
                    $y1 = $R_F;
                    $z1 = $z_E3;
                }
                for ($j = 0; $j < 4; $j++){          //Ebenenschleife
                    $a = $j+1;
                    if ($j == 0){
                        $Step_angle = pi()/2/($Number_of_Profile_Points-1);
                        $counter = pi()/2;
                        
                        for ($k = 0; $k < $Number_of_Profile_Points; $k++){       //Punkteschleife E1
                            if ($Number_of_Profile_Points > 5){                     // für mehr als 5 Punkte pro Wurzel-Blattfläche werden die Randpunkte der Blattfläche am Flansch als Kreisfunktion abgebildet. Bei 5 Punkten wird die Standard Kreisannäherung verwendet
                                $b = $k+1;                              
                                $x = $R_F*cos($counter);
                                $y = $y1*sin($counter);                   
                                $z = $z1; 
                            } else {                           
                                if ($k <  $Number_of_Profile_Points/5){
                                    $x = 0;
                                    $y = $y1;                 
                                    $z = $z1;
                                } elseif ($Number_of_Profile_Points/5   <= $k and $k  <  $Number_of_Profile_Points*2/5) {
                                    $x = $R_F*$Rf6;
                                    $y = $y1;
                                    $z = $z1;
                                } elseif ($Number_of_Profile_Points*2/5   <= $k and $k <  $Number_of_Profile_Points*3/5){
                                    $x = $R_F*$Rf5;
                                    $y = $y1*$Rf5;
                                    $z = $z1;
                                } elseif ($Number_of_Profile_Points*3/5   <= $k and $k <  $Number_of_Profile_Points*4/5){
                                    $x = $R_F;
                                    $y = $y1*$Rf6;
                                    $z = $z1;
                                } elseif ($k >=  $Number_of_Profile_Points*4/5){
                                    $x = $R_F;
                                    $y = 0;
                                    $z = $z1;
                                }    
                            }
                            $Punkte_Blattflaeche[$i][$j][$k][0] = "Punkte_Blattflaeche_$c-E$a-P$b";             //berechnen des Viertelkreises am Flansch
                            $Punkte_Blattflaeche[$i][$j][$k][1] = $x;
                            $Punkte_Blattflaeche[$i][$j][$k][2] = $y*cos($RotationAngle)-$z*sin($RotationAngle)+$p_w;
                            $Punkte_Blattflaeche[$i][$j][$k][3] = $y*sin($RotationAngle) + $z*cos($RotationAngle);
                            $counter = $counter - $Step_angle;

                        }
                        
                    }elseif ($j == 1){
                        for ($k = 0; $k < count($RPS_Points[$i]); $k++){                                         //Stützebene nach Flansch
                            $b = $k+1; 
                            $Punkte_Blattflaeche[$i][$j][$k] = $Punkte_Blattflaeche[$i][0][$k];                  
                            $Punkte_Blattflaeche[$i][$j][$k][1] = $Punkte_Blattflaeche[$i][0][$Number_of_Profile_Points-1][1]+$WT;
                            $Punkte_Blattflaeche[$i][$j][$k][0] = "Punkte_Blattflaeche_$c-E$a-P$b";

                        
                        }
                    } elseif ($j == 2){
                        for ($k = 0; $k < count($RPS_Points[$i]); $k++){                                              //Stützebene bei RPS-AT
                            $b = $k+1;
                            $Punkte_Blattflaeche[$i][$j][$k][0] = "Punkte_Blattflaeche_$c-E$a-P$b";
                            $Punkte_Blattflaeche[$i][$j][$k][1] = $x_RPS-$AT;
                            $Punkte_Blattflaeche[$i][$j][$k][2] = $RPS_AT_Points[$i][$k][0];
                            $Punkte_Blattflaeche[$i][$j][$k][3] = $RPS_AT_Points[$i][$k][1];


                        }     
                    } elseif ($j == 3){
                        for ($k = 0; $k < count($RPS_Points[$i]); $k++){                                            //Stützebene bei RPS
                            $b = $k+1;
                            $Punkte_Blattflaeche[$i][$j][$k][0] = "Punkte_Blattflaeche_$c-E$a-P$b";
                            $Punkte_Blattflaeche[$i][$j][$k][1] = $x_RPS;
                            $Punkte_Blattflaeche[$i][$j][$k][2] = $RPS_Points[$i][$k][0];
                            $Punkte_Blattflaeche[$i][$j][$k][3] = $RPS_Points[$i][$k][1];

                            
                        }
                    }
                }
            }
            //Drehung um y-Achse
            for ($i = 0; $i < 4; $i++){
                for ($j = 0; $j < 4; $j++){
                    for ($k = 0; $k < $Number_of_Profile_Points; $k++){
                        if ($j == 0 or $j ==1){
                            $deltax = $Punkte_Blattflaeche[$i][$j][$k][1]- $x_RPS; // $x_RPS -  Abstand zwischen Punkt und Drehachse (Achse liegt bei RPS)
                            $Punkte_Blattflaeche[$i][$j][$k][1] = $deltax*cos($Cone_Angle)-$Punkte_Blattflaeche[$i][$j][$k][3]*sin($Cone_Angle);    //Drehung um y-Achse
                            $Punkte_Blattflaeche[$i][$j][$k][3] = $deltax*sin($Cone_Angle)+$Punkte_Blattflaeche[$i][$j][$k][3]*cos($Cone_Angle);
                            $Punkte_Blattflaeche[$i][$j][$k][1] = $Punkte_Blattflaeche[$i][$j][$k][1] +$x_RPS;
                        }
                    }
                }
            }    
        //............................Schnittfläche.................................
            for ($i = 0; $i < count($Punkte_Blattflaeche[0]); $i++){       //übernehmen der Punkte von Blattflächen
                $a = $i+1;
                $Punkte_Schnittflaeche[$i][0] = $Punkte_Blattflaeche[0][$i][count($Punkte_Blattflaeche[0][0])-1];
                $Punkte_Schnittflaeche[$i][0][0] = "Punkte_Schnittflaeche_E$a-P1";
                $Punkte_Schnittflaeche[$i][1] = $Punkte_Blattflaeche[3][$i][count($Punkte_Blattflaeche[0][0])-1];
                $Punkte_Schnittflaeche[$i][1][0] = "Punkte_Schnittflaeche_E$a-P2";
            }
        //............................Kantenfläche_HK...............................
            for ($i = 0; $i < count($Punkte_Blattflaeche[0]); $i++){      //übernehmen der Punkte von Blattflächen
                $a = $i+1;
                $Punkte_Kantenflaeche_HK[$i][0] = $Punkte_Blattflaeche[2][$i][0];
                $Punkte_Kantenflaeche_HK[$i][0][0] = "Punkte_Kantenflaeche_E$a-P1";
                $Punkte_Kantenflaeche_HK[$i][1] = $Punkte_Blattflaeche[3][$i][0];
                $Punkte_Kantenflaeche_HK[$i][1][0] = "Punkte_Kantenflaeche_E$a-P2";

            }  
        //............................Kantenfläche_VK...............................
            for ($i = 0; $i < count($Punkte_Blattflaeche[0]); $i++){      //übernehmen der Punkte von Blattflächen
                $a = $i+1;
                $Punkte_Kantenflaeche_VK[$i][0] = $Punkte_Blattflaeche[0][$i][0];
                $Punkte_Kantenflaeche_VK[$i][0][0] = "Punkte_Kantenflaeche_E$a-P1";
                $Punkte_Kantenflaeche_VK[$i][1] = $Punkte_Blattflaeche[1][$i][0];
                $Punkte_Kantenflaeche_VK[$i][1][0] = "Punkte_Kantenflaeche_E$a-P2";
            }  
            
        //............................Verrundung_Blattfläche_Schnittfläche........................................
            for ($i = 0; $i < count($Punkte_Blattflaeche[2]); $i++){
                if ($i == 0 ){
                    $a = $delta_y_round[0];
                    $b = $delta_z_round[0];
                } elseif ($i == 1) {
                    $a = $delta_y_round[1];
                    $b = $delta_z_round[1];
                } elseif ($i == 2) {
                    $a = $delta_y_round[2];
                    $b = $delta_z_round[2];
                } elseif ($i == 3){
                    $a = $delta_y_round[3];
                    $b = $delta_z_round[3];
                }
                
                if (count($RPS_AT_Points[0]) > 5){

                    $Punkte_Verrundung_oben[$i][0] = $Punkte_Blattflaeche[2][$i][3];                //übernehmen der Punkte von Blattfläche, oben
                    $Punkte_Verrundung_oben[$i][0][0] = "Verrundung_oben_E$i-P1";
                    $Punkte_Verrundung_oben[$i][0][1] = $Punkte_Blattflaeche[2][$i][count($Punkte_Blattflaeche[2][$i])-10][1];   //($Punkte_Blattflaeche[2][$i][3][1]+
                    $Punkte_Verrundung_oben[$i][0][2] = $Punkte_Blattflaeche[2][$i][count($Punkte_Blattflaeche[2][$i])-10][2];  //($Punkte_Blattflaeche[2][$i][3][2]+ /2
                    $Punkte_Verrundung_oben[$i][0][3] = $Punkte_Blattflaeche[2][$i][count($Punkte_Blattflaeche[2][$i])-10][3]-$b;  //($Punkte_Blattflaeche[2][$i][3][3]+ /2-0.4
        
                    $Punkte_Verrundung_oben[$i][1] = $Punkte_Blattflaeche[2][$i][count($Punkte_Blattflaeche[2][$i])-1];
                    $Punkte_Verrundung_oben[$i][1][0] = "Verrundung_oben_E$i-P2";
        
                    $Punkte_Verrundung_oben[$i][2] = $Punkte_Schnittflaeche[$i][1];
                    $Punkte_Verrundung_oben[$i][2][0] = "Verrundung_oben_E$i-P3";
                    $Punkte_Verrundung_oben[$i][2][1] = ($Punkte_Schnittflaeche[$i][0][1]+$Punkte_Blattflaeche[2][$i][count($Punkte_Blattflaeche[2][$i])-1][1])/2;     //bei 5 Punkten statt count($Punkte_Blattflaeche[2][$i])-1 Zahl 4 einsetzen (letzter Punkt der Ebene)
                    $Punkte_Verrundung_oben[$i][2][2] = ($Punkte_Schnittflaeche[$i][0][2]+$Punkte_Blattflaeche[2][$i][count($Punkte_Blattflaeche[2][$i])-1][2])/2-$a;
                    $Punkte_Verrundung_oben[$i][2][3] = ($Punkte_Schnittflaeche[$i][0][3]+$Punkte_Blattflaeche[2][$i][count($Punkte_Blattflaeche[2][$i])-1][3])/2;
                
                    $Punkte_Verrundung_unten[$i][0] = $Punkte_Blattflaeche[1][$i][3];                //übernehmen der Punkte von Blattfläche, unten
                    $Punkte_Verrundung_unten[$i][0][0] = "Verrundung_unten_E$i-P1";
                    $Punkte_Verrundung_unten[$i][0][1] =$Punkte_Blattflaeche[1][$i][count($Punkte_Blattflaeche[2][$i])-10][1];      // ($Punkte_Blattflaeche[1][$i][3][1]+ /2
                    $Punkte_Verrundung_unten[$i][0][2] = $Punkte_Blattflaeche[1][$i][count($Punkte_Blattflaeche[2][$i])-10][2];  // ($Punkte_Blattflaeche[1][$i][3][2]+ /2
                    $Punkte_Verrundung_unten[$i][0][3] = $Punkte_Blattflaeche[1][$i][count($Punkte_Blattflaeche[2][$i])-10][3]+$b ;  // ($Punkte_Blattflaeche[1][$i][3][3]+ /2+0.2

                    $Punkte_Verrundung_unten[$i][1] = $Punkte_Blattflaeche[1][$i][count($Punkte_Blattflaeche[2][$i])-1];
                    $Punkte_Verrundung_unten[$i][1][0] = "Verrundung_unten_E$i-P2";

                    $Punkte_Verrundung_unten[$i][2] = $Punkte_Schnittflaeche[$i][1];
                    $Punkte_Verrundung_unten[$i][2][0] = "Verrundung_unten_E$i-P3";
                    $Punkte_Verrundung_unten[$i][2][1] = ($Punkte_Schnittflaeche[$i][1][1]+$Punkte_Blattflaeche[1][$i][count($Punkte_Blattflaeche[2][$i])-1][1])/2;
                    $Punkte_Verrundung_unten[$i][2][2] = ($Punkte_Schnittflaeche[$i][1][2]+$Punkte_Blattflaeche[1][$i][count($Punkte_Blattflaeche[2][$i])-1][2])/2+$a;
                    $Punkte_Verrundung_unten[$i][2][3] = ($Punkte_Schnittflaeche[$i][1][3]+$Punkte_Blattflaeche[1][$i][count($Punkte_Blattflaeche[2][$i])-1][3])/2;
                } else {
                    $Punkte_Verrundung_oben[$i][0] = $Punkte_Blattflaeche[2][$i][3];                //übernehmen der Punkte von Blattfläche, oben
                    $Punkte_Verrundung_oben[$i][0][0] = "Verrundung_oben_E$i-P1";
                    $Punkte_Verrundung_oben[$i][0][1] = $Punkte_Blattflaeche[2][$i][3][1];   //($Punkte_Blattflaeche[2][$i][3][1]+
                    $Punkte_Verrundung_oben[$i][0][2] = $Punkte_Blattflaeche[2][$i][3][2];  //($Punkte_Blattflaeche[2][$i][3][2]+ /2
                    $Punkte_Verrundung_oben[$i][0][3] = $Punkte_Blattflaeche[2][$i][3][3]-$b;  //($Punkte_Blattflaeche[2][$i][3][3]+ /2-0.4
        
                    $Punkte_Verrundung_oben[$i][1] = $Punkte_Blattflaeche[2][$i][4];
                    $Punkte_Verrundung_oben[$i][1][0] = "Verrundung_oben_E$i-P2";
        
                    $Punkte_Verrundung_oben[$i][2] = $Punkte_Schnittflaeche[$i][1];
                    $Punkte_Verrundung_oben[$i][2][0] = "Verrundung_oben_E$i-P3";
                    $Punkte_Verrundung_oben[$i][2][1] = ($Punkte_Schnittflaeche[$i][0][1]+$Punkte_Blattflaeche[2][$i][4][1])/2;     //bei 5 Punkten statt count($Punkte_Blattflaeche[2][$i])-1 Zahl 4 einsetzen (letzter Punkt der Ebene)
                    $Punkte_Verrundung_oben[$i][2][2] = ($Punkte_Schnittflaeche[$i][0][2]+$Punkte_Blattflaeche[2][$i][4][2])/2-$a;
                    $Punkte_Verrundung_oben[$i][2][3] = ($Punkte_Schnittflaeche[$i][0][3]+$Punkte_Blattflaeche[2][$i][4][3])/2;
                
                    $Punkte_Verrundung_unten[$i][0] = $Punkte_Blattflaeche[1][$i][3];                //übernehmen der Punkte von Blattfläche, unten
                    $Punkte_Verrundung_unten[$i][0][0] = "Verrundung_unten_E$i-P1";
                    $Punkte_Verrundung_unten[$i][0][1] =$Punkte_Blattflaeche[1][$i][3][1];      // ($Punkte_Blattflaeche[1][$i][3][1]+ /2
                    $Punkte_Verrundung_unten[$i][0][2] = $Punkte_Blattflaeche[1][$i][3][2];  // ($Punkte_Blattflaeche[1][$i][3][2]+ /2
                    $Punkte_Verrundung_unten[$i][0][3] = $Punkte_Blattflaeche[1][$i][3][3]+$b;  // ($Punkte_Blattflaeche[1][$i][3][3]+ /2+0.2
                    $Punkte_Verrundung_unten[$i][1] = $Punkte_Blattflaeche[1][$i][4];
                    $Punkte_Verrundung_unten[$i][1][0] = "Verrundung_unten_E$i-P2";
                    $Punkte_Verrundung_unten[$i][2] = $Punkte_Schnittflaeche[$i][1];
                    $Punkte_Verrundung_unten[$i][2][0] = "Verrundung_unten_E$i-P3";
                    $Punkte_Verrundung_unten[$i][2][1] = ($Punkte_Schnittflaeche[$i][1][1]+$Punkte_Blattflaeche[1][$i][4][1])/2;
                    $Punkte_Verrundung_unten[$i][2][2] = ($Punkte_Schnittflaeche[$i][1][2]+$Punkte_Blattflaeche[1][$i][4][2])/2+$a;
                    $Punkte_Verrundung_unten[$i][2][3] = ($Punkte_Schnittflaeche[$i][1][3]+$Punkte_Blattflaeche[1][$i][4][3])/2;
        
        
                }
                
              
            }

        //............................Tangentenrand.................................

            if ($Side == 'oben')                                                                //Offset für oben oder unten setzen um Spalt zu generieren
                {$Distanzflaechen_zOffset = 0.6;}     //0.6                       
            else
                {$Distanzflaechen_zOffset = -0.6;}
            $Distanzflaechen_yOffset = 2;
            $Distanzflaechen_xOffset = 2;



            if ($includeblock == "ja"){  
            
            for ($i = 0; $i < count($Punkte_Blattflaeche[0]); $i++){                        //Trennfläche_Tangentenrand_vorne    
                $a = $i+1;                                                                              //übernehmen der Punkte von Blattflächen
                $Punkte_Trennflaeche_Tangentenrand_vorne[$i][0] = $Punkte_Blattflaeche[0][$i][0];
                $Punkte_Trennflaeche_Tangentenrand_vorne[$i][0][3] = $Punkte_Trennflaeche_Tangentenrand_vorne[$i][0][3] +$zKW[$i];
            
                $Punkte_Trennflaeche_Tangentenrand_vorne[$i][0][0] = "Punkte_Tangentenrand_vorne_E$a-P1";
                $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1] = $Punkte_Trennflaeche_Tangentenrand_vorne[$i][0];
                $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][1] = $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][1];
                $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][2] =  $Punkte_Trennflaeche_Tangentenrand_vorne[$i][0][2]-$bTR;
                //$Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][3] = $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][3] - $zKW[$i]; 
                $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][0] = "Punkte_Tangentenrand_vorne_E$a-P2";
                
            }                      
            for ($i = 0; $i < count($Punkte_Blattflaeche[0]); $i++){                        //Trennflaeche_Tangentenrand_hinten    
                $a = $i+1;    
                
                $Punkte_Trennflaeche_Tangentenrand_hinten[$i][0] = $Punkte_Blattflaeche[3][$i][0];    //übernehmen der Punkte von Blattflächen 
                $Punkte_Trennflaeche_Tangentenrand_hinten[$i][0][0] = "Punkte_Tangentenrand_hinten_E$a-P1";
                if ($i == count($Punkte_Blattflaeche[0]) -1){                                                                                       //versetzen der letzten Stützpunkte in die Mitte der HK
                    $Punkte_Trennflaeche_Tangentenrand_hinten[$i][0][2] = ($Punkte_Blattflaeche[2][$i][0][2]+$Punkte_Blattflaeche[3][$i][0][2])/2;
                    $Punkte_Trennflaeche_Tangentenrand_hinten[$i][0][3] = ($Punkte_Blattflaeche[2][$i][0][3]+$Punkte_Blattflaeche[3][$i][0][3])/2;
                }
                $Punkte_Trennflaeche_Tangentenrand_hinten[$i][1] = $Punkte_Trennflaeche_Tangentenrand_hinten[$i][0];        
                $Punkte_Trennflaeche_Tangentenrand_hinten[$i][1][2] =  $Punkte_Trennflaeche_Tangentenrand_hinten[$i][0][2]+$bTR;
                $Punkte_Trennfläche_Tangentenrand_hinten[$i][1][0] = "Punkte_Tangentenrand_hinten_E$a-P2";
            }

            for ($i=0; $i < 5; $i++){         //Trennflaeche_Tangentenrand_vorne_rund
                $a = $i+1;
                if ($i == 0){
                    $x = -$R_F;
                    $y = 0;
                    $z = $z_E1;
                    $deltax = -$bTR;
                    $deltay = 0;
                } elseif ($i == 1){
                    $x = -$R_F;
                    $y = -$R_F*$Rf4;
                    $z = $z_E1;
                    $deltax = -$bTR;
                    $deltay = 0;
                } elseif ($i == 2){
                    $x = -$R_F*$Rf3;
                    $y = -$R_F*$Rf3;
                    $z = $z_E1;
                    $deltax = -$bTR;
                    $deltay = -$bTR;
                } elseif ($i == 3){
                    $x = -$R_F*$Rf4;
                    $y = -$R_F;
                    $z = $z_E1;
                    $deltax = 0;
                    $deltay = -$bTR;
                } elseif ($i == 4){
                    $x = 0;
                    $y = -$R_F;
                    $z = $z_E1;
                    $deltax = 0;
                    $deltay = -$bTR;
                }
                $Punkte_Trennflaeche_Tangentenrand_vorne_rund[$i][0][0] = "Trennflaeche_Tangentenrand_vorne_rund_E$a-P1";      //berechnen der P1 für jede Ebene
                $Punkte_Trennflaeche_Tangentenrand_vorne_rund[$i][0][1] = $x;
                $Punkte_Trennflaeche_Tangentenrand_vorne_rund[$i][0][2] = $y*cos($RotationAngle) - $z*sin($RotationAngle) + $p_w;
                $Punkte_Trennflaeche_Tangentenrand_vorne_rund[$i][0][3] = $z*cos($RotationAngle) + $y*sin($RotationAngle);

                $Punkte_Trennflaeche_Tangentenrand_vorne_rund[$i][1] = $Punkte_Trennflaeche_Tangentenrand_vorne_rund[$i][0];       //P2 mit Abstand zu P1
                $Punkte_Trennflaeche_Tangentenrand_vorne_rund[$i][1][0] = "Trennflaeche_Tangentenrand_vorne_rund_E$a-P2";
                $Punkte_Trennflaeche_Tangentenrand_vorne_rund[$i][1][1] = $Punkte_Trennflaeche_Tangentenrand_vorne_rund[$i][0][1]+$deltax;
                $Punkte_Trennflaeche_Tangentenrand_vorne_rund[$i][1][2] = $Punkte_Trennflaeche_Tangentenrand_vorne_rund[$i][0][2]+$deltay;
            }

            
                //Drehung um y-Achse
            for ($i=0; $i < 5; $i++){ 
                for ($j = 0; $j < 2; $j++){
                    $deltax = $Punkte_Trennflaeche_Tangentenrand_vorne_rund[$i][$j][1]- $x_RPS; // $x_RPS -  Abstand zwischen Punkt und Drehachse (Achse liegt bei RPS)
                    $Punkte_Trennflaeche_Tangentenrand_vorne_rund[$i][$j][1] = $deltax*cos($Cone_Angle)-$Punkte_Trennflaeche_Tangentenrand_vorne_rund[$i][$j][3]*sin($Cone_Angle);    //Drehung um y-Achse
                    $Punkte_Trennflaeche_Tangentenrand_vorne_rund[$i][$j][3] = $deltax*sin($Cone_Angle)+$Punkte_Trennflaeche_Tangentenrand_vorne_rund[$i][$j][3]*cos($Cone_Angle);
                    $Punkte_Trennflaeche_Tangentenrand_vorne_rund[$i][$j][1] = $Punkte_Trennflaeche_Tangentenrand_vorne_rund[$i][$j][1] +$x_RPS;
                }
            }
            




            for ($i=0; $i < 5; $i++){         //Trennflaeche_Tangentenrand_hinten_rund
                $a = $i+1;
                if ($i == 0){
                    $x = -$R_F;
                    $y = 0;
                    $z = $z_E3;
                    $deltax = -$bTR;
                    $deltay = 0;
                } elseif ($i == 1){
                    $x = -$R_F;
                    $y = $R_F*$Rf4;
                    $z = $z_E3;
                    $deltax = -$bTR;
                    $deltay = 0;
                } elseif ($i == 2){
                    $x = -$R_F*$Rf3;
                    $y = $R_F*$Rf3;
                    $z = $z_E3;
                    $deltax = -$bTR;
                    $deltay = $bTR;
                } elseif ($i == 3){
                    $x = -$R_F*$Rf4;
                    $y = $R_F;
                    $z = $z_E3;
                    $deltax = 0;
                    $deltay = $bTR;
                } elseif ($i == 4){
                    $x = 0;
                    $y = $R_F;
                    $z = $z_E3;
                    $deltax = 0;
                    $deltay = $bTR;
                }
                $Punkte_Trennflaeche_Tangentenrand_hinten_rund[$i][0][0] = "Trennflaeche_Tangentenrand_hinten_rund_E$a-P1";      //berechnen der P1 für jede Ebene
                $Punkte_Trennflaeche_Tangentenrand_hinten_rund[$i][0][1] = $x;
                $Punkte_Trennflaeche_Tangentenrand_hinten_rund[$i][0][2] = $y*cos($RotationAngle) - $z*sin($RotationAngle) + $p_w;
                $Punkte_Trennflaeche_Tangentenrand_hinten_rund[$i][0][3] = $z*cos($RotationAngle) + $y*sin($RotationAngle);

                $Punkte_Trennflaeche_Tangentenrand_hinten_rund[$i][1] = $Punkte_Trennflaeche_Tangentenrand_hinten_rund[$i][0];       //P2 mit Abstand zu P1
                $Punkte_Trennflaeche_Tangentenrand_hinten_rund[$i][1][0] = "Trennflaeche_Tangentenrand_hinten_rund_E$a-P2";
                $Punkte_Trennflaeche_Tangentenrand_hinten_rund[$i][1][1] = $Punkte_Trennflaeche_Tangentenrand_hinten_rund[$i][0][1]+$deltax;
                $Punkte_Trennflaeche_Tangentenrand_hinten_rund[$i][1][2] = $Punkte_Trennflaeche_Tangentenrand_hinten_rund[$i][0][2]+$deltay;
            }
                //Drehung um y-Achse
            for ($i=0; $i < 5; $i++){ 
                for ($j = 0; $j < 2; $j++){
                    $deltax = $Punkte_Trennflaeche_Tangentenrand_hinten_rund[$i][$j][1]- $x_RPS; // $x_RPS -  Abstand zwischen Punkt und Drehachse (Achse liegt bei RPS)
                    $Punkte_Trennflaeche_Tangentenrand_hinten_rund[$i][$j][1] = $deltax*cos($Cone_Angle)-$Punkte_Trennflaeche_Tangentenrand_hinten_rund[$i][$j][3]*sin($Cone_Angle);    //Drehung um y-Achse
                    $Punkte_Trennflaeche_Tangentenrand_hinten_rund[$i][$j][3] = $deltax*sin($Cone_Angle)+$Punkte_Trennflaeche_Tangentenrand_hinten_rund[$i][$j][3]*cos($Cone_Angle);
                    $Punkte_Trennflaeche_Tangentenrand_hinten_rund[$i][$j][1] = $Punkte_Trennflaeche_Tangentenrand_hinten_rund[$i][$j][1] +$x_RPS;
                }
            }
            
            for ($i = 0; $i<2; $i++){                 //Trennflaeche_Tangentenrand_Stufe
                    $Punkte_Trennflaeche_Tangentenrand_Stufe[$i][0] = $Punkte_Trennflaeche_Tangentenrand_hinten_rund[0][$i];
                    $Punkte_Trennflaeche_Tangentenrand_Stufe[$i][0][0] = "Trennflaeche_Tangentenrand_Stufe_E$i-P1";
                    
                    $Punkte_Trennflaeche_Tangentenrand_Stufe[$i][1] = $Punkte_Trennflaeche_Tangentenrand_Stufe[$i][0];
                    $Punkte_Trennflaeche_Tangentenrand_Stufe[$i][1][2] = $Punkte_Trennflaeche_Tangentenrand_Stufe[$i][0][2]+$Distanzflaechen_zOffset;
                    $Punkte_Trennflaeche_Tangentenrand_Stufe[$i][1][0] = "Trennflaeche_Tangentenrand_Stufe_E$i-P2";


                    $Punkte_Trennflaeche_Tangentenrand_Stufe[$i][3] = $Punkte_Trennflaeche_Tangentenrand_vorne_rund[0][$i];
                    $Punkte_Trennflaeche_Tangentenrand_Stufe[$i][3][0] = "Trennflaeche_Tangentenrand_Stufe_E$i-P4";

                    $Punkte_Trennflaeche_Tangentenrand_Stufe[$i][2] = $Punkte_Trennflaeche_Tangentenrand_Stufe[$i][3];
                    $Punkte_Trennflaeche_Tangentenrand_Stufe[$i][2][2] = $Punkte_Trennflaeche_Tangentenrand_Stufe[$i][3][2]+$Distanzflaechen_zOffset;
                    $Punkte_Trennflaeche_Tangentenrand_Stufe[$i][2][0] = "Trennflaeche_Tangentenrand_Stufe_E$i-P3";
            }
            

            
            
            
            
            
            
            
            
            
        //............................Blockrand.....................................
                                                                                        
            $Punkte_Trennflaeche_Blockrand[0][0][0] = "Trennflaeche_Blockrand-E1-P1";       //Trennfläche_Blockrand setzen der Blockrand Punkte                       
            $Punkte_Trennflaeche_Blockrand[0][0][1] = $P0B[0];
            $Punkte_Trennflaeche_Blockrand[0][0][2] = $P0B[1];
            $Punkte_Trennflaeche_Blockrand[0][0][3] = 0;

            $Punkte_Trennflaeche_Blockrand[0][1][0] = "Trennflaeche_Blockrand-E1-P2";
            $Punkte_Trennflaeche_Blockrand[0][1][1] = $P0B[0];
            $Punkte_Trennflaeche_Blockrand[0][1][2] = $P0B[1]-$bB;
            $Punkte_Trennflaeche_Blockrand[0][1][3] = 0;

            $Punkte_Trennflaeche_Blockrand[3][1][0] = "Trennflaeche_Blockrand-E4-P2";
            $Punkte_Trennflaeche_Blockrand[3][1][1] = $P0B[0];
            $Punkte_Trennflaeche_Blockrand[3][1][2] = $P0B[1]+$bB-$PB[1];
            $Punkte_Trennflaeche_Blockrand[3][1][3] = 0;

            $Punkte_Trennflaeche_Blockrand[3][0][0] = "Trennflaeche_Blockrand-E4-P1";
            $Punkte_Trennflaeche_Blockrand[3][0][1] = $P0B[0];
            $Punkte_Trennflaeche_Blockrand[3][0][2] = $P0B[1]-$PB[1];
            $Punkte_Trennflaeche_Blockrand[3][0][3] = 0;


            $Punkte_Trennflaeche_Blockrand[1][0] = $Punkte_Trennflaeche_Blockrand[0][0];
            $Punkte_Trennflaeche_Blockrand[1][0][1] = $Punkte_Trennflaeche_Blockrand[0][0][1]*1-$PB[0];
            $Punkte_Trennflaeche_Blockrand[2][0][0] = "Trennflaeche_Blockrand-E2-P1";


            $Punkte_Trennflaeche_Blockrand[1][1] = $Punkte_Trennflaeche_Blockrand[0][1];
            $Punkte_Trennflaeche_Blockrand[1][1][1] = $Punkte_Trennflaeche_Blockrand[0][0][1]-$PB[0]+$bB;
            $Punkte_Trennflaeche_Blockrand[1][1][0] = "Trennflaeche_Blockrand-E2-P2";


            $Punkte_Trennflaeche_Blockrand[2][1] = $Punkte_Trennflaeche_Blockrand[3][1];
            $Punkte_Trennflaeche_Blockrand[2][1][1] = $Punkte_Trennflaeche_Blockrand[3][1][1]-$PB[0]+$bB;
            $Punkte_Trennflaeche_Blockrand[2][1][0] = "Trennflaeche_Blockrand-E3-P2";


            $Punkte_Trennflaeche_Blockrand[2][0] = $Punkte_Trennflaeche_Blockrand[3][0];
            $Punkte_Trennflaeche_Blockrand[2][0][1] = $Punkte_Trennflaeche_Blockrand[3][0][1]-$PB[0];
            $Punkte_Trennflaeche_Blockrand[2][0][0] = "Trennflaeche_Blockrand-E3-P1";
        //............................Blockrand_aussen.....................................
                                                                                            
            for ($i = 0; $i < 4; $i++){
                $a = $i+1;
                $Punkte_Trennflaeche_Blockrand_aussen[$i][0] = $Punkte_Trennflaeche_Blockrand[$i][0]; //übernehmen von Trennfläche_Blockrand 
                $Punkte_Trennflaeche_Blockrand_aussen[$i][0][0] = "Trennflaeche_Blockrand_außen-E$a-P1";
                if ($i == 0){
                    $b = 0;
                    $c = $DFB;
                } elseif ($i == 1){
                    $b = -$DFB;
                    $c = $DFB;
                } elseif ($i == 2){
                    $b = -$DFB;
                    $c = -$DFB;
                }  elseif ($i == 3){
                    $b = 0;
                    $c = -$DFB;            
                }
                $Punkte_Trennflaeche_Blockrand_aussen[$i][1] = $Punkte_Trennflaeche_Blockrand[$i][0];
                $Punkte_Trennflaeche_Blockrand_aussen[$i][1][1] = $Punkte_Trennflaeche_Blockrand[$i][0][1] + $b;
                $Punkte_Trennflaeche_Blockrand_aussen[$i][1][2] = $Punkte_Trennflaeche_Blockrand[$i][0][2] + $c;
                $Punkte_Trennflaeche_Blockrand_aussen[$i][1][0] = "Trennflaeche_Blockrand_außen-E$a-P2";               
            }


        //............................Distanzflächen................................
            $mplus1 = count($Punkte_Trennflaeche_Tangentenrand_vorne); 

            for ($i=0; $i < $mplus1; $i++){                                                     //Schleife zum Durchlaufen der Ebenen, übernommen von Blattflaeche_Hauptflaeche
                $b = $i +1;

                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P6";                 //P6 mit x-Werten der Ebenen von Tangentenrand vorne ind y,z von Blockrand
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5][1] = $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][1];       
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5][2]= $Punkte_Trennflaeche_Blockrand[3][1][2];
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5][3]= $Punkte_Trennflaeche_Blockrand[3][1][3];
                
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5]; //P5  mit versetzter y-Koordinate
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P5";
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4][2] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4][2]+ $Distanzflaechen_yOffset;
                    
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][3] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4]; //P4  mit versetzter z-Koordinate
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][3][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P4";
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][3][3] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][3][3] + $Distanzflaechen_zOffset;

                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][0] = $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1];
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][0][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P1"; //P1 aufBlockrand

                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][1] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][0]; //P2  mit versetzter y-Koordinate
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][1][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P2";
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][1][2] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][0][2]- $Distanzflaechen_yOffset;


                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][2] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][1]; //P3  mit versetzter z-Koordinate
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][2][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P3";
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][2][3] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][1][3] + $Distanzflaechen_zOffset;
            }

            $mplus1 = count($Punkte_Trennflaeche_Tangentenrand_vorne_rund);
            for ($i=0; $i < $mplus1; $i++){                                                     //$Punkte_Trennflaeche_Tangentenrand_vorne_rund
                $b = $i +1;
                if ($i<2){
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][5][0] = "Distanzflaeche_Rundung_vorne-E$b-P6";                 //P6 mit x-Werten der Ebenen von Tangentenrand vorne ind y,z von Blockrand
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][5][1] = $Punkte_Trennflaeche_Blockrand[1][1][1];       
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][5][2]= ($Punkte_Trennflaeche_Tangentenrand_vorne_rund[$i][0][2]+$Punkte_Trennflaeche_Tangentenrand_hinten_rund[$i][0][2])/2;
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][5][3]= $Punkte_Trennflaeche_Blockrand[3][1][3];
                    
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][4] = $Punkte_Distanzflaeche_Rundung_vorne[$i][5]; //P5  mit versetzter y-Koordinate
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][4][0] = "Distanzflaeche_Rundung_vorne-E$b-P5";
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][4][1] = $Punkte_Distanzflaeche_Rundung_vorne[$i][4][1]+ $Distanzflaechen_yOffset;
                        
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][3] = $Punkte_Distanzflaeche_Rundung_vorne[$i][4]; //P4  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][3][0] = "Distanzflaeche_Rundung_vorne-E$b-P4";
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][3][3] = $Punkte_Distanzflaeche_Rundung_vorne[$i][3][3] + $Distanzflaechen_zOffset;

                    $Punkte_Distanzflaeche_Rundung_vorne[$i][0] = $Punkte_Trennflaeche_Tangentenrand_vorne_rund[$i][1];
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][0][0] = "Distanzflaeche_Rundung_vorne-E$b-P1"; //P1 aufBlockrand

                    $Punkte_Distanzflaeche_Rundung_vorne[$i][1] = $Punkte_Distanzflaeche_Rundung_vorne[$i][0]; //P2  mit versetzter x-Koordinate
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][1][0] = "Distanzflaeche_Rundung_vorne-E$b-P2";
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][1][1] = $Punkte_Distanzflaeche_Rundung_vorne[$i][0][1]- $Distanzflaechen_yOffset;


                    $Punkte_Distanzflaeche_Rundung_vorne[$i][2] = $Punkte_Distanzflaeche_Rundung_vorne[$i][1]; //P3  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][2][0] = "Distanzflaeche_Rundung_vorne-E$b-P3";
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][2][3] = $Punkte_Distanzflaeche_Rundung_vorne[$i][1][3] + $Distanzflaechen_zOffset;
                } elseif ($i == 2){
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][5][0] = "Distanzflaeche_Rundung_vorne-E$b-P6";                 //P6 mit x-Werten der Ebenen von Tangentenrand vorne ind y,z von Blockrand
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][5][1] = $Punkte_Trennflaeche_Blockrand[1][1][1];       
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][5][2]= $Punkte_Trennflaeche_Blockrand[3][1][2];
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][5][3]= $Punkte_Trennflaeche_Blockrand[3][1][3];
                    
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][4] = $Punkte_Distanzflaeche_Rundung_vorne[$i][5]; //P5  mit versetzter x und y-Koordinate
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][4][0] = "Distanzflaeche_Rundung_vorne-E$b-P5";
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][4][2] = $Punkte_Distanzflaeche_Rundung_vorne[$i][4][2]+ $Distanzflaechen_yOffset;
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][4][1] = $Punkte_Distanzflaeche_Rundung_vorne[$i][4][1]+ $Distanzflaechen_yOffset;
                        
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][3] = $Punkte_Distanzflaeche_Rundung_vorne[$i][4]; //P4  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][3][0] = "Distanzflaeche_Rundung_vorne-E$b-P4";
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][3][3] = $Punkte_Distanzflaeche_Rundung_vorne[$i][3][3] + $Distanzflaechen_zOffset;

                    $Punkte_Distanzflaeche_Rundung_vorne[$i][0] = $Punkte_Trennflaeche_Tangentenrand_vorne_rund[$i][1];
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][0][0] = "Distanzflaeche_Rundung_vorne-E$b-P1"; //P1 aufBlockrand

                    $Punkte_Distanzflaeche_Rundung_vorne[$i][1] = $Punkte_Distanzflaeche_Rundung_vorne[$i][0]; //P2  mit versetzter x und y-Koordinate
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][1][0] = "Distanzflaeche_Rundung_vorne-E$b-P2";
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][1][2] = $Punkte_Distanzflaeche_Rundung_vorne[$i][0][2]- $Distanzflaechen_yOffset;


                    $Punkte_Distanzflaeche_Rundung_vorne[$i][2] = $Punkte_Distanzflaeche_Rundung_vorne[$i][1]; //P3  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][2][0] = "Distanzflaeche_Rundung_vorne-E$b-P3";
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][2][3] = $Punkte_Distanzflaeche_Rundung_vorne[$i][1][3] + $Distanzflaechen_zOffset;
                } elseif ($i > 2){
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][5][0] = "Distanzflaeche_Rundung_vorne-E$b-P6";                 //P6 mit x-Werten der Ebenen von Tangentenrand vorne ind y,z von Blockrand
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][5][1] = $Punkte_Trennflaeche_Tangentenrand_vorne_rund[$i][1][1];       
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][5][2]= $Punkte_Trennflaeche_Blockrand[3][1][2];
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][5][3]= $Punkte_Trennflaeche_Blockrand[3][1][3];
                    
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][4] = $Punkte_Distanzflaeche_Rundung_vorne[$i][5]; //P5  mit versetzter x-Koordinate
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][4][0] = "Distanzflaeche_Rundung_vorne-E$b-P5";
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][4][2] = $Punkte_Distanzflaeche_Rundung_vorne[$i][4][2]+ $Distanzflaechen_yOffset;
                        
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][3] = $Punkte_Distanzflaeche_Rundung_vorne[$i][4]; //P4  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][3][0] = "Distanzflaeche_Rundung_vorne-E$b-P4";
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][3][3] = $Punkte_Distanzflaeche_Rundung_vorne[$i][3][3] + $Distanzflaechen_zOffset;

                    $Punkte_Distanzflaeche_Rundung_vorne[$i][0] = $Punkte_Trennflaeche_Tangentenrand_vorne_rund[$i][1];
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][0][0] = "Distanzflaeche_Rundung_vorne-E$b-P1"; //P1 aufBlockrand

                    $Punkte_Distanzflaeche_Rundung_vorne[$i][1] = $Punkte_Distanzflaeche_Rundung_vorne[$i][0]; //P2  mit versetzter y-Koordinate
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][1][0] = "Distanzflaeche_Rundung_vorne-E$b-P2";
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][1][2] = $Punkte_Distanzflaeche_Rundung_vorne[$i][0][2]- $Distanzflaechen_yOffset;


                    $Punkte_Distanzflaeche_Rundung_vorne[$i][2] = $Punkte_Distanzflaeche_Rundung_vorne[$i][1]; //P3  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][2][0] = "Distanzflaeche_Rundung_vorne-E$b-P3";
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][2][3] = $Punkte_Distanzflaeche_Rundung_vorne[$i][1][3] + $Distanzflaechen_zOffset;
                } 
                if ($i == 1 or $i == 3){
                                                                                                                            //überschreiben P4-P6 und verlegen in Blockrand Ecke (wie mittlerer Spline)
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][5][1] = $Punkte_Trennflaeche_Blockrand[1][1][1];
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][5][2]= $Punkte_Trennflaeche_Blockrand[3][1][2];
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][5][3]= $Punkte_Trennflaeche_Blockrand[3][1][3];
                    
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][4] = $Punkte_Distanzflaeche_Rundung_vorne[$i][5]; //P5  mit versetzter x und y-Koordinate
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][4][2] = $Punkte_Distanzflaeche_Rundung_vorne[$i][4][2]+ $Distanzflaechen_yOffset;
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][4][1] = $Punkte_Distanzflaeche_Rundung_vorne[$i][4][1]+ $Distanzflaechen_yOffset;
                        
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][3] = $Punkte_Distanzflaeche_Rundung_vorne[$i][4]; //P4  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][3][3] = $Punkte_Distanzflaeche_Rundung_vorne[$i][3][3] + $Distanzflaechen_zOffset;
                }
            }



            $mplus1 = count($Punkte_Trennflaeche_Tangentenrand_hinten_rund);
            for ($i=0; $i < $mplus1; $i++){                                                     //$Punkte_Trennflaeche_Tangentenrand_vorne_rund
                $b = $i +1;
                if ($i<2){
                    if ($i==0){
                        $Punkte_Distanzflaeche_Rundung_hinten[$i][5][2]= $Punkte_Distanzflaeche_Rundung_vorne[$i][5][2];
                    } else {
                        $Punkte_Distanzflaeche_Rundung_hinten[$i][5][2]= $Punkte_Trennflaeche_Tangentenrand_hinten_rund[$i][1][2];
                    }
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][5][0] = "Distanzflaeche_Rundung_hinten-E$b-P6";                 //P6 mit x-Werten der Ebenen von Tangentenrand hinten ind y,z von Blockrand
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][5][1] = $Punkte_Trennflaeche_Blockrand[1][1][1];       
                    
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][5][3]= $Punkte_Trennflaeche_Blockrand[1][1][3];
                    
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][4] = $Punkte_Distanzflaeche_Rundung_hinten[$i][5]; //P5  mit versetzter y-Koordinate
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][4][0] = "Distanzflaeche_Rundung_hinten-E$b-P5";
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][4][1] = $Punkte_Distanzflaeche_Rundung_hinten[$i][4][1]+ $Distanzflaechen_yOffset;
                        
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][3] = $Punkte_Distanzflaeche_Rundung_hinten[$i][4]; //P4  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][3][0] = "Distanzflaeche_Rundung_hinten-E$b-P4";
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][3][3] = $Punkte_Distanzflaeche_Rundung_hinten[$i][3][3] + $Distanzflaechen_zOffset;

                    $Punkte_Distanzflaeche_Rundung_hinten[$i][0] = $Punkte_Trennflaeche_Tangentenrand_hinten_rund[$i][1];
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][0][0] = "Distanzflaeche_Rundung_hinten-E$b-P1"; //P1 aufBlockrand

                    $Punkte_Distanzflaeche_Rundung_hinten[$i][1] = $Punkte_Distanzflaeche_Rundung_hinten[$i][0]; //P2  mit versetzter x-Koordinate
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][1][0] = "Distanzflaeche_Rundung_hinten-E$b-P2";
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][1][1] = $Punkte_Distanzflaeche_Rundung_hinten[$i][0][1]- $Distanzflaechen_yOffset;


                    $Punkte_Distanzflaeche_Rundung_hinten[$i][2] = $Punkte_Distanzflaeche_Rundung_hinten[$i][1]; //P3  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][2][0] = "Distanzflaeche_Rundung_hinten-E$b-P3";
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][2][3] = $Punkte_Distanzflaeche_Rundung_hinten[$i][1][3] + $Distanzflaechen_zOffset;
                
                } elseif ($i == 2){
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][5][0] = "Distanzflaeche_Rundung_hinten-E$b-P6";                 //P6 mit x-Werten der Ebenen von Tangentenrand hinten ind y,z von Blockrand
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][5][1] = $Punkte_Trennflaeche_Blockrand[1][1][1];       
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][5][2]= $Punkte_Trennflaeche_Blockrand[1][1][2];
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][5][3]= $Punkte_Trennflaeche_Blockrand[1][1][3];
                    
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][4] = $Punkte_Distanzflaeche_Rundung_hinten[$i][5]; //P5  mit versetzter x und y-Koordinate
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][4][0] = "Distanzflaeche_Rundung_hinten-E$b-P5";
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][4][2] = $Punkte_Distanzflaeche_Rundung_hinten[$i][4][2]- $Distanzflaechen_yOffset;
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][4][1] = $Punkte_Distanzflaeche_Rundung_hinten[$i][4][1]+ $Distanzflaechen_yOffset;
                        
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][3] = $Punkte_Distanzflaeche_Rundung_hinten[$i][4]; //P4  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][3][0] = "Distanzflaeche_Rundung_hinten-E$b-P4";
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][3][3] = $Punkte_Distanzflaeche_Rundung_hinten[$i][3][3] + $Distanzflaechen_zOffset;

                    $Punkte_Distanzflaeche_Rundung_hinten[$i][0] = $Punkte_Trennflaeche_Tangentenrand_hinten_rund[$i][1];
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][0][0] = "Distanzflaeche_Rundung_hinten-E$b-P1"; //P1 aufBlockrand

                    $Punkte_Distanzflaeche_Rundung_hinten[$i][1] = $Punkte_Distanzflaeche_Rundung_hinten[$i][0]; //P2  mit versetzter x und y-Koordinate
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][1][0] = "Distanzflaeche_Rundung_hinten-E$b-P2";
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][1][2] = $Punkte_Distanzflaeche_Rundung_hinten[$i][0][2]+ $Distanzflaechen_yOffset;


                    $Punkte_Distanzflaeche_Rundung_hinten[$i][2] = $Punkte_Distanzflaeche_Rundung_hinten[$i][1]; //P3  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][2][0] = "Distanzflaeche_Rundung_hinten-E$b-P3";
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][2][3] = $Punkte_Distanzflaeche_Rundung_hinten[$i][1][3] + $Distanzflaechen_zOffset;
                } elseif ($i > 2){
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][5][0] = "Distanzflaeche_Rundung_hinten-E$b-P6";                 //P6 mit x-Werten der Ebenen von Tangentenrand hinten ind y,z von Blockrand
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][5][1] = $Punkte_Trennflaeche_Tangentenrand_hinten_rund[$i][1][1];       
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][5][2]= $Punkte_Trennflaeche_Blockrand[1][1][2];
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][5][3]= $Punkte_Trennflaeche_Blockrand[1][1][3];
                    
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][4] = $Punkte_Distanzflaeche_Rundung_hinten[$i][5]; //P5  mit versetzter x-Koordinate
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][4][0] = "Distanzflaeche_Rundung_hinten-E$b-P5";
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][4][2] = $Punkte_Distanzflaeche_Rundung_hinten[$i][4][2]- $Distanzflaechen_yOffset;
                        
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][3] = $Punkte_Distanzflaeche_Rundung_hinten[$i][4]; //P4  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][3][0] = "Distanzflaeche_Rundung_hinten-E$b-P4";
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][3][3] = $Punkte_Distanzflaeche_Rundung_hinten[$i][3][3] + $Distanzflaechen_zOffset;

                    $Punkte_Distanzflaeche_Rundung_hinten[$i][0] = $Punkte_Trennflaeche_Tangentenrand_hinten_rund[$i][1];
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][0][0] = "Distanzflaeche_Rundung_hinten-E$b-P1"; //P1 aufBlockrand

                    $Punkte_Distanzflaeche_Rundung_hinten[$i][1] = $Punkte_Distanzflaeche_Rundung_hinten[$i][0]; //P2  mit versetzter y-Koordinate
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][1][0] = "Distanzflaeche_Rundung_hinten-E$b-P2";
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][1][2] = $Punkte_Distanzflaeche_Rundung_hinten[$i][0][2]+ $Distanzflaechen_yOffset;


                    $Punkte_Distanzflaeche_Rundung_hinten[$i][2] = $Punkte_Distanzflaeche_Rundung_hinten[$i][1]; //P3  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][2][0] = "Distanzflaeche_Rundung_hinten-E$b-P3";
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][2][3] = $Punkte_Distanzflaeche_Rundung_hinten[$i][1][3] + $Distanzflaechen_zOffset;
                } 
                if ($i == 1 or $i == 3){
                                                                                                                            //überschreiben P4-P6 und verlegen in Blockrand Ecke (wie mittlerer Spline)
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][5][1] = $Punkte_Trennflaeche_Blockrand[1][1][1];
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][5][2]= $Punkte_Trennflaeche_Blockrand[1][1][2];
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][5][3]= $Punkte_Trennflaeche_Blockrand[1][1][3];
                    
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][4] = $Punkte_Distanzflaeche_Rundung_hinten[$i][5]; //P5  mit versetzter x und y-Koordinate
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][4][2] = $Punkte_Distanzflaeche_Rundung_hinten[$i][4][2]- $Distanzflaechen_yOffset;
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][4][1] = $Punkte_Distanzflaeche_Rundung_hinten[$i][4][1]+ $Distanzflaechen_yOffset;
                        
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][3] = $Punkte_Distanzflaeche_Rundung_hinten[$i][4]; //P4  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][3][3] = $Punkte_Distanzflaeche_Rundung_hinten[$i][3][3] + $Distanzflaechen_zOffset;
                }
            }








            $mplus1 = count($Punkte_Trennflaeche_Tangentenrand_hinten);                          //Trennflaeche_Tangentenrand_vorne
            for ($i=0; $i < $mplus1; $i++){                                                     //Schleife zum Durchlaufen der Ebenen, übernommen von Blattflaeche_Hauptflaeche
                $b = $i +1;

                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][5][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P6";                 //P6 mit x-Werten der Ebenen von Tangentenrand vorne ind y,z von Blockrand
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][5][1] = $Punkte_Trennflaeche_Tangentenrand_hinten[$i][1][1];       
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][5][2]= $Punkte_Trennflaeche_Blockrand[1][1][2];
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][5][3]= $Punkte_Trennflaeche_Blockrand[1][1][3];
                
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][5]; //P5  mit versetzter y-Koordinate
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P5";
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4][2] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4][2]- $Distanzflaechen_yOffset;
                    
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][3] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4]; //P4  mit versetzter z-Koordinate
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][3][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P4";
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][3][3] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][3][3] + $Distanzflaechen_zOffset;

                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0] = $Punkte_Trennflaeche_Tangentenrand_hinten[$i][1];
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P1"; //P1 aufBlockrand

                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0]; //P2  mit versetzter y-Koordinate
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P2";
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1][2] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0][2]+ $Distanzflaechen_yOffset;


                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][2] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1]; //P3  mit versetzter z-Koordinate
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][2][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P3";
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][2][3] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1][3] + $Distanzflaechen_zOffset;
            }
            for ($i =0; $i < count($Punkte_Distanzflaeche_Hauptflaeche_hinten[0]);$i++){                   //Distanzflaeche_Stufe
                $a = $i+1;
                $Punkte_Distanzflaeche_Stufe[$i][0] = $Punkte_Distanzflaeche_Rundung_hinten[0][$i];    // Punkte übernehmen von Distanzflaeche_Hauptflaeche_hinten und Distanzflaeche_Hauptflaeche_vorne
                $Punkte_Distanzflaeche_Stufe[$i][0][0] = "Punkte_Distanzflaeche_Stufe_E$a-P1";
                $Punkte_Distanzflaeche_Stufe[$i][1] = $Punkte_Distanzflaeche_Rundung_vorne[0][$i];
                $Punkte_Distanzflaeche_Stufe[$i][1][0] = "Punkte_Distanzflaeche_Stufe_E$a-P2";
                for ($j = 0; $j < count($Punkte_Distanzflaeche_Stufe[0]); $j++){                                                            //y-Verschiebung um Klemmen der Stufe zu verhindern
                    $Punkte_Distanzflaeche_Stufe[$i][$j][2] = $Punkte_Distanzflaeche_Stufe[$i][$j][2] + $Distanzflaechen_zOffset;
                }

            }   
            



        //............................Zentrierung_Konus.............................
            //if ($Side == "oben"){
                $Punkte_Zentrierung_Konus[0][0][0] = "Zentrierung_Konus E1-P1";                               //Mittelpunkte Kreis 1, kleiner Kreis
                $Punkte_Zentrierung_Konus[0][0][1] = $Punkte_Trennflaeche_Blockrand[1][1][1]+$PZK[0];  
                $Punkte_Zentrierung_Konus[0][0][2] = $Punkte_Trennflaeche_Blockrand[1][1][2]-$PZK[1];
                $Punkte_Zentrierung_Konus[0][0][3] = $PZK[2];
                                    
                $Punkte_Zentrierung_Konus[0][1] =   $Punkte_Zentrierung_Konus[0][0];         //E1P2 Punkt auf Kreis 1 
                $Punkte_Zentrierung_Konus[0][1][0] = "Zentrierung_Konus E1-P2"; 
                $Punkte_Zentrierung_Konus[0][1][1] = $Punkte_Zentrierung_Konus[0][0][1]+10;     

                $Punkte_Zentrierung_Konus[1][0] =   $Punkte_Zentrierung_Konus[0][0];         //E2P1 Mittelpunkt Kreis 2 
                $Punkte_Zentrierung_Konus[1][0][0] = "Zentrierung_Konus E2-P1"; 
                $Punkte_Zentrierung_Konus[1][0][3] = $Punkte_Zentrierung_Konus[1][0][3]-30;

                $Punkte_Zentrierung_Konus[1][1] =   $Punkte_Zentrierung_Konus[1][0];         //E2P2 Punkt auf Kreis 2
                $Punkte_Zentrierung_Konus[1][1][0] = "Zentrierung_Konus E2-P2"; 
                $Punkte_Zentrierung_Konus[1][1][1] = $Punkte_Zentrierung_Konus[1][0][1]+10;


        } //Ende includeBlock  if Abfrage     
        //............................Output........................................
            $Points[0][0] = $Punkte_Flanschflaeche[0];
            $Points[1][0] = $Punkte_Flanschflaeche[1];
            $Points[2][0] = $Punkte_Flanschflaeche[2];
            $Points[3][0] = $Punkte_Flanschflaeche[3];
            $Points[4][0] = $Punkte_Verbindungsflaeche_1_2_aussen;
            $Points[5][0] = $Punkte_Verbindungsflaeche_1_2_stufe;
            $Points[6][0] = $Punkte_Verbindungsflaeche_2_3_aussen;
            $Points[7][0] = $Punkte_Verbindungsflaeche_2_3_stufe;

            $Points[8][0] = $Punkte_Blattflaeche[0];
            $Points[9][0] = $Punkte_Blattflaeche[1];
            $Points[10][0] = $Punkte_Blattflaeche[2];
            $Points[11][0] = $Punkte_Blattflaeche[3];

            $Points[12][0] = $Punkte_Schnittflaeche;
            $Points[13][0] = $Punkte_Kantenflaeche_HK;
            $Points[14][0] = $Punkte_Kantenflaeche_VK;
            $Points[15][0] = $Punkte_Verrundung_oben;
            $Points[16][0] = $Punkte_Verrundung_unten;
            if ($includeblock == "ja"){
            $Points[17][0] = $Punkte_Trennflaeche_Tangentenrand_vorne;
            $Points[18][0] = $Punkte_Trennflaeche_Tangentenrand_hinten;
            $Points[19][0] =  $Punkte_Trennflaeche_Tangentenrand_vorne_rund;
            $Points[20][0] =  $Punkte_Trennflaeche_Tangentenrand_hinten_rund;
            $Points[21][0] =  $Punkte_Trennflaeche_Tangentenrand_Stufe;
            $Points[22][0] = $Punkte_Trennflaeche_Blockrand;
            $Points[23][0] = $Punkte_Distanzflaeche_Hauptflaeche_vorne;
            $Points[24][0] = $Punkte_Distanzflaeche_Hauptflaeche_hinten;
            $Points[25][0] = $Punkte_Distanzflaeche_Rundung_vorne;
            $Points[26][0] = $Punkte_Distanzflaeche_Rundung_hinten;
            $Points[27][0] = $Punkte_Distanzflaeche_Stufe;
            $Points[28][0] = $Punkte_Trennflaeche_Blockrand_aussen;
            $Points[29][0] = $Punkte_Zentrierung_Konus;
            }
            


            //Drehen der Punkte für Rechtsdreher
            if ($Turn_Direction == "rechts"){
                for ($i = 0; $i < count($Points); $i++){               //jede Fläche
                for ($j = 0; $j < count($Points[$i][0]);$j++){             //jede Flächenebene
                    for ($k = 0; $k < count($Points[$i][0][$j]); $k++){      //jeder Punkt
                            $Points[$i][0][$j][$k][2]= - $Points[$i][0][$j][$k][2];
                    }
                }
            }
            }
            
            for ($i = 0; $i < count($Points);$i++){
                if ($i == 0){
                    $u = 5;
                    $v = 2;
                    $Surface_Name[$i]="Flanschflaeche_Ebene-1";
                    $Surface_Colour[$i] = "('NONE',0.3,0.3,0.8)";
                } elseif ($i == 1){
                    $u = 5;
                    $v = 2;
                    $Surface_Name[$i]="Flanschflaeche_Ebene-2";
                    $Surface_Colour[$i] = "('NONE',0.1,0.6,0.8)";
                } elseif ($i == 2){
                    $u = 5;
                    $v = 2;
                    $Surface_Name[$i]="Flanschflaeche_Ebene-3";
                    $Surface_Colour[$i] = "('NONE',0.1,0.6,0.8)";
                } elseif ($i == 3){
                    $u = 5;
                    $v = 2;
                    $Surface_Name[$i]="Flanschflaeche_Ebene-4";
                    $Surface_Colour[$i] = "('NONE',0.8,0.3,0.5)";
                } elseif ($i == 4){
                    $u = 5;
                    $v = 2;
                    $Surface_Name[$i]="Verbindungsflaeche_1_2_Aussen";
                    $Surface_Colour[$i] = "('NONE',0.5,0.9,0.7)";
                } elseif ($i == 5){
                    $u = 5;
                    $v = 2;
                    $Surface_Name[$i]="Verbindungsflaeche_1_2_Stufe";
                    $Surface_Colour[$i] = "('NONE',0.1,0.7,0.3)";
                } elseif ($i == 6){
                    $u = 5;
                    $v = 2;
                    $Surface_Name[$i]="Verbindungsflaeche_2_3_Aussen";
                    $Surface_Colour[$i] = "('NONE',0.6,0.8,0.1)";
                } elseif ($i == 7){
                    $u = 5;
                    $v = 2;
                    $Surface_Name[$i]="Verbindungsflaeche_2_3_Stufe";
                    $Surface_Colour[$i] = "('NONE',0.4,0.3,0.2)";
                } elseif ($i == 8){
                    $u = 4;
                    $v = 5;
                    $Surface_Name[$i]="Blattflaeche_oben_vorne";
                    $Surface_Colour[$i] = "('NONE',0.2,0.1,0.8)";
                } elseif ($i == 9){
                    $u = 4;
                    $v = 5;
                    $Surface_Name[$i]="Blattflaeche_unten_vorne";
                    $Surface_Colour[$i] = "('NONE',0.4,0.6,0.7)";
                } elseif ($i == 10){
                    $u = 4;
                    $v = 5;
                    $Surface_Name[$i]="Blattflaeche_oben_hinten";
                    $Surface_Colour[$i] = "('NONE',0.2,0.5,0.8)";
                } elseif ($i == 11){
                    $u = 4;
                    $v = 5;
                    $Surface_Name[$i]="Blattflaeche_unten_hinten";
                    $Surface_Colour[$i] = "('NONE',0.3,0.5,0.5)";
                } elseif ($i == 12){
                    $u = 4;
                    $v = 2;
                    $Surface_Name[$i]="Schnittflaeche";
                    $Surface_Colour[$i] = "('NONE',0.3,0.5,0.5)";
                } elseif ($i == 13){
                    $u = 4;
                    $v = 2;
                    $Surface_Name[$i]="Kantenflaeche_VK";
                    $Surface_Colour[$i] = "('NONE',0.3,0.5,0.5)";
                } elseif ($i == 14){
                    $u = 4;
                    $v = 2;
                    $Surface_Name[$i]="Kantenflaeche_HK";
                    $Surface_Colour[$i] = "('NONE',0.3,0.5,0.5)";
                }  elseif ($i == 15) {
                    $u = 4;
                    $v = 3;
                    $Surface_Name[$i]="Verrundung_oben";
                    $Surface_Colour[$i] = "('NONE',0.0,7,0.1)";            
                } elseif ($i == 16) {
                    $u = 4;
                    $v = 3;
                    $Surface_Name[$i]="Verrundung_unten";
                    $Surface_Colour[$i] = "('NONE',0.0,7,0.1)";    
                } elseif ($i == 17){
                    $u = 4;
                    $v = 2;
                    $Surface_Name[$i]="Trennflaeche_Tangentenrand_vorne";
                    $Surface_Colour[$i] = "('NONE',1.0,0.,0.5)";
                } elseif ($i == 18){
                    $u = 4;
                    $v = 2;
                    $Surface_Name[$i]="Trennflaeche_Tangentenrand_hinten";
                    $Surface_Colour[$i] = "('NONE',1.,0.,0.5)";
                } elseif ($i == 19){
                    $u = 4;
                    $v = 2;
                    $Surface_Name[$i]="Trennflaeche_Tangentenrand_vorne_rund";
                    $Surface_Colour[$i] = "('NONE',1.,0.,0.5)";
                } elseif ($i == 20){
                    $u = 4;
                    $v = 2;
                    $Surface_Name[$i]="Trennflaeche_Tangentenrand_hinten_rund";
                    $Surface_Colour[$i] = "('NONE',1.,0.,0.5)";
                } elseif ($i == 21){
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="Trennflaeche_Tangentenrand_Stufe";
                    $Surface_Colour[$i] = "('NONE',1.,0.,0.5)";
                } elseif ($i == 22){
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="Trennflaeche_Blockrand";
                    $Surface_Colour[$i] = "('NONE',0.0,1,0.3)";
                } elseif ($i == 23){
                    $u = 4;
                    $v = 4;
                    $Surface_Name[$i]="Distanzflaeche_Hauptflaeche_vorne";
                    $Surface_Colour[$i] = "('NONE',0.7,0.2,0.0)";
                } elseif ($i == 24){
                    $u = 4;
                    $v = 4;
                    $Surface_Name[$i]="Distanzflaeche_Hauptflaeche_hinten";
                    $Surface_Colour[$i] = "('NONE',0.7,0.2,0.0)";
                } elseif ($i == 25){
                    $u = 4;
                    $v = 4;
                    $Surface_Name[$i]="Distanzflaeche_Rundung_vorne";
                    $Surface_Colour[$i] = "('NONE',0.7,0.2,0.0)";
                } elseif ($i == 26){
                    $u = 4;
                    $v = 4;
                    $Surface_Name[$i]="Distanzflaeche_Rundung_hinten";
                    $Surface_Colour[$i] = "('NONE',0.7,0.2,0.0)";
                } elseif ($i == 27){
                    $u = 4;
                    $v = 2;
                    $Surface_Name[$i]="Distanzflaeche_Stufe";
                    $Surface_Colour[$i] = "('NONE',0.7,0.2,0.0)";
                } elseif($i == 28) {  
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="Trennflaeche_Blockrand_aussen";
                    $Surface_Colour[$i] = "('NONE',0.0,1,0.1)";        
                    
                } elseif ($i == 29) {
                    $Surface_Name[$i]="Zentrierung_Konus";
                    $Surface_Colour[$i] = "('NONE',0.5,0,0.5)";
                }
            $Points[$i][1] = $u;
            $Points[$i][2] = $v;
            $Points[$i][3] = $Surface_Name[$i];
            $Points[$i][4] = $Surface_Colour[$i];   
            }
            return($Points);
    }
    function Geometry_Calculation_Extension($inputBlatt, $inputBlatt_Block,  $Side, $Turn_Direction, $includeblock){   //Geometrieberechnung Verlängerung
        //............................Scope.......................................
                /*

            Autor:			Helix-Design

            Programmname:	Geometry_Calculation_Extension

            Modulname:		Geometry_Calculation_Extension.php

            Änderungsstand:	21.04.2021

            Namenskürzel:		PM	


            Beschreibung:				berechnet Geometriepunkte einer Verlängerung, z.B. als Zwischenstück bei größeren Blättern oder Verlängerung von Wurzeln

                            

            Der Programmablauf kommt von:		Main.php


            Benötigte Werte:			wie Geometry_Calculation_Blade aber nur mit seitlichen Blockrändern

            Der Programmablauf wird übergeben an:	StepPostprocessor.php


            Übergebene Werte:			Alle Geometriepunkte

            -------------------------------------------------------------------------------------
            */
        //............................Input........................................

            //global $u_Blade;
            $u_Blade = $inputBlatt[0][0];                          //Ordnung der Spline-Fläche x Richtung
            //global $v_Blade;
            $v_Blade = $inputBlatt[1][0];                          //Ordnung der Spline-Fläche y Richtung        
            $r = $inputBlatt[4];             //lokaler Radius
            $l = $inputBlatt[5];             //Profiltiefe
            $d = $inputBlatt[6];             //Profildicke
            $p = $inputBlatt[7];             //Profilrücklage
            $q = $inputBlatt[8];             //Profil V-Lage
            $s =  $inputBlatt[9];             //Dicke der Hinterkante
            $t = $inputBlatt[10];             //lokale Steigung
            for ($i=0; $i < count($inputBlatt[11]); $i++){
                $yTwistAngle[$i] = $inputBlatt[11][$i]/180*pi() ; //Verdrehwinkel y-Achse in rad
                $zTwistAngle[$i] = $inputBlatt[12][$i]/180*pi(); //Verdrehwinkel z-Achse in rad
            };
            $RfP =  $inputBlatt[13]; 
            $Profilnum = $inputBlatt[14];
            $mplus1 = count($r);
            
            $x_RPS =  $r[0];
            //Input Block  
            $zKW = $inputBlatt_Block[0];                   //z-Verschiebung Tangentenrand
            $bTR = $inputBlatt_Block[1][0];              //Trennfläche_Tangentenrand Breite
            $bB = $inputBlatt_Block[2][0];               //Blockrand Breite
            $PB = $inputBlatt_Block[3];                    //Blockabmaße
            $P0B = $inputBlatt_Block[4];                   //Blocknullpunkt
            $PZK = $inputBlatt_Block[5];                   //Punkt Zentrierkonus
            $RotationAngleBlock = $inputBlatt[2][0]/180*pi();             //Drehwinkel um x-Achse in Blockebene
            $RotationAngleBlocky = $inputBlatt[3][0]/180*pi();             //Drehwinkel um y-Achse in Blockebene
            $DFB = $inputBlatt_Block[6][0]; //Fräserdurchmesser Blockumrandung
            
         

        //............................Blattflaeche_Hauptflaeche........................................ 
            for ($i=0; $i < $mplus1; $i++){                     //Ebenenschleife


                    $a = $Profilnum[$i];
                        
                    $ProfilName = PropellerStepCodeProfil::where('name', '=', "$a")->pluck('inputProfil');
                    //dd($ProfilName);
                    $ProfilName = str_replace('[','',$ProfilName);
                    $ProfilName = str_replace('"','',$ProfilName);
                    $ProfilName = str_replace(']','',$ProfilName);
                
                    $BasicProfilpoints2 =  explode('\r\n', $ProfilName); 
                    
                    $nplus1 = count($BasicProfilpoints2)/2; //Anzahl der Profilpunktestützpunkte
                for ($i_1 = 0; $i_1 < $nplus1*2; $i_1++ ){
                    $row = explode(' ',$BasicProfilpoints2[$i_1] );
                    $BasicProfilpoints[$i_1] =  $row; 

                }

               
                    $nplus1 = count($BasicProfilpoints)/2; //Anzahl der Profilpunktestützpunkte
                    $AngleofIncidence[$i] = -atan ($t[$i]/(2*pi()*$r[$i]))+$RotationAngleBlock; // Berechnung des lokalen Einstellwinkels aus Steigung
                    

                    for ($j=0; $j < $nplus1;$j ++){                                                                 //Schleife Profilpunkte
                        $a = $j+1;
                        $b = $i+1;
                        $BasicProfilpoints_oben[$j] = $BasicProfilpoints[$j];
                        $BasicProfilpoints_unten[$j] = $BasicProfilpoints[$j+$nplus1];                       
                        $Punkte_Blattflaeche_Hauptflaeche_oben[$i][$j][0] = "Blattflaeche_Hauptflaeche_oben-E$b-P$a";    //Zuweisung der Punktnamen
                
                            
                        $Punkte_Blattflaeche_Hauptflaeche_unten[$i][$j][0] = "Blattflaeche_Hauptflaeche_unten-E$b-P$a";
                        

                        $Punkte_Blattflaeche_Hauptflaeche_oben[$i][$j][1] = $r[$i];                                                      //zuweisen des x-Wertes
                        $Punkte_Blattflaeche_Hauptflaeche_unten[$i][$j][1] = $r[$i];
                        $BasicProfilpoints_oben[$j][0] = $BasicProfilpoints_oben[$j][0]-$RfP[$i];                                            // verschieben der Basispunkte auf Referenzlinie
                        $BasicProfilpoints_unten[$j][0] = $BasicProfilpoints_unten[$j][0]-$RfP[$i];
                        $Punkte_Blattflaeche_Hauptflaeche_oben[$i][$j][2] = $BasicProfilpoints_oben[$j][0]*$l[$i];                            //skalieren der y-Werte mit Profiltiefe
                        $Punkte_Blattflaeche_Hauptflaeche_unten[$i][$j][2] = $BasicProfilpoints_unten[$j][0]*$l[$i];
                        $Punkte_Blattflaeche_Hauptflaeche_oben[$i][$j][3] = $BasicProfilpoints_oben[$j][1]*$l[$i]*$d[$i];                            //skalieren der z-Werte mit Profiltiefe
                        $Punkte_Blattflaeche_Hauptflaeche_unten[$i][$j][3] = $BasicProfilpoints_unten[$j][1]*$l[$i]*$d[$i];
                        if ($j == $nplus1-1){ 
                        $Punkte_Blattflaeche_Hauptflaeche_oben[$i][$j][3] = $Punkte_Blattflaeche_Hauptflaeche_oben[$i][$j][3]+$s[$i]/2; //versetzen des letzten Punktes der Blattfläche  
                        $Punkte_Blattflaeche_Hauptflaeche_unten[$i][$j][3] = $Punkte_Blattflaeche_Hauptflaeche_unten[$i][$j][3]-$s[$i]/2; //versetzen des letzten Punktes der Blattfläche                                                                                 
                        }
                        $Punkte_Blattflaeche_Hauptflaeche_oben[$i][$j][2] = $Punkte_Blattflaeche_Hauptflaeche_oben[$i][$j][2] + $p[$i];  // Verschiebung entlang der y-Achse
                        $Punkte_Blattflaeche_Hauptflaeche_unten[$i][$j][2] = $Punkte_Blattflaeche_Hauptflaeche_unten[$i][$j][2] + $p[$i];
                        $Punkte_Blattflaeche_Hauptflaeche_oben[$i][$j][3] = $Punkte_Blattflaeche_Hauptflaeche_oben[$i][$j][3] +$q[$i];  // Verschiebung entlang der z-Achse
                        $Punkte_Blattflaeche_Hauptflaeche_unten[$i][$j][3] = $Punkte_Blattflaeche_Hauptflaeche_unten[$i][$j][3] +$q[$i];

                        $Punkte_Drehung[0][$i][$j] =   $Punkte_Blattflaeche_Hauptflaeche_oben[$i][$j];              //hinzufügen zu Hilfsarray um Drehmatrizen in Schleife zu durchlaufen
                        $Punkte_Drehung[1][$i][$j] =   $Punkte_Blattflaeche_Hauptflaeche_unten[$i][$j];
                    }                                   //Ende Punktschleife
                }                                       //Ende Ebenenschleife
            
                                                    




            //Drehmatrizen für Blattfläche  (alles was gedreht wird)

            for ($k = 0; $k < count($Punkte_Drehung); $k++){
            for ($i=0; $i <  count($Punkte_Drehung[$k]); $i++){
                for ($j=0; $j < count($Punkte_Drehung[$k][$i]);$j ++){ 

                    $TurnProfilpoints =$Punkte_Drehung[$k][$i];                                                  //Hilfsvariable zum drehen der Flächen
                    $Punkte_Drehung[$k][$i][$j][2] = $TurnProfilpoints[$j][2]*cos($AngleofIncidence[$i]) - $TurnProfilpoints[$j][3]*sin($AngleofIncidence[$i]); //Drehamtrix um x-Achse
                    $Punkte_Drehung[$k][$i][$j][3] = $TurnProfilpoints[$j][2]*sin($AngleofIncidence[$i]) + $TurnProfilpoints[$j][3]*cos($AngleofIncidence[$i]);                     

                    $TurnProfilpoints = $Punkte_Drehung[$k][$i];                                                  //Hilfsvariable zum drehen des Profils mit aktuellen Punkten
                    $TurnProfilpoints[$j][1] = $Punkte_Drehung[$k][$i][$j][1] - $r[$i];                           //Abziehen des x-Wertes um in der lokalen Ebene zu drehen
                    $Punkte_Drehung[$k][$i][$j][3] =  $TurnProfilpoints[$j][3]*cos($yTwistAngle[$i]) - $TurnProfilpoints[$j][1]*sin($yTwistAngle[$i]); //Drehamtrix um y-Achse
                    $Punkte_Drehung[$k][$i][$j][1] =   $TurnProfilpoints[$j][3]*sin($yTwistAngle[$i]) + $TurnProfilpoints[$j][1]*cos($yTwistAngle[$i]);                        
                                
                    $TurnProfilpoints = $Punkte_Drehung[$k][$i];                                                  //Hilfsvariable zum drehen des Profils mit aktuellen Punkten
                    $TurnProfilpoints_unten = $Punkte_Blattflaeche_Hauptflaeche_unten[$i];
                    $Punkte_Drehung[$k][$i][$j][2] =  $TurnProfilpoints[$j][2]*cos($zTwistAngle[$i]) - $TurnProfilpoints[$j][1]*sin($zTwistAngle[$i]); //Drehamtrix um z-Achse                        
                    $Punkte_Drehung[$k][$i][$j][1] =   $TurnProfilpoints[$j][2]*sin($zTwistAngle[$i]) + $TurnProfilpoints[$j][1]*cos($zTwistAngle[$i]);                        
                    $Punkte_Drehung[$k][$i][$j][1] = $Punkte_Drehung[$k][$i][$j][1] + $r[$i];                              //Addieren des x-Wertes der lokalen Ebene nach Drehung   
                }
            }
            }                     
            $Punkte_Blattflaeche_Hauptflaeche_oben =  $Punkte_Drehung[0];           //entpacken nach Drehung für größere Nachvollziehbarkeit anhand des Variablennames
            $Punkte_Blattflaeche_Hauptflaeche_unten =  $Punkte_Drehung[1];

                        
            

        //............................Blattflaeche_HK........................................
            for ($i=0; $i < $mplus1; $i++){                     //Ebenenschleife
            for ($j=0; $j < $nplus1;$j ++){                 //Schleife Profilpunkte 
                $Punkte_Blattflaeche_HK[$i][0] = $Punkte_Blattflaeche_Hauptflaeche_oben[$i][$nplus1-1];                //setzen der HK Punkte
                $Punkte_Blattflaeche_HK[$i][1] = $Punkte_Blattflaeche_Hauptflaeche_unten[$i][$nplus1-1];                   
                $Punkte_Blattflaeche_HK[$i][0][0] = "Blattflaeche_HK-E$b-P1";                                           //Namenszuweisung HK Punkte
                $Punkte_Blattflaeche_HK[$i][1][0] = "Blattflaeche_HK-E$b-P2";
        //............................Trennflaeche_Tangentenrand_vorne........................................ 
            $Punkte_Trennflaeche_Tangentenrand_vorne[$i][0] = $Punkte_Blattflaeche_Hauptflaeche_oben[$i][0];         //übernehme Punkte von VK
            $Punkte_Trennflaeche_Tangentenrand_vorne[$i][0][0] = "Trennflaeche_Tangentenrand_vorne-E$b-P2";
            $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1] = $Punkte_Blattflaeche_Hauptflaeche_oben[$i][0];

            $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][2] = $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][2]-$bTR;
            
            $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][3] = $Punkte_Blattflaeche_Hauptflaeche_oben[$i][0][3]+$zKW[$i];          //z-Korrektur
            $Punkte_Trennflaeche_Tangentenrand_vorne[$i][0][3] = $Punkte_Blattflaeche_Hauptflaeche_oben[$i][0][3]+$zKW[$i];          //z-Korrektur
            $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][0] = "Trennflaeche_Tangentenrand_vorne-E$b-P1";
        //............................Trennflaeche_Tangentenrand_hinten........................................     
            $Punkte_Trennflaeche_Tangentenrand_hinten[$i][1][0] = "Trennflaeche_Tangentenrand_hinten-E$b-P2";   
            $Punkte_Trennflaeche_Tangentenrand_hinten[$i][1][1] = $Punkte_Blattflaeche_HK[$i][0][1];
            $Punkte_Trennflaeche_Tangentenrand_hinten[$i][1][2] = ($Punkte_Blattflaeche_HK[$i][0][2]+$Punkte_Blattflaeche_HK[$i][1][2])/2;
            $Punkte_Trennflaeche_Tangentenrand_hinten[$i][1][3] = ($Punkte_Blattflaeche_HK[$i][0][3]+$Punkte_Blattflaeche_HK[$i][1][3])/2;        //zuweisen und berechnen der Mitte der HK
            $Punkte_Trennflaeche_Tangentenrand_hinten[$i][0] = $Punkte_Trennflaeche_Tangentenrand_hinten[$i][1];
            
            
            $Punkte_Trennflaeche_Tangentenrand_hinten[$i][0][2] = $Punkte_Trennflaeche_Tangentenrand_hinten[$i][1][2]+$bTR;   
            
            $Punkte_Trennflaeche_Tangentenrand_hinten[$i][0][0] = "Trennflaeche_Tangentenrand_hinten-E$b-P1";
            }
                }





        //..........................Trennflaeche_Blockrand........................................  
            //hinten                                                                              //setzen der Blockrand Punkte
            $Punkte_Trennflaeche_Blockrand_hinten[0][0][0] = "Trennflaeche_Blockrand_hinten-E1-P1";                               
            $Punkte_Trennflaeche_Blockrand_hinten[0][0][1] = $P0B[0];
            $Punkte_Trennflaeche_Blockrand_hinten[0][0][2] = $P0B[1];
            $Punkte_Trennflaeche_Blockrand_hinten[0][0][3] = 0;

            $Punkte_Trennflaeche_Blockrand_hinten[0][1][0] = "Trennflaeche_Blockrand_hinten-E1-P2";
            $Punkte_Trennflaeche_Blockrand_hinten[0][1][1] = $P0B[0];
            $Punkte_Trennflaeche_Blockrand_hinten[0][1][2] = $P0B[1]-$bB;
            $Punkte_Trennflaeche_Blockrand_hinten[0][1][3] = 0;

            $Punkte_Trennflaeche_Blockrand_hinten[1][0] = $Punkte_Trennflaeche_Blockrand_hinten[0][0];
            $Punkte_Trennflaeche_Blockrand_hinten[1][0][1] = $Punkte_Trennflaeche_Blockrand_hinten[0][0][1]+$PB[0];
            $Punkte_Trennflaeche_Blockrand_hinten[1][0][0] = "Trennflaeche_Blockrand_hinten-E2-P1";


            $Punkte_Trennflaeche_Blockrand_hinten[1][1] = $Punkte_Trennflaeche_Blockrand_hinten[0][1];
            $Punkte_Trennflaeche_Blockrand_hinten[1][1][1] = $Punkte_Trennflaeche_Blockrand_hinten[0][1][1]+$PB[0];
            $Punkte_Trennflaeche_Blockrand_hinten[1][1][0] = "Trennflaeche_Blockrand_hinten-E2-P2";

            //vorne

            $Punkte_Trennflaeche_Blockrand_vorne[1][1][0] = "Trennflaeche_Blockrand_vorne-E4-P2";
            $Punkte_Trennflaeche_Blockrand_vorne[1][1][1] = $P0B[0];
            $Punkte_Trennflaeche_Blockrand_vorne[1][1][2] = $P0B[1]+$bB-$PB[1];
            $Punkte_Trennflaeche_Blockrand_vorne[1][1][3] = 0;

            $Punkte_Trennflaeche_Blockrand_vorne[1][0][0] = "Trennflaeche_Blockrand_vorne-E4-P1";
            $Punkte_Trennflaeche_Blockrand_vorne[1][0][1] = $P0B[0];
            $Punkte_Trennflaeche_Blockrand_vorne[1][0][2] = $P0B[1]-$PB[1];
            $Punkte_Trennflaeche_Blockrand_vorne[1][0][3] = 0;


            $Punkte_Trennflaeche_Blockrand_vorne[0][1] = $Punkte_Trennflaeche_Blockrand_vorne[1][1];
            $Punkte_Trennflaeche_Blockrand_vorne[0][1][1] = $Punkte_Trennflaeche_Blockrand_vorne[1][1][1]+$PB[0];
            $Punkte_Trennflaeche_Blockrand_vorne[0][1][0] = "Trennflaeche_Blockrand_vorne-E3-P2";


            $Punkte_Trennflaeche_Blockrand_vorne[0][0] = $Punkte_Trennflaeche_Blockrand_vorne[1][0];
            $Punkte_Trennflaeche_Blockrand_vorne[0][0][1] = $Punkte_Trennflaeche_Blockrand_vorne[1][0][1]+$PB[0];
            $Punkte_Trennflaeche_Blockrand_vorne[0][0][0] = "Trennflaeche_Blockrand_vorne-E3-P1";
        //............................Blockrand_aussen.....................................
            //hinten                                                                             
            for ($i = 0; $i < 2; $i++){
                $a = $i+1;
                $Punkte_Trennflaeche_Blockrand_aussen_hinten[$i][0] = $Punkte_Trennflaeche_Blockrand_hinten[$i][0]; //übernehmen von Trennfläche_Blockrand 
                $Punkte_Trennflaeche_Blockrand_aussen_hinten[$i][0][0] = "Trennflaeche_Blockrand_außen_hinten-E$a-P1";
                if ($i == 0){
                    $b = 0;
                    $c = $DFB;
                } elseif ($i == 1){
                    $b = 0;
                    $c = $DFB;
                        
                }
                $Punkte_Trennflaeche_Blockrand_aussen_hinten[$i][1] = $Punkte_Trennflaeche_Blockrand_hinten[$i][0];
                $Punkte_Trennflaeche_Blockrand_aussen_hinten[$i][1][1] = $Punkte_Trennflaeche_Blockrand_hinten[$i][0][1] + $b;
                $Punkte_Trennflaeche_Blockrand_aussen_hinten[$i][1][2] = $Punkte_Trennflaeche_Blockrand_hinten[$i][0][2] + $c;
                $Punkte_Trennflaeche_Blockrand_aussen_hinten[$i][1][0] = "Trennflaeche_Blockrand_außen_hinten-E$a-P2";               
            }

                //vorne
                for ($i = 0; $i < 2; $i++){
                    $a = $i+1;
                    $Punkte_Trennflaeche_Blockrand_aussen_vorne[$i][0] = $Punkte_Trennflaeche_Blockrand_vorne[$i][0]; //übernehmen von Trennfläche_Blockrand 
                    $Punkte_Trennflaeche_Blockrand_aussen_vorne[$i][0][0] = "Trennflaeche_Blockrand_außen_vorne-E$a-P1";
                    if ($i == 0){
                        $b = 0;
                        $c = -$DFB;
                    } elseif ($i == 1){
                        $b = 0;
                        $c = -$DFB;               
                    }
                    $Punkte_Trennflaeche_Blockrand_aussen_vorne[$i][1] = $Punkte_Trennflaeche_Blockrand_vorne[$i][0];
                    $Punkte_Trennflaeche_Blockrand_aussen_vorne[$i][1][1] = $Punkte_Trennflaeche_Blockrand_vorne[$i][0][1] + $b;
                    $Punkte_Trennflaeche_Blockrand_aussen_vorne[$i][1][2] = $Punkte_Trennflaeche_Blockrand_vorne[$i][0][2] + $c;
                    $Punkte_Trennflaeche_Blockrand_aussen_vorne[$i][1][0] = "Trennflaeche_Blockrand_außen_vorne-E$a-P2";               
                }

            
        //............................Distanzflaeche_Hauptflaeche........................................
            if ($Side == 'oben')                                                                //Offset für oben oder unten setzen um Spalt zu generieren
            {$Distanzflaechen_zOffset = 0.6;}     //0.6                       
            else
            {$Distanzflaechen_zOffset = -0.6;}

                $Distanzflaechen_yOffset = 2;
                $Distanzflaechen_xOffset = 2;

                for ($i=0; $i < $mplus1; $i++){                                                     //Schleife zum Durchlaufen der Ebenen, übernommen von Blattflaeche_Hauptflaeche
            $b = $i +1;
            
            /*if ($i == $mplus1-1){  
            //............................Distanzflaeche_Hauptflaeche_vorne........................................
                        //erster Punkt, letzte Ebene auf Blockrand, die restlichen mit x-Werten der Blattflächen_Hauptfläche Ebenen
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][0] = $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1];
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][0][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P1"; //P1 aufBlockrand
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5] = $Punkte_Trennflaeche_Blockrand_vorne[1][1];    
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P6";

                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5]; //P5  mit versetzter y-Koordinate, bei letzter Ebene ebenfalls versetzer x-Wert
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P5";
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4][1] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5][1]- $Distanzflaechen_xOffset;
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4][2] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5][2]+ $Distanzflaechen_yOffset;  
                }
                else {*/
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P6";
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5][1] = $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][1];       
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5][2]= $Punkte_Trennflaeche_Blockrand_vorne[1][1][2];
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5][3]= $Punkte_Trennflaeche_Blockrand_vorne[1][1][3];
                
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5]; //P5  mit versetzter y-Koordinate
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P5";
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4][2] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4][2]+ $Distanzflaechen_yOffset;
                    //}
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][3] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4]; //P4  mit versetzter z-Koordinate
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][3][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P4";
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][3][3] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][3][3] + $Distanzflaechen_zOffset;

                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][0] = $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1];
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][0][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P1"; //P1 aufBlockrand

                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][1] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][0]; //P2  mit versetzter y-Koordinate
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][1][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P2";
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][1][2] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][0][2]- $Distanzflaechen_yOffset;


                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][2] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][1]; //P3  mit versetzter z-Koordinate
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][2][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P3";
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][2][3] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][1][3] + $Distanzflaechen_zOffset;



                //............................Distanzflaeche_Hauptflaeche_hinten........................................
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][5] = $Punkte_Trennflaeche_Tangentenrand_hinten[$i][0];   //P6 auf Tangentenrand
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][5][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P6";   
                /*if ($i == $mplus1-1){  
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0] = $Punkte_Trennflaeche_Blockrand_hinten[1][1];    
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P1";

                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0]; 
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P2";
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1][1] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0][1]- $Distanzflaechen_xOffset;
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1][2] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0][2]- $Distanzflaechen_yOffset;

                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][5];  //5. Punkt mit versetzter x und y-Koordinate
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P2";
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4][2] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][5][2]+ $Distanzflaechen_yOffset;
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4][1] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][5][1]+ $Distanzflaechen_xOffset;
                        
                    }
                else { */
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P1";
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0][1] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][5][1];       
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0][2]= $Punkte_Trennflaeche_Blockrand_hinten[0][1][2];
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0][3]= $Punkte_Trennflaeche_Blockrand_hinten[1][1][3];

                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0]; 
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P2";
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1][2] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0][2]- $Distanzflaechen_yOffset;
                        
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][5];  //5. Punkt mit versetzter y-Koordinate
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P2";
                        $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4][2] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][5][2]+ $Distanzflaechen_yOffset;
                    //}
                



            $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][3] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4]; //4. Punkt  mit versetzter z-Koordinate
            $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][3][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P3";
            $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][3][3] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4][3] + $Distanzflaechen_zOffset;

            $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][2] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1]; //3. Punkt  mit versetzter z-Koordinate
            $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][2][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P4";
            $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][2][3] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1][3] + $Distanzflaechen_zOffset;
                }

        //............................Output......................................
            $Punkte_Verlaengerung[0][0] =  $Punkte_Drehung[0];
            $Punkte_Verlaengerung[1][0] =  $Punkte_Drehung[1];
            $Punkte_Verlaengerung[2][0] = $Punkte_Blattflaeche_HK;
            
            if ($includeblock == "ja"){
                $Punkte_Verlaengerung[3][0] = $Punkte_Trennflaeche_Tangentenrand_vorne;
                $Punkte_Verlaengerung[4][0] = $Punkte_Trennflaeche_Tangentenrand_hinten;
                $Punkte_Verlaengerung[5][0] = $Punkte_Trennflaeche_Blockrand_vorne;
                $Punkte_Verlaengerung[6][0] = $Punkte_Trennflaeche_Blockrand_hinten;
                $Punkte_Verlaengerung[7][0] = $Punkte_Distanzflaeche_Hauptflaeche_vorne;
                $Punkte_Verlaengerung[8][0] = $Punkte_Distanzflaeche_Hauptflaeche_hinten;
                $Punkte_Verlaengerung[9][0] = $Punkte_Trennflaeche_Blockrand_aussen_vorne;
                $Punkte_Verlaengerung[10][0] = $Punkte_Trennflaeche_Blockrand_aussen_hinten;
            
            }



            //Drehen der Punkte für Rechtsdreher
                if ($Turn_Direction == "rechts"){
                    for ($i = 0; $i < count($Punkte_Verlaengerung); $i++){               //jede Fläche
                    for ($j = 0; $j < count($Punkte_Verlaengerung[$i][0]);$j++){             //jede Flächenebene
                        for ($k = 0; $k < count($Punkte_Verlaengerung[$i][0][$j]); $k++){      //jeder Punkt
                            $Punkte_Verlaengerung[$i][0][$j][$k][2]= - $Punkte_Verlaengerung[$i][0][$j][$k][2];
                        }
                    }
                }
            }
                for ($i = 0; $i < count($Punkte_Verlaengerung); $i++){    
                    if ($i == 0){
                        $u = $u_Blade;
                        $v = $v_Blade;
                        $Surface_Name[$i]="Blattflaeche_Hauptflaeche_oben";                                              //Spline Ordnung der verschiedenen Flächen setzen
                        $Surface_Colour[$i] = "('NONE',0.3,0.3,0.8)";
                    } elseif($i == 1){
                        $u = $u_Blade;
                        $v = $v_Blade;
                        $Surface_Name[$i]="Blattflaeche_Hauptflaeche_unten";                                              //Spline Ordnung der verschiedenen Flächen setzen
                        $Surface_Colour[$i] = "('NONE',0.3,0.3,0.8)";
                    } elseif($i == 2){
                        $u = $u_Blade;
                        $v=2;
                        $Surface_Name[$i]="Blattflaeche_HK";
                        $Surface_Colour[$i] = "('NONE',0,0,1)";       
                    } elseif($i == 3){
                        $u = $u_Blade;
                        $v=2;
                        $Surface_Name[$i]="Trennflaeche_Tangentenrand_vorne";
                        $Surface_Colour[$i] = "('NONE',0,1,1)";
                    } elseif($i == 4){
                        $u = $u_Blade;
                        $v=2;
                        $Surface_Name[$i]="Trennflaeche_Tangentenrand_hinten";
                        $Surface_Colour[$i] = "('NONE',1,0,0)";    
                    } elseif($i == 5){
                        $u=2;
                        $v=2;
                        $Surface_Name[$i]="Trennflaeche_Blockrand_vorne";
                        $Surface_Colour[$i] = "('NONE',1,1,1)";
                    }elseif($i == 6){
                        $u=2;
                        $v=2;
                        $Surface_Name[$i]="Trennflaeche_Blockrand_hinten";
                        $Surface_Colour[$i] = "('NONE',1,1,1)";
                    } elseif($i == 7){
                        $u = $u_Blade; 
                        $v=4;
                        $Surface_Name[$i]="Distanzflaeche_Hauptflaeche_vorne";
                        $Surface_Colour[$i] = "('NONE',0,0,0.5)";
                    } elseif($i == 8){
                        $u = $u_Blade;
                        $v=4;
                        $Surface_Name[$i]="Distanzflaeche_Hauptflaeche_hinten";
                        $Surface_Colour[$i] = "('NONE',0,0.5,0)";
                    } elseif($i == 9){
                        $u=2;
                        $v=2;
                        $Surface_Name[$i]="Trennflaeche_Blockrand_aussen_vorne";
                        $Surface_Colour[$i] = "('NONE',1,1,1)";
                    }elseif($i == 10){
                        $u=2;
                        $v=2;
                        $Surface_Name[$i]="Trennflaeche_Blockrand_aussen_hinten";
                        $Surface_Colour[$i] = "('NONE',1,1,1)";
                    }
                    
                    $Punkte_Verlaengerung[$i][1] = $u;
                    $Punkte_Verlaengerung[$i][2] = $v;
                    $Punkte_Verlaengerung[$i][3] = $Surface_Name[$i];
                    $Punkte_Verlaengerung[$i][4] = $Surface_Colour[$i];
                }


            return($Punkte_Verlaengerung);

    }
    function Geometry_Calculation_CAM($Points, $Side, $includeBlade,  $includeRoot, $Roottyp, $Turn_Direction, $inputWurzel_Block, $inputBlatt_Block, $DFB, $includeExtension){   //Geometrieberechnung CAM-Hilfslinien und flächen
        //............................Scope.......................................
                /*

            Autor:			Helix-Design

            Programmname:	Geometry_Calculation_Extension

            Modulname:		Geometry_Calculation_Extension.php

            Änderungsstand:	21.04.2021

            Namenskürzel:		PM	


            Beschreibung:				berechnet Geometriepunkte einer Verlängerung, z.B. als Zwischenstück bei größeren Blättern oder Verlängerung von Wurzeln

                            

            Der Programmablauf kommt von:		Main.php


            Benötigte Werte:			wie Geometry_Calculation_Blade aber nur mit seitlichen Blockrändern

            Der Programmablauf wird übergeben an:	StepPostprocessor.php


            Übergebene Werte:			Alle Geometriepunkte

            -------------------------------------------------------------------------------------
            */
        //............................Input........................................
            
            //Input Block

            if ($includeBlade == "ja" or $includeExtension){
                $zKW = $inputBlatt_Block[0];             //z-Verschiebung Tangentenrand
                $bTR = $inputBlatt_Block[1][0]*1;             //Trennfläche_Tangentenrand Breite
                $bB = $inputBlatt_Block[2][0]*1;              //Blockrand Breite
                $PB = $inputBlatt_Block[3];              //Blockabmaße
                $P0B = $inputBlatt_Block[4];             //Blocknullpunkt
                $PZK = $inputBlatt_Block[5];             //Punkt Zentrierkonus 

            }
            
            if ($includeRoot == "ja"){
                $zKW = $inputWurzel_Block[0];             //z-Verschiebung Tangentenrand
                $bTR = $inputWurzel_Block[1][0]*1;             //Trennfläche_Tangentenrand Breite
                $bB = $inputWurzel_Block[2][0]*1;              //Blockrand Breite
                $PB = $inputWurzel_Block[3];              //Blockabmaße
                $P0B = $inputWurzel_Block[4];             //Blocknullpunkt
                $PZK = $inputWurzel_Block[5];             //Punkt Zentrierkonus  
            }      
            


                $zmax = $P0B[2];                          //max. z-Wert des Modells
                $z_Block = $PB[2];                          //Dicke des Rohteil Blocks
                //$Side = "oben";

                //if ($Side == "oben"){
                $z_Cam_Lines = -50;
                //} else{
                ////}
            
                //Maximalwerte finden 
                $xmax = -100000;
                $xmin = 100000;
                $ymax = -100000;
                $ymin = 100000;
                
                for ($i = 0; $i < count($Points); $i++){        //jede Fläche durchsuchen        
                    for ($j = 0; $j < count($Points[$i][0]); $j++){ // jede Flächenebene
                        for ($k = 0; $k < count($Points[$i][0][$j]); $k++){  
                            $Surface_Name[$i] = $Points[$i][3];                  
                            if (substr_compare( $Surface_Name[$i], "Trennflaeche_Blockrand_aussen", 0, 28) == 0){ 
                                if ($xmax < $Points[$i][0][$j][$k][1]){
                                    $xmax = $Points[$i][0][$j][$k][1];
                                }
                                if ($xmin > $Points[$i][0][$j][$k][1]){
                                    $xmin = $Points[$i][0][$j][$k][1];
                                }
                                if ($ymax < $Points[$i][0][$j][$k][2]){
                                    $ymax = $Points[$i][0][$j][$k][2];
                                }
                                if ($ymin > $Points[$i][0][$j][$k][2]){
                                    $ymin = $Points[$i][0][$j][$k][2];
                                }          
                            }          
                        }
                    }
                }
            
        //............................Blockumrandung........................................ 

            //Berechnen der Anzahl der Runden bei Zustellung = 8mm
            
            $NumberofRounds = ceil(($zmax+10)/10);      // rundet auf
       



            $z = $zmax;
            $xmax = $xmax;
            $zmin = $zmax - $z_Block;                   // Offset für 20 er SChaftfräser
            if ($Side == "unten"){                      //verdrehen der Punkte für unten
                $ya = $ymax;
                $ymax = $ymin;
                $ymin = $ya;
            }
            if ($includeRoot == "ja"){
                $xmax = $xmax +$DFB;
                $Punkte_Blockumrandung[0][0][0] = "Punkt_Blockrand$j*$k";
                $Punkte_Blockumrandung[0][0][1] = $xmin-10;
                $Punkte_Blockumrandung[0][0][2] = $ymax;
                $Punkte_Blockumrandung[0][0][3] = $zmax;
            } else{
                $xmin = $xmin -$DFB;
                $Punkte_Blockumrandung[0][0][0] = "Punkt_Blockrand$j*$k";
                $Punkte_Blockumrandung[0][0][1] = $xmax+10;
                $Punkte_Blockumrandung[0][0][2] = $ymin;
                $Punkte_Blockumrandung[0][0][3] = $zmax;
            }
            
            if ($includeRoot == "ja" and $includeBlade == "ja"){
                $xmax = $xmax -$DFB;
                $Punkte_Blockumrandung[0][0][0] = "Punkt_Blockrand$j*$k";
                $Punkte_Blockumrandung[0][0][1] = $xmin-10;
                $Punkte_Blockumrandung[0][0][2] = $ymax;
                $Punkte_Blockumrandung[0][0][3] = $zmax;
            }

            


            
            $counter = 1;
            for ($k = 1; $k < $NumberofRounds+1; $k++){
                    $z = $z - 10;
                    if ($k == $NumberofRounds){
                        $z =-10;
                    }
                    for ($i = 0; $i < 5; $i++){
                        if ($includeRoot == "ja" ){
                            $a = 2;
                            if ($i == 0 or $i == 4){
                                $x = $xmin;
                                $y = $ymax;
                            } elseif ($i == 1){
                                $x = $xmax;
                                $y = $ymax;
                            } elseif ($i == 2){
                                $x = $xmax;
                                $y = $ymin;
                            }  elseif ($i == 3){
                                $x = $xmin;
                                $y = $ymin;
                            }
                        } else {
                            $a = 2;
                            if ($i == 0 or $i == 4){
                                $x = $xmax;
                                $y = $ymin;
                            } elseif ($i == 1){
                                $x = $xmin;
                                $y = $ymin;
                            } elseif ($i == 2){
                                $x = $xmin;
                                $y = $ymax;
                            }  elseif ($i == 3){
                                $x = $xmax;
                                $y = $ymax;
                            }
                        }
                        if ($includeBlade == "ja" and $includeRoot == "ja"){
                            $Punkte_Blockumrandung[0][$counter][0] = "Punkt_Blockrand_$counter";
                            $Punkte_Blockumrandung[0][$counter][1] = $x;
                            $Punkte_Blockumrandung[0][$counter][2] = $y;
                            $Punkte_Blockumrandung[0][$counter][3] = $z;
                            $counter++;
                        } else {
                            if ($k == $NumberofRounds and $i == $a ){
                                $zc = $z-20;
                                $NumberofFrontrounds =  abs(ceil(($zmin-$z)/10));
                                if ($NumberofFrontrounds == 0){
                                    $NumberofFrontrounds = 1;
                                }
                                for ($j = 0; $j < $NumberofFrontrounds; $j++){
                                    if ($zc< $zmin){
                                        $zc = $zmin;
                                    }
                                    $Punkte_Blockumrandung[0][$counter][0] = "Punkt_Blockrand_$counter";
                                    $Punkte_Blockumrandung[0][$counter][1] = $x;
                                    $Punkte_Blockumrandung[0][$counter][2] = $y;
                                    $Punkte_Blockumrandung[0][$counter][3] = $z;
                                    $counter++;

                                    $Punkte_Blockumrandung[0][$counter][0] = "Punkt_Blockrand_$counter";
                                    $Punkte_Blockumrandung[0][$counter][1] = $x;
                                    $Punkte_Blockumrandung[0][$counter][2] = $y;
                                    $Punkte_Blockumrandung[0][$counter][3] = $zc+10;
                                    $counter++;
                                    
                                    $Punkte_Blockumrandung[0][$counter][0] = "Punkt_Blockrand_$counter";
                                    $Punkte_Blockumrandung[0][$counter][1] = $x;
                                    if ($includeRoot == "ja"){
                                        $Punkte_Blockumrandung[0][$counter][2] = $ymax;
                                    } else {
                                        $Punkte_Blockumrandung[0][$counter][2] = $ymin;
                                    }
                                    $Punkte_Blockumrandung[0][$counter][3] = $zc+10;
                                    $counter++;
                                            
                                    $Punkte_Blockumrandung[0][$counter][0] = "Punkt_Blockrand_$counter";
                                    $Punkte_Blockumrandung[0][$counter][1] = $x;

                                    if ($includeRoot == "ja"){
                                        $Punkte_Blockumrandung[0][$counter][2] = $ymax;
                                    } else {
                                        $Punkte_Blockumrandung[0][$counter][2] = $ymin;
                                    }
                                        
                                    $Punkte_Blockumrandung[0][$counter][3] = $zc;
                                    $counter++;
                                            
                                    $Punkte_Blockumrandung[0][$counter][0] = "Punkt_Blockrand_$counter";
                                    $Punkte_Blockumrandung[0][$counter][1] = $x;
                                    if ($includeRoot == "ja" ){
                                        $Punkte_Blockumrandung[0][$counter][2] = $ymin;
                                    } else {
                                        $Punkte_Blockumrandung[0][$counter][2] = $ymax;
                                    }
                                    
                                    $Punkte_Blockumrandung[0][$counter][3] = $zc;
                                    $counter++; 
                                        
                                    $zc = $zc -10;
                                }
                                $Punkte_Blockumrandung[0][$counter][0] = "Punkt_Blockrand_$counter";
                                $Punkte_Blockumrandung[0][$counter][1] = $x;
                                $Punkte_Blockumrandung[0][$counter][2] = $y;
                                $Punkte_Blockumrandung[0][$counter][3] = -10;
                                $counter++; 
                            } else {
                                $Punkte_Blockumrandung[0][$counter][0] = "Punkt_Blockrand_$counter";
                                $Punkte_Blockumrandung[0][$counter][1] = $x;
                                $Punkte_Blockumrandung[0][$counter][2] = $y;
                                $Punkte_Blockumrandung[0][$counter][3] = $z;
                                $counter++;
                            }
                            $Punkte_Blockumrandung[0][$counter][0] = "Punkt_Blockrand_$counter";
                            $Punkte_Blockumrandung[0][$counter][1] = $x;
                            $Punkte_Blockumrandung[0][$counter][2] = $y;
                            $Punkte_Blockumrandung[0][$counter][3] = $z;
                            $counter++;  
                        }
                        
                    }
            }
                if ($includeRoot == "ja"){
                    
                    $Punkte_Blockumrandung[0][$counter][0] = "Punkt_Blockrand_$counter";
                    $Punkte_Blockumrandung[0][$counter][1] = $xmin -20;
                    $Punkte_Blockumrandung[0][$counter][2] = $y;
                    $Punkte_Blockumrandung[0][$counter][3] = $zmax;
                } else{
                
                    $Punkte_Blockumrandung[0][$counter][0] = "Punkt_Blockrand_$counter";
                    $Punkte_Blockumrandung[0][$counter][1] = $xmax +20;
                    $Punkte_Blockumrandung[0][$counter][2] = $y;
                    $Punkte_Blockumrandung[0][$counter][3] = $zmax;
                }

                
            
            
            
                





        //............................Tiefenrechteck........................................
            //werden zur Begrenzung beim Schruppen benötigt um die maximale Tiefenzustellung zu begrenzen
            $NumberofRounds = ceil(($z_Block)/8);

            $counter = 0;
            $z = $zmax;
            for ($k = 0; $k < $NumberofRounds; $k++){
                $z = $z -8;
                if ($Side == "oben"){
                    if ($k == $NumberofRounds-1){
                    $z =0;
                    }
                }
                for ($j = 0; $j < 2; $j++){     //Ebenenschleife
                    for ($i = 0; $i < 2; $i++){     //Punktschleife
                        if ($j == 0 and $i == 0){
                            $x = $xmin;
                            $y = $ymin;
                        } elseif ($j == 0 and $i == 1){
                            $x = $xmin;
                            $y = $ymax;
                        } elseif ($j == 1 and $i == 0){
                            $x = $xmax;
                            if ($Side == "oben"){
                                $y = $ymin;
                            } else {
                                $y = $ymax;
                            }            
                        }  elseif ($j == 1 and $i == 1){
                            $x = $xmax;
                            if ($Side == "oben"){
                                $y = $ymax;
                            } else {
                                $y = $ymin;
                            }
                            
                        }
                        $Punkte_Tiefenquadrate[$k][$j][$i][0] = "Punkt_Tiefenrechteck $k-P$j";
                        $Punkte_Tiefenquadrate[$k][$j][$i][1] = $x;
                        $Punkte_Tiefenquadrate[$k][$j][$i][2] = $y;
                        $Punkte_Tiefenquadrate[$k][$j][$i][3] = $z;
                        $counter++;
                    }
                }
            }
        
        //............................Drehen aller Flächenpunkte........................................ 
            $deltay = abs($ymax) - abs($ymin);
                if ($Side == "unten") {
                    $deltay = abs($ymax) - abs($ymin);
                    for ($i = 0; $i < count($Punkte_Blockumrandung[0]); $i++){
                        $Punkte_Blockumrandung[0][$i][2] = -$Punkte_Blockumrandung[0][$i][2]-$deltay;
                    }
                    for ($i = 0; $i < count($Punkte_Tiefenquadrate); $i++){
                        for ($j = 0; $j < count($Punkte_Tiefenquadrate[$i][0]); $j++){
                            $Punkte_Tiefenquadrate[$i][0][$j][2]  = -$Punkte_Tiefenquadrate[$i][0][$j][2]-$deltay;
                        }
                    }
                    for ($i = 0; $i < count($Points); $i++){  // jede Fläche
                    for ($j = 0; $j < count($Points[$i][0]); $j++){  //jede Ebene der Fläche
                        for ($k = 0; $k < count($Points[$i][0][0]); $k++){
                            $Points[$i][0][$j][$k][2] = - $Points[$i][0][$j][$k][2]-$deltay;
                            $Points[$i][0][$j][$k][3] = - $Points[$i][0][$j][$k][3];
                        }
                    }
                }
                } else {
                    $deltay = 0;
                }


        //............................Rechteck VK oder HK........................................
            if ($Side == "oben"){
                $a = "Trennflaeche_Tangentenrand_hinten";
            } else {
                $a = "Trennflaeche_Tangentenrand_vorne";
            }
            if ($Turn_Direction == "rechts"){
                $b = 30;
            } else {
                $b = -30;

            }

            for ($i = 0; $i < count($Points); $i++){ 
                $Surface_Name[$i] = $Points[$i][3];
                if ($Surface_Name[$i] == $a){   //sucht Tantentenrand Fläche um Koordinaten zu übernehmen
                    $Punkte_K_Rechteck[0][0] = $Points[$i][0][0][0];
                    $Punkte_K_Rechteck[0][0][2] = $Punkte_K_Rechteck[0][0][2] +$b;
                    $Punkte_K_Rechteck[0][0][3] = $z_Cam_Lines-3;
                    $Punkte_K_Rechteck[0][1] =  $Punkte_K_Rechteck[0][0];
                    $Punkte_K_Rechteck[0][1][2] = $Punkte_K_Rechteck[0][0][2] -2*$b;

                    $Punkte_K_Rechteck[0][2] = $Points[$i][0][ceil((count($Points[$i][0])-1)/2)-1][0];  //ca. mittlere EBene von Tantenrand für stark gekrümmte Blätter
                    $Punkte_K_Rechteck[0][2][2] = $Punkte_K_Rechteck[0][2][2] -$b;
                    $Punkte_K_Rechteck[0][2][3] = $z_Cam_Lines-3;
                    if ($includeBlade == "ja"){
                        $Punkte_K_Rechteck[0][3] = $Points[$i][0][count($Points[$i][0])-3][0];  //vor-vorletzte Ebene von Tantentenrand
                    } else {
                        $Punkte_K_Rechteck[0][3] = $Points[$i][0][count($Points[$i][0])-1][0];  //letzte Ebene von Tantentenrand
                    }
                    
                    $Punkte_K_Rechteck[0][3][2] = $Punkte_K_Rechteck[0][3][2] -$b;
                    $Punkte_K_Rechteck[0][3][3] = $z_Cam_Lines-3;

                    $Punkte_K_Rechteck[0][4] =  $Punkte_K_Rechteck[0][3];                
                    $Punkte_K_Rechteck[0][4][2] = $Punkte_K_Rechteck[0][3][2] +2*$b;


                    $Punkte_K_Rechteck[0][5] =  $Punkte_K_Rechteck[0][2];                
                    $Punkte_K_Rechteck[0][5][2] = $Punkte_K_Rechteck[0][2][2] +2*$b;    

                    $Punkte_K_Rechteck[0][6] =  $Punkte_K_Rechteck[0][0];

                }
            }


        //............................Begrenzung_Distanzfläche_Rundung........................................

            if ($xmax >= 200){
                $c = 15;
            } else {
                $c =0;
            }

            
            if ($includeRoot == "ja"){
                if ($Side == "oben"){
                    if ($Turn_Direction == "rechts"){
                        $a = +30;
                        $b = -20;
                    } else {
                        $a = +30;
                        $b = 20;
                    }
                } else {
                    if ($Turn_Direction == "rechts"){
                        $a = +30;
                        $b = 20;
                    } else {
                        $a = +30;
                        $b = -20;
                    }
                }
            } else{
                 if ($Side == "oben"){
                    if ($Turn_Direction == "rechts"){
                        $a = -30;
                        $b = -20;
                    } else {
                        $a = -30;
                        $b = 20;
                    }
                } else {
                    if ($Turn_Direction == "rechts"){
                        $a = -30;
                        $b = 20;
                    } else {
                        $a = -30;
                        $b = -20;
                    }
                }
            }

            for ($i = 0; $i < count($Points); $i++){ 
                $Surface_Name[$i] = $Points[$i][3];
                if ($Surface_Name[$i] == "Trennflaeche_Blockrand"){   //sucht Blockrand Fläche um Koordinaten zu übernehmen        
                    $Punkte_Trennflaeche_Blockrand = $Points[$i][0];
                    $Punkte_Begrenzung_Distanzfläche_Rundung[0][0] = $Punkte_Trennflaeche_Blockrand[1][1];          //übernehmen der Blockrand-Ecken
                    $Punkte_Begrenzung_Distanzfläche_Rundung[0][0][3] = $z_Cam_Lines;
                    $Punkte_Begrenzung_Distanzfläche_Rundung[0][1] = $Punkte_Trennflaeche_Blockrand[2][1];
                    $Punkte_Begrenzung_Distanzfläche_Rundung[0][1][3] =$z_Cam_Lines;

                    $Punkte_Begrenzung_Distanzfläche_Rundung[0][2] = $Punkte_Begrenzung_Distanzfläche_Rundung[0][1];
                    $Punkte_Begrenzung_Distanzfläche_Rundung[0][2][1] = $Punkte_Begrenzung_Distanzfläche_Rundung[0][1][1]+$a;
                    $Punkte_Begrenzung_Distanzfläche_Rundung[0][2][2] = $Punkte_Begrenzung_Distanzfläche_Rundung[0][1][2]+$b;

                    $Punkte_Begrenzung_Distanzfläche_Rundung[0][3] = $Punkte_Begrenzung_Distanzfläche_Rundung[0][0];
                    $Punkte_Begrenzung_Distanzfläche_Rundung[0][3][1] = $Punkte_Begrenzung_Distanzfläche_Rundung[0][0][1]+$a;
                    $Punkte_Begrenzung_Distanzfläche_Rundung[0][3][2] = $Punkte_Begrenzung_Distanzfläche_Rundung[0][0][2]-$b;

                    $Punkte_Begrenzung_Distanzfläche_Rundung[0][4] = $Punkte_Begrenzung_Distanzfläche_Rundung[0][0];
                }
            }

        //............................Begrenzung_Zapfen(A, V)........................................
            $xmax_Za = -100000;
            $xmin_Za = 100000;
            $ymax_Za = -100000;
            $ymin_Za = 100000;




            for ($i = 0; $i < count($Points); $i++){
                $Surface_Name[$i] = $Points[$i][3];
                if ($Surface_Name[$i] == "Fläche_Zapfen_oben"){   //sucht Zapfenfläche um Koordinaten zu übernehmen
                    $Punkte_Zapfen = $Points[$i][0];
                    for ($j = 0; $j < count($Punkte_Zapfen); $j++){ // jede Flächenebene
                        for ($k = 0; $k < count($Punkte_Zapfen[$j]); $k++){
                    
                                if ($xmax_Za < $Punkte_Zapfen[$j][$k][1]){
                                    $xmax_Za = $Punkte_Zapfen[$j][$k][1];
                                }
                                if ($xmin_Za > $Punkte_Zapfen[$j][$k][1]){
                                    $xmin_Za = $Punkte_Zapfen[$j][$k][1];
                                }
                                if ($ymax_Za < $Punkte_Zapfen[$j][$k][2]){
                                    $ymax_Za = $Punkte_Zapfen[$j][$k][2];
                                }
                                if ($ymin_Za > $Punkte_Zapfen[$j][$k][2]){
                                    $ymin_Za = $Punkte_Zapfen[$j][$k][2];
                                }          
                                        
                        }
                    }
                    $Punkte_Begrenzung_Zapfen[0][0][0] = "Punkte_Begrenzung_Zapfen";
                    $Punkte_Begrenzung_Zapfen[0][0][1] = $xmax_Za+20;
                    $Punkte_Begrenzung_Zapfen[0][0][2] = $ymax_Za+30;
                    $Punkte_Begrenzung_Zapfen[0][0][3] = $z_Cam_Lines+5;

                    $Punkte_Begrenzung_Zapfen[0][1][0] = "Punkte_Begrenzung_Zapfen";
                    $Punkte_Begrenzung_Zapfen[0][1][1] = $xmax_Za+20;
                    $Punkte_Begrenzung_Zapfen[0][1][2] = $ymin_Za-30;
                    $Punkte_Begrenzung_Zapfen[0][1][3] = $z_Cam_Lines+5;

                    $Punkte_Begrenzung_Zapfen[0][2][0] = "Punkte_Begrenzung_Zapfen";
                    $Punkte_Begrenzung_Zapfen[0][2][1] = $xmin_Za-20;
                    $Punkte_Begrenzung_Zapfen[0][2][2] = $ymin_Za-30;
                    $Punkte_Begrenzung_Zapfen[0][2][3] = $z_Cam_Lines+5;

                    $Punkte_Begrenzung_Zapfen[0][3][0] = "Punkte_Begrenzung_Zapfen";
                    $Punkte_Begrenzung_Zapfen[0][3][1] = $xmin_Za-20;
                    $Punkte_Begrenzung_Zapfen[0][3][2] = $ymax_Za+30;
                    $Punkte_Begrenzung_Zapfen[0][3][3] = $z_Cam_Lines+5;

                    $Punkte_Begrenzung_Zapfen[0][4][0] = "Punkte_Begrenzung_Zapfen";
                    $Punkte_Begrenzung_Zapfen[0][4][1] = $xmax_Za+20;
                    $Punkte_Begrenzung_Zapfen[0][4][2] = $ymax_Za+30;
                    $Punkte_Begrenzung_Zapfen[0][4][3] = $z_Cam_Lines+5;
                }
            }

        //............................Begrenzung_Verbindungsfläche_Rundung........................................
            if ($includeRoot == "ja" and $Roottyp == "F"){       //nachfolgende Linien werden nur für Wurzel erzeugt



                if ($Side == "oben"){
                    if ($Turn_Direction == "rechts"){
                        $a = -5;
                        $b = -20;
                        $c = -10;
                    } else {
                        $a = -5;
                        $b = 20;
                        $c = 10;
                    }
                } else {
                    if ($Turn_Direction == "rechts"){
                        $a = -5;
                        $b = -20;
                        $c = -10;
                    } else {
                        $a = -5;
                        $b = 20;
                        $c = 10;
                    }
                }
            
            

                
                for ($i = 0; $i < count($Points); $i++){
                    $Surface_Name[$i] = $Points[$i][3];
                    if ($Side == "oben"){
                        $Temp_Surf_Name = "Flanschflaeche_Ebene-3";
                    } else {
                        $Temp_Surf_Name = "Flanschflaeche_Ebene-2";
                    }
                    if ($Surface_Name[$i] == $Temp_Surf_Name){
                        $Punkte_Flanschflaeche_Ebene_2 = $Points[$i][0];
                    }
                

                    if ($Surface_Name[$i] == "Verbindungsflaeche_2_3_Aussen"){   //sucht Blockrand Fläche um Koordinaten zu übernehmen        
                        $Punkte_Verbindungsflaeche_1_2_Aussen = $Points[$i][0];
                        
                        $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][0] = $Punkte_Verbindungsflaeche_1_2_Aussen[0][0];          //übernehmen der Blockrand-Ecken
                        $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][0][1] = $Punkte_Verbindungsflaeche_1_2_Aussen[0][0][1]+$a;
                        $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][0][2] = $Punkte_Verbindungsflaeche_1_2_Aussen[0][0][2]+$a;
                        $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][0][3] =  $z_Cam_Lines+5;

                        $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][1] = $Punkte_Flanschflaeche_Ebene_2[1][1];
                        $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][1][1] = $Punkte_Verbindungsflaeche_1_2_Aussen[0][1][1]+$a;
                        $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][1][3] =$z_Cam_Lines+5;

                        $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][2] = $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][1];
                        $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][2][1] = $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][1][1]+20;
                        //$Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][2][2] = $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][1][2]+25;

                        $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][3] = $Punkte_Flanschflaeche_Ebene_2[2][1];
                        //$Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][3][1] = $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][2][1]+20;
                        $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][3][2] = $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][3][2]-$b;
                        $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][3][3] = $z_Cam_Lines+5;

                        $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][2][1] =  $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][3][1];
                        $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][2][2] = $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][3][2]+$c;

                        $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][4] = $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][3];
                        $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][4][1] = $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][4][1]-25;
                        $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][4][2] = $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][4][2]-1.5*$b;

                        $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][5] = $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][0];
                        $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][5][1] = $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][0][1]+20;

                        $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][6] = $Punkte_Begrenzung_Verbindungsflaeche_Rundung[0][0];
                    } 
                }
                

        //............................Begrenzung_Distanzfläche_Stufe........................................   
            if ($Side == "oben" ){
                if ($Turn_Direction == "rechts" ){
                    $a = -40;
                } else {
                    $a = 40;
                }
                
            } else {
                if ($Turn_Direction == "rechts" ){
                    $a = 40;
                } else {
                    $a = -40;
                }
            }
            
            
                for ($i = 0; $i < count($Points); $i++){
                    $Surface_Name[$i] = $Points[$i][3];
                    if ($Surface_Name[$i] == "Trennflaeche_Tangentenrand_Stufe"){   //sucht Blockrand Fläche um Koordinaten zu übernehmen        
                        $Tangentenrand_Stufe = $Points[$i][0];
                        
                        $Punkte_Begrenzung_Distanzfläche_Stufe[0][0] = $Tangentenrand_Stufe[0][0];          //übernehmen der Blockrand-Ecken
                        $Punkte_Begrenzung_Distanzfläche_Stufe[0][0][3] =  $z_Cam_Lines-5;
                        $Punkte_Begrenzung_Distanzfläche_Stufe[0][0][2] = $Punkte_Begrenzung_Distanzfläche_Stufe[0][0][2] +$deltay-$a/2;

                        $Punkte_Begrenzung_Distanzfläche_Stufe[0][1] = $Punkte_Begrenzung_Distanzfläche_Stufe[0][0];
                        $Punkte_Begrenzung_Distanzfläche_Stufe[0][1][1] = $Punkte_Begrenzung_Distanzfläche_Stufe[0][0][1]-50;

                        $Punkte_Begrenzung_Distanzfläche_Stufe[0][2] = $Punkte_Begrenzung_Distanzfläche_Stufe[0][1];
                        $Punkte_Begrenzung_Distanzfläche_Stufe[0][2][2] = $Punkte_Begrenzung_Distanzfläche_Stufe[0][1][2]+$a;

                        $Punkte_Begrenzung_Distanzfläche_Stufe[0][3] = $Punkte_Begrenzung_Distanzfläche_Stufe[0][0];
                        $Punkte_Begrenzung_Distanzfläche_Stufe[0][3][2] = $Punkte_Begrenzung_Distanzfläche_Stufe[0][0][2]+$a;

                        $Punkte_Begrenzung_Distanzfläche_Stufe[0][4] = $Punkte_Begrenzung_Distanzfläche_Stufe[0][0];
                    } 
                }
                
                if ($Side == "unten"){
                    for ($i = 0; $i < count($Punkte_Begrenzung_Distanzfläche_Stufe[0]); $i++){
                        $Punkte_Begrenzung_Distanzfläche_Stufe[0][$i][2] = -$Punkte_Begrenzung_Distanzfläche_Stufe[0][$i][2]-13;            
                    } 
                } 
        //............................Begrenzung_Verbindungsfläche_Stufe........................................
            for ($i = 0; $i < count($Points); $i++){
                $Surface_Name[$i] = $Points[$i][3];
                if ($Side == "oben"){
                    $Name = "Verbindungsflaeche_1_2_Stufe";
                    if ($Turn_Direction == "rechts"){
                        $y_Offset = -2.945;
                    } else {
                        $y_Offset = 2.945;
                    }
                    if ($Surface_Name[$i] == $Name){   //sucht Blockrand Fläche um Koordinaten zu übernehmen        
                        $Verbindungsflaeche_Stufe = $Points[$i][0];            
                        $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][0] = $Verbindungsflaeche_Stufe[0][1];          //übernehmen der Verbindungsflächen Stufen Ecken
                        $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][0][1] = $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][0][1]-10;
                        $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][0][2] = $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][0][2]+$y_Offset;
                        $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][0][3] = $z_Cam_Lines+1;
                        $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][1] = $Verbindungsflaeche_Stufe[3][1];          //übernehmen der Verbindungsflächen Stufen Ecken
                        $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][1][2] = $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][1][2]+$y_Offset;
                        $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][1][3] = $z_Cam_Lines+1;
                        $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][2] = $Verbindungsflaeche_Stufe[3][0];          //übernehmen der Verbindungsflächen Stufen Ecken
                        //$Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][2][2] = $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][2][2]+$y_Offset;
                        $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][2][3] = $z_Cam_Lines+1;
                        $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][3] = $Verbindungsflaeche_Stufe[0][0];          //übernehmen der Verbindungsflächen Stufen Ecken
                        //$Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][3][2] = $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][3][2]+$y_Offset;
                        $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][3][1] = $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][3][1]-10;
                        $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][3][3] = $z_Cam_Lines+1;
                    }
                }
                else {
                    $Name = "Verbindungsflaeche_2_3_Stufe";
                    if ($Turn_Direction == "rechts"){
                        $y_Offset = -2.945;
                    } else {
                        $y_Offset = 2.945;
                    }
                    
                    if ($Surface_Name[$i] == $Name){   //sucht Blockrand Fläche um Koordinaten zu übernehmen        
                        $Verbindungsflaeche_Stufe = $Points[$i][0];            
                        $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][0] = $Verbindungsflaeche_Stufe[0][0];          //übernehmen der Verbindungsflächen Stufen Ecken
                        $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][0][1] = $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][0][1]-10;
                        $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][0][2] = $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][0][2]+$y_Offset;
                        $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][0][3] = $z_Cam_Lines-2;
                        $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][1] = $Verbindungsflaeche_Stufe[3][0];          //übernehmen der Verbindungsflächen Stufen Ecken
                        $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][1][2] = $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][1][2]+$y_Offset;
                        $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][1][3] =  $z_Cam_Lines-2;
                        $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][2] = $Verbindungsflaeche_Stufe[3][1];          //übernehmen der Verbindungsflächen Stufen Ecken
                        $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][2][3] = $z_Cam_Lines-2;
                        $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][3] = $Verbindungsflaeche_Stufe[0][1];          //übernehmen der Verbindungsflächen Stufen Ecken
                        $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][3][1] = $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][3][1]-10;
                        $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][3][3] =  $z_Cam_Lines-2;
                    }
                }
            }

            
            $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][4] = $Punkte_Begrenzung_Verbindungsflaeche_Stufe[0][0];

        //............................Begrenzung_Ebene........................................
            
            if ($Side == "oben" ){
                if ($Turn_Direction == "rechts" ){
                    $y_Offset = -40;
                    $a = 0;
                } else {
                    $y_Offset = 40;
                    $a = 0;
                }
                
            } else {
                if ($Turn_Direction == "rechts" ){
                    $y_Offset = -40;
                    $a = 1;
                } else {
                    $y_Offset = 40;
                    $a =0;

                }
            }
            
            
            $Punkte_Begrenzung_Ebene[0][0] = $Verbindungsflaeche_Stufe[0][$a];          //übernehmen der Verbindungsflächen Stufen Ecken
            $Punkte_Begrenzung_Ebene[0][0][3] = $z_Cam_Lines;
            $Punkte_Begrenzung_Ebene[0][1] = $Verbindungsflaeche_Stufe[3][$a];
            $Punkte_Begrenzung_Ebene[0][1][3] = $z_Cam_Lines;
            $Punkte_Begrenzung_Ebene[0][2] = $Punkte_Begrenzung_Ebene[0][1];
            $Punkte_Begrenzung_Ebene[0][2][2] = $Punkte_Begrenzung_Ebene[0][1][2] + $y_Offset;
            $Punkte_Begrenzung_Ebene[0][3] = $Punkte_Begrenzung_Ebene[0][0];
            $Punkte_Begrenzung_Ebene[0][3][2] = $Punkte_Begrenzung_Ebene[0][0][2] + $y_Offset;
            $Punkte_Begrenzung_Ebene[0][4] = $Punkte_Begrenzung_Ebene[0][0];





            


        //............................Output........................................


            
            $BlockPoints[1][0]=$Punkte_Begrenzung_Verbindungsflaeche_Rundung;
            $BlockPoints[2][0]=$Punkte_Begrenzung_Distanzfläche_Stufe;
            $BlockPoints[3][0]=$Punkte_Begrenzung_Verbindungsflaeche_Stufe;
            $BlockPoints[4][0]=$Punkte_Begrenzung_Ebene;
            } else {                      // Klammer für includeRoot Abfrage 
                $BlockPoints[1][0]="";
                $BlockPoints[2][0]="";
                $BlockPoints[3][0]="";
                $BlockPoints[4][0]="";
            
            }                                                 
                                        
            if ($includeExtension == "ja" and $includeRoot <> "ja"){
                $BlockPoints[0][0]="";
            } else {
                $BlockPoints[0][0]=$Punkte_Begrenzung_Distanzfläche_Rundung;
            }
                
                $BlockPoints[5][0]=$Punkte_Blockumrandung;
                $BlockPoints[6][0]=$Punkte_Tiefenquadrate[0];
                $BlockPoints[7][0]=$Punkte_Tiefenquadrate[1];
                $BlockPoints[8][0]=$Punkte_Tiefenquadrate[2];
                $BlockPoints[9][0]=$Punkte_Tiefenquadrate[3];
                $BlockPoints[10][0] = $Punkte_K_Rechteck;
                if ($includeRoot =="ja" and  $Roottyp == "V"){
                    $BlockPoints[11][0] = $Punkte_Begrenzung_Zapfen;
                }
              
            
            
                for ($i = 0; $i < count($BlockPoints); $i++){
                if ($i == 0){
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="CAM_Linie_Distanzfläche_Spitze";
                    $Surface_Colour[$i] = "('NONE',1,1,1)";
                } elseif ($i == 1){
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="CAM_Linie_Verbindungsfläche_Rundung";
                    $Surface_Colour[$i] = "('NONE',0.1,0.6,0.8)";
                } elseif ($i == 2){
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="CAM_Linie_Distanzfläche_Stufe";
                    $Surface_Colour[$i] = "('NONE',0.1,0.6,0.8)";
                } elseif ($i == 3){
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="CAM_Linie_Verbindungsflaeche_Stufe";
                    $Surface_Colour[$i] = "('NONE',0.8,0.3,0.5)";
                } elseif ($i == 4){
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="CAM_Linie_Begrenzung_Ebene";
                    $Surface_Colour[$i] = "('NONE',0.5,0.9,0.7)";
                }elseif ($i == 5){
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="CAM_Linie_Blockrand";
                    $Surface_Colour[$i] = "('NONE',0.5,0.9,0.7)";
                } elseif($i == 6){
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="Tiefenbegrenzung 1";
                    $Surface_Colour[$i] = "('NONE',0.5,0.9,0.7)";
                } elseif($i == 7){
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="Tiefenbegrenzung 2";
                    $Surface_Colour[$i] = "('NONE',0.5,0.9,0.7)";
                } elseif($i == 8){
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="Tiefenbegrenzung 3";
                    $Surface_Colour[$i] = "('NONE',0.5,0.9,0.7)";
                } elseif($i == 9){
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="Tiefenbegrenzung 4";
                    $Surface_Colour[$i] = "('NONE',0.5,0.9,0.7)";
                } elseif($i == 10){
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="CAM_Linie_HK_Rechteck";
                    $Surface_Colour[$i] = "('NONE',0.5,0.9,0.7)";
                } elseif($i == 11){
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="CAM_Linie_Zapfen";
                    $Surface_Colour[$i] = "('NONE',0.5,0.9,0.7)";
                }
                
                if ($BlockPoints[$i][0] == ""){    //wenn keine Punkte zugewiesen, werden alle Werte auf leer gesetzt und herausgefiltert
                    $BlockPoints[$i] = "";
                    
            
                } else {
                    $BlockPoints[$i][1] = $u;
                    $BlockPoints[$i][2] = $v;
                    $BlockPoints[$i][3] = $Surface_Name[$i];
                    $BlockPoints[$i][4] = $Surface_Colour[$i]; 
                } 
            
            }
                $BlockPoints = array_filter($BlockPoints);
                $BlockPoints = array_merge($BlockPoints);
                $Point_Array_CAM[0] = $Points; //gibt gedrehte Punkte zurück
                $Point_Array_CAM[1] = $BlockPoints; //Gibt CAM Punkte zurück



            return($Point_Array_CAM);
                    



    }
    function Geometry_Calculation_RootAV($Punkte_Blatt, $includeblock , $inputWurzel_AV, $inputWurzel_Block, $Side, $Turn_Direction){ //Geometrieberechnung der Wurzel Typ A/V   
        //............................Input.........................................
                //Input Block

               
            
                
                $zKW = $inputWurzel_Block[0];             //z-Verschiebung Tangentenrand
                $bTR = $inputWurzel_Block[1][0];             //Trennfläche_Tangentenrand Breite
                $bB = $inputWurzel_Block[2][0];              //Blockrand Breite
                $PB = $inputWurzel_Block[3];              //Blockabmaße
                $P0B = $inputWurzel_Block[4];             //Blocknullpunkt
                $PZK = $inputWurzel_Block[5];             //Punkt Zentrierkonus
                $DFB = $inputWurzel_Block[6][0];             //Fräserdurchmesser Blockrand
            
           
            
            $Cone_Angle =  -$inputWurzel_AV[0][0];                 //V-Winkel der Wurzel
            $RotationAngleBlock =   $inputWurzel_AV[1][0]/180*pi();          //Verdrehwinkel in die Blockebene                     
            $WT = $inputWurzel_AV[2][0];                          
            $AT = $inputWurzel_AV[3][0];   
            $x_RPS =  $inputWurzel_AV[4][0]; 
            $HTB =  $inputWurzel_AV[5][0];                      
            //$Kompatibility = $inputWurzel_AV[6][0];


            for ($i = 0; $i < count($inputWurzel_AV[6]); $i++){
                $CircleStations[$i][0] = $inputWurzel_AV[7][$i];
                $CircleStations[$i][1] = $inputWurzel_AV[8][$i];
                $CircleStations[$i][2] = $inputWurzel_AV[9][$i];
                $CircleStations[$i][3] = $inputWurzel_AV[10][$i];
            }
            $CircleStations = array_merge($CircleStations);

           


           

            

            if ($Side == 'oben')                                                                //Offset für oben oder unten setzen um Spalt zu generieren
                {$Distanzflaechen_zOffset = 0.6;}     //0.6                       
            else
                {$Distanzflaechen_zOffset = -0.6;}

            $Distanzflaechen_yOffset = 2;
            $Distanzflaechen_xOffset = 2;

            
                                    



        //............................Kreisabschnitte......................................
            $Rf1 = 1.496;             //Rundfaktor zur Spline-Halbkreis-Wandlung 5.Ordnung mitte außen (Richardsche Kreis Annäherung)
            $Rf2 = 0.88;
            $Rf3 = 0.7815;             //Rundfaktor zur Spline-Viertelkreis-Wandlung 4.Ordnung mitte außen
            $Rf4 = 0.2627;
            $Rf5 = 0.7913;             //Rundfaktor zur Spline-Halbkreis-Wandlung 5.Ordnung mitte außen
            $Rf6 = 0.3916;    

            for ($i = 0; $i < count($CircleStations); $i++){    //Ebenenschleife    
                $x = $CircleStations[$i][0];
                for ($j = 0; $j < 5; $j++){
                    if ($j == 0){
                        $y = $CircleStations[$i][1]-$CircleStations[$i][3]/2;
                        $z_up = $CircleStations[$i][2];
                        $z_down = $CircleStations[$i][2];
                    }  elseif ($j == 1){
                        $y = $CircleStations[$i][1]-$CircleStations[$i][3]/2;
                        $z_up = $CircleStations[$i][2]+$CircleStations[$i][3]/2*$Rf2;
                        $z_down = $CircleStations[$i][2]-$CircleStations[$i][3]/2*$Rf2;
                    }  elseif ($j == 2){
                        $y = $CircleStations[$i][1];
                        $z_up = $CircleStations[$i][2]+$CircleStations[$i][3]/2*$Rf1;
                        $z_down = $CircleStations[$i][2]-$CircleStations[$i][3]/2*$Rf1;
                    }  elseif ($j == 3){
                        $y = $CircleStations[$i][1]+$CircleStations[$i][3]/2;
                        $z_up = $CircleStations[$i][2]+$CircleStations[$i][3]/2*$Rf2;
                        $z_down = $CircleStations[$i][2]-$CircleStations[$i][3]/2*$Rf2;
                    }  elseif ($j == 4){
                        $y = $CircleStations[$i][1]+$CircleStations[$i][3]/2;
                        $z_up = $CircleStations[$i][2];
                        $z_down = $CircleStations[$i][2];
                    }
                    $Punkte_Kreisabschnitte_oben[$i][$j][0] = "Punke_Kreisabschnitte_Zapfen_oben_E$i P$j";
                    $Punkte_Kreisabschnitte_oben[$i][$j][1] = $x;
                    $Punkte_Kreisabschnitte_oben[$i][$j][2] = $y;
                    $Punkte_Kreisabschnitte_oben[$i][$j][3] = $z_up;

                    $Punkte_Kreisabschnitte_unten[$i][$j][0] = "Punke_Kreisabschnitte_Zapfen_unten_E$i P$j";
                    $Punkte_Kreisabschnitte_unten[$i][$j][1] = $x;
                    $Punkte_Kreisabschnitte_unten[$i][$j][2] = $y;      
                    $Punkte_Kreisabschnitte_unten[$i][$j][3] = $z_down;


                }     

            }

            if ($Turn_Direction == "rechts"){
                for ($i = 0; $i < count($Punkte_Blatt); $i++){               //jede Fläche
                for ($j = 0; $j < count($Punkte_Blatt[$i][0]);$j++){             //jede Flächenebene
                    for ($k = 0; $k < count($Punkte_Blatt[$i][0][$j]); $k++){      //jeder Punkt
                            $Punkte_Blatt[$i][0][$j][$k][2]= - $Punkte_Blatt[$i][0][$j][$k][2];
                        }
                    }
                }
            }









        //............................Blattfläche...................................

                for ($j = 0; $j < count($Punkte_Kreisabschnitte_oben[0]); $j++){
                    if ($j == 4){
                        $a = $HTB;
                    } else {
                        $a = 0;
                    }
                    $Punkte_Blattflaeche_oben[0][$j] = $Punkte_Kreisabschnitte_oben[count($Punkte_Kreisabschnitte_oben)-1][$j]; //übernehmen der letzten Ebene des Zepfens
                    $Punkte_Blattflaeche_oben[0][$j][0] = "Punke_Blattfläche_oben E1 P$j";
                
                    $Punkte_Blattflaeche_unten[0][$j] = $Punkte_Kreisabschnitte_unten[count($Punkte_Kreisabschnitte_unten)-1][$j]; //übernehmen der letzten Ebene des Zepfens
                    $Punkte_Blattflaeche_unten[0][$j][0] = "Punke_Blattfläche_oben E1 P$j";

                    $Punkte_Blattflaeche_oben[1][$j]  =  $Punkte_Blattflaeche_oben[0][$j];
                    $Punkte_Blattflaeche_oben[1][$j][0] = "Punke_Blattfläche_oben E2 P$j";
                    $Punkte_Blattflaeche_oben[1][$j][1] =  $Punkte_Blattflaeche_oben[0][$j][1]+$WT;

                $Punkte_Blattflaeche_unten[1][$j]  = $Punkte_Blattflaeche_unten[0][$j];
                $Punkte_Blattflaeche_unten[1][$j][0] = "Punke_Blattfläche_unten E2 P$j";
                $Punkte_Blattflaeche_unten[1][$j][1] = $Punkte_Blattflaeche_unten[0][$j][1]+$WT;

                $Punkte_Blattflaeche_oben[2][$j][0] = "Punkte_Blattflaeche_oben_-E3-P$j";
                $Punkte_Blattflaeche_oben[2][$j][1] = $x_RPS-($AT+$a);
                $Punkte_Blattflaeche_oben[2][$j][2] = $Punkte_Blatt[0][0][0][$j][2] - $x_RPS*(($Punkte_Blatt[0][0][1][$j][2]-$Punkte_Blatt[0][0][0][$j][2])/( $Punkte_Blatt[0][0][1][$j][1]-$Punkte_Blatt[0][0][0][$j][1]))+(($Punkte_Blatt[0][0][1][$j][2]-$Punkte_Blatt[0][0][0][$j][2])/( $Punkte_Blatt[0][0][1][$j][1]-$Punkte_Blatt[0][0][0][$j][1]))*($x_RPS-($AT+$a));
                $Punkte_Blattflaeche_oben[2][$j][3] = $Punkte_Blatt[0][0][0][$j][3] - $x_RPS*(($Punkte_Blatt[0][0][1][$j][3]-$Punkte_Blatt[0][0][0][$j][3])/( $Punkte_Blatt[0][0][1][$j][1]-$Punkte_Blatt[0][0][0][$j][1]))+(($Punkte_Blatt[0][0][1][$j][3]-$Punkte_Blatt[0][0][0][$j][3])/( $Punkte_Blatt[0][0][1][$j][1]-$Punkte_Blatt[0][0][0][$j][1]))*($x_RPS-($AT+$a));

                $Punkte_Blattflaeche_unten[2][$j][0] = "Punkte_Blattflaeche_unten_-E3-P$j";
                $Punkte_Blattflaeche_unten[2][$j][1] = $x_RPS-($AT+$a);
                $Punkte_Blattflaeche_unten[2][$j][2] = $Punkte_Blatt[1][0][0][$j][2] - $x_RPS*(($Punkte_Blatt[1][0][1][$j][2]-$Punkte_Blatt[1][0][0][$j][2])/( $Punkte_Blatt[1][0][1][$j][1]-$Punkte_Blatt[1][0][0][$j][1]))+(($Punkte_Blatt[1][0][1][$j][2]-$Punkte_Blatt[1][0][0][$j][2])/( $Punkte_Blatt[1][0][1][$j][1]-$Punkte_Blatt[1][0][0][$j][1]))*($x_RPS-($AT+$a));
                $Punkte_Blattflaeche_unten[2][$j][3] = $Punkte_Blatt[1][0][0][$j][3] - $x_RPS*(($Punkte_Blatt[1][0][1][$j][3]-$Punkte_Blatt[1][0][0][$j][3])/( $Punkte_Blatt[1][0][1][$j][1]-$Punkte_Blatt[1][0][0][$j][1]))+(($Punkte_Blatt[1][0][1][$j][3]-$Punkte_Blatt[1][0][0][$j][3])/( $Punkte_Blatt[1][0][1][$j][1]-$Punkte_Blatt[1][0][0][$j][1]))*($x_RPS-($AT+$a));


                $Punkte_Blattflaeche_oben[3][$j][0] = "Punkte_Blattflaeche_oben-E4-P$j";
                $Punkte_Blattflaeche_oben[3][$j][1] = $x_RPS;
                $Punkte_Blattflaeche_oben[3][$j][2] = $Punkte_Blatt[0][0][0][$j][2];
                $Punkte_Blattflaeche_oben[3][$j][3] = $Punkte_Blatt[0][0][0][$j][3];

                $Punkte_Blattflaeche_unten[3][$j][0] = "Punkte_Blattflaeche_unten-E4-P$j";
                $Punkte_Blattflaeche_unten[3][$j][1] = $x_RPS;
                $Punkte_Blattflaeche_unten[3][$j][2] = $Punkte_Blatt[1][0][0][$j][2];
                $Punkte_Blattflaeche_unten[3][$j][3] = $Punkte_Blatt[1][0][0][$j][3];
                }
                                    
                    

            $Punkte_Konuswinkel[0] =     $Punkte_Kreisabschnitte_oben; //verpacken in Array für Schleifendurchlauf
            $Punkte_Konuswinkel[1] =     $Punkte_Kreisabschnitte_unten;
            $Punkte_Konuswinkel[2] =     $Punkte_Blattflaeche_oben;
            $Punkte_Konuswinkel[3] =     $Punkte_Blattflaeche_unten;
                
            //Drehung um y-Achse
            for ($i = 0; $i < count($Punkte_Konuswinkel); $i++ ){
                for ($j = 0; $j < count($Punkte_Konuswinkel[$i]); $j++){
                    for ($k = 0; $k <count($Punkte_Konuswinkel[$i][$j]); $k++){
                    if ($i == 2 or $i ==3){
                        if ($j == 0 or $j == 1) {
                            $deltax = $Punkte_Konuswinkel[$i][$j][$k][1]- $x_RPS;           // $x_RPS -  Abstand zwischen Punkt und Drehachse (Achse liegt bei RPS)
                            $Punkte_Konuswinkel[$i][$j][$k][1] = $deltax*cos($Cone_Angle)-$Punkte_Konuswinkel[$i][$j][$k][3]*sin($Cone_Angle);    //Drehung um y-Achse
                            $Punkte_Konuswinkel[$i][$j][$k][3] = $deltax*sin($Cone_Angle)+$Punkte_Konuswinkel[$i][$j][$k][3]*cos($Cone_Angle);
                            $Punkte_Konuswinkel[$i][$j][$k][1] = $Punkte_Konuswinkel[$i][$j][$k][1] +$x_RPS;

                        }

                    } else{
                            $deltax = $Punkte_Konuswinkel[$i][$j][$k][1]- $x_RPS;           // $x_RPS -  Abstand zwischen Punkt und Drehachse (Achse liegt bei RPS)
                            $Punkte_Konuswinkel[$i][$j][$k][1] = $deltax*cos($Cone_Angle)-$Punkte_Konuswinkel[$i][$j][$k][3]*sin($Cone_Angle);    //Drehung um y-Achse
                            $Punkte_Konuswinkel[$i][$j][$k][3] = $deltax*sin($Cone_Angle)+$Punkte_Konuswinkel[$i][$j][$k][3]*cos($Cone_Angle);
                            $Punkte_Konuswinkel[$i][$j][$k][1] = $Punkte_Konuswinkel[$i][$j][$k][1] +$x_RPS;
                    }
                        
                    }
                }
            }
            $Punkte_Kreisabschnitte_oben = $Punkte_Konuswinkel[0];
            $Punkte_Kreisabschnitte_unten = $Punkte_Konuswinkel[1];
            $Punkte_Blattflaeche_oben = $Punkte_Konuswinkel[2];
            $Punkte_Blattflaeche_unten=     $Punkte_Konuswinkel[3];
                
            


            
        //............................Blattflaeche_HK........................................
            $mplus1 = count($Punkte_Blattflaeche_oben);
            $nplus1 = count($Punkte_Blattflaeche_oben[0]);
                for ($i=0; $i < $mplus1; $i++){                     //Ebenenschleife
                    $b = $i +1;
                    for ($j=0; $j < $nplus1;$j ++){                 //Schleife Profilpunkte 
                        $Punkte_Blattflaeche_HK[$i][0] = $Punkte_Blattflaeche_oben[$i][$nplus1-1];                //setzen der HK Punkte
                        $Punkte_Blattflaeche_HK[$i][1] = $Punkte_Blattflaeche_unten[$i][$nplus1-1];                   
                        $Punkte_Blattflaeche_HK[$i][0][0] = "Blattflaeche_HK-E$b-P1";                                           //Namenszuweisung HK Punkte
                        $Punkte_Blattflaeche_HK[$i][1][0] = "Blattflaeche_HK-E$b-P2";
                    }
                }
        //............................Tangentenrand.................................
            if ($includeblock == "ja") {

                for ($i = 0; $i < count($Punkte_Blattflaeche_oben); $i++){                        //Trennfläche_Tangentenrand_vorne    
                    $a = $i+1;                                                                              //übernehmen der Punkte von Blattflächen
                    $Punkte_Trennflaeche_Tangentenrand_vorne[$i][0] = $Punkte_Blattflaeche_oben[$i][0];
                    $Punkte_Trennflaeche_Tangentenrand_vorne[$i][0][3] = $Punkte_Trennflaeche_Tangentenrand_vorne[$i][0][3] +$zKW[$i];
                
                    $Punkte_Trennflaeche_Tangentenrand_vorne[$i][0][0] = "Punkte_Schnittflaeche_E$a-P1";
                    $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1] = $Punkte_Trennflaeche_Tangentenrand_vorne[$i][0];
                    $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][1] = $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][1];
                    if ($i == 2 or $i == 3){
                        $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][2] =  $Punkte_Trennflaeche_Tangentenrand_vorne[$i][0][2]-$bTR;
                    } else{
                        $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][2] =  $Punkte_Trennflaeche_Tangentenrand_vorne[$i][0][2]-15;
                    }
                    //$Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][3] = $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][3] - $zKW[$i]; 
                    $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][0] = "Punkte_Schnittflaeche_E$a-P2";
                    
                }                      
                for ($i = 0; $i < count($Punkte_Blattflaeche_oben); $i++){                        //Trennflaeche_Tangentenrand_hinten    
                    $a = $i+1;    
                    
                    $Punkte_Trennflaeche_Tangentenrand_hinten[$i][0] = $Punkte_Blattflaeche_HK[$i][0];    //übernehmen der Punkte von Blattflächen 
                    $Punkte_Trennflaeche_Tangentenrand_hinten[$i][0][0] = "Punkte_Schnittflaeche_E$a-P1";
                                                                                                        //versetzen der letzten Stützpunkte in die Mitte der HK
                    $Punkte_Trennflaeche_Tangentenrand_hinten[$i][0][2] = ($Punkte_Blattflaeche_HK[$i][0][2]+$Punkte_Blattflaeche_HK[$i][1][2])/2;
                    $Punkte_Trennflaeche_Tangentenrand_hinten[$i][0][3] = ($Punkte_Blattflaeche_HK[$i][0][3]+$Punkte_Blattflaeche_HK[$i][1][3])/2;
                    
                    $Punkte_Trennflaeche_Tangentenrand_hinten[$i][1] = $Punkte_Trennflaeche_Tangentenrand_hinten[$i][0];
                    if ($i == 2 or $i == 3){
                        $Punkte_Trennflaeche_Tangentenrand_hinten[$i][1][2] =  $Punkte_Trennflaeche_Tangentenrand_hinten[$i][0][2]+$bTR;
                    } else{
                        $Punkte_Trennflaeche_Tangentenrand_hinten[$i][1][2] =  $Punkte_Trennflaeche_Tangentenrand_hinten[$i][0][2]+15;
                    }        
                    
                    $Punkte_Trennfläche_Tangentenrand_hinten[$i][1][0] = "Punkte_Schnittflaeche_E$a-P2";
                }

                                                            //Tangentenrand Zapfen

                                                        
                    $Punkte_Trennflaeche_Tangentenrand_Zapfen[0][0] = $Punkte_Trennflaeche_Tangentenrand_hinten[0][1];
                    $Punkte_Trennflaeche_Tangentenrand_Zapfen[0][1] =  $Punkte_Trennflaeche_Tangentenrand_vorne[0][1];


                    $Punkte_Trennflaeche_Tangentenrand_Zapfen[1][0] = $Punkte_Trennflaeche_Tangentenrand_Zapfen[0][0];
                    $Punkte_Trennflaeche_Tangentenrand_Zapfen[1][0][1] = $Punkte_Kreisabschnitte_oben[1][0][1];
                    $Punkte_Trennflaeche_Tangentenrand_Zapfen[1][0][3] = $Punkte_Kreisabschnitte_oben[1][0][3];

                    $Punkte_Trennflaeche_Tangentenrand_Zapfen[1][1] =  $Punkte_Trennflaeche_Tangentenrand_Zapfen[0][1];
                    $Punkte_Trennflaeche_Tangentenrand_Zapfen[1][1][1] = $Punkte_Kreisabschnitte_oben[1][4][1];
                    $Punkte_Trennflaeche_Tangentenrand_Zapfen[1][1][3] = $Punkte_Kreisabschnitte_oben[1][4][3];



                

            
            
        //............................Blockrand.....................................
                                                                                        
            $Punkte_Trennflaeche_Blockrand[0][0][0] = "Trennflaeche_Blockrand-E1-P1";       //Trennfläche_Blockrand setzen der Blockrand Punkte                       
            $Punkte_Trennflaeche_Blockrand[0][0][1] = $P0B[0];
            $Punkte_Trennflaeche_Blockrand[0][0][2] = $P0B[1];
            $Punkte_Trennflaeche_Blockrand[0][0][3] = 0;

            $Punkte_Trennflaeche_Blockrand[0][1][0] = "Trennflaeche_Blockrand-E1-P2";
            $Punkte_Trennflaeche_Blockrand[0][1][1] = $P0B[0];
            $Punkte_Trennflaeche_Blockrand[0][1][2] = $P0B[1]-$bB;
            $Punkte_Trennflaeche_Blockrand[0][1][3] = 0;

            $Punkte_Trennflaeche_Blockrand[3][1][0] = "Trennflaeche_Blockrand-E4-P2";
            $Punkte_Trennflaeche_Blockrand[3][1][1] = $P0B[0];
            $Punkte_Trennflaeche_Blockrand[3][1][2] = $P0B[1]+$bB-$PB[1];
            $Punkte_Trennflaeche_Blockrand[3][1][3] = 0;

            $Punkte_Trennflaeche_Blockrand[3][0][0] = "Trennflaeche_Blockrand-E4-P1";
            $Punkte_Trennflaeche_Blockrand[3][0][1] = $P0B[0];
            $Punkte_Trennflaeche_Blockrand[3][0][2] = $P0B[1]-$PB[1];
            $Punkte_Trennflaeche_Blockrand[3][0][3] = 0;


            $Punkte_Trennflaeche_Blockrand[1][0] = $Punkte_Trennflaeche_Blockrand[0][0];
            $Punkte_Trennflaeche_Blockrand[1][0][1] = $Punkte_Trennflaeche_Blockrand[0][0][1]*1-$PB[0];
            $Punkte_Trennflaeche_Blockrand[2][0][0] = "Trennflaeche_Blockrand-E2-P1";


            $Punkte_Trennflaeche_Blockrand[1][1] = $Punkte_Trennflaeche_Blockrand[0][1];
            $Punkte_Trennflaeche_Blockrand[1][1][1] = $Punkte_Trennflaeche_Blockrand[0][0][1]-$PB[0]+$bB;
            $Punkte_Trennflaeche_Blockrand[1][1][0] = "Trennflaeche_Blockrand-E2-P2";


            $Punkte_Trennflaeche_Blockrand[2][1] = $Punkte_Trennflaeche_Blockrand[3][1];
            $Punkte_Trennflaeche_Blockrand[2][1][1] = $Punkte_Trennflaeche_Blockrand[3][1][1]-$PB[0]+$bB;
            $Punkte_Trennflaeche_Blockrand[2][1][0] = "Trennflaeche_Blockrand-E3-P2";


            $Punkte_Trennflaeche_Blockrand[2][0] = $Punkte_Trennflaeche_Blockrand[3][0];
            $Punkte_Trennflaeche_Blockrand[2][0][1] = $Punkte_Trennflaeche_Blockrand[3][0][1]-$PB[0];
            $Punkte_Trennflaeche_Blockrand[2][0][0] = "Trennflaeche_Blockrand-E3-P1";



        //............................Blockrand_aussen.....................................
                                                                                            
            for ($i = 0; $i < 4; $i++){
                $a = $i+1;
                $Punkte_Trennflaeche_Blockrand_aussen[$i][0] = $Punkte_Trennflaeche_Blockrand[$i][0]; //übernehmen von Trennfläche_Blockrand 
                $Punkte_Trennflaeche_Blockrand_aussen[$i][0][0] = "Trennflaeche_Blockrand_außen-E$a-P1";
                if ($i == 0){
                    $b = 0;
                    $c = $DFB;
                } elseif ($i == 1){
                    $b = -$DFB;
                    $c = $DFB;
                } elseif ($i == 2){
                    $b = -$DFB;
                    $c = -$DFB;
                }  elseif ($i == 3){
                    $b = 0;
                    $c = -$DFB;            
                }
                $Punkte_Trennflaeche_Blockrand_aussen[$i][1] = $Punkte_Trennflaeche_Blockrand[$i][0];
                $Punkte_Trennflaeche_Blockrand_aussen[$i][1][1] = $Punkte_Trennflaeche_Blockrand[$i][0][1] + $b;
                $Punkte_Trennflaeche_Blockrand_aussen[$i][1][2] = $Punkte_Trennflaeche_Blockrand[$i][0][2] + $c;
                $Punkte_Trennflaeche_Blockrand_aussen[$i][1][0] = "Trennflaeche_Blockrand_außen-E$a-P2";               
            }


        //............................Distanzflächen................................
            //Distanzflaeche_Hauptflaeche_vorne
            $mplus1 = count($Punkte_Trennflaeche_Tangentenrand_vorne); 

            for ($i=0; $i < $mplus1; $i++){                                                     //Schleife zum Durchlaufen der Ebenen, übernommen von Blattflaeche_Hauptflaeche
                $b = $i +1;

                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P6";                 //P6 mit x-Werten der Ebenen von Tangentenrand vorne ind y,z von Blockrand
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5][1] = $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][1];       
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5][2]= $Punkte_Trennflaeche_Blockrand[3][1][2];
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5][3]= $Punkte_Trennflaeche_Blockrand[3][1][3];
                
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5]; //P5  mit versetzter y-Koordinate
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P5";
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4][2] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4][2]+ $Distanzflaechen_yOffset;
                    
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][3] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4]; //P4  mit versetzter z-Koordinate
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][3][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P4";
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][3][3] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][3][3] + $Distanzflaechen_zOffset;

                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][0] = $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1];
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][0][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P1"; //P1 aufBlockrand

                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][1] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][0]; //P2  mit versetzter y-Koordinate
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][1][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P2";
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][1][2] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][0][2]- $Distanzflaechen_yOffset;


                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][2] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][1]; //P3  mit versetzter z-Koordinate
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][2][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P3";
                $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][2][3] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][1][3] + $Distanzflaechen_zOffset;
            }


        //............................Distanzflaeche_Zapfen_vorne.............................
            $mplus1 = count($Punkte_Trennflaeche_Tangentenrand_Zapfen); 

            for ($i=0; $i < $mplus1; $i++){                                                     //Schleife zum Durchlaufen der Ebenen, übernommen von Blattflaeche_Hauptflaeche
                $b = $i +1;

                $Punkte_Distanzflaeche_Zapfen_vorne[$i][5][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P6";                 //P6 mit x-Werten der Ebenen von Tangentenrand vorne ind y,z von Blockrand
                $Punkte_Distanzflaeche_Zapfen_vorne[$i][5][1] = $Punkte_Trennflaeche_Tangentenrand_Zapfen[$i][1][1];       
                $Punkte_Distanzflaeche_Zapfen_vorne[$i][5][2]= $Punkte_Trennflaeche_Blockrand[3][1][2];
                $Punkte_Distanzflaeche_Zapfen_vorne[$i][5][3]= $Punkte_Trennflaeche_Blockrand[3][1][3];
                
                $Punkte_Distanzflaeche_Zapfen_vorne[$i][4] = $Punkte_Distanzflaeche_Zapfen_vorne[$i][5]; //P5  mit versetzter y-Koordinate
                $Punkte_Distanzflaeche_Zapfen_vorne[$i][4][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P5";
                $Punkte_Distanzflaeche_Zapfen_vorne[$i][4][2] = $Punkte_Distanzflaeche_Zapfen_vorne[$i][4][2] + $Distanzflaechen_yOffset;
                    
                $Punkte_Distanzflaeche_Zapfen_vorne[$i][3] = $Punkte_Distanzflaeche_Zapfen_vorne[$i][4]; //P4  mit versetzter z-Koordinate
                $Punkte_Distanzflaeche_Zapfen_vorne[$i][3][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P4";
                $Punkte_Distanzflaeche_Zapfen_vorne[$i][3][3] = $Punkte_Distanzflaeche_Zapfen_vorne[$i][3][3] + $Distanzflaechen_zOffset;

                $Punkte_Distanzflaeche_Zapfen_vorne[$i][0] = $Punkte_Trennflaeche_Tangentenrand_Zapfen[$i][1];
                $Punkte_Distanzflaeche_Zapfen_vorne[$i][0][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P1"; //P1 aufBlockrand

                $Punkte_Distanzflaeche_Zapfen_vorne[$i][1] = $Punkte_Distanzflaeche_Zapfen_vorne[$i][0]; //P2  mit versetzter y-Koordinate
                $Punkte_Distanzflaeche_Zapfen_vorne[$i][1][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P2";
                $Punkte_Distanzflaeche_Zapfen_vorne[$i][1][2] = $Punkte_Distanzflaeche_Zapfen_vorne[$i][0][2] - $Distanzflaechen_yOffset;


                $Punkte_Distanzflaeche_Zapfen_vorne[$i][2] = $Punkte_Distanzflaeche_Zapfen_vorne[$i][1]; //P3  mit versetzter z-Koordinate
                $Punkte_Distanzflaeche_Zapfen_vorne[$i][2][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P3";
                $Punkte_Distanzflaeche_Zapfen_vorne[$i][2][3] = $Punkte_Distanzflaeche_Zapfen_vorne[$i][1][3] + $Distanzflaechen_zOffset;
            }
        //............................Distanzflaeche_Zapfen_hinten.............................

            $mplus1 = count($Punkte_Trennflaeche_Tangentenrand_Zapfen); 
            
            for ($i=0; $i < $mplus1; $i++){                                                     //Schleife zum Durchlaufen der Ebenen, übernommen von Blattflaeche_Hauptflaeche
                $b = $i +1;

                $Punkte_Distanzflaeche_Zapfen_hinten[$i][5][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P6";                 //P6 mit x-Werten der Ebenen von Tangentenrand vorne ind y,z von Blockrand
                $Punkte_Distanzflaeche_Zapfen_hinten[$i][5][1] = $Punkte_Trennflaeche_Tangentenrand_Zapfen[$i][0][1];       
                $Punkte_Distanzflaeche_Zapfen_hinten[$i][5][2]= $Punkte_Trennflaeche_Blockrand[1][1][2];
                $Punkte_Distanzflaeche_Zapfen_hinten[$i][5][3]= $Punkte_Trennflaeche_Blockrand[1][1][3];
                
                $Punkte_Distanzflaeche_Zapfen_hinten[$i][4] = $Punkte_Distanzflaeche_Zapfen_hinten[$i][5]; //P5  mit versetzter y-Koordinate
                $Punkte_Distanzflaeche_Zapfen_hinten[$i][4][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P5";
                $Punkte_Distanzflaeche_Zapfen_hinten[$i][4][2] = $Punkte_Distanzflaeche_Zapfen_hinten[$i][4][2] - $Distanzflaechen_yOffset;
                    
                $Punkte_Distanzflaeche_Zapfen_hinten[$i][3] = $Punkte_Distanzflaeche_Zapfen_hinten[$i][4]; //P4  mit versetzter z-Koordinate
                $Punkte_Distanzflaeche_Zapfen_hinten[$i][3][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P4";
                $Punkte_Distanzflaeche_Zapfen_hinten[$i][3][3] = $Punkte_Distanzflaeche_Zapfen_hinten[$i][3][3] + $Distanzflaechen_zOffset;

                $Punkte_Distanzflaeche_Zapfen_hinten[$i][0] = $Punkte_Trennflaeche_Tangentenrand_Zapfen[$i][0];
                $Punkte_Distanzflaeche_Zapfen_hinten[$i][0][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P1"; //P1 aufBlockrand

                $Punkte_Distanzflaeche_Zapfen_hinten[$i][1] = $Punkte_Distanzflaeche_Zapfen_hinten[$i][0]; //P2  mit versetzter y-Koordinate
                $Punkte_Distanzflaeche_Zapfen_hinten[$i][1][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P2";
                $Punkte_Distanzflaeche_Zapfen_hinten[$i][1][2] = $Punkte_Distanzflaeche_Zapfen_hinten[$i][0][2] + $Distanzflaechen_yOffset;


                $Punkte_Distanzflaeche_Zapfen_hinten[$i][2] = $Punkte_Distanzflaeche_Zapfen_hinten[$i][1]; //P3  mit versetzter z-Koordinate
                $Punkte_Distanzflaeche_Zapfen_hinten[$i][2][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P3";
                $Punkte_Distanzflaeche_Zapfen_hinten[$i][2][3] = $Punkte_Distanzflaeche_Zapfen_hinten[$i][1][3] + $Distanzflaechen_zOffset;
            }

        //............................Distanzflaeche_Zapfen_Spitze.............................
            $mplus1 = count($Punkte_Trennflaeche_Tangentenrand_Zapfen); 
            
            for ($i=0; $i < $mplus1; $i++){                                                     //Schleife zum Durchlaufen der Ebenen, übernommen von Blattflaeche_Hauptflaeche
                $b = $i +1;

                $Punkte_Distanzflaeche_Zapfen_spitze[5][$i][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P6";                 //P6 mit x-Werten der Ebenen von Tangentenrand vorne ind y,z von Blockrand
                $Punkte_Distanzflaeche_Zapfen_spitze[5][$i] = $Punkte_Trennflaeche_Tangentenrand_Zapfen[1][$i];       
                //$Punkte_Distanzflaeche_Zapfen_spitze[5][$i][2]= $Punkte_Trennflaeche_Blockrand[3][1][2];
                //$Punkte_Distanzflaeche_Zapfen_spitze[5][$i][3]= $Punkte_Trennflaeche_Blockrand[3][1][3];
                
                $Punkte_Distanzflaeche_Zapfen_spitze[4][$i] = $Punkte_Distanzflaeche_Zapfen_spitze[5][$i]; //P5  mit versetzter y-Koordinate
                $Punkte_Distanzflaeche_Zapfen_spitze[4][$i][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P5";
                $Punkte_Distanzflaeche_Zapfen_spitze[4][$i][1] = $Punkte_Distanzflaeche_Zapfen_spitze[4][$i][1]- $Distanzflaechen_xOffset;
                    
                $Punkte_Distanzflaeche_Zapfen_spitze[3][$i] = $Punkte_Distanzflaeche_Zapfen_spitze[4][$i]; //P4  mit versetzter z-Koordinate
                $Punkte_Distanzflaeche_Zapfen_spitze[3][$i][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P4";
                $Punkte_Distanzflaeche_Zapfen_spitze[3][$i][3] = $Punkte_Distanzflaeche_Zapfen_spitze[3][$i][3] ;//+ $Distanzflaechen_zOffset;

                $Punkte_Distanzflaeche_Zapfen_spitze[0][$i] = $Punkte_Trennflaeche_Blockrand[1][1];
                $Punkte_Distanzflaeche_Zapfen_spitze[0][$i][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P1"; //P1 aufBlockrand
                $Punkte_Distanzflaeche_Zapfen_spitze[0][$i][2] = $Punkte_Distanzflaeche_Zapfen_spitze[5][$i][2];

                $Punkte_Distanzflaeche_Zapfen_spitze[1][$i] = $Punkte_Distanzflaeche_Zapfen_spitze[0][$i]; //P2  mit versetzter y-Koordinate
                $Punkte_Distanzflaeche_Zapfen_spitze[1][$i][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P2";
                $Punkte_Distanzflaeche_Zapfen_spitze[1][$i][1] = $Punkte_Distanzflaeche_Zapfen_spitze[0][$i][1]+ $Distanzflaechen_xOffset;


                $Punkte_Distanzflaeche_Zapfen_spitze[2][$i] = $Punkte_Distanzflaeche_Zapfen_spitze[1][$i]; //P3  mit versetzter z-Koordinate
                $Punkte_Distanzflaeche_Zapfen_spitze[2][$i][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P3";
                $Punkte_Distanzflaeche_Zapfen_spitze[2][$i][3] = $Punkte_Distanzflaeche_Zapfen_spitze[5][$i][3];
            }
        //............................Distanzflaeche_Spitze_vorne.............................
            $Punkte_Distanzflaeche_Spitze_vorne[0] = $Punkte_Distanzflaeche_Zapfen_vorne[$mplus1-1];// übernehmen der letzten Ebene von Distanzflaeche_Zapfen_vorne
            for ($i=0; $i < 6; $i++){
                $Punkte_Distanzflaeche_Spitze_vorne[2][$i]  =  $Punkte_Distanzflaeche_Zapfen_spitze[5-$i][1];
            }
            for ($i = 1; $i <2; $i++){        
                $Punkte_Distanzflaeche_Spitze_vorne[$i][0][0] = "Distanzflaeche_Hauptflaeche_vorne-E2-P6";                 //P6 mit x-Werten der Ebenen von Tangentenrand vorne ind y,z von Blockrand
                $Punkte_Distanzflaeche_Spitze_vorne[$i][0] = $Punkte_Trennflaeche_Tangentenrand_Zapfen[1][1];       
                
                
                $Punkte_Distanzflaeche_Spitze_vorne[$i][1] = $Punkte_Distanzflaeche_Spitze_vorne[$i][0]; //P5  mit versetzter y-Koordinate
                $Punkte_Distanzflaeche_Spitze_vorne[$i][1][0] = "Distanzflaeche_Hauptflaeche_vorne-E2-P5";
                $Punkte_Distanzflaeche_Spitze_vorne[$i][1][1] = $Punkte_Distanzflaeche_Spitze_vorne[$i][1][1]- $Distanzflaechen_xOffset;
                $Punkte_Distanzflaeche_Spitze_vorne[$i][1][2] = $Punkte_Distanzflaeche_Spitze_vorne[$i][1][2]- $Distanzflaechen_yOffset;
                    
                $Punkte_Distanzflaeche_Spitze_vorne[$i][2] = $Punkte_Distanzflaeche_Spitze_vorne[$i][1]; //P4  mit versetzter z-Koordinate
                $Punkte_Distanzflaeche_Spitze_vorne[$i][2][0] = "Distanzflaeche_Hauptflaeche_vorne-E2-P4";
                $Punkte_Distanzflaeche_Spitze_vorne[$i][2][3] = $Punkte_Distanzflaeche_Spitze_vorne[$i][1][3] + $Distanzflaechen_zOffset;

                $Punkte_Distanzflaeche_Spitze_vorne[$i][5] = $Punkte_Trennflaeche_Blockrand[2][1];
                $Punkte_Distanzflaeche_Spitze_vorne[$i][5][0] = "Distanzflaeche_Hauptflaeche_vorne-E2-P1"; //P1 aufBlockrand

                $Punkte_Distanzflaeche_Spitze_vorne[$i][4] = $Punkte_Distanzflaeche_Spitze_vorne[$i][5]; //P2  mit versetzter y-Koordinate
                $Punkte_Distanzflaeche_Spitze_vorne[$i][4][0] = "Distanzflaeche_Hauptflaeche_vorne-E2-P2";
                $Punkte_Distanzflaeche_Spitze_vorne[$i][4][1] = $Punkte_Distanzflaeche_Spitze_vorne[$i][5][1]+ $Distanzflaechen_xOffset;
                $Punkte_Distanzflaeche_Spitze_vorne[$i][4][2] = $Punkte_Distanzflaeche_Spitze_vorne[$i][5][2]+ $Distanzflaechen_yOffset;


                $Punkte_Distanzflaeche_Spitze_vorne[$i][3] = $Punkte_Distanzflaeche_Spitze_vorne[$i][4]; //P3  mit versetzter z-Koordinate
                $Punkte_Distanzflaeche_Spitze_vorne[$i][3][0] = "Distanzflaeche_Hauptflaeche_vorne-E2-P3";
                $Punkte_Distanzflaeche_Spitze_vorne[$i][3][3] = $Punkte_Distanzflaeche_Spitze_vorne[$i][4][3] + $Distanzflaechen_zOffset;
            }   


        //............................Distanzflaeche_Spitze_hinten.............................
            $Punkte_Distanzflaeche_Spitze_hinten[0] = $Punkte_Distanzflaeche_Zapfen_hinten[$mplus1-1];// übernehmen der letzten Ebene von Distanzflaeche_Zapfen_hinten
            for ($i=0; $i < 6; $i++){
                $Punkte_Distanzflaeche_Spitze_hinten[2][$i]  =  $Punkte_Distanzflaeche_Zapfen_spitze[5-$i][0];
            }
            for ($i = 1; $i <2; $i++){         
                $Punkte_Distanzflaeche_Spitze_hinten[$i][0][0] = "Distanzflaeche_Hauptflaeche_vorne-E2-P6";                 //P1 auf Ecke Trennflaeche_Tangentenrand_Zapfen
                $Punkte_Distanzflaeche_Spitze_hinten[$i][0] = $Punkte_Trennflaeche_Tangentenrand_Zapfen[1][0];       
                
                
                $Punkte_Distanzflaeche_Spitze_hinten[$i][1] = $Punkte_Distanzflaeche_Spitze_hinten[$i][0]; //P5  mit versetzter y-Koordinate
                $Punkte_Distanzflaeche_Spitze_hinten[$i][1][0] = "Distanzflaeche_Hauptflaeche_vorne-E2-P5";
                $Punkte_Distanzflaeche_Spitze_hinten[$i][1][1] = $Punkte_Distanzflaeche_Spitze_hinten[$i][1][1]- $Distanzflaechen_xOffset;
                $Punkte_Distanzflaeche_Spitze_hinten[$i][1][2] = $Punkte_Distanzflaeche_Spitze_hinten[$i][1][2]+ $Distanzflaechen_yOffset;
                    
                $Punkte_Distanzflaeche_Spitze_hinten[$i][2] = $Punkte_Distanzflaeche_Spitze_hinten[$i][1]; //P4  mit versetzter z-Koordinate
                $Punkte_Distanzflaeche_Spitze_hinten[$i][2][0] = "Distanzflaeche_Hauptflaeche_vorne-E2-P4";
                $Punkte_Distanzflaeche_Spitze_hinten[$i][2][3] = $Punkte_Distanzflaeche_Spitze_hinten[$i][1][3] + $Distanzflaechen_zOffset;

                $Punkte_Distanzflaeche_Spitze_hinten[$i][5] = $Punkte_Trennflaeche_Blockrand[1][1];
                $Punkte_Distanzflaeche_Spitze_hinten[$i][5][0] = "Distanzflaeche_Hauptflaeche_vorne-E2-P1"; //P1 aufBlockrand

                $Punkte_Distanzflaeche_Spitze_hinten[$i][4] = $Punkte_Distanzflaeche_Spitze_hinten[$i][5]; //P2  mit versetzter y-Koordinate
                $Punkte_Distanzflaeche_Spitze_hinten[$i][4][0] = "Distanzflaeche_Hauptflaeche_vorne-E2-P2";
                $Punkte_Distanzflaeche_Spitze_hinten[$i][4][1] = $Punkte_Distanzflaeche_Spitze_hinten[$i][5][1]+ $Distanzflaechen_xOffset;
                $Punkte_Distanzflaeche_Spitze_hinten[$i][4][2] = $Punkte_Distanzflaeche_Spitze_hinten[$i][5][2]- $Distanzflaechen_yOffset;


                $Punkte_Distanzflaeche_Spitze_hinten[$i][3] = $Punkte_Distanzflaeche_Spitze_hinten[$i][4]; //P3  mit versetzter z-Koordinate
                $Punkte_Distanzflaeche_Spitze_hinten[$i][3][0] = "Distanzflaeche_Hauptflaeche_vorne-E2-P3";
                $Punkte_Distanzflaeche_Spitze_hinten[$i][3][3] = $Punkte_Distanzflaeche_Spitze_hinten[$i][4][3] + $Distanzflaechen_zOffset;
            }
            



        //............................Trennflaeche_Tangentenrand_hinten.............................


            $mplus1 = count($Punkte_Trennflaeche_Tangentenrand_hinten);                          //Trennflaeche_Tangentenrand_vorne
            for ($i=0; $i < $mplus1; $i++){                                                     //Schleife zum Durchlaufen der Ebenen, übernommen von Blattflaeche_Hauptflaeche
                $b = $i +1;

                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][5][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P6";                 //P6 mit x-Werten der Ebenen von Tangentenrand vorne ind y,z von Blockrand
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][5][1] = $Punkte_Trennflaeche_Tangentenrand_hinten[$i][1][1];       
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][5][2]= $Punkte_Trennflaeche_Blockrand[1][1][2];
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][5][3]= $Punkte_Trennflaeche_Blockrand[1][1][3];
                
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][5]; //P5  mit versetzter y-Koordinate
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P5";
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4][2] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4][2] - $Distanzflaechen_yOffset;
                    
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][3] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4]; //P4  mit versetzter z-Koordinate
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][3][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P4";
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][3][3] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][3][3] + $Distanzflaechen_zOffset;

                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0] = $Punkte_Trennflaeche_Tangentenrand_hinten[$i][1];
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P1"; //P1 aufBlockrand

                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0]; //P2  mit versetzter y-Koordinate
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P2";
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1][2] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0][2] + $Distanzflaechen_yOffset;


                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][2] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1]; //P3  mit versetzter z-Koordinate
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][2][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P3";
                $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][2][3] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1][3] + $Distanzflaechen_zOffset;
            }

        //............................Ausrichtung_Zapfen.............................
            //hinten oben

            $temp_var = count($Punkte_Kreisabschnitte_oben);

                if ($temp_var < 6) {                    //Schutz falls keine 6. Kreisstation vorhanden (z.B. v-Wurzel)
                    $NUMBEROFCIRCLESTATION = 0;
                } else {
                    $NUMBEROFCIRCLESTATION = 1;
                }
                for ($i = 0; $i < 16; $i++){            //Ebenenschleife
                    if ($i == 0) {
                        $x =  $Punkte_Kreisabschnitte_oben[$NUMBEROFCIRCLESTATION][0][1];
                        $z = 0;
                        $local_Pitch_Angle = 0;
                    } elseif ($i == 1) {
                        $x = $x +20;
                        $z = 8.5;
                        $local_Pitch_Angle =  -12;
                    } elseif ($i == 2)  {
                        $x = $x +10;
                        $z = 8.5;
                        $local_Pitch_Angle =  -12;
                    } elseif ($i == 3)  {
                        $x = $x +10;
                        $z = 8.5;
                        $local_Pitch_Angle =  -8;
                    } elseif ($i == 4)  {
                        $x = $x +10;
                        $z = 8.5;
                        $local_Pitch_Angle =  -8;
                    } elseif ($i == 5)  {
                        $x = $x +10;
                        $z = 8.5;
                        $local_Pitch_Angle =  -4;
                    } elseif ($i == 6)  {
                        $x = $x +10;
                        $z = 8.5;
                        $local_Pitch_Angle =  -4;
                    } elseif ($i == 7)  {
                        $x = $x +10;
                        $z = 8.5;
                        $local_Pitch_Angle = 0;
                    } elseif ($i == 8)  {
                        $x = $x +10;
                        $z = 8.5;
                        $local_Pitch_Angle = 0;
                    } elseif ($i == 9)  {
                        $x = $x +10;
                        $z = 8.5;
                        $local_Pitch_Angle = 4;
                    } elseif ($i == 10)  {
                        $x = $x +10;
                        $z = 8.5;
                        $local_Pitch_Angle = 4;
                    } elseif ($i == 11)  {
                        $x = $x +10;
                        $z = 8.5;
                        $local_Pitch_Angle = 8;
                    } elseif ($i == 12)  {
                        $x = $x +10;
                        $z = 8.5;
                        $local_Pitch_Angle = 8;
                    } elseif ($i == 13)  {
                        $x = $x +10;
                        $z = 8.5;
                        $local_Pitch_Angle = 12;
                    } elseif ($i == 14)  {
                        $x = $x +10;
                        $z = 8.5;
                        $local_Pitch_Angle = 12;
                    } elseif ($i == 15)  {
                        $x = $x +20;
                        $z = 0;
                        $local_Pitch_Angle = 0;
                    }
                    for ($j = 0 ; $j < 5; $j++){            //Punktschleife
                        if ($j == 0){
                            $y = 30; 
                            $a = 0;
                            //$z = 0;
                        } elseif ($j == 1){
                            $y = 30;
                            $a = 0;   
                        } elseif ($j == 2){
                            $y = 40;
                            $a = 0;  
                        } elseif ($j == 3){
                            $y = 40;
                            $a = 5;  
                        } elseif ($j == 4){
                            $y = 55;
                            $a = 0;
                            $z = 0; 
                        }
                        if ($j == 0){
                            $Punkte_Ausrichtung_Zapfen_uv[$i][$j][0] = "Punkte_Ausrichtung_Zapfen_E$i-P$j";
                            $Punkte_Ausrichtung_Zapfen_uv[$i][$j][1] = $x; //übernehmen des x-Wertes des 6. Kreisabschnitts
                            $Punkte_Ausrichtung_Zapfen_uv[$i][$j][2] = 20 + $CircleStations[$NUMBEROFCIRCLESTATION][1];   //
                            $Punkte_Ausrichtung_Zapfen_uv[$i][$j][3] = $z *cos($local_Pitch_Angle*(pi()/180)) + $y * sin($local_Pitch_Angle*(pi()/180)) + $CircleStations[$NUMBEROFCIRCLESTATION][2];
                        } elseif ($j == 1 or $j == 2 or $j == 3) {
                            $b = cos($local_Pitch_Angle*(2*pi()/180));
                            $Punkte_Ausrichtung_Zapfen_uv[$i][$j][0] = "Punkte_Ausrichtung_Zapfen_E$i-P$j";
                            $Punkte_Ausrichtung_Zapfen_uv[$i][$j][1] = $x; //übernehmen des x-Wertes des 6. Kreisabschnitts
                            $Punkte_Ausrichtung_Zapfen_uv[$i][$j][2] = $y *cos($local_Pitch_Angle*(pi()/180)) - $z * sin($local_Pitch_Angle*(pi()/180)) + $CircleStations[$NUMBEROFCIRCLESTATION][1] + $a;   //
                            $Punkte_Ausrichtung_Zapfen_uv[$i][$j][3] = $z *cos($local_Pitch_Angle*(pi()/180)) + $y * sin($local_Pitch_Angle*(pi()/180)) + $CircleStations[$NUMBEROFCIRCLESTATION][2];
                        } elseif ($j == 4){
                            $Punkte_Ausrichtung_Zapfen_uv[$i][$j][0] = "Punkte_Ausrichtung_Zapfen_E$i-P$j";
                            $Punkte_Ausrichtung_Zapfen_uv[$i][$j][1] = $x; //übernehmen des x-Wertes des 6. Kreisabschnitts
                            $Punkte_Ausrichtung_Zapfen_uv[$i][$j][2] = $y + $CircleStations[$NUMBEROFCIRCLESTATION][1];   //
                            $Punkte_Ausrichtung_Zapfen_uv[$i][$j][3] =  $CircleStations[$NUMBEROFCIRCLESTATION][2];
                        } 

                    }

                } 
                //vorne oben
                for ($i = 0; $i < 16; $i++){            //Ebenenschleife
                    if ($i == 0) {
                        $x =  $Punkte_Kreisabschnitte_oben[$NUMBEROFCIRCLESTATION][0][1];
                        $z = 0;
                        $local_Pitch_Angle = 0;
                    } elseif ($i == 1) {
                        $x = $x +20;
                        $z = 8.5;
                        $local_Pitch_Angle =  -12;
                    } elseif ($i == 2)  {
                        $x = $x +10;
                        $z = 8.5;
                        $local_Pitch_Angle =  -12;
                    } elseif ($i == 3)  {
                        $x = $x +10;
                        $z = 8.5;
                        $local_Pitch_Angle =  -8;
                    } elseif ($i == 4)  {
                        $x = $x +10;
                        $z = 8.5;
                        $local_Pitch_Angle =  -8;
                    } elseif ($i == 5)  {
                        $x = $x +10;
                        $z = 8.5;
                        $local_Pitch_Angle =  -4;
                    } elseif ($i == 6)  {
                        $x = $x +10;
                        $z = 8.5;
                        $local_Pitch_Angle =  -4;
                    } elseif ($i == 7)  {
                        $x = $x +10;
                        $z = 8.5;
                        $local_Pitch_Angle = 0;
                    } elseif ($i == 8)  {
                        $x = $x +10;
                        $z = 8.5;
                        $local_Pitch_Angle = 0;
                    } elseif ($i == 9)  {
                        $x = $x +10;
                        $z = 8.5;
                        $local_Pitch_Angle = 4;
                    } elseif ($i == 10)  {
                        $x = $x +10;
                        $z = 8.5;
                        $local_Pitch_Angle = 4;
                    } elseif ($i == 11)  {
                        $x = $x +10;
                        $z = 8.5;
                        $local_Pitch_Angle =8;
                    } elseif ($i == 12)  {
                        $x = $x +10;
                        $z = 8.5;
                        $local_Pitch_Angle = 8;
                    } elseif ($i == 13)  {
                        $x = $x +10;
                        $z = 8.5;
                        $local_Pitch_Angle = 12;
                    } elseif ($i == 14)  {
                        $x = $x +10;
                        $z = 8.5;
                        $local_Pitch_Angle = 12;
                    } elseif ($i == 15)  {
                        $x = $x +20;
                        $z = 0;
                        $local_Pitch_Angle = 0;
                    }
                    for ($j = 0 ; $j < 5; $j++){            //Punktschleife
                        if ($j == 0){
                            $y = -30; 
                            $a = 0;
                            //$z = 0;
                        } elseif ($j == 1){
                            $y = -30;
                            $a = 0;   
                        } elseif ($j == 2){
                            $y = -40;
                            $a = 0;  
                        } elseif ($j == 3){
                            $y = -40;
                            $a = 5;  
                        } elseif ($j == 4){
                            $y = -55;
                            $a = 0;
                            $z = 0; 
                        }
                        if ($j == 0){
                            $Punkte_Ausrichtung_Zapfen_ov[$i][$j][0] = "Punkte_Ausrichtung_Zapfen_E$i-P$j";
                            $Punkte_Ausrichtung_Zapfen_ov[$i][$j][1] = $x; //übernehmen des x-Wertes des 6. Kreisabschnitts
                            $Punkte_Ausrichtung_Zapfen_ov[$i][$j][2] = -20 + $CircleStations[$NUMBEROFCIRCLESTATION][1];   //
                            $Punkte_Ausrichtung_Zapfen_ov[$i][$j][3] = $z *cos($local_Pitch_Angle*(pi()/180)) + $y * sin($local_Pitch_Angle*(pi()/180)) + $CircleStations[$NUMBEROFCIRCLESTATION][2];
                        } elseif ($j == 1 or $j == 2 or $j == 3) {
                            $b = cos($local_Pitch_Angle*(2*pi()/180));
                            $Punkte_Ausrichtung_Zapfen_ov[$i][$j][0] = "Punkte_Ausrichtung_Zapfen_E$i-P$j";
                            $Punkte_Ausrichtung_Zapfen_ov[$i][$j][1] = $x; //übernehmen des x-Wertes des 6. Kreisabschnitts
                            $Punkte_Ausrichtung_Zapfen_ov[$i][$j][2] = $y *cos($local_Pitch_Angle*(pi()/180)) - $z * sin($local_Pitch_Angle*(pi()/180)) + $CircleStations[$NUMBEROFCIRCLESTATION][1] - $a;   //
                            $Punkte_Ausrichtung_Zapfen_ov[$i][$j][3] = $z *cos($local_Pitch_Angle*(pi()/180)) + $y * sin($local_Pitch_Angle*(pi()/180)) + $CircleStations[$NUMBEROFCIRCLESTATION][2];
                        } elseif ($j == 4){
                            $Punkte_Ausrichtung_Zapfen_ov[$i][$j][0] = "Punkte_Ausrichtung_Zapfen_E$i-P$j";
                            $Punkte_Ausrichtung_Zapfen_ov[$i][$j][1] = $x; //übernehmen des x-Wertes des 6. Kreisabschnitts
                            $Punkte_Ausrichtung_Zapfen_ov[$i][$j][2] = $y + $CircleStations[$NUMBEROFCIRCLESTATION][1];   //
                            $Punkte_Ausrichtung_Zapfen_ov[$i][$j][3] =  $CircleStations[$NUMBEROFCIRCLESTATION][2];
                        } 

                    }

                } 

                //vorne unten
                for ($i = 0; $i < 16; $i++){            //Ebenenschleife
                    if ($i == 0) {
                        $x =  $Punkte_Kreisabschnitte_oben[$NUMBEROFCIRCLESTATION][0][1];
                        $z = 0;
                        $local_Pitch_Angle = 0;
                    } elseif ($i == 1) {
                        $x = $x +20;
                        $z = -8.5;
                        $local_Pitch_Angle =  -12;
                    } elseif ($i == 2)  {
                        $x = $x +10;
                        $z = -8.5;
                        $local_Pitch_Angle =  -12;
                    } elseif ($i == 3)  {
                        $x = $x +10;
                        $z = -8.5;
                        $local_Pitch_Angle =  -8;
                    } elseif ($i == 4)  {
                        $x = $x +10;
                        $z = -8.5;
                        $local_Pitch_Angle =  -8;
                    } elseif ($i == 5)  {
                        $x = $x +10;
                        $z = -8.5;
                        $local_Pitch_Angle =  -4;
                    } elseif ($i == 6)  {
                        $x = $x +10;
                        $z = -8.5;
                        $local_Pitch_Angle =  -4;
                    } elseif ($i == 7)  {
                        $x = $x +10;
                        $z = -8.5;
                        $local_Pitch_Angle = 0;
                    } elseif ($i == 8)  {
                        $x = $x +10;
                        $z = -8.5;
                        $local_Pitch_Angle = 0;
                    } elseif ($i == 9)  {
                        $x = $x +10;
                        $z = -8.5;
                        $local_Pitch_Angle = 4;
                    } elseif ($i == 10)  {
                        $x = $x +10;
                        $z = -8.5;
                        $local_Pitch_Angle = 4;
                    } elseif ($i == 11)  {
                        $x = $x +10;
                        $z = -8.5;
                        $local_Pitch_Angle =8;
                    } elseif ($i == 12)  {
                        $x = $x +10;
                        $z = -8.5;
                        $local_Pitch_Angle = 8;
                    } elseif ($i == 13)  {
                        $x = $x +10;
                        $z = -8.5;
                        $local_Pitch_Angle = 12;
                    } elseif ($i == 14)  {
                        $x = $x +10;
                        $z = -8.5;
                        $local_Pitch_Angle = 12;
                    } elseif ($i == 15)  {
                        $x = $x +20;
                        $z = 0;
                        $local_Pitch_Angle = 0;
                    }
                    for ($j = 0 ; $j < 5; $j++){            //Punktschleife
                        if ($j == 0){
                            $y = -30; 
                            $a = 0;
                            //$z = 0;
                        } elseif ($j == 1){
                            $y = -30;
                            $a = 0;   
                        } elseif ($j == 2){
                            $y = -40;
                            $a = 0;  
                        } elseif ($j == 3){
                            $y = -40;
                            $a = 5;  
                        } elseif ($j == 4){
                            $y = -55;
                            $a = 0;
                            $z = 0; 
                        }
                        if ($j == 0){
                            $Punkte_Ausrichtung_Zapfen_uh[$i][$j][0] = "Punkte_Ausrichtung_Zapfen_E$i-P$j";
                            $Punkte_Ausrichtung_Zapfen_uh[$i][$j][1] = $x; //übernehmen des x-Wertes des 6. Kreisabschnitts
                            $Punkte_Ausrichtung_Zapfen_uh[$i][$j][2] = -20 + $CircleStations[$NUMBEROFCIRCLESTATION][1];   //
                            $Punkte_Ausrichtung_Zapfen_uh[$i][$j][3] = $z *cos($local_Pitch_Angle*(pi()/180)) + $y * sin($local_Pitch_Angle*(pi()/180)) + $CircleStations[$NUMBEROFCIRCLESTATION][2];
                        } elseif ($j == 1 or $j == 2 or $j == 3) {
                            $b = cos($local_Pitch_Angle*(2*pi()/180));
                            $Punkte_Ausrichtung_Zapfen_uh[$i][$j][0] = "Punkte_Ausrichtung_Zapfen_E$i-P$j";
                            $Punkte_Ausrichtung_Zapfen_uh[$i][$j][1] = $x; //übernehmen des x-Wertes des 6. Kreisabschnitts
                            $Punkte_Ausrichtung_Zapfen_uh[$i][$j][2] = $y *cos($local_Pitch_Angle*(pi()/180)) - $z * sin($local_Pitch_Angle*(pi()/180)) + $CircleStations[$NUMBEROFCIRCLESTATION][1] - $a;   //
                            $Punkte_Ausrichtung_Zapfen_uh[$i][$j][3] = $z *cos($local_Pitch_Angle*(pi()/180)) + $y * sin($local_Pitch_Angle*(pi()/180)) + $CircleStations[$NUMBEROFCIRCLESTATION][2];
                        } elseif ($j == 4){
                            $Punkte_Ausrichtung_Zapfen_uh[$i][$j][0] = "Punkte_Ausrichtung_Zapfen_E$i-P$j";
                            $Punkte_Ausrichtung_Zapfen_uh[$i][$j][1] = $x; //übernehmen des x-Wertes des 6. Kreisabschnitts
                            $Punkte_Ausrichtung_Zapfen_uh[$i][$j][2] = $y + $CircleStations[$NUMBEROFCIRCLESTATION][1];   //
                            $Punkte_Ausrichtung_Zapfen_uh[$i][$j][3] =  $CircleStations[$NUMBEROFCIRCLESTATION][2];
                        } 

                    }

                } 

                //hinten unten
                for ($i = 0; $i < 16; $i++){            //Ebenenschleife
                    if ($i == 0) {
                        $x =  $Punkte_Kreisabschnitte_oben[$NUMBEROFCIRCLESTATION][0][1];
                        $z = 0;
                        $local_Pitch_Angle = 0;
                    } elseif ($i == 1) {
                        $x = $x +20;
                        $z = -8.5;
                        $local_Pitch_Angle =  -12;
                    } elseif ($i == 2)  {
                        $x = $x +10;
                        $z = -8.5;
                        $local_Pitch_Angle =  -12;
                    } elseif ($i == 3)  {
                        $x = $x +10;
                        $z = -8.5;
                        $local_Pitch_Angle =  -8;
                    } elseif ($i == 4)  {
                        $x = $x +10;
                        $z = -8.5;
                        $local_Pitch_Angle =  -8;
                    } elseif ($i == 5)  {
                        $x = $x +10;
                        $z = -8.5;
                        $local_Pitch_Angle =  -4;
                    } elseif ($i == 6)  {
                        $x = $x +10;
                        $z = -8.5;
                        $local_Pitch_Angle =  -4;
                    } elseif ($i == 7)  {
                        $x = $x +10;
                        $z = -8.5;
                        $local_Pitch_Angle = 0;
                    } elseif ($i == 8)  {
                        $x = $x +10;
                        $z = -8.5;
                        $local_Pitch_Angle = 0;
                    } elseif ($i == 9)  {
                        $x = $x +10;
                        $z = -8.5;
                        $local_Pitch_Angle = 4;
                    } elseif ($i == 10)  {
                        $x = $x +10;
                        $z = -8.5;
                        $local_Pitch_Angle = 4;
                    } elseif ($i == 11)  {
                        $x = $x +10;
                        $z = -8.5;
                        $local_Pitch_Angle =8;
                    } elseif ($i == 12)  {
                        $x = $x +10;
                        $z = -8.5;
                        $local_Pitch_Angle = 8;
                    } elseif ($i == 13)  {
                        $x = $x +10;
                        $z = -8.5;
                        $local_Pitch_Angle = 12;
                    } elseif ($i == 14)  {
                        $x = $x +10;
                        $z = -8.5;
                        $local_Pitch_Angle = 12;
                    } elseif ($i == 15)  {
                        $x = $x +20;
                        $z = 0;
                        $local_Pitch_Angle = 0;
                    }
                    for ($j = 0 ; $j < 5; $j++){            //Punktschleife
                        if ($j == 0){
                            $y = 30; 
                            $a = 0;
                            //$z = 0;
                        } elseif ($j == 1){
                            $y = 30;
                            $a = 0;   
                        } elseif ($j == 2){
                            $y = 40;
                            $a = 0;  
                        } elseif ($j == 3){
                            $y = 40;
                            $a = 5;  
                        } elseif ($j == 4){
                            $y = 55;
                            $a = 0;
                            $z = 0; 
                        }
                        if ($j == 0){
                            $Punkte_Ausrichtung_Zapfen_oh[$i][$j][0] = "Punkte_Ausrichtung_Zapfen_E$i-P$j";
                            $Punkte_Ausrichtung_Zapfen_oh[$i][$j][1] = $x; //übernehmen des x-Wertes des 6. Kreisabschnitts
                            $Punkte_Ausrichtung_Zapfen_oh[$i][$j][2] = 20 + $CircleStations[$NUMBEROFCIRCLESTATION][1];   //
                            $Punkte_Ausrichtung_Zapfen_oh[$i][$j][3] = $z *cos($local_Pitch_Angle*(pi()/180)) + $y * sin($local_Pitch_Angle*(pi()/180)) + $CircleStations[$NUMBEROFCIRCLESTATION][2];
                        } elseif ($j == 1 or $j == 2 or $j == 3) {
                            $b = cos($local_Pitch_Angle*(2*pi()/180));
                            $Punkte_Ausrichtung_Zapfen_oh[$i][$j][0] = "Punkte_Ausrichtung_Zapfen_E$i-P$j";
                            $Punkte_Ausrichtung_Zapfen_oh[$i][$j][1] = $x; //übernehmen des x-Wertes des 6. Kreisabschnitts
                            $Punkte_Ausrichtung_Zapfen_oh[$i][$j][2] = $y *cos($local_Pitch_Angle*(pi()/180)) - $z * sin($local_Pitch_Angle*(pi()/180)) + $CircleStations[$NUMBEROFCIRCLESTATION][1] + $a;   //
                            $Punkte_Ausrichtung_Zapfen_oh[$i][$j][3] = $z *cos($local_Pitch_Angle*(pi()/180)) + $y * sin($local_Pitch_Angle*(pi()/180)) + $CircleStations[$NUMBEROFCIRCLESTATION][2];
                        } elseif ($j == 4){
                            $Punkte_Ausrichtung_Zapfen_oh[$i][$j][0] = "Punkte_Ausrichtung_Zapfen_E$i-P$j";
                            $Punkte_Ausrichtung_Zapfen_oh[$i][$j][1] = $x; //übernehmen des x-Wertes des 6. Kreisabschnitts
                            $Punkte_Ausrichtung_Zapfen_oh[$i][$j][2] = $y + $CircleStations[$NUMBEROFCIRCLESTATION][1];   //
                            $Punkte_Ausrichtung_Zapfen_oh[$i][$j][3] =  $CircleStations[$NUMBEROFCIRCLESTATION][2];
                        } 

                    }

                } 




        //............................Zentrierung_Konus.............................

            $Punkte_Zentrierung_Konus[0][0][0] = "Zentrierung_Konus E1-P1";                               //Mittelpunkte Kreis 1, kleiner Kreis
            $Punkte_Zentrierung_Konus[0][0][1] = $Punkte_Trennflaeche_Blockrand[1][1][1]+$PZK[0];  
            $Punkte_Zentrierung_Konus[0][0][2] = $Punkte_Trennflaeche_Blockrand[1][1][2]-$PZK[1];
            $Punkte_Zentrierung_Konus[0][0][3] = $PZK[2];
                                
            $Punkte_Zentrierung_Konus[0][1] =   $Punkte_Zentrierung_Konus[0][0];         //E1P2 Punkt auf Kreis 1 
            $Punkte_Zentrierung_Konus[0][1][0] = "Zentrierung_Konus E1-P2"; 
            $Punkte_Zentrierung_Konus[0][1][1] = $Punkte_Zentrierung_Konus[0][0][1]+10;     

            $Punkte_Zentrierung_Konus[1][0] =   $Punkte_Zentrierung_Konus[0][0];         //E2P1 Mittelpunkt Kreis 2 
            $Punkte_Zentrierung_Konus[1][0][0] = "Zentrierung_Konus E2-P1"; 
            $Punkte_Zentrierung_Konus[1][0][3] = $Punkte_Zentrierung_Konus[1][0][3]-30;

            $Punkte_Zentrierung_Konus[1][1] =   $Punkte_Zentrierung_Konus[1][0];         //E2P2 Punkt auf Kreis 2
            $Punkte_Zentrierung_Konus[1][1][0] = "Zentrierung_Konus E2-P2"; 
            $Punkte_Zentrierung_Konus[1][1][1] = $Punkte_Zentrierung_Konus[1][0][1]+10;

            $Rf1 = 1.496;             //Rundfaktor zur Spline-Halbkreis-Wandlung 5.Ordnung mitte außen (Richardsche Kreis Annäherung)
            $Rf2 = 0.88;
            $Rf3 = 0.7815;             //Rundfaktor zur Spline-Viertelkreis-Wandlung 4.Ordnung mitte außen
            $Rf4 = 0.2627;
            $Rf5 = 0.7913;             //Rundfaktor zur Spline-Halbkreis-Wandlung 5.Ordnung mitte außen
            $Rf6 = 0.3916; 

            $r1 = 10;
            $r2 = 15;

            for ($i = 0; $i < 2; $i++){    //Ebenenschleife    
                if ($i == 0){
                    if ($Side == "oben"){
                        $z = $PZK[2]-30;
                        $r = 15;
                    } else {
                        $z = $PZK[2];
                        $r = 10;
                    }
                } else {
                    if ($Side == "oben"){
                        $z = $PZK[2];
                        $r = 10;
                    } else {
                        $z = $PZK[2]-30;
                        $r = 15;
                    }
                }

                for ($j = 0; $j < 5; $j++){
                    if ($j == 0){
                        $x = $Punkte_Trennflaeche_Blockrand[1][1][1]+$PZK[0]+$r;
                        $y1 = $Punkte_Trennflaeche_Blockrand[1][1][2]-$PZK[1];
                        $y2 = $Punkte_Trennflaeche_Blockrand[1][1][2]-$PZK[1];
                    
                    }  elseif ($j == 1){

                        $x = $Punkte_Trennflaeche_Blockrand[1][1][1]+$PZK[0]+$r;
                        $y1 = $Punkte_Trennflaeche_Blockrand[1][1][2]-$PZK[1]+$r*$Rf2;
                        $y2 = $Punkte_Trennflaeche_Blockrand[1][1][2]-$PZK[1]-$r*$Rf2;

                        
                    }  elseif ($j == 2){

                        $x = $Punkte_Trennflaeche_Blockrand[1][1][1]+$PZK[0];
                        $y1 = $Punkte_Trennflaeche_Blockrand[1][1][2]-$PZK[1]+$r*$Rf1;
                        $y2 = $Punkte_Trennflaeche_Blockrand[1][1][2]-$PZK[1]-$r*$Rf1;



                    }  elseif ($j == 3){
                        $x = $Punkte_Trennflaeche_Blockrand[1][1][1]+$PZK[0]-$r;
                        $y1 = $Punkte_Trennflaeche_Blockrand[1][1][2]-$PZK[1]+$r*$Rf2;
                        $y2 = $Punkte_Trennflaeche_Blockrand[1][1][2]-$PZK[1]-$r*$Rf2;
                    }  elseif ($j == 4){
                        $x = $Punkte_Trennflaeche_Blockrand[1][1][1]+$PZK[0]-$r;
                        $y1 = $Punkte_Trennflaeche_Blockrand[1][1][2]-$PZK[1];
                        $y2 = $Punkte_Trennflaeche_Blockrand[1][1][2]-$PZK[1];
                    }
                    $Punkte_Zentrierung_Konus1[$i][$j][0] = "Punke_Zentrierung_Konus_E$i P$j";
                    $Punkte_Zentrierung_Konus1[$i][$j][1] = $x;
                    $Punkte_Zentrierung_Konus1[$i][$j][2] = $y1;
                    $Punkte_Zentrierung_Konus1[$i][$j][3] = $z;

                    $Punkte_Zentrierung_Konus2[$i][$j][0] = "Punke_Zentrierung_Konus_E$i P$j";
                    $Punkte_Zentrierung_Konus2[$i][$j][1] = $x;
                    $Punkte_Zentrierung_Konus2[$i][$j][2] = $y2;
                    $Punkte_Zentrierung_Konus2[$i][$j][3] = $z;

            

                }

            }
            for ($i = 0; $i < 2; $i++){    //Ebenenschleife    
                for ($j = 0; $j < 5; $j++){
                    if ($i == 0){
                        if ($Side == "oben"){
                            $Punkte_Zentrierung_Konus3[$i][$j] =  $Punkte_Zentrierung_Konus1[1][$j];
                        } else {
                            $Punkte_Zentrierung_Konus3[$i][$j] =  $Punkte_Zentrierung_Konus1[0][$j];
                        }
                    } else {
                        if ($Side == "oben"){
                            $Punkte_Zentrierung_Konus3[$i][$j] =  $Punkte_Zentrierung_Konus2[1][$j];
                        } else {
                            $Punkte_Zentrierung_Konus3[$i][$j] =  $Punkte_Zentrierung_Konus2[0][$j];
                        }



                        
                    }
                }
            }




        } //Ende Schleife include Block
        //............................Output........................................
            $Points[0][0] = $Punkte_Kreisabschnitte_oben;
            $Points[1][0] = $Punkte_Kreisabschnitte_unten;
            $Points[2][0] = $Punkte_Blattflaeche_oben;
            $Points[3][0] = $Punkte_Blattflaeche_unten;
            $Points[4][0] = $Punkte_Blattflaeche_HK;
            if ($includeblock == "ja"){
                $Points[5][0] = $Punkte_Trennflaeche_Tangentenrand_vorne;
                $Points[6][0] = $Punkte_Trennflaeche_Tangentenrand_hinten;
                $Points[7][0] = $Punkte_Trennflaeche_Blockrand;
                $Points[8][0] = $Punkte_Trennflaeche_Blockrand_aussen;
                $Points[9][0] = $Punkte_Distanzflaeche_Hauptflaeche_vorne;
                $Points[10][0] = $Punkte_Distanzflaeche_Hauptflaeche_hinten;
                $Points[11][0] = $Punkte_Trennflaeche_Tangentenrand_Zapfen;
                $Points[12][0] =  $Punkte_Distanzflaeche_Zapfen_vorne;
                $Points[13][0] =  $Punkte_Distanzflaeche_Zapfen_hinten;
                $Points[14][0] =  $Punkte_Distanzflaeche_Zapfen_spitze;
                $Points[15][0] = $Punkte_Distanzflaeche_Spitze_vorne;
                $Points[16][0] = $Punkte_Distanzflaeche_Spitze_hinten;
                $Points[17][0] = $Punkte_Ausrichtung_Zapfen_ov;
                $Points[18][0] = $Punkte_Ausrichtung_Zapfen_oh;
                $Points[19][0] = $Punkte_Ausrichtung_Zapfen_uv;
                $Points[20][0] = $Punkte_Ausrichtung_Zapfen_uh;
                $Points[21][0] = $Punkte_Zentrierung_Konus1;
                $Points[22][0] = $Punkte_Zentrierung_Konus2;
                $Points[23][0] = $Punkte_Zentrierung_Konus3;
            }




            //Drehen der Punkte für Rechtsdreher
            if ($Turn_Direction == "rechts"){
                for ($i = 0; $i < count($Points); $i++){               //jede Fläche
                for ($j = 0; $j < count($Points[$i][0]);$j++){             //jede Flächenebene
                    for ($k = 0; $k < count($Points[$i][0][$j]); $k++){      //jeder Punkt
                            $Points[$i][0][$j][$k][2]= - $Points[$i][0][$j][$k][2];
                    }
                }
            }
            }

            
            for ($i = 0; $i < count($Points);$i++){
                if ($i == 0){
                    $u = 2;
                    $v = 5;
                    $Surface_Name[$i]="Fläche_Zapfen_oben";
                    $Surface_Colour[$i] = "('NONE',0.3,0.3,0.8)";
                } elseif ($i == 1){
                    $u = 2;
                    $v = 5;
                    $Surface_Name[$i]="Fläche_Zapfen_unten";
                    $Surface_Colour[$i] = "('NONE',0.3,0.3,0.8)";
                } elseif ($i == 2){
                    $u = 4;           // u und v von Blattfläche übernommen
                    $v = $Punkte_Blatt[0][2];
                    $Surface_Name[$i]="Blattfläche-oben";
                    $Surface_Colour[$i] = "('NONE',1,0,0)";
                } elseif ($i == 3){
                    $u = 4;
                    $v = $Punkte_Blatt[0][2];
                    $Surface_Name[$i]="Blattfläche-unten";
                    $Surface_Colour[$i] = "('NONE',0,0,1)";
                } elseif ($i == 4){
                    $u = 4;
                    $v = 2;
                    $Surface_Name[$i]="Blattfläche-HK";
                    $Surface_Colour[$i] = "('NONE',0,0.5,1)";
                } elseif ($i == 5){
                    $u = 4;
                    $v = 2;
                    $Surface_Name[$i]="Trennflaeche_Tangentenrand_vorne";
                    $Surface_Colour[$i] = "('NONE',0,1,1)";
                } elseif ($i == 6){
                    $u = 4;
                    $v = 2;
                    $Surface_Name[$i]="Trennflaeche_Tangentenrand_hinten";
                    $Surface_Colour[$i] = "('NONE',0,1,1)";
                } elseif ($i == 7){
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="Trennflaeche_Blockrand";
                    $Surface_Colour[$i] = "('NONE',1,1,1)";
                } elseif ($i == 8){
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="Trennflaeche_Blockrand_aussen";
                    $Surface_Colour[$i] = "('NONE',0.2,0.1,0.8)";
                } elseif ($i == 9){
                    $u = 4;
                    $v = 4;
                    $Surface_Name[$i]="Distanzfläche_Hauptfläche_vorne";
                    $Surface_Colour[$i] = "('NONE',0.2,0.5,0.8)";
                } elseif ($i == 10){
                    $u = 4;
                    $v = 4;
                    $Surface_Name[$i]="Distanzfläche_Hauptfläche_hinten";
                    $Surface_Colour[$i] = "('NONE',0.2,0.5,0.8)";
                } elseif ($i == 11){
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="Trennflaeche_Tangentenrand_Zapfen";
                    $Surface_Colour[$i] = "('NONE',0,1,1)";
                } elseif ($i == 12){
                    $u = 2;
                    $v = 4;
                    $Surface_Name[$i]="Distanzflaeche_Zapfen_vorne";
                    $Surface_Colour[$i] = "('NONE',0.2,0.5,0.8)";
                } elseif ($i == 13){
                    $u = 2;
                    $v = 4;
                    $Surface_Name[$i]="Distanzflaeche_Zapfen_hinten";
                    $Surface_Colour[$i] ="('NONE',0.2,0.5,0.8)";
                } elseif ($i == 14){
                    $u = 4;
                    $v = 2;
                    $Surface_Name[$i]="Distanzflaeche_Zapfen_Spitze";
                    $Surface_Colour[$i] = "('NONE',0.2,0.5,0.8)";
                } elseif ($i == 15){
                    $u = 2;
                    $v = 4;
                    $Surface_Name[$i]="Distanzflaeche_Zapfen_Spitze_vorne";
                    $Surface_Colour[$i] = "('NONE',0.2,0.5,0.8)";
                } elseif ($i == 16){
                    $u = 2;
                    $v = 4;
                    $Surface_Name[$i]="Distanzflaeche_Zapfen_Spitze_hinten";
                    $Surface_Colour[$i] = "('NONE',0.2,0.5,0.8)";
                } elseif ($i == 17){
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="Ausrichtung_Zapfen_oben_vorne";
                    $Surface_Colour[$i] = "('NONE',1.,0.,0.5)";
                } elseif ($i == 18){
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="Ausrichtung_Zapfen_oben_hinten";
                    $Surface_Colour[$i] = "('NONE',1.,0.,0.5)";
                } elseif ($i == 19){
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="Ausrichtung_Zapfen_unten_hinten";
                    $Surface_Colour[$i] = "('NONE',1.,0.,0.5)";
                } elseif ($i == 20){
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="Ausrichtung_Zapfen_unten_vorne";
                    $Surface_Colour[$i] = "('NONE',1.,0.,0.5)";
                } elseif ($i == 21){
                    $u = 2;
                    $v = 5;
                    $Surface_Name[$i]="Zetrierung_Konus_1";
                    $Surface_Colour[$i] = "('NONE',0.7,0.2,0.0)";
                } elseif ($i == 22){
                    $u = 2;
                    $v = 5;
                    $Surface_Name[$i]="Zetrierung_Konus_2";
                    $Surface_Colour[$i] = "('NONE',0.7,0.2,0.0)";
                } elseif ($i == 23){
                    $u = 2;
                    $v = 5;
                    $Surface_Name[$i]="Zetrierung_Konus_3";
                    $Surface_Colour[$i] = "('NONE',0.7,0.2,0.0)";
                } elseif ($i == 24){
                    $u = 4;
                    $v = 4;
                    $Surface_Name[$i]="Distanzflaeche_Rundung_hinten";
                    $Surface_Colour[$i] = "('NONE',0.7,0.2,0.0)";
                } elseif ($i == 25){
                    $u = 4;
                    $v = 2;
                    $Surface_Name[$i]="Distanzflaeche_Stufe";
                    $Surface_Colour[$i] = "('NONE',0.7,0.2,0.0)";
                } elseif($i == 26) {  
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="Trennflaeche_Blockrand_aussen";
                    $Surface_Colour[$i] = "('NONE',0.0,1,0.1)";        
                    
                } elseif ($i == 27) {
                    $u = 2;
                    $v = 5;
                    $Surface_Name[$i]="Konus";
                    $Surface_Colour[$i] = "('NONE',0.5,0,0.5)";
                } elseif ($i == 28) {
                    $u = 4;
                    $v = 3;
                    $Surface_Name[$i]="Verrundung_oben";
                    $Surface_Colour[$i] = "('NONE',0.0,7,0.1)"; 
                } elseif ($i == 29) {
                    $u = 4;
                    $v = 3;
                    $Surface_Name[$i]="Verrundung_unten";
                    $Surface_Colour[$i] = "('NONE',0.0,7,0.1)";
                }
            $Points[$i][1] = $u;
            $Points[$i][2] = $v;
            $Points[$i][3] = $Surface_Name[$i];
            $Points[$i][4] = $Surface_Colour[$i];   
            }
            return($Points);
    }
    function Geometry_Calculation_RootK($includeblock ,$input_Wurzel_F, $inputWurzel_Block, $Side, $Turn_Direction, $Roottyp){ //Geometrieberechnung der Wurzel Typ K
        //............................Input.........................................
                //Input Block

              
            
                $zKW = $inputWurzel_Block[0];             //z-Verschiebung Tangentenrand
                $bTR = $inputWurzel_Block[1][0]*1;             //Trennfläche_Tangentenrand Breite
                $bB = $inputWurzel_Block[2][0]*1;              //Blockrand Breite
                $PB = $inputWurzel_Block[3];              //Blockabmaße
                $P0B = $inputWurzel_Block[4];             //Blocknullpunkt
                $PZK = $inputWurzel_Block[5];             //Punkt Zentrierkonus
                $DFB = $inputWurzel_Block[6];             //Fräserdurchmesser Blockrand
                //$RotationAngleBlock = $inputWurzel_Block[6][$i]/180*pi();             //Drehwinkel in Blockebene
                
            
            
            
            
            
           
            
                $z_E1 = $input_Wurzel_F[0];                          //z-Höhe Flansch 1 (ungedreht)
                $z_E2 = $input_Wurzel_F[1];                          //z-Höhe Flansch 2 (ungedreht)
                $z_E3 = $input_Wurzel_F[2];                          //z-Höhe Flansch 3 (ungedreht)
                $R_F = $input_Wurzel_F[3];                            //Flanschradius
                $S_p =  $z_E1 - $z_E2;                          //Spaltmaß 
                $p_w =   $input_Wurzel_F[5];                         //y-Verschiebung der Drehachse
                $AngleofIncidence = $input_Wurzel_F[6];              //Einstellwinkel der Wurzel
                $Cone_Angle =  $input_Wurzel_F[7];                 //V-Winkel der Wurzel
                $RotationAngleBlock =   $input_Wurzel_F[8];          //Verdrehwinkel in die Blockebene
                $WT =   $input_Wurzel_F[9];          //Abstand erste Ebene der Flanschflächen
                $AT =  $input_Wurzel_F[10];  //Abstand Ebene Tangentenausrichtung zu x_RPS             
                $x_RPS = $input_Wurzel_F[11];        //x-Wert der Trennstelle
                $RotationAngle = ($AngleofIncidence + $RotationAngleBlock); //Verdrehwinkel gesamt
                //$x_Extension = [12];  // Verlängerung der geraden Blattfläche zu x_RPS
                $Kompatibility = $input_Wurzel_F[12];
                $L_F = $input_Wurzel_F[14];
                if ($input_Wurzel_F[13] == null){
                    $Kompatibility_Points = PropellerModellKompatibilitaet::where('name', '=', "$Kompatibility")->pluck('inputKompatibilitaet');
                    
                    $Kompatibility_Points = str_replace('[','',$Kompatibility_Points);
                    $Kompatibility_Points = str_replace('"','',$Kompatibility_Points);
                    $Kompatibility_Points = str_replace(']','',$Kompatibility_Points);
                    $Kompatibility_Points = str_replace('\t','',$Kompatibility_Points);
            
                    $Kompatibility_Points =  explode('\r\n', $Kompatibility_Points); 
                
                    $counter_1 = count($Kompatibility_Points); //Anzahl der Profilpunktestützpunkte
                    for ($i_1 = 0; $i_1 < $counter_1; $i_1++ ){
                        $row = explode(' ',$Kompatibility_Points[$i_1] );
                        $Kompatibility_Points[$i_1] =  $row; 
                    }
                } else {
                    $Kompatibility_Points = $input_Wurzel_F[13]; 
                    $Kompatibility_Points = explode("\r\n", $Kompatibility_Points);
                    for ($j=0; $j < count($Kompatibility_Points); $j++){
                        $Kompatibility_Points[$j] = explode(" ", $Kompatibility_Points[$j]);
                    }
        
                }

                for ($j=0;$j < 4; $j++){
                    for ($i=0;$i < count($Kompatibility_Points)/8; $i++){                         
                        $RPS_Points[$j][$i] = $Kompatibility_Points[$i+($j)*count($Kompatibility_Points)/4];
                        $RPS_AT_Points[$j][$i] = $Kompatibility_Points[$i+($j)*count($Kompatibility_Points)/4+count($Kompatibility_Points)/8];
                        }    
                }
                



        //............................Flansche......................................
            $Rf1 = 1;             //Rundfaktor zur Spline-Halbkreis-Wandlung 5.Ordnung mitte außen
            $Rf2 = 1;
            $Rf3 = 1;             //Rundfaktor zur Spline-Viertelkreis-Wandlung 4.Ordnung mitte außen
            $Rf4 = 1;
            $Rf5 = 1;             //Rundfaktor zur Spline-Halbkreis-Wandlung 5.Ordnung mitte außen
            $Rf6 = 1;    


            for ($i = 0; $i < 4; $i++){              //Flanschebenen Schleife
                $c = $i +1;
                if($i == 0){                           //Ebene 1
                    $y1 = -$R_F;
                    $z = $z_E1;
                } elseif($i == 1){                     //Ebene 2
                    $y1 = -$R_F;
                    $z = $z_E2-$S_p;
                } elseif ($i == 2){                    //Ebene 2 mit Spalt
                    $y1 = $R_F;
                    $z = $z_E2+$S_p;
                } elseif ($i == 3){                     //Ebene 3
                    $y1 = $R_F;
                    $z = $z_E3;
                }
                for ($j = 0; $j < 5; $j++){          //Ebenenschleife
                    $a = $j+1;
                    if ($j == 0){
                        $x = -$L_F;
                        $yE = 0;
                    }elseif ($j == 1){
                        $x = -$L_F;
                        $yE = $y1 ;
                    }elseif ($j == 2){
                        $x = 0;
                        $yE = $y1 * $Rf1;
                    }elseif ($j == 3){
                        $x = $L_F;
                        $yE = $y1 * $Rf2;
                    }elseif ($j == 4){
                        $x = $L_F;
                        $yE = 0;
                        }
                    for ($k = 0; $k < 2; $k++){       //Punkteschleife
                        $b = $k+1;
                        if ($k == 0){
                            $y = 0;
                        } else {
                            $y = $yE;
                        }
                        $Punkte_Flanschflaeche[$i][$j][$k][0] = "Flanschflaeche_Ebene$c-E$a-P$b";                               //Drehung um x-Achse
                        $Punkte_Flanschflaeche[$i][$j][$k][1] = $x;
                        $Punkte_Flanschflaeche[$i][$j][$k][2] = $y*cos($RotationAngle)-$z*sin($RotationAngle)+$p_w;
                        $Punkte_Flanschflaeche[$i][$j][$k][3] = $y*sin($RotationAngle) + $z*cos($RotationAngle);
                        
                        $deltax = $Punkte_Flanschflaeche[$i][$j][$k][1]- $x_RPS; // $x_RPS -  Abstand zwischen Punkt und Drehachse (Achse liegt bei RPS)
                        $Punkte_Flanschflaeche[$i][$j][$k][1] = $deltax*cos($Cone_Angle)-$Punkte_Flanschflaeche[$i][$j][$k][3]*sin($Cone_Angle);    //Drehung um y-Achse
                        $Punkte_Flanschflaeche[$i][$j][$k][3] = $deltax*sin($Cone_Angle)+$Punkte_Flanschflaeche[$i][$j][$k][3]*cos($Cone_Angle);
                        $Punkte_Flanschflaeche[$i][$j][$k][1] = $Punkte_Flanschflaeche[$i][$j][$k][1] +$x_RPS;


                    }

                }
            }
        //............................Flansch_Rundung......................................    


            $Rf1 = 1.496;             //Rundfaktor zur Spline-Halbkreis-Wandlung 5.Ordnung mitte außen (Richardsche Kreis Annäherung)
            $Rf2 = 0.88;
            $Rf3 = 0.7815;             //Rundfaktor zur Spline-Viertelkreis-Wandlung 4.Ordnung mitte außen
            $Rf4 = 0.2627;
            $Rf5 = 0.7913;             //Rundfaktor zur Spline-Halbkreis-Wandlung 5.Ordnung mitte außen
            $Rf6 = 0.3916; 
            $Rf7 = 1.65;


            if ($Roottyp == "K"){
                for ($i = 0; $i < 4; $i++){    //Ebenenschleife    
                    if ($i == 0){
                        $y = -$R_F;
                        $r = 0;
                    } elseif ($i == 1){
                        $y = -$R_F;
                        $r = ($z_E1-$z_E3)/2;
                    } elseif ($i == 2){
                        $y = $R_F;
                        $r = ($z_E1-$z_E3)/2;
                    } elseif ($i == 3){
                        $y = $R_F;
                        $r = 0;
                    }

                    for ($j = 0; $j < 5; $j++){
                        if ($j == 0){
                            $x = -$L_F;
                            $z = $z_E1;
                        }  elseif ($j == 1){
                            $x = -$L_F - $r*$Rf2;
                            $z = $z_E1;
                        }  elseif ($j == 2){
                            $x = -$L_F - $r*$Rf1;
                            $z = $z_E2;
                        }  elseif ($j == 3){
                            $x = -$L_F - $r*$Rf2;
                            $z = $z_E3;
                        }  elseif ($j == 4){
                            $x = -$L_F;
                            $z = $z_E3;
                        }
                        $Punkte_Flanschflaeche_Rundung[$i][$j][0] = "Punke_Kreisabschnitte_Zapfen_oben_E$i P$j";
                        $Punkte_Flanschflaeche_Rundung[$i][$j][1] = $x;
                        $Punkte_Flanschflaeche_Rundung[$i][$j][2] = $y;//*cos($RotationAngle)-$z*sin($RotationAngle)+$p_w;
                        $Punkte_Flanschflaeche_Rundung[$i][$j][3] = $z;//*sin($RotationAngle) + $z*cos($RotationAngle);

                        $y_temp= $Punkte_Flanschflaeche_Rundung[$i][$j][2];
                        $z_temp = $Punkte_Flanschflaeche_Rundung[$i][$j][3];


                        $Punkte_Flanschflaeche_Rundung[$i][$j][0] = "Punke_Kreisabschnitte_Zapfen_oben_E$i P$j";
                        $Punkte_Flanschflaeche_Rundung[$i][$j][1] = $x;
                        $Punkte_Flanschflaeche_Rundung[$i][$j][2] = $y_temp*cos($RotationAngle)-$z_temp*sin($RotationAngle)+$p_w;
                        $Punkte_Flanschflaeche_Rundung[$i][$j][3] = $y_temp*sin($RotationAngle) + $z_temp*cos($RotationAngle);
                
                        $deltax = $Punkte_Flanschflaeche_Rundung[$i][$j][1]- $x_RPS; // $x_RPS -  Abstand zwischen Punkt und Drehachse (Achse liegt bei RPS)
                        $Punkte_Flanschflaeche_Rundung[$i][$j][0] = "Punke_Kreisabschnitte_Zapfen_oben_E$i P$j";
                        $Punkte_Flanschflaeche_Rundung[$i][$j][1] = $x;
                        $Punkte_Flanschflaeche_Rundung[$i][$j][1] = $deltax*cos($Cone_Angle)-$Punkte_Flanschflaeche_Rundung[$i][$j][3]*sin($Cone_Angle);    //Drehung um y-Achse
                        $Punkte_Flanschflaeche_Rundung[$i][$j][3] = $deltax*sin($Cone_Angle)+$Punkte_Flanschflaeche_Rundung[$i][$j][3]*cos($Cone_Angle);
                        $Punkte_Flanschflaeche_Rundung[$i][$j][1] = $Punkte_Flanschflaeche_Rundung[$i][$j][1] +$x_RPS; 
                        
                    }     
                }
            } else {
                for ($i = 0; $i < 4; $i++){    //Ebenenschleife    
                    if ($i == 0){
                        $z = $z_E1;
                        $r = 0;
                    } elseif ($i == 1){
                        $z = $z_E1;
                        $r = $R_F;
                    } elseif ($i == 2){
                        $z = $z_E3;
                        
                        $r = $R_F;
                    } elseif ($i == 3){
                        
                        $z = $z_E3;
                        $r = 0;
                    }

                    for ($j = 0; $j < 5; $j++){
                        if ($j == 0){
                            $x = -$L_F;
                            $y = -$R_F;
                            
                        }  elseif ($j == 1){
                            $x = -$L_F - $r*$Rf2;
                            $y = -$R_F;
                            
                        }  elseif ($j == 2){
                            $x = -$L_F - $r*$Rf1;
                            $y = 0;
                        }  elseif ($j == 3){
                            $x = -$L_F - $r*$Rf2;
                            $y = $R_F;
                        }  elseif ($j == 4){
                            $x = -$L_F;
                            $y = $R_F;
                        }
                        $Punkte_Flanschflaeche_Rundung[$i][$j][0] = "Punke_Kreisabschnitte_Zapfen_oben_E$i P$j";
                        $Punkte_Flanschflaeche_Rundung[$i][$j][1] = $x;
                        $Punkte_Flanschflaeche_Rundung[$i][$j][2] = $y;//*cos($RotationAngle)-$z*sin($RotationAngle)+$p_w;
                        $Punkte_Flanschflaeche_Rundung[$i][$j][3] = $z;//*sin($RotationAngle) + $z*cos($RotationAngle);

                        $y_temp= $Punkte_Flanschflaeche_Rundung[$i][$j][2];
                        $z_temp = $Punkte_Flanschflaeche_Rundung[$i][$j][3];


                        $Punkte_Flanschflaeche_Rundung[$i][$j][0] = "Punke_Kreisabschnitte_Zapfen_oben_E$i P$j";
                        $Punkte_Flanschflaeche_Rundung[$i][$j][1] = $x;
                        $Punkte_Flanschflaeche_Rundung[$i][$j][2] = $y_temp*cos($RotationAngle)-$z_temp*sin($RotationAngle)+$p_w;
                        $Punkte_Flanschflaeche_Rundung[$i][$j][3] = $y_temp*sin($RotationAngle) + $z_temp*cos($RotationAngle);
                
                        $deltax = $Punkte_Flanschflaeche_Rundung[$i][$j][1]- $x_RPS; // $x_RPS -  Abstand zwischen Punkt und Drehachse (Achse liegt bei RPS)
                        $Punkte_Flanschflaeche_Rundung[$i][$j][0] = "Punke_Kreisabschnitte_Zapfen_oben_E$i P$j";
                        $Punkte_Flanschflaeche_Rundung[$i][$j][1] = $x;
                        $Punkte_Flanschflaeche_Rundung[$i][$j][1] = $deltax*cos($Cone_Angle)-$Punkte_Flanschflaeche_Rundung[$i][$j][3]*sin($Cone_Angle);    //Drehung um y-Achse
                        $Punkte_Flanschflaeche_Rundung[$i][$j][3] = $deltax*sin($Cone_Angle)+$Punkte_Flanschflaeche_Rundung[$i][$j][3]*cos($Cone_Angle);
                        $Punkte_Flanschflaeche_Rundung[$i][$j][1] = $Punkte_Flanschflaeche_Rundung[$i][$j][1] +$x_RPS; 
                        
                    }     
                }


            }
        //............................Verbindungsflächen.........................................
            
                for ($j = 0; $j < count($Punkte_Flanschflaeche[0]); $j++){                                         
                    $Punkte_Verbindungsflaeche_1_2_aussen[$j][0] = $Punkte_Flanschflaeche[0][$j][1];                       //Verbindungsfläche 1-2 außen       
                    $Punkte_Verbindungsflaeche_1_2_aussen[$j][0][0] = "Punkte_Verbindungsflaeche_1_2_aussen_E$j P1";           //übernehmen der P2 von Flanschebene 1 und 2
                    $Punkte_Verbindungsflaeche_1_2_aussen[$j][1] = $Punkte_Flanschflaeche[1][$j][1];
                    $Punkte_Verbindungsflaeche_1_2_aussen[$j][0][0] = "Punkte_Verbindungsflaeche_1_2_aussen_E$j P2";
            
                    $Punkte_Verbindungsflaeche_1_2_stufe[$j][0] = $Punkte_Flanschflaeche[0][$j][0];                       //Verbindungsfläche 1-2 Stufe       
                    $Punkte_Verbindungsflaeche_1_2_stufe[$j][0][0] = "Punkte_Verbindungsflaeche_1_2_stufe_E$j P1";           //übernehmen der P2 von Flanschebene 1 und 2
                    $Punkte_Verbindungsflaeche_1_2_stufe[$j][1] = $Punkte_Flanschflaeche[1][$j][0];
                    $Punkte_Verbindungsflaeche_1_2_stufe[$j][0][0] = "Punkte_Verbindungsflaeche_1_2_stufe_E$j P2";
            
                    $Punkte_Verbindungsflaeche_2_3_aussen[$j][0] = $Punkte_Flanschflaeche[2][$j][1];                       //Verbindungsfläche 1-2 außen       
                    $Punkte_Verbindungsflaeche_2_3_aussen[$j][0][0] = "Punkte_Verbindungsflaeche_2_3_aussen_E$j P1";           //übernehmen der P2 von Flanschebene 2 und 3
                    $Punkte_Verbindungsflaeche_2_3_aussen[$j][1] = $Punkte_Flanschflaeche[3][$j][1];
                    $Punkte_Verbindungsflaeche_2_3_aussen[$j][0][0] = "Punkte_Verbindungsflaeche_2_3_aussen_E$j P2";
            
                    $Punkte_Verbindungsflaeche_2_3_stufe[$j][0] = $Punkte_Flanschflaeche[2][$j][0];                       //Verbindungsfläche 1-2 Stufe       
                    $Punkte_Verbindungsflaeche_2_3_stufe[$j][0][0] = "Punkte_Verbindungsflaeche_2_3_stufe_E$j P1";           //übernehmen der P2 von Flanschebene 3 und 3
                    $Punkte_Verbindungsflaeche_2_3_stufe[$j][1] = $Punkte_Flanschflaeche[3][$j][0];
                    $Punkte_Verbindungsflaeche_2_3_stufe[$j][0][0] = "Punkte_Verbindungsflaeche_2_3_stufe_E$j P2";}
        //............................Blattfläche...................................
                for ($i = 0; $i < 4; $i++){              //Blattflächen-Schleife
                    $c = $i +1;
                    if($i == 0){         //
                        $y1 = -$R_F;
                        $z1 = $z_E1;
            
                    } elseif($i == 1){
                        $y1 = -$R_F;
                        $z1 = $z_E2-$S_p;
                    } elseif ($i == 2){
                        $y1 = $R_F;
                        $z1 = $z_E2+$S_p;
                    } elseif ($i == 3){
                        $y1 = $R_F;
                        $z1 = $z_E3;
                    }
                    for ($j = 0; $j < 4; $j++){          //Ebenenschleife
                        $a = $j+1;
                        if ($j == 0){
                            for ($k = 0; $k < 5; $k++){       //Punkteschleife E1
                                $b = $k+1;
                                if ($k == 0){
                                    $x = $L_F;
                                    $y = $y1;
                                    $z = $z1;
                                } elseif ($k == 1) {
                                    $x = $L_F;
                                    $y = $y1/4*3;
                                    $z = $z1;
                                } elseif ($k == 2){
                                    $x = $L_F;
                                    $y = $y1/4*2;
                                    $z = $z1;
                                } elseif ($k == 3){
                                    $x = $L_F;
                                    $y = $y1/4;
                                    $z = $z1;
                                } elseif ($k == 4){
                                    $x = $L_F;
                                    $y = 0;
                                    $z = $z1;
                                }
                                $Punkte_Blattflaeche[$i][$j][$k][0] = "Punkte_Blattflaeche_$c-E$a-P$b";             //berechnen des Viertelkreises am Flansch
                                $Punkte_Blattflaeche[$i][$j][$k][1] = $x;
                                $Punkte_Blattflaeche[$i][$j][$k][2] = $y*cos($RotationAngle)-$z*sin($RotationAngle)+$p_w;
                                $Punkte_Blattflaeche[$i][$j][$k][3] = $y*sin($RotationAngle) + $z*cos($RotationAngle);
            
                                
                            }
                        }elseif ($j == 1){
                            for ($k = 0; $k < 5; $k++){
                                $b = $k+1; 
                                $Punkte_Blattflaeche[$i][$j][$k] = $Punkte_Blattflaeche[$i][0][$k];                  
                                $Punkte_Blattflaeche[$i][$j][$k][1] = $Punkte_Blattflaeche[$i][0][4][1]+$WT;
                                $Punkte_Blattflaeche[$i][$j][$k][0] = "Punkte_Blattflaeche_$c-E$a-P$b";
            
                            
                            }
                        } elseif ($j == 2){
                            for ($k = 0; $k < count($RPS_Points[$i]); $k++){
                                $b = $k+1;
                                $Punkte_Blattflaeche[$i][$j][$k][0] = "Punkte_Blattflaeche_$c-E$a-P$b";
                                $Punkte_Blattflaeche[$i][$j][$k][1] = $x_RPS-$AT;
                                $Punkte_Blattflaeche[$i][$j][$k][2] = $RPS_AT_Points[$i][$k][0];
                                $Punkte_Blattflaeche[$i][$j][$k][3] = $RPS_AT_Points[$i][$k][1];
            
                
                            }     
                        } elseif ($j == 3){
                            for ($k = 0; $k < count($RPS_Points[$i]); $k++){
                                $b = $k+1;
                                $Punkte_Blattflaeche[$i][$j][$k][0] = "Punkte_Blattflaeche_$c-E$a-P$b";
                                $Punkte_Blattflaeche[$i][$j][$k][1] = $x_RPS;
                                $Punkte_Blattflaeche[$i][$j][$k][2] = $RPS_Points[$i][$k][0];
                                $Punkte_Blattflaeche[$i][$j][$k][3] = $RPS_Points[$i][$k][1];
            
                                
                            }
                        }
                    }
                }
                //Drehung um y-Achse
                for ($i = 0; $i < 4; $i++){
                    for ($j = 0; $j < 4; $j++){
                        for ($k = 0; $k < 5; $k++){
                            if ($j == 0 or $j ==1){
                                $deltax = $Punkte_Blattflaeche[$i][$j][$k][1]- $x_RPS; // $x_RPS -  Abstand zwischen Punkt und Drehachse (Achse liegt bei RPS)
                                $Punkte_Blattflaeche[$i][$j][$k][1] = $deltax*cos($Cone_Angle)-$Punkte_Blattflaeche[$i][$j][$k][3]*sin($Cone_Angle);    //Drehung um y-Achse
                                $Punkte_Blattflaeche[$i][$j][$k][3] = $deltax*sin($Cone_Angle)+$Punkte_Blattflaeche[$i][$j][$k][3]*cos($Cone_Angle);
                                $Punkte_Blattflaeche[$i][$j][$k][1] = $Punkte_Blattflaeche[$i][$j][$k][1] +$x_RPS;
                            }
                        }
                    }
                }
                
                //if ($x_Extension <> 0){

            

        //............................Schnittfläche.................................
            for ($i = 0; $i < count($Punkte_Blattflaeche[0]); $i++){       //übernehmen der Punkte von Blattflächen
                $a = $i+1;
                $Punkte_Schnittflaeche[$i][0] = $Punkte_Blattflaeche[0][$i][4];
                $Punkte_Schnittflaeche[$i][0][0] = "Punkte_Schnittflaeche_E$a-P1";
                $Punkte_Schnittflaeche[$i][1] = $Punkte_Blattflaeche[3][$i][4];
                $Punkte_Schnittflaeche[$i][0][0] = "Punkte_Schnittflaeche_E$a-P2";
            }
        //............................Kantenfläche_HK...............................
            for ($i = 0; $i < count($Punkte_Blattflaeche[0]); $i++){      //übernehmen der Punkte von Blattflächen
                $a = $i+1;
                $Punkte_Kantenflaeche_HK[$i][0] = $Punkte_Blattflaeche[2][$i][0];
                $Punkte_Kantenflaeche_HK[$i][0][0] = "Punkte_Schnittflaeche_E$a-P1";
                $Punkte_Kantenflaeche_HK[$i][1] = $Punkte_Blattflaeche[3][$i][0];
                $Punkte_Kantenflaeche_HK[$i][0][0] = "Punkte_Schnittflaeche_E$a-P2";

            }  
        //............................Kantenfläche_VK...............................
            for ($i = 0; $i < count($Punkte_Blattflaeche[0]); $i++){      //übernehmen der Punkte von Blattflächen
                $a = $i+1;
                $Punkte_Kantenflaeche_VK[$i][0] = $Punkte_Blattflaeche[0][$i][0];
                $Punkte_Kantenflaeche_VK[$i][0][0] = "Punkte_Schnittflaeche_E$a-P1";
                $Punkte_Kantenflaeche_VK[$i][1] = $Punkte_Blattflaeche[1][$i][0];
                $Punkte_Kantenflaeche_VK[$i][0][0] = "Punkte_Schnittflaeche_E$a-P2";
            }  
            

        //............................Tangentenrand.................................

            if ($Side == 'oben')                                                                //Offset für oben oder unten setzen um Spalt zu generieren
                {$Distanzflaechen_zOffset = 0.6;}     //0.6                       
            else
                {$Distanzflaechen_zOffset = -0.6;}
            $Distanzflaechen_yOffset = 2;
            $Distanzflaechen_xOffset = 2;



            if ($includeblock == "ja"){ 

                //Trennfläche_Tangentenrand_vorne   

                for ($i = 0; $i < count($Punkte_Blattflaeche[0]); $i++){                        
                    $a = $i+1;                                                                              //übernehmen der Punkte von Blattflächen
                    $Punkte_Trennflaeche_Tangentenrand_vorne[$i][0] = $Punkte_Blattflaeche[0][$i][0];
                    $Punkte_Trennflaeche_Tangentenrand_vorne[$i][0][3] = $Punkte_Trennflaeche_Tangentenrand_vorne[$i][0][3] +$zKW[$i];
                
                    $Punkte_Trennflaeche_Tangentenrand_vorne[$i][0][0] = "Punkte_Tangentenrand_vorne_E$a-P1";
                    $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1] = $Punkte_Trennflaeche_Tangentenrand_vorne[$i][0];
                    $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][1] = $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][1];
                    $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][2] =  $Punkte_Trennflaeche_Tangentenrand_vorne[$i][0][2]-$bTR;
                    //$Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][3] = $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][3] - $zKW[$i]; 
                    $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][0] = "Punkte_Tangentenrand_vorne_E$a-P2";
                    
                }   
                
                //Trennflaeche_Tangentenrand_hinten  
                for ($i = 0; $i < count($Punkte_Blattflaeche[0]); $i++){                          
                    $a = $i+1;    
                    
                    $Punkte_Trennflaeche_Tangentenrand_hinten[$i][0] = $Punkte_Blattflaeche[3][$i][0];    //übernehmen der Punkte von Blattflächen 
                    $Punkte_Trennflaeche_Tangentenrand_hinten[$i][0][0] = "Punkte_Tangentenrand_hinten_E$a-P1";
                    if ($i == count($Punkte_Blattflaeche[0]) -1){                                                                                       //versetzen der letzten Stützpunkte in die Mitte der HK
                        $Punkte_Trennflaeche_Tangentenrand_hinten[$i][0][2] = ($Punkte_Blattflaeche[2][$i][0][2]+$Punkte_Blattflaeche[3][$i][0][2])/2;
                        $Punkte_Trennflaeche_Tangentenrand_hinten[$i][0][3] = ($Punkte_Blattflaeche[2][$i][0][3]+$Punkte_Blattflaeche[3][$i][0][3])/2;
                    }
                    $Punkte_Trennflaeche_Tangentenrand_hinten[$i][1] = $Punkte_Trennflaeche_Tangentenrand_hinten[$i][0];        
                    $Punkte_Trennflaeche_Tangentenrand_hinten[$i][1][2] =  $Punkte_Trennflaeche_Tangentenrand_hinten[$i][0][2]+$bTR;
                    $Punkte_Trennfläche_Tangentenrand_hinten[$i][1][0] = "Punkte_Tangentenrand_hinten_E$a-P2";
                }

                //Trennflaeche_Tangentenrand_Flansch

                $Punkte_Tangentenrand_Flansch_hinten[0][0] = $Punkte_Flanschflaeche[3][1][1];
                $Punkte_Tangentenrand_Flansch_hinten[0][1] = $Punkte_Tangentenrand_Flansch_hinten[0][0];
                $Punkte_Tangentenrand_Flansch_hinten[0][1][2] = $Punkte_Tangentenrand_Flansch_hinten[0][1][2] + $bTR;
                
                $Punkte_Tangentenrand_Flansch_hinten[1][0] = $Punkte_Flanschflaeche[3][3][1];
                $Punkte_Tangentenrand_Flansch_hinten[1][1] = $Punkte_Tangentenrand_Flansch_hinten[1][0];
                $Punkte_Tangentenrand_Flansch_hinten[1][1][2] = $Punkte_Tangentenrand_Flansch_hinten[1][1][2] + $bTR;



                $Punkte_Tangentenrand_Flansch_vorne[0][0] = $Punkte_Flanschflaeche[0][1][1];
                $Punkte_Tangentenrand_Flansch_vorne[0][1] = $Punkte_Tangentenrand_Flansch_vorne[0][0];
                $Punkte_Tangentenrand_Flansch_vorne[0][1][2] = $Punkte_Tangentenrand_Flansch_vorne[0][1][2] - $bTR;
                
                $Punkte_Tangentenrand_Flansch_vorne[1][0] = $Punkte_Flanschflaeche[0][3][1];
                $Punkte_Tangentenrand_Flansch_vorne[1][1] = $Punkte_Tangentenrand_Flansch_vorne[1][0];
                $Punkte_Tangentenrand_Flansch_vorne[1][1][2] = $Punkte_Tangentenrand_Flansch_vorne[1][1][2] - $bTR;


            //$Punkte_Tangentenrand_Rundung_vorne
                $r = ($z_E1-$z_E3)/2;

                $Punkte_Tangentenrand_Rundung_vorne[0][0] = $Punkte_Flanschflaeche_Rundung[2][4];

                $Punkte_Tangentenrand_Rundung_vorne[0][1] = $Punkte_Flanschflaeche_Rundung[2][3];
                $Punkte_Tangentenrand_Rundung_vorne[0][1][1] =  $Punkte_Tangentenrand_Rundung_vorne[0][1][1];

                $Punkte_Tangentenrand_Rundung_vorne[0][2] = $Punkte_Flanschflaeche_Rundung[2][2];
                if ($Roottyp == "K"){
                    $Punkte_Tangentenrand_Rundung_vorne[0][2][1] =  $Punkte_Tangentenrand_Rundung_vorne[0][2][1]+$r*$Rf1-$r;   
                } else {
                    $Punkte_Tangentenrand_Rundung_vorne[0][2][1] =  $Punkte_Tangentenrand_Rundung_vorne[0][2][1]+$r*$Rf7-$r;
                }
                


                for ($i = 0; $i < 3 ; $i++) { 
                    $Punkte_Tangentenrand_Rundung_vorne[1][$i] = $Punkte_Tangentenrand_Rundung_vorne[0][$i];
                    $Punkte_Tangentenrand_Rundung_vorne[1][$i][2] = $Punkte_Tangentenrand_Rundung_vorne[1][$i][2]+$bTR;
                }

                //$Punkte_Tangentenrand_Rundung_hinten
                

                $Punkte_Tangentenrand_Rundung_hinten[0][0] = $Punkte_Flanschflaeche_Rundung[1][0];

                $Punkte_Tangentenrand_Rundung_hinten[0][1] = $Punkte_Flanschflaeche_Rundung[1][1];
                $Punkte_Tangentenrand_Rundung_hinten[0][1][1] =  $Punkte_Tangentenrand_Rundung_hinten[0][1][1];

                $Punkte_Tangentenrand_Rundung_hinten[0][2] = $Punkte_Flanschflaeche_Rundung[1][2];
                if ($Roottyp == "K"){
                    $Punkte_Tangentenrand_Rundung_hinten[0][2][1] =  $Punkte_Tangentenrand_Rundung_hinten[0][2][1]+$r*$Rf1-$r;
                } else {
                    $Punkte_Tangentenrand_Rundung_hinten[0][2][1] =  $Punkte_Tangentenrand_Rundung_hinten[0][2][1]+$r*$Rf7-$r;
                }

                    


                for ($i = 0; $i < 3 ; $i++) { 
                $Punkte_Tangentenrand_Rundung_hinten[1][$i] = $Punkte_Tangentenrand_Rundung_hinten[0][$i];
                $Punkte_Tangentenrand_Rundung_hinten[1][$i][2] = $Punkte_Tangentenrand_Rundung_hinten[1][$i][2]-$bTR;
                }


                    //$Punkte_Tangentenrand_Rundung
                $Punkte_Tangentenrand_Rundung[0][0] = $Punkte_Tangentenrand_Rundung_hinten[1][2];
                $Punkte_Tangentenrand_Rundung[1][0] = $Punkte_Tangentenrand_Rundung_hinten[0][2];

                $Punkte_Tangentenrand_Rundung[2][0] = $Punkte_Tangentenrand_Rundung_vorne[0][2];
                $Punkte_Tangentenrand_Rundung[3][0] = $Punkte_Tangentenrand_Rundung_vorne[1][2];

            
                            
                for ($i = 0; $i < 4 ; $i++) { 
                    $Punkte_Tangentenrand_Rundung[$i][1] = $Punkte_Tangentenrand_Rundung[$i][0];
                    $Punkte_Tangentenrand_Rundung[$i][1][1] = $Punkte_Tangentenrand_Rundung[$i][0][1]-$bTR;
                }
                
            
            
                
            
            

            
            
            
            
            
            
            
            
            
        //............................Blockrand.....................................
                                                                                            
            $Punkte_Trennflaeche_Blockrand[0][0][0] = "Trennflaeche_Blockrand-E1-P1";       //Trennfläche_Blockrand setzen der Blockrand Punkte                       
            $Punkte_Trennflaeche_Blockrand[0][0][1] = $P0B[0];
            $Punkte_Trennflaeche_Blockrand[0][0][2] = $P0B[1];
            $Punkte_Trennflaeche_Blockrand[0][0][3] = 0;

            $Punkte_Trennflaeche_Blockrand[0][1][0] = "Trennflaeche_Blockrand-E1-P2";
            $Punkte_Trennflaeche_Blockrand[0][1][1] = $P0B[0];
            $Punkte_Trennflaeche_Blockrand[0][1][2] = $P0B[1]-$bB;
            $Punkte_Trennflaeche_Blockrand[0][1][3] = 0;

            $Punkte_Trennflaeche_Blockrand[3][1][0] = "Trennflaeche_Blockrand-E4-P2";
            $Punkte_Trennflaeche_Blockrand[3][1][1] = $P0B[0];
            $Punkte_Trennflaeche_Blockrand[3][1][2] = $P0B[1]+$bB-$PB[1];
            $Punkte_Trennflaeche_Blockrand[3][1][3] = 0;

            $Punkte_Trennflaeche_Blockrand[3][0][0] = "Trennflaeche_Blockrand-E4-P1";
            $Punkte_Trennflaeche_Blockrand[3][0][1] = $P0B[0];
            $Punkte_Trennflaeche_Blockrand[3][0][2] = $P0B[1]-$PB[1];
            $Punkte_Trennflaeche_Blockrand[3][0][3] = 0;


            $Punkte_Trennflaeche_Blockrand[1][0] = $Punkte_Trennflaeche_Blockrand[0][0];
            $Punkte_Trennflaeche_Blockrand[1][0][1] = $Punkte_Trennflaeche_Blockrand[0][0][1]*1-$PB[0];
            $Punkte_Trennflaeche_Blockrand[2][0][0] = "Trennflaeche_Blockrand-E2-P1";


            $Punkte_Trennflaeche_Blockrand[1][1] = $Punkte_Trennflaeche_Blockrand[0][1];
            $Punkte_Trennflaeche_Blockrand[1][1][1] = $Punkte_Trennflaeche_Blockrand[0][0][1]-$PB[0]+$bB;
            $Punkte_Trennflaeche_Blockrand[1][1][0] = "Trennflaeche_Blockrand-E2-P2";


            $Punkte_Trennflaeche_Blockrand[2][1] = $Punkte_Trennflaeche_Blockrand[3][1];
            $Punkte_Trennflaeche_Blockrand[2][1][1] = $Punkte_Trennflaeche_Blockrand[3][1][1]-$PB[0]+$bB;
            $Punkte_Trennflaeche_Blockrand[2][1][0] = "Trennflaeche_Blockrand-E3-P2";


            $Punkte_Trennflaeche_Blockrand[2][0] = $Punkte_Trennflaeche_Blockrand[3][0];
            $Punkte_Trennflaeche_Blockrand[2][0][1] = $Punkte_Trennflaeche_Blockrand[3][0][1]-$PB[0];
            $Punkte_Trennflaeche_Blockrand[2][0][0] = "Trennflaeche_Blockrand-E3-P1";
        //............................Blockrand_aussen.....................................
                                                                                            
            for ($i = 0; $i < 4; $i++){
                $a = $i+1;
                $Punkte_Trennflaeche_Blockrand_aussen[$i][0] = $Punkte_Trennflaeche_Blockrand[$i][0]; //übernehmen von Trennfläche_Blockrand 
                $Punkte_Trennflaeche_Blockrand_aussen[$i][0][0] = "Trennflaeche_Blockrand_außen-E$a-P1";
                if ($i == 0){
                    $b = 0;
                    $c = 10;
                } elseif ($i == 1){
                    $b = -10;
                    $c = 10;
                } elseif ($i == 2){
                    $b = -10;
                    $c = -10;
                }  elseif ($i == 3){
                    $b = 0;
                    $c = -10;            
                }
                $Punkte_Trennflaeche_Blockrand_aussen[$i][1] = $Punkte_Trennflaeche_Blockrand[$i][0];
                $Punkte_Trennflaeche_Blockrand_aussen[$i][1][1] = $Punkte_Trennflaeche_Blockrand[$i][0][1] + $b;
                $Punkte_Trennflaeche_Blockrand_aussen[$i][1][2] = $Punkte_Trennflaeche_Blockrand[$i][0][2] + $c;
                $Punkte_Trennflaeche_Blockrand_aussen[$i][1][0] = "Trennflaeche_Blockrand_außen-E$a-P2";               
            }


        //............................Distanzflächen................................
            
            
            $mplus1 = count($Punkte_Trennflaeche_Tangentenrand_vorne); 
                
                for ($i=0; $i < $mplus1; $i++){                                                     //Schleife zum Durchlaufen der Ebenen, übernommen von Blattflaeche_Hauptflaeche
                    $b = $i +1;
                
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P6";                 //P6 mit x-Werten der Ebenen von Tangentenrand vorne ind y,z von Blockrand
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5][1] = $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1][1];       
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5][2]= $Punkte_Trennflaeche_Blockrand[3][1][2];
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5][3]= $Punkte_Trennflaeche_Blockrand[3][1][3];
                    
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][5]; //P5  mit versetzter y-Koordinate
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P5";
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4][2] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4][2]+ $Distanzflaechen_yOffset;
                        
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][3] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][4]; //P4  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][3][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P4";
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][3][3] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][3][3] + $Distanzflaechen_zOffset;
            
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][0] = $Punkte_Trennflaeche_Tangentenrand_vorne[$i][1];
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][0][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P1"; //P1 aufBlockrand
            
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][1] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][0]; //P2  mit versetzter y-Koordinate
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][1][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P2";
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][1][2] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][0][2]- $Distanzflaechen_yOffset;
            
            
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][2] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][1]; //P3  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][2][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P3";
                    $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][2][3] = $Punkte_Distanzflaeche_Hauptflaeche_vorne[$i][1][3] + $Distanzflaechen_zOffset;
                }





                $mplus1 = count($Punkte_Tangentenrand_Flansch_vorne); 
                
                for ($i=0; $i < $mplus1; $i++){                                                     //Schleife zum Durchlaufen der Ebenen, übernommen von Blattflaeche_Hauptflaeche
                    $b = $i +1;
                
                    $Punkte_Distanzflaeche_Flansch_vorne[$i][5][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P6";                 //P6 mit x-Werten der Ebenen von Tangentenrand vorne ind y,z von Blockrand
                    $Punkte_Distanzflaeche_Flansch_vorne[$i][5][1] = $Punkte_Tangentenrand_Flansch_vorne[$i][1][1];       
                    $Punkte_Distanzflaeche_Flansch_vorne[$i][5][2]= $Punkte_Trennflaeche_Blockrand[3][1][2];
                    $Punkte_Distanzflaeche_Flansch_vorne[$i][5][3]= $Punkte_Trennflaeche_Blockrand[3][1][3];
                    
                    $Punkte_Distanzflaeche_Flansch_vorne[$i][4] = $Punkte_Distanzflaeche_Flansch_vorne[$i][5]; //P5  mit versetzter y-Koordinate
                    $Punkte_Distanzflaeche_Flansch_vorne[$i][4][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P5";
                    $Punkte_Distanzflaeche_Flansch_vorne[$i][4][2] = $Punkte_Distanzflaeche_Flansch_vorne[$i][4][2]+ $Distanzflaechen_yOffset;
                        
                    $Punkte_Distanzflaeche_Flansch_vorne[$i][3] = $Punkte_Distanzflaeche_Flansch_vorne[$i][4]; //P4  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Flansch_vorne[$i][3][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P4";
                    $Punkte_Distanzflaeche_Flansch_vorne[$i][3][3] = $Punkte_Distanzflaeche_Flansch_vorne[$i][3][3] + $Distanzflaechen_zOffset;
            
                    $Punkte_Distanzflaeche_Flansch_vorne[$i][0] = $Punkte_Tangentenrand_Flansch_vorne[$i][1];
                    $Punkte_Distanzflaeche_Flansch_vorne[$i][0][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P1"; //P1 aufBlockrand
            
                    $Punkte_Distanzflaeche_Flansch_vorne[$i][1] = $Punkte_Distanzflaeche_Flansch_vorne[$i][0]; //P2  mit versetzter y-Koordinate
                    $Punkte_Distanzflaeche_Flansch_vorne[$i][1][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P2";
                    $Punkte_Distanzflaeche_Flansch_vorne[$i][1][2] = $Punkte_Distanzflaeche_Flansch_vorne[$i][0][2]- $Distanzflaechen_yOffset;
            
            
                    $Punkte_Distanzflaeche_Flansch_vorne[$i][2] = $Punkte_Distanzflaeche_Flansch_vorne[$i][1]; //P3  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Flansch_vorne[$i][2][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P3";
                    $Punkte_Distanzflaeche_Flansch_vorne[$i][2][3] = $Punkte_Distanzflaeche_Flansch_vorne[$i][1][3] + $Distanzflaechen_zOffset;
                }



                $mplus1 = count($Punkte_Tangentenrand_Flansch_vorne); 
                
                for ($i=0; $i < $mplus1; $i++){                                                     //Schleife zum Durchlaufen der Ebenen, übernommen von Blattflaeche_Hauptflaeche
                    $b = $i +1;
                
                    $Punkte_Distanzflaeche_Flansch_hinten[$i][5][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P6";                 //P6 mit x-Werten der Ebenen von Tangentenrand hinten ind y,z von Blockrand
                    $Punkte_Distanzflaeche_Flansch_hinten[$i][5][1] = $Punkte_Tangentenrand_Flansch_hinten[$i][1][1];       
                    $Punkte_Distanzflaeche_Flansch_hinten[$i][5][2]= $Punkte_Trennflaeche_Blockrand[1][1][2];
                    $Punkte_Distanzflaeche_Flansch_hinten[$i][5][3]= $Punkte_Trennflaeche_Blockrand[1][1][3];
                    
                    $Punkte_Distanzflaeche_Flansch_hinten[$i][4] = $Punkte_Distanzflaeche_Flansch_hinten[$i][5]; //P5  mit versetzter y-Koordinate
                    $Punkte_Distanzflaeche_Flansch_hinten[$i][4][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P5";
                    $Punkte_Distanzflaeche_Flansch_hinten[$i][4][2] = $Punkte_Distanzflaeche_Flansch_hinten[$i][4][2]- $Distanzflaechen_yOffset;
                        
                    $Punkte_Distanzflaeche_Flansch_hinten[$i][3] = $Punkte_Distanzflaeche_Flansch_hinten[$i][4]; //P4  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Flansch_hinten[$i][3][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P4";
                    $Punkte_Distanzflaeche_Flansch_hinten[$i][3][3] = $Punkte_Distanzflaeche_Flansch_hinten[$i][3][3] + $Distanzflaechen_zOffset;
            
                    $Punkte_Distanzflaeche_Flansch_hinten[$i][0] = $Punkte_Tangentenrand_Flansch_hinten[$i][1];
                    $Punkte_Distanzflaeche_Flansch_hinten[$i][0][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P1"; //P1 aufBlockrand
            
                    $Punkte_Distanzflaeche_Flansch_hinten[$i][1] = $Punkte_Distanzflaeche_Flansch_hinten[$i][0]; //P2  mit versetzter y-Koordinate
                    $Punkte_Distanzflaeche_Flansch_hinten[$i][1][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P2";
                    $Punkte_Distanzflaeche_Flansch_hinten[$i][1][2] = $Punkte_Distanzflaeche_Flansch_hinten[$i][0][2]+ $Distanzflaechen_yOffset;
            
            
                    $Punkte_Distanzflaeche_Flansch_hinten[$i][2] = $Punkte_Distanzflaeche_Flansch_hinten[$i][1]; //P3  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Flansch_hinten[$i][2][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P3";
                    $Punkte_Distanzflaeche_Flansch_hinten[$i][2][3] = $Punkte_Distanzflaeche_Flansch_hinten[$i][1][3] + $Distanzflaechen_zOffset;
                }



                $mplus1 = count($Punkte_Tangentenrand_Rundung_hinten[0]); 
                
                for ($i=0; $i < $mplus1; $i++){                                                     //Schleife zum Durchlaufen der Ebenen, übernommen von Blattflaeche_Hauptflaeche
                    $b = $i +1;
                
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][5][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P6";                 //P6 mit x-Werten der Ebenen von Tangentenrand hinten ind y,z von Blockrand
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][5][1] = $Punkte_Tangentenrand_Rundung_hinten[1][$i][1];       
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][5][2]= $Punkte_Trennflaeche_Blockrand[3][1][2];
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][5][3]= $Punkte_Trennflaeche_Blockrand[3][1][3];
                    
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][4] = $Punkte_Distanzflaeche_Rundung_hinten[$i][5]; //P5  mit versetzter y-Koordinate
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][4][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P5";
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][4][2] = $Punkte_Distanzflaeche_Rundung_hinten[$i][4][2] + $Distanzflaechen_yOffset;
                        
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][3] = $Punkte_Distanzflaeche_Rundung_hinten[$i][4]; //P4  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][3][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P4";
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][3][3] = $Punkte_Distanzflaeche_Rundung_hinten[$i][3][3] + $Distanzflaechen_zOffset;
            
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][0] = $Punkte_Tangentenrand_Rundung_hinten[1][$i];
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][0][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P1"; //P1 aufBlockrand
            
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][1] = $Punkte_Distanzflaeche_Rundung_hinten[$i][0]; //P2  mit versetzter y-Koordinate
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][1][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P2";
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][1][2] = $Punkte_Distanzflaeche_Rundung_hinten[$i][0][2] - $Distanzflaechen_yOffset;
            
            
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][2] = $Punkte_Distanzflaeche_Rundung_hinten[$i][1]; //P3  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][2][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P3";
                    $Punkte_Distanzflaeche_Rundung_hinten[$i][2][3] = $Punkte_Distanzflaeche_Rundung_hinten[$i][1][3] + $Distanzflaechen_zOffset;
                }

                $mplus1 = count($Punkte_Tangentenrand_Rundung_vorne[0]); 
                
                for ($i=0; $i < $mplus1; $i++){                                                     //Schleife zum Durchlaufen der Ebenen, übernommen von Blattflaeche_Hauptflaeche
                    $b = $i +1;
                
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][5][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P6";                 //P6 mit x-Werten der Ebenen von Tangentenrand vorne ind y,z von Blockrand
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][5][1] = $Punkte_Tangentenrand_Rundung_vorne[1][$i][1];       
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][5][2]= $Punkte_Trennflaeche_Blockrand[1][1][2];
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][5][3]= $Punkte_Trennflaeche_Blockrand[1][1][3];
                    
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][4] = $Punkte_Distanzflaeche_Rundung_vorne[$i][5]; //P5  mit versetzter y-Koordinate
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][4][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P5";
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][4][2] = $Punkte_Distanzflaeche_Rundung_vorne[$i][4][2] - $Distanzflaechen_yOffset;
                        
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][3] = $Punkte_Distanzflaeche_Rundung_vorne[$i][4]; //P4  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][3][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P4";
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][3][3] = $Punkte_Distanzflaeche_Rundung_vorne[$i][3][3] + $Distanzflaechen_zOffset;
            
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][0] = $Punkte_Tangentenrand_Rundung_vorne[1][$i];
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][0][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P1"; //P1 aufBlockrand
            
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][1] = $Punkte_Distanzflaeche_Rundung_vorne[$i][0]; //P2  mit versetzter y-Koordinate
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][1][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P2";
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][1][2] = $Punkte_Distanzflaeche_Rundung_vorne[$i][0][2] + $Distanzflaechen_yOffset;
            
            
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][2] = $Punkte_Distanzflaeche_Rundung_vorne[$i][1]; //P3  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][2][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P3";
                    $Punkte_Distanzflaeche_Rundung_vorne[$i][2][3] = $Punkte_Distanzflaeche_Rundung_vorne[$i][1][3] + $Distanzflaechen_zOffset;
                }

                $mplus1 = count($Punkte_Tangentenrand_Rundung_vorne); 
                
                for ($i=0; $i < $mplus1; $i++){                                                     //Schleife zum Durchlaufen der Ebenen, übernommen von Blattflaeche_Hauptflaeche
                    $b = $i +1;
                
                    $Punkte_Distanzflaeche_Rundung_Spitze_vorne[$i][5][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P6";                 //P6 mit x-Werten der Ebenen von Tangentenrand vorne ind y,z von Blockrand
                    $Punkte_Distanzflaeche_Rundung_Spitze_vorne[$i][5][1] = $Punkte_Tangentenrand_Rundung[0][$i][1];       
                    $Punkte_Distanzflaeche_Rundung_Spitze_vorne[$i][5][2]= $Punkte_Trennflaeche_Blockrand[3][1][2];
                    $Punkte_Distanzflaeche_Rundung_Spitze_vorne[$i][5][3]= $Punkte_Trennflaeche_Blockrand[3][1][3];
                    
                    $Punkte_Distanzflaeche_Rundung_Spitze_vorne[$i][4] = $Punkte_Distanzflaeche_Rundung_Spitze_vorne[$i][5]; //P5  mit versetzter y-Koordinate
                    $Punkte_Distanzflaeche_Rundung_Spitze_vorne[$i][4][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P5";
                    $Punkte_Distanzflaeche_Rundung_Spitze_vorne[$i][4][2] = $Punkte_Distanzflaeche_Rundung_Spitze_vorne[$i][4][2] + $Distanzflaechen_yOffset;
                        
                    $Punkte_Distanzflaeche_Rundung_Spitze_vorne[$i][3] = $Punkte_Distanzflaeche_Rundung_Spitze_vorne[$i][4]; //P4  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Rundung_Spitze_vorne[$i][3][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P4";
                    $Punkte_Distanzflaeche_Rundung_Spitze_vorne[$i][3][3] = $Punkte_Distanzflaeche_Rundung_Spitze_vorne[$i][3][3] + $Distanzflaechen_zOffset;
            
                    $Punkte_Distanzflaeche_Rundung_Spitze_vorne[$i][0] = $Punkte_Tangentenrand_Rundung[0][$i];
                    $Punkte_Distanzflaeche_Rundung_Spitze_vorne[$i][0][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P1"; //P1 aufBlockrand
            
                    $Punkte_Distanzflaeche_Rundung_Spitze_vorne[$i][1] = $Punkte_Distanzflaeche_Rundung_Spitze_vorne[$i][0]; //P2  mit versetzter y-Koordinate
                    $Punkte_Distanzflaeche_Rundung_Spitze_vorne[$i][1][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P2";
                    $Punkte_Distanzflaeche_Rundung_Spitze_vorne[$i][1][2] = $Punkte_Distanzflaeche_Rundung_Spitze_vorne[$i][0][2] - $Distanzflaechen_yOffset;
            
            
                    $Punkte_Distanzflaeche_Rundung_Spitze_vorne[$i][2] = $Punkte_Distanzflaeche_Rundung_Spitze_vorne[$i][1]; //P3  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Rundung_Spitze_vorne[$i][2][0] = "Distanzflaeche_Hauptflaeche_vorne-E$b-P3";
                    $Punkte_Distanzflaeche_Rundung_Spitze_vorne[$i][2][3] = $Punkte_Distanzflaeche_Rundung_Spitze_vorne[$i][1][3] + $Distanzflaechen_zOffset;
                }

                $mplus1 = count($Punkte_Tangentenrand_Rundung_hinten); 
                
                for ($i=0; $i < $mplus1; $i++){                                                     //Schleife zum Durchlaufen der Ebenen, übernommen von Blattflaeche_Hauptflaeche
                    $b = $i +1;
                
                    $Punkte_Distanzflaeche_Rundung_Spitze_hinten[$i][5][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P6";                 //P6 mit x-Werten der Ebenen von Tangentenrand hinten ind y,z von Blockrand
                    $Punkte_Distanzflaeche_Rundung_Spitze_hinten[$i][5][1] = $Punkte_Tangentenrand_Rundung[3][$i][1];       
                    $Punkte_Distanzflaeche_Rundung_Spitze_hinten[$i][5][2]= $Punkte_Trennflaeche_Blockrand[1][1][2];
                    $Punkte_Distanzflaeche_Rundung_Spitze_hinten[$i][5][3]= $Punkte_Trennflaeche_Blockrand[1][1][3];
                    
                    $Punkte_Distanzflaeche_Rundung_Spitze_hinten[$i][4] = $Punkte_Distanzflaeche_Rundung_Spitze_hinten[$i][5]; //P5  mit versetzter y-Koordinate
                    $Punkte_Distanzflaeche_Rundung_Spitze_hinten[$i][4][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P5";
                    $Punkte_Distanzflaeche_Rundung_Spitze_hinten[$i][4][2] = $Punkte_Distanzflaeche_Rundung_Spitze_hinten[$i][4][2] - $Distanzflaechen_yOffset;
                        
                    $Punkte_Distanzflaeche_Rundung_Spitze_hinten[$i][3] = $Punkte_Distanzflaeche_Rundung_Spitze_hinten[$i][4]; //P4  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Rundung_Spitze_hinten[$i][3][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P4";
                    $Punkte_Distanzflaeche_Rundung_Spitze_hinten[$i][3][3] = $Punkte_Distanzflaeche_Rundung_Spitze_hinten[$i][3][3] + $Distanzflaechen_zOffset;
            
                    $Punkte_Distanzflaeche_Rundung_Spitze_hinten[$i][0] = $Punkte_Tangentenrand_Rundung[3][$i];
                    $Punkte_Distanzflaeche_Rundung_Spitze_hinten[$i][0][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P1"; //P1 aufBlockrand
            
                    $Punkte_Distanzflaeche_Rundung_Spitze_hinten[$i][1] = $Punkte_Distanzflaeche_Rundung_Spitze_hinten[$i][0]; //P2  mit versetzter y-Koordinate
                    $Punkte_Distanzflaeche_Rundung_Spitze_hinten[$i][1][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P2";
                    $Punkte_Distanzflaeche_Rundung_Spitze_hinten[$i][1][2] = $Punkte_Distanzflaeche_Rundung_Spitze_hinten[$i][0][2] + $Distanzflaechen_yOffset;
            
            
                    $Punkte_Distanzflaeche_Rundung_Spitze_hinten[$i][2] = $Punkte_Distanzflaeche_Rundung_Spitze_hinten[$i][1]; //P3  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Rundung_Spitze_hinten[$i][2][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P3";
                    $Punkte_Distanzflaeche_Rundung_Spitze_hinten[$i][2][3] = $Punkte_Distanzflaeche_Rundung_Spitze_hinten[$i][1][3] + $Distanzflaechen_zOffset;
                }

                $mplus1 = count($Punkte_Tangentenrand_Rundung); 
                
                for ($i=0; $i < $mplus1; $i++){                                                     //Schleife zum Durchlaufen der Ebenen, übernommen von Blattflaeche_Hauptflaeche
                    $b = $i +1;
                
                $Punkte_Distanzflaeche_Spitze[$i][5][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P6";                 //P6 mit x-Werten der Ebenen von Tangentenrand hinten ind y,z von Blockrand
                $Punkte_Distanzflaeche_Spitze[$i][5][2] = $Punkte_Tangentenrand_Rundung[$i][1][2];       
                $Punkte_Distanzflaeche_Spitze[$i][5][1]= $Punkte_Trennflaeche_Blockrand[1][1][1];
                $Punkte_Distanzflaeche_Spitze[$i][5][3]= $Punkte_Trennflaeche_Blockrand[1][1][3];
                    
                $Punkte_Distanzflaeche_Spitze[$i][4] =$Punkte_Distanzflaeche_Spitze[$i][5]; //P5  mit versetzter y-Koordinate
                $Punkte_Distanzflaeche_Spitze[$i][4][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P5";
                $Punkte_Distanzflaeche_Spitze[$i][4][1] =$Punkte_Distanzflaeche_Spitze[$i][4][1] + $Distanzflaechen_xOffset;
                        
                $Punkte_Distanzflaeche_Spitze[$i][3] =$Punkte_Distanzflaeche_Spitze[$i][4]; //P4  mit versetzter z-Koordinate
                $Punkte_Distanzflaeche_Spitze[$i][3][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P4";
                $Punkte_Distanzflaeche_Spitze[$i][3][3] =$Punkte_Distanzflaeche_Spitze[$i][3][3] + $Distanzflaechen_zOffset;
            
                $Punkte_Distanzflaeche_Spitze[$i][0] = $Punkte_Tangentenrand_Rundung[$i][1];
                $Punkte_Distanzflaeche_Spitze[$i][0][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P1"; //P1 aufBlockrand
            
                $Punkte_Distanzflaeche_Spitze[$i][1] =$Punkte_Distanzflaeche_Spitze[$i][0]; //P2  mit versetzter y-Koordinate
                $Punkte_Distanzflaeche_Spitze[$i][1][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P2";
                $Punkte_Distanzflaeche_Spitze[$i][1][1] =$Punkte_Distanzflaeche_Spitze[$i][0][1] - $Distanzflaechen_xOffset;
            
            
                $Punkte_Distanzflaeche_Spitze[$i][2] =$Punkte_Distanzflaeche_Spitze[$i][1]; //P3  mit versetzter z-Koordinate
                $Punkte_Distanzflaeche_Spitze[$i][2][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P3";
                $Punkte_Distanzflaeche_Spitze[$i][2][3] =$Punkte_Distanzflaeche_Spitze[$i][1][3] + $Distanzflaechen_zOffset;
                }




                $Punkte_Distanzflaeche_Spitze_vorne[0] = $Punkte_Distanzflaeche_Rundung_Spitze_vorne[1];// übernehmen der letzten Ebene von Distanzflaeche_Zapfen_vorne
                for ($i=0; $i < 6; $i++){
                    $Punkte_Distanzflaeche_Spitze_vorne[2][$i]  =  $Punkte_Distanzflaeche_Spitze[0][$i];
                }
                for ($i = 1; $i <2; $i++){        
                    $Punkte_Distanzflaeche_Spitze_vorne[$i][0][0] = "Distanzflaeche_Hauptflaeche_vorne-E2-P6";                 //P6 mit x-Werten der Ebenen von Tangentenrand vorne ind y,z von Blockrand
                    $Punkte_Distanzflaeche_Spitze_vorne[$i][0] = $Punkte_Distanzflaeche_Rundung_Spitze_vorne[1][0];       
                    
                    
                    $Punkte_Distanzflaeche_Spitze_vorne[$i][1] = $Punkte_Distanzflaeche_Spitze_vorne[$i][0]; //P5  mit versetzter y-Koordinate
                    $Punkte_Distanzflaeche_Spitze_vorne[$i][1][0] = "Distanzflaeche_Hauptflaeche_vorne-E2-P5";
                    $Punkte_Distanzflaeche_Spitze_vorne[$i][1][1] = $Punkte_Distanzflaeche_Spitze_vorne[$i][1][1]- $Distanzflaechen_xOffset;
                    $Punkte_Distanzflaeche_Spitze_vorne[$i][1][2] = $Punkte_Distanzflaeche_Spitze_vorne[$i][1][2]- $Distanzflaechen_yOffset;
                        
                    $Punkte_Distanzflaeche_Spitze_vorne[$i][2] = $Punkte_Distanzflaeche_Spitze_vorne[$i][1]; //P4  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Spitze_vorne[$i][2][0] = "Distanzflaeche_Hauptflaeche_vorne-E2-P4";
                    $Punkte_Distanzflaeche_Spitze_vorne[$i][2][3] = $Punkte_Distanzflaeche_Spitze_vorne[$i][1][3] + $Distanzflaechen_zOffset;
            
                    $Punkte_Distanzflaeche_Spitze_vorne[$i][5] = $Punkte_Trennflaeche_Blockrand[2][1];
                    $Punkte_Distanzflaeche_Spitze_vorne[$i][5][0] = "Distanzflaeche_Hauptflaeche_vorne-E2-P1"; //P1 aufBlockrand
            
                    $Punkte_Distanzflaeche_Spitze_vorne[$i][4] = $Punkte_Distanzflaeche_Spitze_vorne[$i][5]; //P2  mit versetzter y-Koordinate
                    $Punkte_Distanzflaeche_Spitze_vorne[$i][4][0] = "Distanzflaeche_Hauptflaeche_vorne-E2-P2";
                    $Punkte_Distanzflaeche_Spitze_vorne[$i][4][1] = $Punkte_Distanzflaeche_Spitze_vorne[$i][5][1]+ $Distanzflaechen_xOffset;
                    $Punkte_Distanzflaeche_Spitze_vorne[$i][4][2] = $Punkte_Distanzflaeche_Spitze_vorne[$i][5][2]+ $Distanzflaechen_yOffset;
            
            
                    $Punkte_Distanzflaeche_Spitze_vorne[$i][3] = $Punkte_Distanzflaeche_Spitze_vorne[$i][4]; //P3  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Spitze_vorne[$i][3][0] = "Distanzflaeche_Hauptflaeche_vorne-E2-P3";
                    $Punkte_Distanzflaeche_Spitze_vorne[$i][3][3] = $Punkte_Distanzflaeche_Spitze_vorne[$i][4][3] + $Distanzflaechen_zOffset;
                } 



                $Punkte_Distanzflaeche_Spitze_hinten[0] = $Punkte_Distanzflaeche_Rundung_Spitze_hinten[1];// übernehmen der letzten Ebene von Distanzflaeche_Zapfen_hinten
                for ($i=0; $i < 6; $i++){
                    $Punkte_Distanzflaeche_Spitze_hinten[2][$i]  =  $Punkte_Distanzflaeche_Spitze[3][$i];
                }
                for ($i = 1; $i <2; $i++){        
                    $Punkte_Distanzflaeche_Spitze_hinten[$i][0][0] = "Distanzflaeche_Hauptflaeche_hinten-E2-P6";                 //P6 mit x-Werten der Ebenen von Tangentenrand hinten ind y,z von Blockrand
                    $Punkte_Distanzflaeche_Spitze_hinten[$i][0] = $Punkte_Distanzflaeche_Rundung_Spitze_hinten[1][0];       
                    
                    
                    $Punkte_Distanzflaeche_Spitze_hinten[$i][1] = $Punkte_Distanzflaeche_Spitze_hinten[$i][0]; //P5  mit versetzter y-Koordinate
                    $Punkte_Distanzflaeche_Spitze_hinten[$i][1][0] = "Distanzflaeche_Hauptflaeche_hinten-E2-P5";
                    $Punkte_Distanzflaeche_Spitze_hinten[$i][1][1] = $Punkte_Distanzflaeche_Spitze_hinten[$i][1][1]- $Distanzflaechen_xOffset;
                    $Punkte_Distanzflaeche_Spitze_hinten[$i][1][2] = $Punkte_Distanzflaeche_Spitze_hinten[$i][1][2]+ $Distanzflaechen_yOffset;
                        
                    $Punkte_Distanzflaeche_Spitze_hinten[$i][2] = $Punkte_Distanzflaeche_Spitze_hinten[$i][1]; //P4  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Spitze_hinten[$i][2][0] = "Distanzflaeche_Hauptflaeche_hinten-E2-P4";
                    $Punkte_Distanzflaeche_Spitze_hinten[$i][2][3] = $Punkte_Distanzflaeche_Spitze_hinten[$i][1][3] + $Distanzflaechen_zOffset;
            
                    $Punkte_Distanzflaeche_Spitze_hinten[$i][5] = $Punkte_Trennflaeche_Blockrand[1][1];
                    $Punkte_Distanzflaeche_Spitze_hinten[$i][5][0] = "Distanzflaeche_Hauptflaeche_hinten-E2-P1"; //P1 aufBlockrand
            
                    $Punkte_Distanzflaeche_Spitze_hinten[$i][4] = $Punkte_Distanzflaeche_Spitze_hinten[$i][5]; //P2  mit versetzter y-Koordinate
                    $Punkte_Distanzflaeche_Spitze_hinten[$i][4][0] = "Distanzflaeche_Hauptflaeche_hinten-E2-P2";
                    $Punkte_Distanzflaeche_Spitze_hinten[$i][4][1] = $Punkte_Distanzflaeche_Spitze_hinten[$i][5][1]+ $Distanzflaechen_xOffset;
                    $Punkte_Distanzflaeche_Spitze_hinten[$i][4][2] = $Punkte_Distanzflaeche_Spitze_hinten[$i][5][2]- $Distanzflaechen_yOffset;
            
            
                    $Punkte_Distanzflaeche_Spitze_hinten[$i][3] = $Punkte_Distanzflaeche_Spitze_hinten[$i][4]; //P3  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Spitze_hinten[$i][3][0] = "Distanzflaeche_Hauptflaeche_hinten-E2-P3";
                    $Punkte_Distanzflaeche_Spitze_hinten[$i][3][3] = $Punkte_Distanzflaeche_Spitze_hinten[$i][4][3] + $Distanzflaechen_zOffset;
                } 
            





























            
            
            
                $mplus1 = count($Punkte_Trennflaeche_Tangentenrand_hinten);                          //Trennflaeche_Tangentenrand_vorne
                for ($i=0; $i < $mplus1; $i++){                                                     //Schleife zum Durchlaufen der Ebenen, übernommen von Blattflaeche_Hauptflaeche
                    $b = $i +1;
                
                    $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][5][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P6";                 //P6 mit x-Werten der Ebenen von Tangentenrand vorne ind y,z von Blockrand
                    $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][5][1] = $Punkte_Trennflaeche_Tangentenrand_hinten[$i][1][1];       
                    $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][5][2]= $Punkte_Trennflaeche_Blockrand[1][1][2];
                    $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][5][3]= $Punkte_Trennflaeche_Blockrand[1][1][3];
                    
                    $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][5]; //P5  mit versetzter y-Koordinate
                    $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P5";
                    $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4][2] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4][2]- $Distanzflaechen_yOffset;
                        
                    $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][3] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][4]; //P4  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][3][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P4";
                    $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][3][3] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][3][3] + $Distanzflaechen_zOffset;
            
                    $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0] = $Punkte_Trennflaeche_Tangentenrand_hinten[$i][1];
                    $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P1"; //P1 aufBlockrand
            
                    $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0]; //P2  mit versetzter y-Koordinate
                    $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P2";
                    $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1][2] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][0][2]+ $Distanzflaechen_yOffset;
            
            
                    $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][2] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1]; //P3  mit versetzter z-Koordinate
                    $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][2][0] = "Distanzflaeche_Hauptflaeche_hinten-E$b-P3";
                    $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][2][3] = $Punkte_Distanzflaeche_Hauptflaeche_hinten[$i][1][3] + $Distanzflaechen_zOffset;
                }




            
            
                    
                    
            
                
            
        //............................Zentrierung_Konus.............................
            //if ($Side == "oben"){
            $Punkte_Zentrierung_Konus[0][0][0] = "Zentrierung_Konus E1-P1";                               //Mittelpunkte Kreis 1, kleiner Kreis
            $Punkte_Zentrierung_Konus[0][0][1] = $Punkte_Trennflaeche_Blockrand[1][1][1]+$PZK[0];  
            $Punkte_Zentrierung_Konus[0][0][2] = $Punkte_Trennflaeche_Blockrand[1][1][2]-$PZK[1];
            $Punkte_Zentrierung_Konus[0][0][3] = $PZK[2];
                                
            $Punkte_Zentrierung_Konus[0][1] =   $Punkte_Zentrierung_Konus[0][0];         //E1P2 Punkt auf Kreis 1 
            $Punkte_Zentrierung_Konus[0][1][0] = "Zentrierung_Konus E1-P2"; 
            $Punkte_Zentrierung_Konus[0][1][1] = $Punkte_Zentrierung_Konus[0][0][1]+10;     

            $Punkte_Zentrierung_Konus[1][0] =   $Punkte_Zentrierung_Konus[0][0];         //E2P1 Mittelpunkt Kreis 2 
            $Punkte_Zentrierung_Konus[1][0][0] = "Zentrierung_Konus E2-P1"; 
            $Punkte_Zentrierung_Konus[1][0][3] = $Punkte_Zentrierung_Konus[1][0][3]-30;

            $Punkte_Zentrierung_Konus[1][1] =   $Punkte_Zentrierung_Konus[1][0];         //E2P2 Punkt auf Kreis 2
            $Punkte_Zentrierung_Konus[1][1][0] = "Zentrierung_Konus E2-P2"; 
            $Punkte_Zentrierung_Konus[1][1][1] = $Punkte_Zentrierung_Konus[1][0][1]+10;


            } //Ende includeBlock  if Abfrage
            


            


                
            

        //............................Output........................................
            $Points[0][0] = $Punkte_Flanschflaeche[0];
            $Points[1][0] = $Punkte_Flanschflaeche[1];
            $Points[2][0] = $Punkte_Flanschflaeche[2];
            $Points[3][0] = $Punkte_Flanschflaeche[3];
            $Points[4][0] = $Punkte_Verbindungsflaeche_1_2_aussen;
            $Points[5][0] = $Punkte_Verbindungsflaeche_1_2_stufe;
            $Points[6][0] = $Punkte_Verbindungsflaeche_2_3_aussen;
            $Points[7][0] = $Punkte_Verbindungsflaeche_2_3_stufe;

            $Points[8][0] = $Punkte_Blattflaeche[0];
            $Points[9][0] = $Punkte_Blattflaeche[1];
            $Points[10][0] = $Punkte_Blattflaeche[2];
            $Points[11][0] = $Punkte_Blattflaeche[3];

            $Points[12][0] = $Punkte_Schnittflaeche;
            $Points[13][0] = $Punkte_Kantenflaeche_HK;
            $Points[14][0] = $Punkte_Kantenflaeche_VK;
            $Points[15][0] = $Punkte_Flanschflaeche_Rundung;
            if ($includeblock == "ja"){
            $Points[16][0] = $Punkte_Trennflaeche_Tangentenrand_vorne;
            $Points[17][0] = $Punkte_Trennflaeche_Tangentenrand_hinten;
            $Points[18][0] =  $Punkte_Tangentenrand_Flansch_hinten;
            $Points[19][0] =  $Punkte_Tangentenrand_Flansch_vorne;
            
            $Points[20][0] =  $Punkte_Tangentenrand_Rundung_vorne;
            $Points[21][0] =  $Punkte_Tangentenrand_Rundung_hinten;
            $Points[22][0] =  $Punkte_Tangentenrand_Rundung;
            $Points[23][0] = $Punkte_Trennflaeche_Blockrand_aussen;
            $Points[24][0] = $Punkte_Trennflaeche_Blockrand;
            $Points[25][0] = $Punkte_Distanzflaeche_Hauptflaeche_vorne;
            $Points[26][0] = $Punkte_Distanzflaeche_Hauptflaeche_hinten;
            $Points[27][0] = $Punkte_Distanzflaeche_Flansch_vorne;
            $Points[28][0] = $Punkte_Distanzflaeche_Flansch_hinten;
            $Points[29][0] = $Punkte_Distanzflaeche_Rundung_hinten;
            $Points[30][0] = $Punkte_Distanzflaeche_Rundung_vorne;
            $Points[31][0] = $Punkte_Distanzflaeche_Rundung_Spitze_vorne;
            $Points[32][0] = $Punkte_Distanzflaeche_Rundung_Spitze_hinten;
            $Points[33][0] = $Punkte_Distanzflaeche_Spitze;
            $Points[34][0] =$Punkte_Distanzflaeche_Spitze_vorne;
            $Points[35][0] =$Punkte_Distanzflaeche_Spitze_hinten;
            $Points[36][0] =$Punkte_Zentrierung_Konus;
            }
            /*

            $Points[19][0] =  $Punkte_Trennflaeche_Tangentenrand_hinten_rund;
            $Points[20][0] =  $Punkte_Trennflaeche_Tangentenrand_Stufe;
            $Points[21][0] = $Punkte_Trennflaeche_Blockrand;
            $Points[22][0] = $Punkte_Distanzflaeche_Hauptflaeche_vorne;
            $Points[23][0] = $Punkte_Distanzflaeche_Hauptflaeche_hinten;
            $Points[24][0] = $Punkte_Distanzflaeche_Rundung_vorne;
            $Points[25][0] = $Punkte_Distanzflaeche_Rundung_hinten;
            $Points[26][0] = $Punkte_Distanzflaeche_Stufe;
            $Points[27][0] = $Punkte_Trennflaeche_Blockrand_aussen;
            $Points[28][0] = $Punkte_Zentrierung_Konus;
            */
            
            


                //Drehen der Punkte für Rechtsdreher
                if ($Turn_Direction == "rechts"){
                for ($i = 0; $i < count($Points); $i++){               //jede Fläche
                    for ($j = 0; $j < count($Points[$i][0]);$j++){             //jede Flächenebene
                        for ($k = 0; $k < count($Points[$i][0][$j]); $k++){      //jeder Punkt
                            $Points[$i][0][$j][$k][2]= - $Points[$i][0][$j][$k][2];
                        }
                    }
                }
            }
            
            for ($i = 0; $i < count($Points);$i++){
                if ($i == 0){
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="Flanschflaeche_Ebene-1";
                    $Surface_Colour[$i] = "('NONE',0.3,0.3,0.8)";
                } elseif ($i == 1){
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="Flanschflaeche_Ebene-2";
                    $Surface_Colour[$i] = "('NONE',0.1,0.6,0.8)";
                } elseif ($i == 2){
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="Flanschflaeche_Ebene-2";
                    $Surface_Colour[$i] = "('NONE',0.1,0.6,0.8)";
                } elseif ($i == 3){
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="Flanschflaeche_Ebene-3";
                    $Surface_Colour[$i] = "('NONE',0.8,0.3,0.5)";
                } elseif ($i == 4){
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="Verbindungsflaeche_1_2_Aussen";
                    $Surface_Colour[$i] = "('NONE',0.5,0.9,0.7)";
                } elseif ($i == 5){
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="Verbindungsflaeche_1_2_Stufe";
                    $Surface_Colour[$i] = "('NONE',0.1,0.7,0.3)";
                } elseif ($i == 6){
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="Verbindungsflaeche_2_3_Aussen";
                    $Surface_Colour[$i] = "('NONE',0.6,0.8,0.1)";
                } elseif ($i == 7){
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="Verbindungsflaeche_2_3_Stufe";
                    $Surface_Colour[$i] = "('NONE',0.4,0.3,0.2)";
                } elseif ($i == 8){
                    $u = 4;
                    $v = 5;
                    $Surface_Name[$i]="Blattflaeche_oben_vorne";
                    $Surface_Colour[$i] = "('NONE',0.2,0.1,0.8)";
                } elseif ($i == 9){
                    $u = 4;
                    $v = 5;
                    $Surface_Name[$i]="Blattflaeche_unten_vorne";
                    $Surface_Colour[$i] = "('NONE',0.4,0.6,0.7)";
                } elseif ($i == 10){
                    $u = 4;
                    $v = 5;
                    $Surface_Name[$i]="Blattflaeche_oben_hinten";
                    $Surface_Colour[$i] = "('NONE',0.2,0.5,0.8)";
                } elseif ($i == 11){
                    $u = 4;
                    $v = 5;
                    $Surface_Name[$i]="Blattflaeche_unten_hinten";
                    $Surface_Colour[$i] = "('NONE',0.3,0.5,0.5)";
                } elseif ($i == 12){
                    $u = 4;
                    $v = 2;
                    $Surface_Name[$i]="Schnittflaeche";
                    $Surface_Colour[$i] = "('NONE',0.3,0.5,0.5)";
                } elseif ($i == 13){
                    $u = 4;
                    $v = 2;
                    $Surface_Name[$i]="Kantenflaeche_VK";
                    $Surface_Colour[$i] = "('NONE',0.3,0.5,0.5)";
                } elseif ($i == 14){
                    $u = 4;
                    $v = 2;
                    $Surface_Name[$i]="Kantenflaeche_HK";
                    $Surface_Colour[$i] = "('NONE',0.3,0.5,0.5)";
                }  elseif ($i == 15) {
                    $u = 2;
                    $v = 5;
                    $Surface_Name[$i]="Flanschfläche_Verrundung";
                    $Surface_Colour[$i] = "('NONE',0.0,7,0.1)";            
                } elseif ($i == 16) {
                        $u = 4;
                        $v = 2;
                        $Surface_Name[$i]="Trennflaeche_Tangentenrand_vorne";
                        $Surface_Colour[$i] = "('NONE',1.0,0.,0.5)";   
                } elseif ($i == 17){
                        $u = 4;
                        $v = 2;
                        $Surface_Name[$i]="Trennflaeche_Tangentenrand_hinten";
                        $Surface_Colour[$i] = "('NONE',1.,0.,0.5)";
                } elseif ($i == 18){
                        $u = 2;
                        $v = 2;
                        $Surface_Name[$i]="Trennfläche_Tangentenrand_Flansch_vorne";
                        $Surface_Colour[$i] = "('NONE',1.,0.,0.5)";
                } elseif ($i == 19){
                        $u = 2;
                        $v = 2;
                        $Surface_Name[$i]="Trennfläche_Tangentenrand_Flansch_hinten";
                        $Surface_Colour[$i] = "('NONE',1.,0.,0.5)";
                } elseif ($i == 20){
                    $u = 2;
                    $v = 3;
                    $Surface_Name[$i]="Trennfläche_Tangentenrand_Rundung_vorne";
                    $Surface_Colour[$i] = "('NONE',1.,0.,0.5)";
                } elseif ($i == 21){
                    $u = 2;
                    $v = 3;
                    $Surface_Name[$i]="Trennfläche_Tangentenrand_Rundung_hinten";
                    $Surface_Colour[$i] = "('NONE',1.,0.,0.5)";
                } elseif ($i == 22){
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="Tangentenrand_Rundung";
                    $Surface_Colour[$i] = "('NONE',0.0,1,0.3)";
                } elseif ($i == 23){
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="Distanzflaeche_Hauptflaeche_vorne";
                    $Surface_Colour[$i] = "('NONE',0.7,0.2,0.0)";
                } elseif ($i == 24){
                    $u = 2;
                    $v = 2;
                    $Surface_Name[$i]="Distanzflaeche_Hauptflaeche_hinten";
                    $Surface_Colour[$i] = "('NONE',0.7,0.2,0.0)";
                } elseif ($i == 25){
                    $u = 4;
                    $v = 4;
                    $Surface_Name[$i]="Distanzflaeche_Rundung_vorne";
                    $Surface_Colour[$i] = "('NONE',0.7,0.2,0.0)";
                } elseif ($i == 26){
                    $u = 4;
                    $v = 4;
                    $Surface_Name[$i]="Distanzflaeche_Rundung_hinten";
                    $Surface_Colour[$i] = "('NONE',0.7,0.2,0.0)";
                } elseif ($i == 27){
                    $u = 2;
                    $v = 4;
                    $Surface_Name[$i]="Distanzflaeche_Flansch_vorne";
                    $Surface_Colour[$i] = "('NONE',0.7,0.2,0.0)";
                } elseif($i == 28) {  
                    $u = 2;
                    $v = 4;
                    $Surface_Name[$i]="Distanzflaeche_Flansch_hinten";
                    $Surface_Colour[$i] = "('NONE',0.0,1,0.1)";     
                    } elseif($i == 29) {  
                        $u = 3;
                        $v = 4;
                        $Surface_Name[$i]="Distanzflaeche_Flansch_hinten";
                        $Surface_Colour[$i] = "('NONE',0.0,1,0.1)";    
                    } elseif($i == 30) {  
                        $u = 3;
                        $v = 4;
                        $Surface_Name[$i]="Distanzflaeche_Flansch_hinten";
                        $Surface_Colour[$i] = "('NONE',0.0,1,0.1)";    
                    } elseif($i == 31) {  
                        $u = 2;
                        $v = 4;
                        $Surface_Name[$i]="Distanzflaeche_Rundung_Spitze_vorne";
                        $Surface_Colour[$i] = "('NONE',0.0,1,0.1)";    
                    } elseif($i == 32) {  
                        $u = 2;
                        $v = 4;
                        $Surface_Name[$i]="Distanzflaeche_Rundung_Spitze_hinten";
                        $Surface_Colour[$i] = "('NONE',0.0,1,0.1)";    
                    } elseif($i == 33) {  
                        $u = 2;
                        $v = 4;
                        $Surface_Name[$i]= "Distanzflaeche_Spitze";
                        $Surface_Colour[$i] = "('NONE',0.0,1,0.1)";    
                    } elseif($i == 34) {  
                        $u = 2;
                        $v = 4;
                        $Surface_Name[$i]= "Distanzflaeche_Spitze_vorne";
                        $Surface_Colour[$i] = "('NONE',0.0,1,0.1)";    
                    } elseif($i == 35) {  
                        $u = 2;
                        $v = 4;
                        $Surface_Name[$i]= "Distanzflaeche_Spitze_hinten";
                        $Surface_Colour[$i] = "('NONE',0.0,1,0.1)";    
                    } elseif($i == 36) {  
                        $u = 2;
                        $v = 4;
                        $Surface_Name[$i]= "Zentrierung_Konus";
                        $Surface_Colour[$i] = "('NONE',0.0,1,0.1)";    
                    }

            $Points[$i][1] = $u;
            $Points[$i][2] = $v;
            $Points[$i][3] = $Surface_Name[$i];
            $Points[$i][4] = $Surface_Colour[$i];   
            }
            return($Points);

            
    }
    function GeometryCalculationfreeSurface($input_free_Surface){ //Geometrieberechnung der freien Fläche
        //............................Input.........................................
                //Input Block

               
            
                $u = $input_free_Surface[0][0];             //Spline Grad 
                $v = $input_free_Surface[1][0];             //Trennfläche_Tangentenrand Breite
                $nplus1 = (count($input_free_Surface[6]))/3;  //Anzahl Stützebenen
                $mplus1 = count($input_free_Surface[6][0]);     //Anzahl Stützpunkte pro Ebene
                $x_Turn_Angle = $input_free_Surface[2][0]/180*pi();
                $y_pos = $input_free_Surface[3][0];
                $y_Turn_Angle = $input_free_Surface[4][0]/180*pi();
                $x_pos = $input_free_Surface[5][0];
                $a = 0;
                $b = 1;
                $c = 2;
                for ($i=0; $i < $nplus1; $i++){
                    for ($j = 0; $j <  $mplus1; $j++){
                        $Punkte_freie_Flaeche[$i][$j][0] = "Punkte_freie_Flaeche-E$i-P$j";
                        $Punkte_freie_Flaeche[$i][$j][1] = $input_free_Surface[6][$a][$j];
                        $Punkte_freie_Flaeche[$i][$j][2] = $input_free_Surface[6][$b][$j];
                        $Punkte_freie_Flaeche[$i][$j][3] = $input_free_Surface[6][$c][$j];
                    }
                    $a = $a + 3;
                    $b = $b + 3;
                    $c = $c + 3;
                }
               
               

        //............................Drehmatrizen für freie Fläche.................

            //for ($k = 0; $k < count($Punkte_Drehung); $k++){
            for ($i=0; $i < $nplus1; $i++){
                for ($j=0; $j < $mplus1;$j ++){ 

                    $TurnProfilpoints =$Punkte_freie_Flaeche[$i];  
                    $TurnProfilpoints[$j][2] = $Punkte_freie_Flaeche[$i][$j][2] - $y_pos;                                                   //Hilfsvariable zum drehen der Flächen
                    $Punkte_freie_Flaeche[$i][$j][2] = $TurnProfilpoints[$j][2]*cos($x_Turn_Angle) - $TurnProfilpoints[$j][3]*sin($x_Turn_Angle); //Drehamtrix um x-Achse
                    $Punkte_freie_Flaeche[$i][$j][3] = $TurnProfilpoints[$j][2]*sin($x_Turn_Angle) + $TurnProfilpoints[$j][3]*cos($x_Turn_Angle);  
                    $TurnProfilpoints[$j][2] = $Punkte_freie_Flaeche[$i][$j][2] + $y_pos; 
                    $Punkte_freie_Flaeche[$i][$j][2] = $TurnProfilpoints[$j][2];                    

                
                    
                    //Drehen der Profilpunkte um y-Achse bei x_RPS
                    
                    $TurnProfilpoints = $Punkte_freie_Flaeche[$i];                                                  //Hilfsvariable zum drehen des Profils mit aktuellen Punkten
                    $TurnProfilpoints[$j][1] = $Punkte_freie_Flaeche[$i][$j][1] - $x_pos;                           //Abziehen des x-Wertes um in der lokalen Ebene zu drehen
                    $Punkte_freie_Flaeche[$i][$j][1] =  $TurnProfilpoints[$j][1]*cos($y_Turn_Angle) - $TurnProfilpoints[$j][3]*sin($y_Turn_Angle); //Drehamtrix um y-Achse
                    $Punkte_freie_Flaeche[$i][$j][3] =   $TurnProfilpoints[$j][1]*sin($y_Turn_Angle) + $TurnProfilpoints[$j][3]*cos($y_Turn_Angle); 
                    $TurnProfilpoints[$j][1] = $Punkte_freie_Flaeche[$i][$j][1] + $x_pos; 
                    $Punkte_freie_Flaeche[$i][$j][1] = $TurnProfilpoints[$j][1]*cos($y_Turn_Angle); 
                    }
                }


                $Points[0][0] = $Punkte_freie_Flaeche;
                $Points[0][1] = $u;
                $Points[0][2] = $v;
                $Points[0][3] = "freie_Flaeche";
                $Points[0][4] = "('NONE',0.0,7,0.1)";
            

        //............................Output........................................

            return($Points);

    } 
    function GeometryCalculationfreeSpline($input_free_Spline){ //Geometrieberechnung der freien Fläche
        //............................Input.........................................
               

               
            
                $u = $input_free_Spline[0][0];             //Spline Grad 
                //$v = $input_free_Spline[1][0];             //Trennfläche_Tangentenrand Breite
                $nplus1 = (count($input_free_Spline[5]));  //Anzahl Stützebenen
                //$mplus1 = count($input_free_Spline[6][0]);     //Anzahl Stützpunkte pro Ebene
                $x_Turn_Angle = $input_free_Spline[1][0]/180*pi();
                $x_pos = $input_free_Spline[2][0];
                $y_Turn_Angle = $input_free_Spline[3][0]/180*pi();
                $y_pos = $input_free_Spline[4][0];
                $a = 0;
                $b = 1;
                $c = 2;
                
                for ($i=0; $i < $nplus1; $i++){
                    //for ($j = 0; $j <  $mplus1; $j++){
                        $Punkte_freie_Kurve[0][$i][0] = "Punkte_freie_Kurve-E$i-P1";
                        $Punkte_freie_Kurve[0][$i][1] = $input_free_Spline[5][$i][0];
                        $Punkte_freie_Kurve[0][$i][2] = $input_free_Spline[5][$i][1];
                        $Punkte_freie_Kurve[0][$i][3] = $input_free_Spline[5][$i][2];
                        $a = $a + 3;
                        $b = $b + 3;
                        $c = $c + 3;
                    
                   
                }
               
               

        //............................Drehmatrizen für freie Kurve.................

            //for ($k = 0; $k < count($Punkte_Drehung); $k++){
            for ($i=0; $i < $nplus1; $i++){
                //for ($j=0; $j < $mplus1;$j ++){ 

                    $TurnProfilpoints =$Punkte_freie_Kurve[0][$i];  
                    
                    $TurnProfilpoints[2] = $Punkte_freie_Kurve[0][$i][2] - $y_pos;                                                   //Hilfsvariable zum drehen der Flächen
                    $Punkte_freie_Kurve[0][$i][2] = $TurnProfilpoints[2]*cos($x_Turn_Angle) - $TurnProfilpoints[3]*sin($x_Turn_Angle); //Drehamtrix um x-Achse
                    $Punkte_freie_Kurve[0][$i][3] = $TurnProfilpoints[2]*sin($x_Turn_Angle) + $TurnProfilpoints[3]*cos($x_Turn_Angle);  
                    $TurnProfilpoints[2] = $Punkte_freie_Kurve[0][$i][2] + $y_pos; 
                    $Punkte_freie_Kurve[0][$i][2] = $TurnProfilpoints[2];                    

                
                    
                    //Drehen der Profilpunkte um y-Achse bei x_RPS
                    
                    $TurnProfilpoints = $Punkte_freie_Kurve[0][$i];                                                  //Hilfsvariable zum drehen des Profils mit aktuellen Punkten
                    $TurnProfilpoints[1] = $Punkte_freie_Kurve[0][$i][1] - $x_pos;                           //Abziehen des x-Wertes um in der lokalen Ebene zu drehen
                    $Punkte_freie_Kurve[0][$i][1] =  $TurnProfilpoints[1]*cos($y_Turn_Angle) - $TurnProfilpoints[3]*sin($y_Turn_Angle); //Drehamtrix um y-Achse
                    $Punkte_freie_Kurve[0][$i][3] =   $TurnProfilpoints[1]*sin($y_Turn_Angle) + $TurnProfilpoints[3]*cos($y_Turn_Angle); 
                    $TurnProfilpoints[1] = $Punkte_freie_Kurve[0][$i][1] + $x_pos; 
                    $Punkte_freie_Kurve[0][$i][1] = $TurnProfilpoints[1]*cos($y_Turn_Angle); 
                    //}
                }


                  
            

        //............................Output........................................
                $Points[0][0] = $Punkte_freie_Kurve;
                $Points[0][1] = $u;
                $Points[0][2] = 0;
                $Points[0][3] = "CAM_Linie_freie_Kurve";
                $Points[0][4] = "('NONE',0.0,7,0.1)";


            return($Points);

    } 
    private function StepPostProcessor($Point_Array, $Name, $Side, $showSplines){     //Steppostprozessor (steuert alle notwendigen Postprozessor Funktionen)
        /*

        Autor:			Helix-Design

        Programmname:	StepPostProcessor

        Modulname:		StepPostProcessor.php

        Änderungsstand:	13.04.2021

        Namenskürzel:	PM	


        Beschreibung:	ruft relevante Funktionen auf, um die Bausteine eines Step Files zu generieren
                        

        Der Programmablauf kommt von:		Main.php


        Benötigte Werte:			Alle Geometriepunkte

        Der Programmablauf wird übergeben an:	erzeugt stp File Output


        Übergebene Werte:			Alle Step Entities

        -------------------------------------------------------------------------------------
        */
        global $Frame_List;
        global $Step_Output;
        global $Surface_Name;
        global $EntityCounter;
        global $u_Blade;
        global $v_Blade;
        //include_once("Geometry_Calculation.php");
        for ($i = 0; $i < count($Point_Array); $i++){
            $Points[$i] = $Point_Array[$i][0];                                                                                  //auslesen von Informationen aus dem Point_Array (zur Übersichtlichkeit)
            $u = $Point_Array[$i][1];
            $v = $Point_Array[$i][2];
            $Surface_Name[$i] =  $Point_Array[$i][3];
            $Surface_Colour[$i] = $Point_Array[$i][4];
            if ($Surface_Name[$i] == "Zentrierung_Konus"){                                                                          //Konuserstellung verwendet andere Methodik, deswegen hier eine Abfrage
                $Surface_Frame_Entities[$i] = $this -> Cone($Points[$i], $Spline_Entities, $Surface_Colour[$i], $Side);           
            } else {
                if (substr_compare($Surface_Name[$i], "CAM_Linie", 0, 9) == 0){                                                                  //bei CAM - Linien wird nur die Funktion zur Spline Erzeugung aufgerufen. Kriterium ist der Name der Punktwolke 
                    $Points[$i] = $this ->  CARTESIAN_POINT_ENTITY($Points[$i]); 
                    $xKnotVector[$i] = $this ->  Knot_Vector_Stp($u, count($Points[$i][0]));
                    $Spline_Entities[$i] = $this ->  SplineEntity_Line($Surface_Name[$i] ,$Points[$i], $u,  count($Points[$i][0]), $xKnotVector[$i]);
                } else {
                    $Points[$i] = $this -> CARTESIAN_POINT_ENTITY($Points[$i]); 
                    $xKnotVector[$i] = $this ->  Knot_Vector_Stp($u, count($Points[$i]));
                    $yKnotVector[$i] = $this ->  Knot_Vector_Stp($v, count($Points[$i][0]));
                    $Spline_Entities[$i] = $this ->  SplineEntity($Surface_Name[$i] ,$Points[$i], $u, $v, count($Points[$i]), count($Points[$i][0]), $xKnotVector[$i], $yKnotVector[$i]);
                    $Surface_Entities[$i] = $this ->  SurfaceEntity($Surface_Name[$i], $Points[$i], $Spline_Entities[$i], $u, $v, $Surface_Colour[$i]);
                    $Surface_Frame_Entities[$i] = $this ->   Surface_Frame($Spline_Entities[$i], $Points[$i], $Surface_Entities[$i], $Surface_Colour[$i], $Surface_Name[$i]);

                }
        
            }
             


            if (count($Point_Array) == 1+ $i ){
                $STEPFRAME = $this ->  Step_Frame($Surface_Frame_Entities, $Spline_Entities, $Name, $showSplines);
                $Step_Output =  $STEPFRAME[0].$STEPFRAME[1].$Step_Output.$STEPFRAME[2];          //zusammenfügen von Header, Grundgerüst und Ende
                 
            }

        }  
        printf("$Name.stp wurde erfolgreich erstellt und steht im Download-Bereich zur Verfügung.");
        Storage::disk('public')->put("$Name.stp", "$Step_Output");
        $Name = $Name.".stp";
     

     return ($Step_Output);

    }
    private function Step_Frame($Frame_List, $Spline_List, $Name, $showSplines){        //Erstellung Grundgerüst der Step-Datei
        global $EntityCounter;
        global $Step_Output;
            //erstellen der Entity Liste für Styled Item und Shell Base Surface Modell
            $Frame_List = array_values(array_filter($Frame_List));
            for ($i = 0; $i<count($Frame_List); $i++){
                $Styled_Item_List[$i] = $Frame_List[$i][1];
                $Shell_based_Surface_Modell_List[$i] = $Frame_List[$i][0];
            }
            $Styled_Item_List = implode(',',$Styled_Item_List);
            $Shell_based_Surface_Modell_List = implode(',',$Shell_based_Surface_Modell_List);
            $counter = 0;
            $Spline_List = array_values(array_filter($Spline_List));
            for ($i = 0; $i<count($Spline_List); $i++){           
                for ($j = 0; $j < count($Spline_List[$i]); $j++){
                    $Spline_Name[$i] = $Spline_List[$i][$j][1];
                    if ($showSplines == "ja"){
                        $Spline_Entity_List[$counter] = $Spline_List[$i][$j][0];
                        $counter++;

                    } else{
                        if (substr_compare($Spline_Name[$i], "CAM_Linie", 0, 9) == 0){      //nur CAM_Linien darstellen, wird if Abfrage entfernt, werden alle Splines dargestellt
                            $Spline_Entity_List[$counter] = $Spline_List[$i][$j][0];
                            $counter++;
                        }
                        else {
                            $Spline_Entity_List[$counter] = "";
                        }
                    }
                }
            }
            $Spline_Entity_List = implode(',',$Spline_Entity_List);
            

        // Grundgerüst Step File. Anordnung muss genauso bleiben. Leerzeichen vor HEADER ENDSEC usw führen zu nicht Ausführung des Step Files im CAD-Programm        
            $DateandTime = date('Y-m-dTH:i:s+P');
            $HEADER = "ISO-10303-21;
            HEADER;
                    /* Generated by Helix
                    */
                    /* OPTION: using custom schema-name function */
                        
                    FILE_DESCRIPTION(
                    /* description */ (''),
                    /* implementation_level */ '2;1');
                        
                    FILE_NAME(
                    /* name */ '$Name.stp',
                    /* time_stamp */ '$DateandTime',
                    /* author */ (''),
                    /* organization */ (''),
                    /* preprocessor_version */ 'Prepro 1.0',
                    /* originating_system */ 'Eigenbau',
                    /* authorisation */ '');

                    FILE_SCHEMA (('AUTOMOTIVE_DESIGN { 1 0 10303 214 3 1 1 1 }'));
            ENDSEC;
                ";
                $DATA = "
            DATA;
                #1=SHAPE_REPRESENTATION_RELATIONSHIP('None',
                'relationship between Test_Surf-None and Test_Surf-None',#15,#2);
                #2=GEOMETRICALLY_BOUNDED_WIREFRAME_SHAPE_REPRESENTATION( 'Test_Surf-None',(#25),#17);
                #3=SHAPE_REPRESENTATION_RELATIONSHIP('None',
                'relationship between Test_Surf_4p-None and Test_Surf_4p-None',#15,#4);
                #4=MANIFOLD_SURFACE_SHAPE_REPRESENTATION('Test_Surf_4p-None',($Shell_based_Surface_Modell_List),#17);                       
                #5=SHAPE_DEFINITION_REPRESENTATION(#6,#15);
                #6=PRODUCT_DEFINITION_SHAPE('','',#7);
                #7=PRODUCT_DEFINITION(' ','',#9,#8);
                #8=PRODUCT_DEFINITION_CONTEXT('part definition',#14,'design');
                #9=PRODUCT_DEFINITION_FORMATION_WITH_SPECIFIED_SOURCE(' ',' ',#11,
                .NOT_KNOWN.);
                #10=PRODUCT_RELATED_PRODUCT_CATEGORY('part','',(#11));
                #11=PRODUCT('Test_Surf_4p','Test_Surf_4p',' ',(#12));
                #12=PRODUCT_CONTEXT(' ',#14,'mechanical');
                #13=APPLICATION_PROTOCOL_DEFINITION('international standard',
                'automotive_design',2010,#14);
                #14=APPLICATION_CONTEXT(
                'core data for automotive mechanical design processes');
                #15=SHAPE_REPRESENTATION('Test_Surf_4p-None',(#26),#17);                   
                #16=MECHANICAL_DESIGN_GEOMETRIC_PRESENTATION_REPRESENTATION('',( $Styled_Item_List),#17);                                        
                #17=(
                GEOMETRIC_REPRESENTATION_CONTEXT(3)
                GLOBAL_UNCERTAINTY_ASSIGNED_CONTEXT((#18))
                GLOBAL_UNIT_ASSIGNED_CONTEXT((#24,#20,#19))
                REPRESENTATION_CONTEXT('Test_Surf_4p','TOP_LEVEL_ASSEMBLY_PART')
                );
                #18=UNCERTAINTY_MEASURE_WITH_UNIT(LENGTH_MEASURE(0.001),#24,
                'DISTANCE_ACCURACY_VALUE','Maximum Tolerance applied to model');
                #19=(NAMED_UNIT(*)SI_UNIT($,.STERADIAN.)SOLID_ANGLE_UNIT());
                #20=(CONVERSION_BASED_UNIT('DEGREE',#22)NAMED_UNIT(#21)PLANE_ANGLE_UNIT());
                #21=DIMENSIONAL_EXPONENTS(0.,0.,0.,0.,0.,0.,0.);
                #22=PLANE_ANGLE_MEASURE_WITH_UNIT(PLANE_ANGLE_MEASURE(0.0174532925),#23);
                #23=(NAMED_UNIT(*)PLANE_ANGLE_UNIT()SI_UNIT($,.RADIAN.));
                #24=(LENGTH_UNIT()NAMED_UNIT(*)SI_UNIT(.MILLI.,.METRE.));
                #25=GEOMETRIC_CURVE_SET('NONE',($Spline_Entity_List));			                   									  
                #26=AXIS2_PLACEMENT_3D('',#29,#27,#28);
                #27=DIRECTION('',(0.,0.,1.));
                #28=DIRECTION('',(1.,0.,0.));
                #29=CARTESIAN_POINT('Nullpunkt',(0, 0, 0));
                ";
                $ENDSEC = "
            ENDSEC;
            END-ISO-10303-21;";
        $STEPFRAME[0] = $HEADER;
        $STEPFRAME[1] = $DATA;
        $STEPFRAME[2] = $ENDSEC;

        return($STEPFRAME);
    }    
    private function Surface_Frame($Spline_List, $Point_List, $Surface_List, $Color, $Surface_Name){  //Erstellung Grundgerüst Step Fläche
        /*

        Autor:			Helix-Design

        Programmname:	Surface_Frame

        Modulname:		StepPostProcessor.php

        Änderungsstand:	17.06.2021

        Namenskürzel:	PM	


        Beschreibung:	erzeugt Befehle, die mit Flächengenerierung zusammenhängen (Frame), aber nicht die eigentliche Flächen
                        

        Der Programmablauf kommt von:		Main.php


        Benötigte Werte:			$Spline_List (Entities aller Splines), $Point_List (Entities aller Punkte), $Surface_List (Entities aller Flächen), $Color, $Surface_Name

        Der Programmablauf wird übergeben an:	erzeugt stp File Output


        Übergebene Werte:			Alle Flächen Frame Entities

        -------------------------------------------------------------------------------------
        */



        global $Step_Output;
        global $Frame_List;
        global $EntityCounter;
        $VERTEX = "";
        //Vertex Points
        for ($i = 0; $i<4; $i++){
            $Vertex_List[$i] = "#$EntityCounter";
            if ($i==0){                                                         //erster Eckpunkt E1-P1
                $a = $Point_List[0][0][4];                                                  
            } elseif ($i==1){                                                   //zweiter Eckpunkt  E1-P(n+1)                                                        
                $a = $Point_List[0][count($Point_List[0])-1][4];
            } elseif ($i==2){                                                      //dritter Eckpunkt  E(m+1)P(n+1)
                $a = $Point_List[count($Point_List)-1][count($Point_List[0])-1][4];
            } elseif ($i = 3){                                                      //vierter Eckpunkt E(m+1)P1
                $a = $Point_List[count($Point_List)-1][0][4];
            }
        $VERTEX = $VERTEX."
        #$EntityCounter = VERTEX_POINT('',$a);";
        $EntityCounter++;
        }
        $SURFACE_FRAME = $VERTEX;
        //EDGE_CURVE
        $EDGE_CURVE = "";
        for ($i = 0; $i<4; $i++){                                               //zuordnen der Vertex Punkte und Spilines der jeweiligen Edge Curve
            $Edge_Curve_List[$i] = "#$EntityCounter";
            if ($i==0){
                $a = $Vertex_List[$i];
                $c = $Vertex_List[$i+1];
                $b = $Spline_List[0][0];
            } elseif ($i==1){
                $a = $Vertex_List[$i];
                $c = $Vertex_List[$i+1];
                $b = $Spline_List[count($Point_List)+1][0];
            } elseif ($i==2){
                $a = $Vertex_List[$i];
                $c = $Vertex_List[$i+1];
            
                $b = $Spline_List[count($Point_List)-1][0];
            } elseif ($i = 3){
                $a = $Vertex_List[$i];
                $c = $Vertex_List[0];
                $b = $Spline_List[count($Point_List)][0];
            }
        $EDGE_CURVE = $EDGE_CURVE."
        #$EntityCounter = EDGE_CURVE('',$a,$c,$b,.T.);";
        $EntityCounter++;
        }
        $SURFACE_FRAME = $SURFACE_FRAME.$EDGE_CURVE;
        //Oriented_Edge

        $ORIENTED_EDGE = "";
        for ($i = 0; $i<4; $i++){                                             //zuordnen der Edge Curve zur Oriented Edge
            if ($i == 0) {
                $Oriented_Edge_List =  "#$EntityCounter";
            } 
            else {
                $Oriented_Edge_List = "$Oriented_Edge_List, #$EntityCounter";
            }
            $a = $Edge_Curve_List[$i];
            $ORIENTED_EDGE = $ORIENTED_EDGE."
        #$EntityCounter = ORIENTED_EDGE('',*,*,$a,.T.);";
        $EntityCounter++;
        }
        $SURFACE_FRAME = $SURFACE_FRAME.$ORIENTED_EDGE;
        //Edge_LOOp
        $Edge_Loop_List = "#$EntityCounter";
        $EDGE_LOOP = "
        #$EntityCounter = EDGE_LOOP('',($Oriented_Edge_List));";
        $SURFACE_FRAME = $SURFACE_FRAME.$EDGE_LOOP;
        $EntityCounter++;
        //Face Outer Bound
        $Face_Outer_Bound_List = "#$EntityCounter";
        $FACE_OUTER_BOUND = "
        #$EntityCounter = FACE_OUTER_BOUND('',$Edge_Loop_List,.T.);";
        $SURFACE_FRAME = $SURFACE_FRAME.$FACE_OUTER_BOUND;
        $EntityCounter++;
        //Advanced_Face
        $Advanced_Face_List = "#$EntityCounter";
        $a = $Surface_List[0];
        $ADVANCED_FACE = "
        #$EntityCounter =ADVANCED_FACE('',($Face_Outer_Bound_List),$a,.T.);";
        $SURFACE_FRAME = $SURFACE_FRAME.$ADVANCED_FACE;
        $EntityCounter++;
        //Open_Shell
        $Open_Shell_List = "#$EntityCounter";
        $OPEN_SHELL = "
        #$EntityCounter =OPEN_SHELL('',($Advanced_Face_List));";
        $SURFACE_FRAME = $SURFACE_FRAME.$OPEN_SHELL;
        $EntityCounter++;
        //Shell Base Surface Model
        $Shell_Based_Surface_List = "#$EntityCounter";
        $SHELL_BASED_SURFACE_MODEL = "
        #$EntityCounter =SHELL_BASED_SURFACE_MODEL('$Surface_Name',($Open_Shell_List));";
        $SURFACE_FRAME = $SURFACE_FRAME.$SHELL_BASED_SURFACE_MODEL;
        $Frame_List[0] = $Shell_Based_Surface_List;                                                                     //zuordnen zu Ausgabe für weitere Verwendung
        $EntityCounter++;
        //Layer Assignment
        $a = 1;
        $b = "Geometrie";                                                                                                 //verschiedene Layer für Hilfsflächen
        if (substr_compare($Surface_Name, "Tiefenbegrenzung", 0, 16) == 0){
            $a = 2;
            $b = "Hilfsflaechen";
        }
        $Layer_Assigment_List = "#$EntityCounter";
        $PRESENTATION_LAYER_ASSIGNMENT = "
        #$EntityCounter =PRESENTATION_LAYER_ASSIGNMENT('$b','Layer $a',($Shell_Based_Surface_List));";
        $SURFACE_FRAME = $SURFACE_FRAME.$PRESENTATION_LAYER_ASSIGNMENT;
        $EntityCounter++;
        //Color
        $Color_RGB_List = "#$EntityCounter";
        $COLOUR_RGB = "
        #$EntityCounter = COLOUR_RGB$Color;";
        $SURFACE_FRAME = $SURFACE_FRAME.$COLOUR_RGB;
        $EntityCounter++;
        //Fill Area Style Color
        $Fill_Area_Style_Color_List = "#$EntityCounter";
        $FILL_AREA_STYLE_COLOUR = "
        #$EntityCounter =FILL_AREA_STYLE_COLOUR('',$Color_RGB_List);";
        $SURFACE_FRAME = $SURFACE_FRAME.$FILL_AREA_STYLE_COLOUR;
        $EntityCounter++;
        //Fill Area Style 
        $Fill_Area_Style_List = "#$EntityCounter";
        $FILL_AREA_STYLE = "
        #$EntityCounter =FILL_AREA_STYLE('',($Fill_Area_Style_Color_List));";
        $SURFACE_FRAME = $SURFACE_FRAME.$FILL_AREA_STYLE;
        $EntityCounter++;
        //Surface Style Fill Area
        $SURFACE_STYLE_FILL_AREA_List = "#$EntityCounter";
        $SURFACE_STYLE_FILL_AREA = "
        #$EntityCounter =SURFACE_STYLE_FILL_AREA($Fill_Area_Style_List);";
        $SURFACE_FRAME = $SURFACE_FRAME.$SURFACE_STYLE_FILL_AREA;
        $EntityCounter++;
        //Surface Side Style
        $SURFACE_SIDE_STYLE_List = "#$EntityCounter";
        $SURFACE_SIDE_STYLE = "
        #$EntityCounter =SURFACE_SIDE_STYLE('',($SURFACE_STYLE_FILL_AREA_List));";
        $SURFACE_FRAME = $SURFACE_FRAME.$SURFACE_SIDE_STYLE;
        $EntityCounter++;
        //Surface Style Usage
        $SURFACE_STYLE_USAGE_List = "#$EntityCounter";
        $SURFACE_STYLE_USAGE = "
        #$EntityCounter =SURFACE_STYLE_USAGE(.BOTH.,$SURFACE_SIDE_STYLE_List);";
        $SURFACE_FRAME = $SURFACE_FRAME.$SURFACE_STYLE_USAGE;
        $EntityCounter++;
        //PRESENTATION_STYLE_ASSIGNMENT
        $PRESENTATION_STYLE_ASSIGNMENT_List = "#$EntityCounter";
        $PRESENTATION_STYLE_ASSIGNMENT = "
        #$EntityCounter =PRESENTATION_STYLE_ASSIGNMENT(($SURFACE_STYLE_USAGE_List));";
        $SURFACE_FRAME = $SURFACE_FRAME.$PRESENTATION_STYLE_ASSIGNMENT;
        $EntityCounter++;
        //STYLED_ITEM
        $STYLED_ITEM_List = "#$EntityCounter";
        $STYLED_ITEM = "
        #$EntityCounter =STYLED_ITEM('',( $PRESENTATION_STYLE_ASSIGNMENT_List),$Shell_Based_Surface_List);";
        $SURFACE_FRAME = $SURFACE_FRAME.$STYLED_ITEM;
        $Frame_List[1] = $STYLED_ITEM_List;                                                                    //zuordnen zu Ausgabe für weitere Verwendung
        $EntityCounter++;

        $Step_Output = $Step_Output.$SURFACE_FRAME;
        return($Frame_List);
    }
    private function SplineEntity($Name,  $Points,  $u, $v, $numberofcontrolpointsx, $numberofcontrolpointsy, $xKnotVector, $yKnotVector){    //Erstellung Step Spline Befehle (für Flächenberandung)
                    /*

            Autor:			Helix-Design

            Programmname:	Surface_Frame

            Modulname:		StepPostProcessor.php

            Änderungsstand:	17.06.2021

            Namenskürzel:	PM	


            Beschreibung:	erstellt die Befehle (Entities) für alle Splines
                            

            Der Programmablauf kommt von:		Main.php


            Benötigte Werte:			$Name,  $Points,  $u, $v, $numberofcontrolpointsx, $numberofcontrolpointsy, $xKnotVector, $yKnotVector

            Der Programmablauf wird übergeben an:	erzeugt stp File Output


            Übergebene Werte:			Alle Spline_Entities

            -------------------------------------------------------------------------------------
            */




            global $EntityCounter;
            global $Step_Output;
            $yKnots = $yKnotVector[0];
            $yKnotMultiplicator = $yKnotVector[1];
            $xKnots = $xKnotVector[0];
            $xKnotMultiplicator = $xKnotVector[1];



            //Kontrollpunktliste der Splines in y-Richtung

            for ($i = 0; $i < $numberofcontrolpointsx; $i++){
                $Controlpoint_Lists[$i] ="(";
                for ($j = 0; $j < $numberofcontrolpointsy; $j++){
                    if ($j < $numberofcontrolpointsy-1){
                        $Controlpoint_Lists[$i] =  $Controlpoint_Lists[$i].$Points[$i][$j][4].",";
                    }
                    else{
                        $Controlpoint_Lists[$i] =  $Controlpoint_Lists[$i].$Points[$i][$j][4]; 
                    }
                }
                $Controlpoint_Lists[$i]=$Controlpoint_Lists[$i].")";    
            }
            //Kontrollpunktliste der Splines in x-Richtung
            $a = $i;
            $b = count($Points[0])-1;
            $Controlpoint_Lists[$a] ="(";
            $Controlpoint_Lists[$a+1] ="(";
            for ($i=0; $i < $numberofcontrolpointsx; $i++){          
                if ($i < $numberofcontrolpointsx-1){
                    $Controlpoint_Lists[$a] =  $Controlpoint_Lists[$a].$Points[$i][0][4].",";  //Kontrollpunkte des vorderen Splines. Bei Blatt z.B. VK
                    $Controlpoint_Lists[$a+1] =  $Controlpoint_Lists[$a+1].$Points[$i][$b][4].",";
                    }
                else{
                    $Controlpoint_Lists[$a] =  $Controlpoint_Lists[$a].$Points[$i][0][4]; //Kontrollpunkte des hinteren Splines. Bei Blatt z.B. HK
                    $Controlpoint_Lists[$a+1] =  $Controlpoint_Lists[$a+1].$Points[$i][$b][4];
                }

            }
            $Controlpoint_Lists[$a]=$Controlpoint_Lists[$a].")";
            $Controlpoint_Lists[$a+1]=$Controlpoint_Lists[$a+1].")";






            //erstellen der B-Spline Entities

            $B_SPLINE = "";
            $u = $u-1;
            $v = $v-1;
            for ($i =0; $i<count($Controlpoint_Lists); $i++){
                $a = $i+1;
                if ($i < count($Controlpoint_Lists)-2 ){                                              //Splines in y-Richtung
                    $Controlpoints = $Controlpoint_Lists[$i];                           
                    $Spline_List[$i][0] = "#$EntityCounter";                                               //Array mit Spline Informationen
                    $Spline_List[$i][1] = "$Name-Spline $a";
                    $Spline_List[$i][2] = $u;
                    $Spline_List[$i][3] = $Controlpoints;
                    $Spline_List[$i][4] = $yKnots;
                    $Spline_List[$i][5] = $yKnotMultiplicator;
                    $B_SPLINE = $B_SPLINE."                                                                  
            #$EntityCounter = B_SPLINE_CURVE_WITH_KNOTS('$Name-Spline$a',$v,$Controlpoints,.UNSPECIFIED.,.F.,.F.,$yKnots,$yKnotMultiplicator,.UNSPECIFIED.);";            //Ausgabefertiger String mit Spline Entitites
                }
                else{
                    $Controlpoints = $Controlpoint_Lists[$i];                                            //Splines in x-Richtung
                    $Spline_List[$i][0] = "#$EntityCounter";
                    $Spline_List[$i][1] = "$Name-Spline $a";
                    $Spline_List[$i][2] = $v;
                    $Spline_List[$i][3] = $Controlpoints;
                    $Spline_List[$i][4] = $xKnots;
                    $Spline_List[$i][5] = $xKnotMultiplicator;
                    $B_SPLINE = $B_SPLINE."
            #$EntityCounter = B_SPLINE_CURVE_WITH_KNOTS('$Name-Spline$a',$u,$Controlpoints,.UNSPECIFIED.,.F.,.F.,$xKnots,$xKnotMultiplicator,.UNSPECIFIED.);";  
                }
                $EntityCounter++;
            }
            $Step_Output = $Step_Output.$B_SPLINE;


            return ($Spline_List);
    }
    private function SurfaceEntity($Name, $Points, $Spline_List,  $u, $v, $Color){ //Erstellung Step Flächen Befehle
            /*

            Autor:			Helix-Design

            Programmname:	Surface_Frame

            Modulname:		StepPostProcessor.php

            Änderungsstand:	17.06.2021

            Namenskürzel:	PM	


            Beschreibung:	erstellt die Befehle (Entities) für alle Flächen
                            

            Der Programmablauf kommt von:		Main.php


            Benötigte Werte:			($Name, $Points, $Spline_List,  $u, $v, $Color

            Der Programmablauf wird übergeben an:	StepPostProcessor


            Übergebene Werte:			Alle Spline_Entities

            -------------------------------------------------------------------------------------
            */

            global $EntityCounter;
            global $Step_Output;
            $a = "";
            $yKnot = $Spline_List[0][5];                                            //übernehmen der Knotenvektoren/-Multiplikatoren, welche bereits für die Spline-Entities berechnet wurden
            $yKnotMult = $Spline_List[0][4];
            $xKnot = $Spline_List[count($Spline_List)-1][5];
            $xKnotMult = $Spline_List[count($Spline_List)-1][4];
            $u = $u-1;                                                          //Verwendung von Grad statt Ordnung
            $v = $v-1;
            $Surface_List[0] = "#$EntityCounter";                              //Surface_Entities und Name speichern, zur Wiederverwendung
            $Surface_List[1] = $Name;
            for ($i = 0; $i < count($Spline_List)-2; $i++){

                $b = $Spline_List[$i][3];
                if ($i== 0){                                                         //übernehmen der Stützpunkte der Splines
                    $a = "$b"; 
                }
                else{
                    $a = "$a,$b";
                }                                        

            }
            $SURFACE = "
            #$EntityCounter = B_SPLINE_SURFACE_WITH_KNOTS('$Name',$u,$v,($a),.UNSPECIFIED.,.F.,.F.,.F.,$xKnotMult,$yKnotMult,$xKnot,$yKnot,.UNSPECIFIED.);";  //Ausgabefertiger String mit Surface Entitites
            $EntityCounter++;

            $Step_Output = $Step_Output.$SURFACE;

            return($Surface_List);
            }
        function Knot_Vector_Stp($u, $numberofcontrolpoints){
                /*

            Autor:			Helix-Design

            Programmname:	Surface_Frame

            Modulname:		StepPostProcessor.php

            Änderungsstand:	17.06.2021

            Namenskürzel:	PM	


            Beschreibung:	erstellt die Befehle (Entities) für alle Flächen
                            

            Der Programmablauf kommt von:		StepPostProcessor.php


            Benötigte Werte:			$u, $numberofcontrolpoints

            Der Programmablauf wird übergeben an:	StepPostProcessor


            Übergebene Werte:			Knotenvektor für Step Entities

            -------------------------------------------------------------------------------------
            */

            $k = $u-1;                                              //Grad des Splines
            $Knotmultiplikator = "(".$u;
            $Knots = "(0";
            $h = 1/($numberofcontrolpoints+$k-2*$k);
            for ($i = 2 * $u; $i <= $numberofcontrolpoints + $u; $i++){
                if ($i < $numberofcontrolpoints + $u) {
                    $Knotmultiplikator = $Knotmultiplikator.",1";
                    $Knots = $Knots.",".$h;
                    $h = $h+1/($numberofcontrolpoints - $k);        
                }   
                else{
                    $Knotmultiplikator = $Knotmultiplikator.",".$u.")";
                    $Knots = $Knots.",1)";
                }   
            }
            $KnotVector[0] = $Knotmultiplikator;
            $KnotVector[1] = $Knots;
            return($KnotVector);
            }
        private  function CARTESIAN_POINT_ENTITY($Point_List){  
                /*

        Autor:			Helix-Design

        Programmname:	Surface_Frame

        Modulname:		StepPostProcessor.php

        Änderungsstand:	17.06.2021

        Namenskürzel:	PM	


        Beschreibung:	erstellt die Befehle (Entities) für alle Punkte
                        

        Der Programmablauf kommt von:		StepPostProcessor.php


        Benötigte Werte:			$Point_List

        Der Programmablauf wird übergeben an:	StepPostProcessor


        Übergebene Werte:			Punkte-Entities

        -------------------------------------------------------------------------------------
        */


        global $Step_Output;
        global $EntityCounter;
        $CARTESIAN_POINT = " ";
        for ($i = 0; $i<count($Point_List);$i++){
                for ($j = 0; $j<count($Point_List[$i]);$j++){
                $Name = $Point_List[$i][$j][0];
                $x = $Point_List[$i][$j][1];
                $y = $Point_List[$i][$j][2];
                $z = $Point_List[$i][$j][3];
                $CARTESIAN_POINT = $CARTESIAN_POINT."
        #$EntityCounter = CARTESIAN_POINT('$Name',($x,$y,$z));";    //Ausgabefertiger String mit Punkten der jeweiligen Fläche
                $Point_List[$i][$j][4] ="#$EntityCounter";
                $EntityCounter++;
                }
                
        }
        $Step_Output = $Step_Output.$CARTESIAN_POINT;
        return ($Point_List);
    }
    private function Cone($Point_List, $Spline_Entities, $COLOUR, $Side){   //Erstellung Konus Befehle
            /*

        Autor:			Helix-Design

        Programmname:	Surface_Frame

        Modulname:		StepPostProcessor.php

        Änderungsstand:	17.06.2021

        Namenskürzel:	PM	


        Beschreibung:	erstellt die Befehle (Entities) für Konus
                        

        Der Programmablauf kommt von:		StepPostProcessor.php


        Benötigte Werte:			$Point_List, $Spline_Entities, $COLOUR, $Side

        Der Programmablauf wird übergeben an:	StepPostProcessor


        Übergebene Werte:			Konus-Entities

        -------------------------------------------------------------------------------------
        */


        global $Step_Output;
        global $EntityCounter;
        global $Surface_Name;

        //CARTESIAN POINTS
        $CARTESIAN_POINT = "";
        $counter = 0;
        for ($i=0;$i<2;$i++){
        for ($j=0;$j<2;$j++){
            $CARTESIAN_POINT_List[$counter] = "#$EntityCounter";
            $x = $Point_List[$i][$j][1];
            $y = $Point_List[$i][$j][2];
            $z = $Point_List[$i][$j][3];
            $Name= $Point_List[$i][$j][0];
            $CARTESIAN_POINT = $CARTESIAN_POINT."
        #$EntityCounter = CARTESIAN_POINT('$Name',($x, $y, $z));";
            $EntityCounter++;
            $counter++;
        }
        }
        $CONE_FRAME = $CARTESIAN_POINT;

        //VERTEX_POINT
        $VERTEX_POINT_List[0] = "#$EntityCounter";

        $a = $CARTESIAN_POINT_List[1];
        $b = $CARTESIAN_POINT_List[3];
        $VERTEX_POINT = "
        #$EntityCounter = VERTEX_POINT('',$a);";
        $EntityCounter++;
        $VERTEX_POINT_List[1] = "#$EntityCounter";
        $VERTEX_POINT = $VERTEX_POINT."
        #$EntityCounter = VERTEX_POINT('',$b);";
        $CONE_FRAME = $CONE_FRAME.$VERTEX_POINT;
        $EntityCounter++;

        //DIRECTION
        $DIRECTION_List[0]= "#$EntityCounter";
        if ($Side == "oben"){                                       //Ausrichtung des Konus ändern für oben oder unten   
        $DIRECTION = "
        #$EntityCounter = DIRECTION('',(0.,0.,-1.));";
        } else {
            $DIRECTION = "
        #$EntityCounter = DIRECTION('',(0.,0.,1.));";
        }
        $EntityCounter++;
        $CONE_FRAME = $CONE_FRAME.$DIRECTION;

        //AXIS2_PLACEMENT_3D
        $AXIS2_PLACEMENT_3D_List[0] = "#$EntityCounter";

        $a = $CARTESIAN_POINT_List[0];
        $b = $CARTESIAN_POINT_List[2];
        $c = $DIRECTION_List[0];

        $AXIS2_PLACEMENT_3D_List[0] = "#$EntityCounter";
        $AXIS2_PLACEMENT_3D = "
        #$EntityCounter = AXIS2_PLACEMENT_3D('',$a,#27,#28);";
        $EntityCounter++;
        $AXIS2_PLACEMENT_3D_List[1] = "#$EntityCounter";
        $AXIS2_PLACEMENT_3D = $AXIS2_PLACEMENT_3D."
        #$EntityCounter = AXIS2_PLACEMENT_3D('',$b,#27,#28);";
        $EntityCounter++;
        $AXIS2_PLACEMENT_3D_List[2] = "#$EntityCounter";
        $AXIS2_PLACEMENT_3D = $AXIS2_PLACEMENT_3D."
        #$EntityCounter = AXIS2_PLACEMENT_3D('',$a,$c,#28);";
        $CONE_FRAME = $CONE_FRAME.$AXIS2_PLACEMENT_3D;
        $EntityCounter++;

        //CIRCLE 
        $CIRCLE_List[0] = "#$EntityCounter";
        $a = $AXIS2_PLACEMENT_3D_List[2];
        $b = $AXIS2_PLACEMENT_3D_List[1];
        $CIRCLE = "
        #$EntityCounter = CIRCLE('',$a,10);";
        $EntityCounter++;
        $CIRCLE_List[1] = "#$EntityCounter";
        $CIRCLE = $CIRCLE."
        #$EntityCounter  = CIRCLE('',$b,15);";
        $CONE_FRAME = $CONE_FRAME.$CIRCLE;
        $EntityCounter++;

        //EDGE_CURVE

        $EDGE_CURVE_List[0] = "#$EntityCounter";
        $a = $VERTEX_POINT_List[0];
        $b = $VERTEX_POINT_List[1];
        $c = $CIRCLE_List[0];
        $d = $CIRCLE_List[1];
        $EDGE_CURVE = "
        #$EntityCounter = EDGE_CURVE('',$a,$a,$c,.T.);";
        $EntityCounter++;
        $EDGE_CURVE_List[1] = "#$EntityCounter";
        $EDGE_CURVE = $EDGE_CURVE."
        #$EntityCounter  = EDGE_CURVE('',$b,$b,$d ,.T.);";
        $CONE_FRAME = $CONE_FRAME.$EDGE_CURVE;
        $EntityCounter++;

        //ORIENTED_EDGE

        $ORIENTED_EDGE_List[0] = "#$EntityCounter";
        $a = $EDGE_CURVE_List[0];
        $b = $EDGE_CURVE_List[1];
        $ORIENTED_EDGE = "
        #$EntityCounter = ORIENTED_EDGE('',*,*,$a,.F.);";
        $EntityCounter++;
        $ORIENTED_EDGE_List[1] = "#$EntityCounter";
        $ORIENTED_EDGE = $ORIENTED_EDGE."
        #$EntityCounter  = ORIENTED_EDGE('',*,*,$b,.F.);";
        $CONE_FRAME = $CONE_FRAME.$ORIENTED_EDGE;
        $EntityCounter++;

        //EDGE_LOOP

        $EDGE_LOOP_List[0] = "#$EntityCounter";
        $a = $ORIENTED_EDGE_List[0];
        $b = $ORIENTED_EDGE_List[1];
        $EDGE_LOOP = "
        #$EntityCounter = EDGE_LOOP('',($a));";
        $EntityCounter++;
        $EDGE_LOOP_List[1] = "#$EntityCounter";
        $EDGE_LOOP = $EDGE_LOOP."
        #$EntityCounter = EDGE_LOOP('',($b));";
        $CONE_FRAME = $CONE_FRAME.$EDGE_LOOP;
        $EntityCounter++;
        //FACE_OUTER_BOUND
        $FACE_OUTER_BOUND_List[0] = "#$EntityCounter";
        $a = $EDGE_LOOP_List[0];
        $b = $EDGE_LOOP_List[1];
        $FACE_OUTER_BOUND = "
        #$EntityCounter = FACE_OUTER_BOUND('',$a,.T.);";
        $EntityCounter++;
        $FACE_OUTER_BOUND_List[1] = "#$EntityCounter";
        $FACE_OUTER_BOUND = $FACE_OUTER_BOUND."
        #$EntityCounter = FACE_OUTER_BOUND('',$b,.T.);";
        $CONE_FRAME = $CONE_FRAME.$FACE_OUTER_BOUND;
        $EntityCounter++;
            //CONICAL_SURFACE
            $CONICAL_SURFACE_List = "#$EntityCounter";
            $a = $AXIS2_PLACEMENT_3D_List[2];
            $CONICAL_SURFACE = "
        #$EntityCounter = CONICAL_SURFACE('',$a,10,9.4623222208);";
            $CONE_FRAME = $CONE_FRAME.$CONICAL_SURFACE;
            $EntityCounter++;
            //FACE_BOUND
        $FACE_BOUND_List[0] = "#$EntityCounter";
        $a = $EDGE_LOOP_List[0];
        $b = $EDGE_LOOP_List[1];
        $FACE_BOUND = "
        #$EntityCounter = FACE_BOUND('',$a,.T.);";
        $EntityCounter++;
        $FACE_BOUND_List[1] = "#$EntityCounter";
        $FACE_BOUND = $FACE_BOUND."
        #$EntityCounter = FACE_BOUND('',$b,.T.);";
        $CONE_FRAME = $CONE_FRAME.$FACE_BOUND;
        $EntityCounter++;
            //PLANE
        $PLANE_List[0] = "#$EntityCounter";
        $a = $AXIS2_PLACEMENT_3D_List[0];
        $b = $AXIS2_PLACEMENT_3D_List[1];
        $PLANE = "
        #$EntityCounter = PLANE('',$a);";
        $EntityCounter++;
        $PLANE_List[1] = "#$EntityCounter";
        $PLANE = $PLANE."
        #$EntityCounter = PLANE('',$b);";
        $CONE_FRAME = $CONE_FRAME.$PLANE;
        $EntityCounter++;

        
        
        
        //ADVANCE_FACE
            $ADVANCED_FACE_List[0] = "#$EntityCounter";
            $a = $FACE_OUTER_BOUND_List[0];
            $b = $FACE_OUTER_BOUND_List[1];
            $c = $PLANE_List[0];
            $d = $PLANE_List[1];
            $e = $FACE_BOUND_List[0];
            $f = $FACE_BOUND_List[1];
            $g = $CONICAL_SURFACE_List;
            $ADVANCED_FACE = "
        #$EntityCounter = ADVANCED_FACE('',($a),$c,.T.);";
            $EntityCounter++;
            $ADVANCED_FACE_List[1] = "#$EntityCounter";
            $ADVANCED_FACE = $ADVANCED_FACE."
        #$EntityCounter = ADVANCED_FACE('',($b),$d,.T.);";
            $EntityCounter++;
            $ADVANCED_FACE_List[2] = "#$EntityCounter";
            $ADVANCED_FACE = $ADVANCED_FACE."
        #$EntityCounter = ADVANCED_FACE('',($e, $f),$g,.T.);";
            $EntityCounter++;
            $CONE_FRAME = $CONE_FRAME.$ADVANCED_FACE;

            //OPEN_SHELL
        $OPEN_SHELL_List[0] = "#$EntityCounter";
        $a = $ADVANCED_FACE_List[0];
        $b = $ADVANCED_FACE_List[2];
        $OPEN_SHELL = "
        #$EntityCounter = OPEN_SHELL('',($a));";
        $EntityCounter++;
        $OPEN_SHELL_List[1] = "#$EntityCounter";
        $OPEN_SHELL = $OPEN_SHELL."
        #$EntityCounter = OPEN_SHELL('',($a,$b));";
        $CONE_FRAME = $CONE_FRAME.$OPEN_SHELL;
        $EntityCounter++;

            //SHELL_BASED_SURFACE_MODEL
            $SHELL_BASED_SURFACE_MODEL_List = "#$EntityCounter";
            $a = $OPEN_SHELL_List[1];
            
            $SHELL_BASED_SURFACE_MODEL = "
        #$EntityCounter = SHELL_BASED_SURFACE_MODEL('Zentrierung_Konus',($a));";
        
            $CONE_FRAME = $CONE_FRAME.$SHELL_BASED_SURFACE_MODEL;
        
            $EntityCounter++;
        //Layer Assignment
        $Layer_Assigment_List = "#$EntityCounter";
        $PRESENTATION_LAYER_ASSIGNMENT = "
        #$EntityCounter = PRESENTATION_LAYER_ASSIGNMENT('1','Layer 1',($SHELL_BASED_SURFACE_MODEL_List));";
        $CONE_FRAME = $CONE_FRAME.$PRESENTATION_LAYER_ASSIGNMENT;
        $EntityCounter++;
        //Color
        $Color_RGB_List = "#$EntityCounter";
        $COLOUR_RGB = "
        #$EntityCounter = COLOUR_RGB$COLOUR;";
        $CONE_FRAME = $CONE_FRAME.$COLOUR_RGB;
        $EntityCounter++;
        //Fill Area Style Color
        $Fill_Area_Style_Color_List = "#$EntityCounter";
        $FILL_AREA_STYLE_COLOUR = "
        #$EntityCounter = FILL_AREA_STYLE_COLOUR('',$Color_RGB_List);";
        $CONE_FRAME = $CONE_FRAME.$FILL_AREA_STYLE_COLOUR;
        $EntityCounter++;
        //Fill Area Style 
        $Fill_Area_Style_List = "#$EntityCounter";
        $FILL_AREA_STYLE = "
        #$EntityCounter = FILL_AREA_STYLE('',($Fill_Area_Style_Color_List));";
        $CONE_FRAME = $CONE_FRAME.$FILL_AREA_STYLE;
        $EntityCounter++;
        //Surface Style Fill Area
        $SURFACE_STYLE_FILL_AREA_List = "#$EntityCounter";
        $SURFACE_STYLE_FILL_AREA = "
        #$EntityCounter = SURFACE_STYLE_FILL_AREA($Fill_Area_Style_List);";
        $CONE_FRAME = $CONE_FRAME.$SURFACE_STYLE_FILL_AREA;
        $EntityCounter++;
        //Surface Side Style
        $SURFACE_SIDE_STYLE_List = "#$EntityCounter";
        $SURFACE_SIDE_STYLE = "
        #$EntityCounter = SURFACE_SIDE_STYLE('',($SURFACE_STYLE_FILL_AREA_List));";
        $CONE_FRAME = $CONE_FRAME.$SURFACE_SIDE_STYLE;
        $EntityCounter++;
        //Surface Style Usage
        $SURFACE_STYLE_USAGE_List = "#$EntityCounter";
        $SURFACE_STYLE_USAGE = "
        #$EntityCounter = SURFACE_STYLE_USAGE(.BOTH.,$SURFACE_SIDE_STYLE_List);";
        $CONE_FRAME = $CONE_FRAME.$SURFACE_STYLE_USAGE;
        $EntityCounter++;
        //PRESENTATION_STYLE_ASSIGNMENT
        $PRESENTATION_STYLE_ASSIGNMENT_List = "#$EntityCounter";
        $PRESENTATION_STYLE_ASSIGNMENT = "
        #$EntityCounter = PRESENTATION_STYLE_ASSIGNMENT(($SURFACE_STYLE_USAGE_List));";
        $CONE_FRAME = $CONE_FRAME.$PRESENTATION_STYLE_ASSIGNMENT;
        $EntityCounter++;
        //STYLED_ITEM
        $STYLED_ITEM_List = "#$EntityCounter";
        $STYLED_ITEM = "
        #$EntityCounter = STYLED_ITEM('',( $PRESENTATION_STYLE_ASSIGNMENT_List),$SHELL_BASED_SURFACE_MODEL_List);";
        $CONE_FRAME = $CONE_FRAME.$STYLED_ITEM;
                                                                        //zuordnen zu Ausgabe für weitere Verwendung
        $EntityCounter++;

        $Frame_List[0] = $SHELL_BASED_SURFACE_MODEL_List;
        $Frame_List[1] = $STYLED_ITEM_List;  
        $Step_Output = $Step_Output.$CONE_FRAME;



        //if ($Objekt == "Blatt" and $includeRoot == "nein"){                             //Abfrage ob Step File beendet und Header gebildet wird, oder ob noch Daten folgen
        //$STEPFRAME = Step_Frame($Surface_Frame_Entities, $Spline_Entities);
        //$Step_Output = $STEPFRAME[0].$STEPFRAME[1].$Step_Output.$STEPFRAME[2];          //zusammenfügen von Header, Grundgerüst und Ende
        //file_put_contents("Output.stp", $Step_Output);                                 // Output als stp
        //}
        return ($Frame_List);
    }
    private function SplineEntity_Line($Name,  $Points,  $u,  $numberofcontrolpointsx,  $xKnotVector){ //Erstellung Step Spline Befehle (nur für Linien)
        /*

        Autor:			Helix-Design

        Programmname:	Surface_Frame

        Modulname:		StepPostProcessor.php

        Änderungsstand:	17.06.2021

        Namenskürzel:	PM	


        Beschreibung:	erstellt die Befehle (Entities) für Splines (wird für Linien, wie z.B. CAM aufgerufen)
                        

        Der Programmablauf kommt von:		StepPostProcessor.php


        Benötigte Werte:			$Name,  $Points,  $u,  $numberofcontrolpointsx,  $xKnotVector

        Der Programmablauf wird übergeben an:	StepPostProcessor


        Übergebene Werte:			Spline-Entities

        -------------------------------------------------------------------------------------
        */


        //erstellt einen Spline nur als Abfolge einer Punktreihe

        global $EntityCounter;
        global $Step_Output;

        $xKnots = $xKnotVector[0];
        $xKnotMultiplicator = $xKnotVector[1];




        //Kontrollpunktliste der Splines in y-Richtung


            $Controlpoint_Lists ="(";
            for ($i = 0; $i < $numberofcontrolpointsx; $i++){
                if ($i < $numberofcontrolpointsx-1){
                    $Controlpoint_Lists =  $Controlpoint_Lists.$Points[0][$i][4].",";
                }
                else{
                    $Controlpoint_Lists =  $Controlpoint_Lists.$Points[0][$i][4]; 
                }
            }
            $Controlpoint_Lists=$Controlpoint_Lists.")"; 






        //erstellen der B-Spline Entities

        $B_SPLINE = "";
        $u = $u-1;


            
                                                        //Splines in u-Richtung
            $Controlpoints = $Controlpoint_Lists;                           
            $Spline_List[0][0] = "#$EntityCounter";                                               //Array mit Spline Informationen
            $Spline_List[0][1] = "$Name-Spline";
            $Spline_List[0][2] = $u;
            $Spline_List[0][3] = $Controlpoints;
            $Spline_List[0][4] = $xKnots;
            $Spline_List[0][5] = $xKnotMultiplicator;
            $B_SPLINE = $B_SPLINE."                                                                  
        #$EntityCounter = B_SPLINE_CURVE_WITH_KNOTS('$Name-Spline',$u,$Controlpoints,.UNSPECIFIED.,.F.,.F.,$xKnots,$xKnotMultiplicator,.UNSPECIFIED.);";            //Ausgabefertiger String mit Spline Entitites
        
        $EntityCounter++;

        //Layer Assignment
                                                                                                //verschiedene Layer für Hilfslinien

        $a = 3;
        $b = "Hilfsflinien";

        $temp_Entity = $Spline_List[0][0];
        $Layer_Assigment_List = "#$EntityCounter";
        $PRESENTATION_LAYER_ASSIGNMENT = "
        #$EntityCounter =PRESENTATION_LAYER_ASSIGNMENT('$b','Layer $a',($temp_Entity));";
        //$SURFACE_FRAME = $SURFACE_FRAME.$PRESENTATION_LAYER_ASSIGNMENT;
        $EntityCounter++;

        $EntityCounter++;
            
        $Step_Output = $Step_Output.$B_SPLINE.$PRESENTATION_LAYER_ASSIGNMENT;
        return ($Spline_List);
    }
            
}


