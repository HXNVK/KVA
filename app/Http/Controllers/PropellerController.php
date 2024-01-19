<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use DB;
use Carbon\Carbon;

use App\Models\Artikel01Propeller;
use App\Models\Artikel02Modell;
use App\Models\PropellerForm;
use App\Models\Propeller;
use App\Models\PropellerModellBlatt;
use App\Models\PropellerModellBlattTyp;
use App\Models\PropellerModellWurzel;
use App\Models\PropellerDurchmesser;
use App\Models\PropellerWinkel;
use App\Models\MyFactoryTransferArtikel;


class PropellerController extends Controller
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
        if(request()->has('artikelkreis')){
            
            $artikelkreis = request('artikelkreis');

            $propellerObjects = Propeller::sortable()
                                        ->where('name','like',"$artikelkreis%")
                                        ->orderBy('name', 'asc')
                                        ->paginate(15)
                                        ->appends('name', 'like', "$artikelkreis%");
        }
        elseif(request()->has('suche')){
            $suche = request('suche');

            $propellerObjects = Propeller::sortable()
                                        ->where('name','like',"%$suche%")
                                        ->orWhere('artikelnummer','like',"%$suche%")
                                        ->orderBy('name', 'asc')
                                        ->paginate(15)
                                        ->appends('name', 'like', "%$suche%");
        }
        else{
            $propellerObjects = Propeller::orderBy('name','asc')->paginate(15);  
        }

        

        return view('propeller.index',compact('propellerObjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $artikel_01PropellerObj = Artikel01Propeller::orderBy('name','asc')
                                                    //->where('blattanzahl','>',"1")
                                                    ->where('inaktiv', '=', "0")
                                                    ->get();

        $propellerObj = Propeller::orderBy('name','asc')->pluck('name');
        $propellerModellBlattTypen = PropellerModellBlattTyp::orderBy('text','asc')->get();


        // $propellerFormenTEST = PropellerForm::select('propeller_formen.*')
        //                                     ->join('propeller_modell_wurzeln','propeller_formen.propeller_modell_wurzel_id','=', 'propeller_modell_wurzeln.id')
        //                                     ->where('propeller_klasse_geometrie_id','=', '2')  //id '2' => GF30-0
        //                                     ->orderBy('propeller_formen.name_kurz', 'asc')
        //                                     ->pluck('propeller_formen.name_kurz','propeller_formen.id'); 

        // $test = json_encode($propellerFormenTEST);

        //dd($propellerModellBlattTypen);

        return view('propeller.create',compact(
                                        'artikel_01PropellerObj',
                                        'propellerObj',
                                        'propellerModellBlattTypen'
                                    ));
    }

    public function propellerFormAjax($id)
    {
        // if($id == 21){
        //     $id = 20;
        // }

        $propellerFormen = PropellerForm::select('propeller_formen.*')
                                            ->join('propeller_modell_wurzeln','propeller_formen.propeller_modell_wurzel_id','=', 'propeller_modell_wurzeln.id')
                                            ->where('propeller_klasse_geometrie_id','=', $id)  //id '2' => GF30-0
                                            ->where('propeller_formen.inaktiv', '=', NULL)
                                            ->orderBy('propeller_formen.name_kurz', 'asc')
                                            ->pluck('propeller_formen.id','propeller_formen.name_kurz');   
                                            
                                                                    
        return json_encode($propellerFormen);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        
        if($request->input('konkurrenzPropeller') == NULL){


            $this->validate($request,[
                'artikel_01Propeller' => 'required',
                'propeller_form' => 'required',
                'winkel' => 'nullable|numeric',
                'notiz' => 'string|max:100|nullable'
                ]);
        


            $artikel_01Propeller = explode(',', $request->input('artikel_01Propeller'));
            $propeller_klasse_geometrie_id = $artikel_01Propeller[0];    //output 1
            $artikel_01Propeller_id = $artikel_01Propeller[1];           //output 107

            $propeller_form_id = $request->input("propeller_form");

        
            $propeller = Propeller::pluck('name');        
            $propellerForm = PropellerForm::find($propeller_form_id);
            $artikel01Propeller = Artikel01Propeller::find($artikel_01Propeller_id);
            $artikel02Modell = Artikel02Modell::pluck('name');
            $propellerModellBlatt = PropellerModellBlatt::find($propellerForm->propeller_modell_blatt_id);
            $propellerModellWurzel = PropellerModellWurzel::find($propellerForm->propeller_modell_wurzel_id);




            // Ermittlung Propellername Besp.: "H30F 1.25m L-NM-07-2" anhand der Formenliste und Artikel01Propeller
            $basisFestigkeitsklasse = $artikel01Propeller->propellerKlasseGeometrie->basis_festigkeitsklasse;                       /**Ermittlung des Durchmessers "26" */
            $spezGeometrieform = $artikel01Propeller->spez_geometrieform;                                                           /**Ermittlung des Durchmessers "F" */
            $spezModellBlatt = substr($propellerForm->propellerModellBlatt->name,8);
            
            $durchmesser = number_format(2*($propellerModellBlatt->bereichslaenge + $propellerModellWurzel->bereichslaenge)/1000,2); /**Ermittlung des Durchmessers "2.20" */
            $drehrichtung = $propellerModellBlatt->propellerDrehrichtung->name;                                                      /**Ermittlung der Drehrichtung "R" */
            $blattmodelltyp = $propellerModellBlatt->propellerModellBlattTyp->text;                                                  /**Ermittlung des Modelltyp "LTM" */

            //dd($blattmodelltyp);
            $propellerWinkel = $request->input('winkel');
            if($propellerWinkel != NULL){
                $propellerWinkel = number_format($request->input('winkel'),0);
            }else{
                $propellerWinkel = number_format($propellerModellBlatt->winkel + $propellerModellWurzel->winkel,0);
                if($propellerWinkel<10){
                    $propellerWinkel =sprintf("%02d",$propellerWinkel,0); /**Formatiert zahlen kleiner Zehn auf "08" */
                }
            }

            if($propellerModellWurzel->konuswinkel != NULL){
                $konuswinkel = sprintf("%02d",number_format($propellerModellWurzel->konuswinkel,0)); 
            }
            else{
                $konuswinkel = NULL; 
            }
            

            $blattanzahl = $artikel01Propeller->blattanzahl;

            //dd($spezGeometrieform);
            // if(Str::of($propellerForm->name_kurz)->contains('A/V')){
            //     $spezModellBlatt = Str::of(substr($propellerForm->name_kurz,7))->trim();
            // }else{
            //     $spezModellBlatt = Str::of(substr($propellerForm->name_kurz,5))->trim();
            // }

            $h60aTyp = null;
            
            if(Str::of($artikel01Propeller->name)->contains('H60A') 
            || Str::of($artikel01Propeller->name)->contains('H40A')){
                if(Str::of($artikel01Propeller->name)->contains('Hydraulik')){
                    $h60aTyp = 'hydr';
                }
                if(Str::of($artikel01Propeller->name)->contains('Automatik')){
                    $h60aTyp = 'aut';
                }
                if(Str::of($artikel01Propeller->name)->contains('EXT')){
                    $h60aTyp = 'ext';
                }
            }

            if(Str::of($spezModellBlatt)->contains('NC')){
                // $spezModellBlatt = Str::of($spezModellBlatt)->rtrim('NC');
                // $spezModellBlatt = Str::of($spezModellBlatt)->trim(); 
                            
                if($artikel01Propeller->blattanzahl > 1){
                    if($spezGeometrieform == 'A' || $spezGeometrieform == 'F' || $spezGeometrieform == 'K' || $spezGeometrieform == 'B' ){
                        $name = "H$basisFestigkeitsklasse"."$spezGeometrieform $durchmesser"."m $drehrichtung"."$blattmodelltyp"."$propellerWinkel-$blattanzahl / NC";
                        //dd($name);
                    }
                    if($spezGeometrieform == 'V'){
                        $name = "H$basisFestigkeitsklasse"."$spezGeometrieform $durchmesser"."m $drehrichtung"."$blattmodelltyp"."$blattanzahl / NC";
                        //dd($name);
                    }
                }
                else{
                    if($spezGeometrieform == 'A' || $spezGeometrieform == 'F' || $spezGeometrieform == 'K' || $spezGeometrieform == 'B' ){
                        $name = "H$basisFestigkeitsklasse"."$spezGeometrieform $durchmesser"."m $drehrichtung"."$blattmodelltyp"."$propellerWinkel / NC";
                        //dd($name);
                    }
                    if($spezGeometrieform == 'V'){
                        $name = "H$basisFestigkeitsklasse"."$spezGeometrieform $durchmesser"."m $drehrichtung"."$blattmodelltyp / NC";
                        //dd($name);
                    }
                }

                $nc_indikator = 1;
            }else{
                //$spezModellBlatt = Str::of($spezModellBlatt)->trim(); 

                //dd($spezModellBlatt);

                if($artikel01Propeller->blattanzahl > 1){
                    if($spezGeometrieform == 'V'){
                        if($basisFestigkeitsklasse == 60){
                            $name = "H$basisFestigkeitsklasse"."$spezGeometrieform $durchmesser"."m $drehrichtung"."$blattmodelltyp"."$propellerWinkel-$blattanzahl";
                        }else{
                            $name = "H$basisFestigkeitsklasse"."$spezGeometrieform $durchmesser"."m $drehrichtung"."$blattmodelltyp"."$blattanzahl";
                        }
                    }
                    if($spezGeometrieform == 'A' || $spezGeometrieform == 'F' || $spezGeometrieform == 'K'|| $spezGeometrieform == 'B'){
                        if($konuswinkel == NULL){
                            if($artikel01Propeller->id == 136 || $artikel01Propeller->id == 204){                                                                  //id 136 = Propeller H30F-2x2 ; id 204 = Propeller H25F-2x2
                                $name = "H$basisFestigkeitsklasse"."$spezGeometrieform $durchmesser"."m $drehrichtung"."$blattmodelltyp"."$propellerWinkel-2x2";
                            }
                            else{
                                $name = "H$basisFestigkeitsklasse"."$spezGeometrieform $durchmesser"."m $drehrichtung"."$blattmodelltyp"."$propellerWinkel-$blattanzahl";
                            }
                        }
                        else{
                            if($artikel01Propeller->id == 136 || $artikel01Propeller->id == 204){                                                                  //id 136 = Propeller H30F-2x2 ; id 204 = Propeller H25F-2x2
                                $name = "H$basisFestigkeitsklasse"."$spezGeometrieform $durchmesser"."m $drehrichtung"."$blattmodelltyp"."$propellerWinkel-$konuswinkel-2x2";
                            }
                            else{
                                $name = "H$basisFestigkeitsklasse"."$spezGeometrieform $durchmesser"."m $drehrichtung"."$blattmodelltyp"."$propellerWinkel-$konuswinkel-$blattanzahl";
                            }
                        }
                    }
                    
                }
                else{
                    if($spezGeometrieform == 'V'){
                        if($basisFestigkeitsklasse == 60){
                            $name = "H$basisFestigkeitsklasse"."$spezGeometrieform $durchmesser"."m $drehrichtung"."$blattmodelltyp"."$propellerWinkel";
                        }else{
                            $name = "H$basisFestigkeitsklasse"."$spezGeometrieform $durchmesser"."m $drehrichtung"."$blattmodelltyp";
                        }
                        //dd($name);
                    }
                    if($spezGeometrieform == 'A' || $spezGeometrieform == 'F' || $spezGeometrieform == 'K'|| $spezGeometrieform == 'B'){
                        if($artikel01Propeller->id == 136 || $artikel01Propeller->id == 204){ 
                            $name = "H$basisFestigkeitsklasse"."$spezGeometrieform $durchmesser"."m $drehrichtung"."$blattmodelltyp"."$propellerWinkel";
                        }
                        else{
                            $name = "H$basisFestigkeitsklasse"."$spezGeometrieform $durchmesser"."m $drehrichtung"."$blattmodelltyp"."$propellerWinkel";
                        }
                    }
                }

                $nc_indikator = 0;
            }

            //dd($name);

            if($h60aTyp != null){
                $name = "$name / $h60aTyp";
            }
            // Ermittlung Artikel ModelCode der Bausteine Durchmesser, Drehrichtung, Typ und Winkel
            $durchmesser = number_format(2*($propellerModellBlatt->bereichslaenge + $propellerModellWurzel->bereichslaenge)/1000,2);
            $artikelCode_durchmesser = PropellerDurchmesser::where('wert',$durchmesser)->pluck('artikel_modelcode');

            //dd($durchmesser);

            $artikelCode_drehrichtung = $propellerModellBlatt->propellerDrehrichtung->artikel_modelcode;


            $artikelCode_typ = $propellerModellBlatt->propellerModellBlattTyp->artikel_modelcode;

            $artikelCode_winkel = PropellerWinkel::where('wert',$propellerWinkel)->pluck('artikel_modelcode');
            $artikelcode = "".$artikelCode_durchmesser[0]."-$artikelCode_drehrichtung-$artikelCode_typ-".$artikelCode_winkel[0]."";
            
            // Check ob Propeller bereits angelegt wurde
            if($propeller->contains($name)){
                return back()->withInput()->withErrors(["Propeller bereits vorhanden !!!"]);        
            }

            // Ermittlung Artikelnummer aus Artikel01Propeller und Propeller Tabelle
            $artikelnummer = "$artikel01Propeller->artikelnummer-$artikelcode";
            if($konuswinkel == NULL){
                $artikelname = "$spezModellBlatt"."$propellerWinkel";
            }
            else{
                $artikelname = "$spezModellBlatt"."$propellerWinkel-$konuswinkel";
            }

            $propeller = new Propeller;

            $propeller->name = $name;
            $propeller->artikel_01Propeller_id = $artikel_01Propeller_id;
            $propeller->propeller_form_id = $propeller_form_id;
            $propeller->winkel = $propellerWinkel;
            $propeller->artikelnummer = $artikelnummer;
            $propeller->NC = $nc_indikator;
            $propeller->notiz = $request->input("notiz");
            $propeller->user_id = auth()->user()->id;
            $propeller->save();



            // //Abspeichern von Propellern in MyFactory Transfertabelle
            // $propellerID = Propeller::where('artikelnummer', $artikelnummer)->pluck('id');
            // $propellerKVAId = $propellerID[0];

            // $datumHeute = Carbon::now()->format('Y-m-d H:i:s');

            // $myF_TransferArtikel = new MyFactoryTransferArtikel;
            // $myF_TransferArtikel->Origin = "helix";
            // $myF_TransferArtikel->RecordDate = $datumHeute;
            // $myF_TransferArtikel->BaseUnit = "Stk";
            // $myF_TransferArtikel->BaseDecimals = 0;
            // $myF_TransferArtikel->ProductGroup = "Propeller";
            // $myF_TransferArtikel->Name1 = $name;
            // $myF_TransferArtikel->ProductLength = 0.000;
            // $myF_TransferArtikel->ProductWidth = 0.000;
            // $myF_TransferArtikel->ProductHeight = 0.000;
            // $myF_TransferArtikel->ProductWeight = 0.000;
            // $myF_TransferArtikel->Attr_Hel_KVAID =  $propellerKVAId;
            // $myF_TransferArtikel->Attr_Hel_KVAArt = $artikelnummer;
            // $myF_TransferArtikel->InActive  = 0;
            // $myF_TransferArtikel->Flag  = 0;
            // $myF_TransferArtikel->save();

            
            if($artikel02Modell->contains($artikelname)){
                
            }else{
                $artikel02Model = new Artikel02Modell;
                $artikel02Model->name = $artikelname;
                $artikel02Model->artikelcode = $artikelcode;
                $artikel02Model->user_id = auth()->user()->id;
                $artikel02Model->save();
            }

        }
        else{
            //dd($request->input('konkurrenzPropeller'));
            // $this->validate($request,[
            //     'konkurrenzPropeller' => 'string|max:100|unique:propeller'
            //     ]);

            $name = $request->input('konkurrenzPropeller');
            $artikel_01Propeller_id = 666;
            $propeller_form_id = 6666;

            $propellerWinkel = 0;
            $artikelnummer = 0-0-0;
            $nc_indikator = 0;


            $propeller = new Propeller;

            $propeller->name = $name;
            $propeller->artikel_01Propeller_id = $artikel_01Propeller_id;
            $propeller->propeller_form_id = $propeller_form_id;
            $propeller->winkel = $propellerWinkel;
            $propeller->artikelnummer = $artikelnummer;
            $propeller->NC = $nc_indikator;
            $propeller->notiz = $request->input("notiz");
            $propeller->user_id = auth()->user()->id;
            $propeller->save();

        }
        
        //dd($name);



        //return response()->json(['error'=>$validator->errors()->all()]);
        return redirect("/propeller")->with('success', "Artikel $propeller->name gespeichert!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $propeller = Propeller::find($id);
        // $allePropeller = Propeller::orderBy('id', 'desc')->get();

        // foreach($allePropeller as $propeller){
        //     $propellerForm = PropellerForm::find($propeller->propeller_form_id);
        //     $propellerModellBlatt = PropellerModellBlatt::find($propellerForm->propeller_modell_blatt_id);
        //     $propellerModellWurzel = PropellerModellWurzel::find($propellerForm->propeller_modell_wurzel_id);

        //     $propellerWinkel = number_format($propellerModellBlatt->winkel + $propellerModellWurzel->winkel,0);

        //     //dd($propellerWinkel);
        //     $propeller->winkel = $propellerWinkel;
        //     $propeller->save();
        // }


        // //dd($allePropeller);


        // return view('propeller.show',compact(
        //                                 'propeller'
        //                                 ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $propeller = Propeller::find($id);
        $propellerFormen = PropellerForm::orderBy('name','asc')->get();
        $artikel_01PropellerObj = Artikel01Propeller::orderBy('name','asc')
                                                    //->where('blattanzahl','>',"1")
                                                    ->where('inaktiv', '=', "0")
                                                    ->get();
        

        return view('propeller.edit',compact(
                                                'propeller',
                                                'propellerFormen',
                                                'artikel_01PropellerObj'
                                                ));
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
            'artikel_01Propeller_id' => 'required',
            'propellerForm_id' => 'required',
            'winkel' => 'nullable|numeric',
            'notiz' => 'string|max:100|nullable'
            ]);
        
        $propeller = Propeller::pluck('name');        
        $propellerForm = PropellerForm::find($request->input('propellerForm_id'));
        $artikel01Propeller = Artikel01Propeller::find($request->input('artikel_01Propeller_id'));
        $artikel02Modell = Artikel02Modell::pluck('name');
        $propellerModellBlatt = PropellerModellBlatt::find($propellerForm->propeller_modell_blatt_id);
        $propellerModellWurzel = PropellerModellWurzel::find($propellerForm->propeller_modell_wurzel_id);


        $propellerWinkel = $request->input('winkel');
        if($propellerWinkel != NULL){
            $propellerWinkel = number_format($request->input('winkel'),0);
        }else{
            $propellerWinkel = number_format($propellerModellBlatt->winkel + $propellerModellWurzel->winkel,0);
            if($propellerWinkel<10){
                $propellerWinkel =sprintf("%02d",$propellerWinkel,0); /**Formatiert zahlen kleiner Zehn auf "08" */
            }
        }

        // Ermittlung Propellername Besp.: "H30F 1.25m L-NM-07-2" anhand der Formenliste und Artikel01Propeller
        $basisFestigkeitsklasse = $artikel01Propeller->propellerKlasseGeometrie->basis_festigkeitsklasse;                       /**Ermittlung des Durchmessers "26" */
        $spezGeometrieform = $artikel01Propeller->spez_geometrieform;                                                           /**Ermittlung des Durchmessers "F" */
        $spezModellBlatt = substr($propellerForm->propellerModellBlatt->name,8);
        
        $durchmesser = number_format(2*($propellerModellBlatt->bereichslaenge + $propellerModellWurzel->bereichslaenge)/1000,2); /**Ermittlung des Durchmessers "2.20" */
        $drehrichtung = $propellerModellBlatt->propellerDrehrichtung->name;                                                      /**Ermittlung der Drehrichtung "R" */
        $blattmodelltyp = $propellerModellBlatt->propellerModellBlattTyp->text;                                                  /**Ermittlung des Modelltyp "LTM" */

        $propellerWinkel = $request->input('winkel');
        if($propellerWinkel != NULL){
            $propellerWinkel = number_format($request->input('winkel'),0);
        }else{
            $propellerWinkel = number_format($propellerModellBlatt->winkel + $propellerModellWurzel->winkel,0);
            if($propellerWinkel<10){
                $propellerWinkel =sprintf("%02d",$propellerWinkel,0); /**Formatiert zahlen kleiner Zehn auf "08" */
            }
        }

        $blattanzahl = $artikel01Propeller->blattanzahl;

        //dd($spezGeometrieform);
        // if(Str::of($propellerForm->name_kurz)->contains('A/V')){
        //     $spezModellBlatt = Str::of(substr($propellerForm->name_kurz,7))->trim();
        // }else{
        //     $spezModellBlatt = Str::of(substr($propellerForm->name_kurz,5))->trim();
        // }

        $h60aTyp = null;
        
        if(Str::of($artikel01Propeller->name)->contains('H60A')){
            if(Str::of($artikel01Propeller->name)->contains('Hydraulik')){
                $h60aTyp = 'hydr';
            }
            if(Str::of($artikel01Propeller->name)->contains('Automatik')){
                $h60aTyp = 'aut';
            }
            if(Str::of($artikel01Propeller->name)->contains('EXT')){
                $h60aTyp = 'ext';
            }
        }

        if(Str::of($spezModellBlatt)->contains('NC')){
            // $spezModellBlatt = Str::of($spezModellBlatt)->rtrim('NC');
            // $spezModellBlatt = Str::of($spezModellBlatt)->trim(); 
                        
            if($artikel01Propeller->blattanzahl > 1){
                if($spezGeometrieform == 'A' || $spezGeometrieform == 'F' || $spezGeometrieform == 'K'){
                    $name = "H$basisFestigkeitsklasse"."$spezGeometrieform $durchmesser $drehrichtung"."$blattmodelltyp-$propellerWinkel-$blattanzahl / NC";
                    //dd($name);
                }
                if($spezGeometrieform == 'V'){
                    $name = "H$basisFestigkeitsklasse"."$spezGeometrieform $durchmesser $drehrichtung"."$blattmodelltyp-$blattanzahl / NC";
                    //dd($name);
                }
            
            $nc_indikator = 1;
            }
        }else{
            //$spezModellBlatt = Str::of($spezModellBlatt)->trim(); 

            //dd($spezModellBlatt);

            if($artikel01Propeller->blattanzahl > 1){
                if($spezGeometrieform == 'V'){
                    if($basisFestigkeitsklasse == 60){
                        $name = "H$basisFestigkeitsklasse"."$spezGeometrieform $durchmesser $drehrichtung"."$blattmodelltyp-$propellerWinkel-$blattanzahl";
                    }else{
                        $name = "H$basisFestigkeitsklasse"."$spezGeometrieform $durchmesser $drehrichtung"."$blattmodelltyp-$blattanzahl";
                    }
                    //dd($name);
                }
                if($spezGeometrieform == 'A' || $spezGeometrieform == 'F' || $spezGeometrieform == 'K'|| $spezGeometrieform == 'B'){
                    if($artikel01Propeller->id == 136 || $artikel01Propeller->id == 204){ 
                        $name = "H$basisFestigkeitsklasse"."$spezGeometrieform $durchmesser"."m $drehrichtung"."$blattmodelltyp-$propellerWinkel-2x2";
                    }
                    else{
                        $name = "H$basisFestigkeitsklasse"."$spezGeometrieform $durchmesser"."m $drehrichtung"."$blattmodelltyp"."$propellerWinkel-$blattanzahl";
                    }
                        
                    //dd($name);
                }
            
            $nc_indikator = 0;
            }
        }

        //dd($name);

        if($h60aTyp != null){
            $name = "$name / $h60aTyp";
        }
        // Ermittlung Artikel ModelCode der Bausteine Durchmesser, Drehrichtung, Typ und Winkel
        $durchmesser = number_format(2*($propellerModellBlatt->bereichslaenge + $propellerModellWurzel->bereichslaenge)/1000,2);
        $artikelCode_durchmesser = PropellerDurchmesser::where('wert',$durchmesser)->pluck('artikel_modelcode');

        //dd($durchmesser);

        $artikelCode_drehrichtung = $propellerModellBlatt->propellerDrehrichtung->artikel_modelcode;


        $artikelCode_typ = $propellerModellBlatt->propellerModellBlattTyp->artikel_modelcode;

        $artikelCode_winkel = PropellerWinkel::where('wert',$propellerWinkel)->pluck('artikel_modelcode');
        $artikelcode = "".$artikelCode_durchmesser[0]."-$artikelCode_drehrichtung-$artikelCode_typ-".$artikelCode_winkel[0]."";
        
        // Check ob Propeller bereits angelegt wurde
        if($propeller->contains($name)){
            return back()->withInput()->withErrors(["Propeller bereits vorhanden !!!"]);        
        }

        // Ermittlung Artikelnummer aus Artikel01Propeller und Propeller Tabelle
        $artikelnummer = "$artikel01Propeller->artikelnummer-$artikelcode";
        $artikelname = "$spezModellBlatt"."$propellerWinkel";

        //dd($artikelname);
        
        $propeller = Propeller::find($id);

        //dd($propeller);

        $propeller->name = $name;
        $propeller->artikel_01Propeller_id = $request->input('artikel_01Propeller_id');
        $propeller->propeller_form_id = $request->input('propellerForm_id');
        $propeller->winkel = $propellerWinkel;
        $propeller->artikelnummer = $artikelnummer;
        $propeller->NC = $nc_indikator;
        $propeller->notiz = $request->input("notiz");
        $propeller->user_id = auth()->user()->id;
        $propeller->save();
        
        //return response()->json(['error'=>$validator->errors()->all()]);
        return redirect("/propeller")->with('success', "Artikel $propeller->name überarbeitet!");
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
}
