<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use DB;


use App\Models\Kunde;
use App\Models\Fluggeraet;
use App\Models\Projekt;
use App\Models\ProjektGeraeteklasse;
use App\Models\ProjektKategorie;
use App\Models\ProjektTyp;
use App\Models\ProjektStatus;
use App\Models\ProjektZertifizierung;
use App\Models\ProjektPropeller;
use App\Models\Propeller;
use App\Models\Motor;
use App\Models\MotorGetriebe;
use App\Models\MotorFlansch;
use App\Models\MotorAusrichtung;
use App\Models\Artikel03Ausfuehrung;
use App\Models\PropellerDurchmesser;



class ProjekteController extends Controller
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
        if(request()->has('geraeteklasse_id')){
            
            $geraeteklasse = request('geraeteklasse_id');

            $projekte = Projekt::sortable()
            ->where('projekt_geraeteklasse_id','like',"%$geraeteklasse%")
            ->orderBy('name', 'asc')
            ->paginate(15)
            ->appends('name', 'like', "%$geraeteklasse%");
        }
        elseif(request()->has('suche')){
            
            $suche = request('suche');

            $projekte = Projekt::sortable()
            ->where('name','like',"%$suche%")
            ->orderBy('name', 'asc')
            ->paginate(15)
            ->appends('name', 'like', "%$suche%");
        }
        else{
            $projekte = Projekt::sortable()
            ->orderBy('name','asc')
            ->paginate(15); 
        }


        return view('projekte.index',compact('projekte'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kunde_id = request('kundenId');
        $kunde = Kunde::find($kunde_id);

        $kunden = Kunde::orderBy('name1','asc')->get();
        $fluggeraete = Fluggeraet::orderBy('name','asc')->get();
        $projektGeraeteklassen = ProjektGeraeteklasse::orderBy('name','asc')->get();
        $projektKategorien = ProjektKategorie::orderBy('name','asc')->get();
        $projektTypen = ProjektTyp::orderBy('name','asc')->get();
        $projektStatusObjects = ProjektStatus::orderBy('name','asc')->get();
        $projektZertifizierungen = ProjektZertifizierung::orderBy('name','asc')->get();
        // $motorGetriebeObjects = MotorGetriebe::orderBy('name','asc')->get();
        $motorFlansche = MotorFlansch::orderBy('name_lang','asc')->get();
        $motorAusrichtungen = MotorAusrichtung::orderBy('name','asc')->get();

        $motoren = DB::table('motoren')
        ->select(
                DB::raw('motoren.id as id'),
                DB::raw('motoren.name as name'),
                DB::raw('motoren.kunde_id as kundeID'),
                DB::raw('kunden.matchcode as kunde'),
                )
        ->join('kunden','motoren.kunde_id','=', 'kunden.id')
        ->orderBy('kunde')
        ->orderBy('name', 'asc')
        ->get();

        //dd($motoren);
        return view('projekte.create',
                    compact(
                        'kunde_id',
                        'kunde',
                        'kunden',
                        'fluggeraete',
                        'projektGeraeteklassen',
                        'projektKategorien',
                        'projektTypen',
                        'projektStatusObjects',
                        'projektZertifizierungen',
                        'motoren',
                        //'motorGetriebeObjects',
                        'motorFlansche',
                        'motorAusrichtungen'
                    ))
                .view('projekte.modalGeraeteklasse',
                        compact('projektGeraeteklassen'
                ));
    }
    

    public function flanschAjax($id)
    {
        $motorFlansch = MotorFlansch::where('motor_id',$id)
                                        ->orderBy('name', 'desc')
                                        ->pluck('name','id');          

        return json_encode($motorFlansch);
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
            'kunde_id' => 'required',
            'projekt_geraeteklasse_id' => 'required',
            'beschreibung' => 'min:2|max:20|string|nullable',
            'projekt_kategorie_id' => 'required',
            'projekt_typ_id' => 'required',
            'projekt_status_id' => 'required',
            'notiz' => 'string|max:100|nullable',
            'motor' => 'required',
            // 'motorGetriebe' => 'required',
            'motorFlansch' => 'required'
        ]);

        
        $kunde_id = $request->input("kunde_id");
        $kunde = Kunde::find($kunde_id);
        $fluggeraet = Fluggeraet::find($request->input("fluggeraet_id"));
        $projekte = Projekt::pluck('name');
        $motor = Motor::find($request->input("motor"));
        // $getriebe = MotorGetriebe::find($request->input("motorGetriebe"));
        // $untersetzungszahl = number_format($getriebe->untersetzungszahl,2);
        $geraeteklasse = ProjektGeraeteklasse::find($request->input("projekt_geraeteklasse_id"));

        if($request->input("fluggeraet_id") != NULL){
            // $name_lang ="$kunde->matchcode / $fluggeraet->name / $motor->name / $untersetzungszahl ($geraeteklasse->name)"; 
            $name_lang ="$kunde->matchcode / $fluggeraet->name / $motor->name ($geraeteklasse->name)"; 
        }else{
            //$name_lang ="$kunde->matchcode / $motor->name / $untersetzungszahl ($geraeteklasse->name)";
            $name_lang ="$kunde->matchcode / $motor->name ($geraeteklasse->name)";
        }
        if($request->input("beschreibung") != NULL){
            $name_lang ="$name_lang / ".$request->input("beschreibung").""; 
        }
        

        //dd($name_lang);
        if($projekte->contains($name_lang)){
            return back()->withInput()->withErrors(["Projekt bereits vorhanden !!!"]);        
        }

        $projekt = new Projekt;
        $projekt->kunde_id = $request->input("kunde_id");
        $projekt->beschreibung = $request->input("beschreibung");
        $projekt->projekt_geraeteklasse_id = $request->input("projekt_geraeteklasse_id");
        $projekt->fluggeraet_id = $request->input("fluggeraet_id");
        $projekt->name = $name_lang;
        $projekt->projekt_kategorie_id = $request->input("projekt_kategorie_id");
        $projekt->projekt_typ_id = $request->input("projekt_typ_id");
        $projekt->projekt_status_id = $request->input("projekt_status_id");
        $projekt->notiz = $request->input("notiz");
        $projekt->motor_id = $request->input("motor");
        // $projekt->motor_getriebe_id = $request->input("motorGetriebe");
        $projekt->motor_flansch_id = $request->input("motorFlansch");
        $projekt->user_id = auth()->user()->id;

        $projekt->save();
        
        //return response()->json(['error'=>$validator->errors()->all()]);
        return redirect("/kunden/{$projekt->kunde_id}")->with('success', "Projekt $projekt->name bei Kunde ".$projekt->kunde->matchcode." gespeichert!");
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
        $userId = auth()->user()->id; 
        \Cart::session($userId);
        
        $projekt = Projekt::find($id);
        $kunde = Kunde::find($projekt->kunde->id);
        $fluggeraete = Fluggeraet::orderBy('name','asc')->get();
        $projektGeraeteklassen = ProjektGeraeteklasse::orderBy('name','asc')->get();
        $projektKategorien = ProjektKategorie::orderBy('name','asc')->get();
        $projektTypen = ProjektTyp::orderBy('name','asc')->get();
        $projektStatusObjects = ProjektStatus::orderBy('name','asc')->get();
        $projektZertifizierungen = ProjektZertifizierung::orderBy('name','asc')->get();
        
        $motorFlansche = MotorFlansch::where('motor_id',$projekt->motor_id)->orderBy('name_lang','asc')->get();

        $motorAusrichtungen = MotorAusrichtung::orderBy('name','asc')->get();

        $motorGetriebeObjects = MotorGetriebe::where('motor_id',$projekt->motor_id)->orderBy('name','asc')->get();
        //dd($projekt->motor->id);

        $motoren = DB::table('motoren')
        ->select(
                DB::raw('motoren.id as id'),
                DB::raw('motoren.name as name'),
                DB::raw('motoren.kunde_id as kundeID'),
                DB::raw('kunden.matchcode as kunde'),
                )
        ->join('kunden','motoren.kunde_id','=', 'kunden.id')
        ->orderBy('kunde')
        ->orderBy('name', 'asc')
        ->get();

        $propellerDurchmesserObjects = PropellerDurchmesser::orderBy('name', 'asc')->get();


        $projektPropellerObjects = ProjektPropeller::select(
                                    'projekt_propeller.id as projektPropellerID',
                                    'projekt_propeller.propeller_gek as propellerGek',
                                    'projekt_propeller.propellerDurchmesser_id as propellerDurchmesserID',
                                    'projekt_propeller.beschreibung as beschreibung',
                                    'projekt_propeller.mp_Vo_drehzahl as mp_Vo_drehzahl',
                                    'projekt_propeller.mp_Vo_schub as mp_Vo_schub',
                                    'projekt_propeller.mp_Vx_drehzahl as mp_Vx_drehzahl',
                                    'projekt_propeller.mp_Vx_steigrate as mp_Vx_steigrate',
                                    'projekt_propeller.mp_Vmax_drehzahl as mp_Vmax_drehzahl',
                                    'projekt_propeller.mp_Vmax_IAS as mp_Vmax_IAS',
                                    'projekt_propeller.mp1_drehzahl as mp1_drehzahl',
                                    'projekt_propeller.mp2_drehzahl as mp2_drehzahl',
                                    'projekt_propeller.mp3_drehzahl as mp3_drehzahl',
                                    'projekt_propeller.mp1_IAS as mp1_IAS',
                                    'projekt_propeller.mp2_IAS as mp2_IAS',
                                    'projekt_propeller.mp3_IAS as mp3_IAS',
                                    'projekt_propeller.notizProduktion as produktionsNotiz',
                                    'projekt_propeller.typenaufkleber as typenaufkleber',
                                    'propeller.id as propellerID',
                                    'propeller.name as propellername',
                                    'propeller.propeller_form_id as propellerFormID',
                                    'projekte.id as projektID',
                                    'projekte.name as projektname',
                                    'artikel_01Propeller.id as artikel_01PropellerID',
                                    'artikel_01Propeller.name as artikel_01PropellerName',
                                    'artikel_01Propeller.preis as artikel_01PropellerPreis',
                                    'artikel_01Propeller.blattanzahl as blattanzahl',
                                    'artikel_03_01Ausfuehrungen.name as ausfuehrung',
                                    'artikel_03_01Ausfuehrungen.preis as ausfuehrungPreis',
                                    'artikel_03_03Farben.text as farbe',
                                    'artikel_03_03Farben.preis as farbePreis',
                                    'artikel_03_05Kantenschuetze.text as kantenschutzband',
                                    'motor_ausrichtungen.name as ausrichtung',
                                    'motor_flansche.name as bohrschema',
                                    'artikel_05Distanzscheiben.name as ds',
                                    'artikel_06_01ASGP.name as asgp',
                                    'artikel_06_02SPGP.name as spgp',
                                    'artikel_06_03SPKP.name as spkp',
                                    'fluggeraete.name as fluggeraet',
                                    'projekt_geraeteklassen.name as geraeteklasse',
                                    'motoren.name as motorname',
                                    'motoren.nenndrehzahl as motorNenndrehzahl',
                                    'motor_getriebe.untersetzungszahl as untersetzung',
                                    'artikel_07_04AP.name as ap',
                                    'propeller_durchmesser.wert as propellerDurchmesser',
                                    'propeller_aufkleber.text as propellerAufkleber'
                                    )
                                    ->join('projekte','projekt_propeller.projekt_id','=', 'projekte.id')
                                    ->join('propeller','projekt_propeller.propeller_id', '=', 'propeller.id')
                                    ->join('artikel_01Propeller', 'propeller.artikel_01Propeller_id', '=', 'artikel_01Propeller.id')
                                    ->leftjoin('artikel_03_01Ausfuehrungen', 'projekt_propeller.artikel_03Ausfuehrung_id', '=', 'artikel_03_01Ausfuehrungen.id')
                                    ->leftjoin('artikel_03_03Farben', 'projekt_propeller.artikel_03Farbe_id', '=', 'artikel_03_03Farben.id')
                                    ->leftjoin('artikel_03_05Kantenschuetze', 'projekt_propeller.artikel_03Kantenschutz_id', '=', 'artikel_03_05Kantenschuetze.id')
                                    ->leftjoin('motoren', 'projekte.motor_id', '=', 'motoren.id')
                                    ->leftjoin('motor_getriebe', 'projekt_propeller.motor_getriebe_id', '=', 'motor_getriebe.id')
                                    ->leftjoin('motor_flansche', 'projekte.motor_flansch_id', '=', 'motor_flansche.id')
                                    ->leftjoin('fluggeraete','projekte.fluggeraet_id','=','fluggeraete.id')
                                    ->leftjoin('projekt_geraeteklassen','projekte.projekt_geraeteklasse_id','=','projekt_geraeteklassen.id')
                                    ->leftjoin('motor_ausrichtungen','fluggeraete.motor_ausrichtung_id', '=', 'motor_ausrichtungen.id')
                                    ->leftjoin('artikel_05Distanzscheiben','fluggeraete.artikel_05Distanzscheibe_id', '=', 'artikel_05Distanzscheiben.id')
                                    ->leftjoin('artikel_06_01ASGP','fluggeraete.artikel_06ASGP_id', '=', 'artikel_06_01ASGP.id')
                                    ->leftjoin('artikel_06_02SPGP','fluggeraete.artikel_06SPGP_id', '=', 'artikel_06_02SPGP.id')
                                    ->leftjoin('artikel_06_03SPKP','fluggeraete.artikel_06SPKP_id', '=', 'artikel_06_03SPKP.id')
                                    ->leftjoin('artikel_07_04AP','motor_flansche.artikel_07AP_id', '=', 'artikel_07_04AP.id')
                                    ->leftjoin('propeller_durchmesser','projekt_propeller.propellerDurchmesser_id', '=', 'propeller_durchmesser.id')
                                    ->leftjoin('propeller_aufkleber','projekt_propeller.propeller_aufkleber_id', '=', 'propeller_aufkleber.id')

                                    ->where('projekt_propeller.projekt_id','=', $id)

                                    ->orderBy('untersetzung', 'asc')
                                    ->orderBy('propellername', 'asc')
                                    ->get();


        $RefProjektPropellerObjects = ProjektPropeller::select(
                                        'projekt_propeller.id as projektPropellerID',
                                        'projekt_propeller.propeller_gek as propellerGek',
                                        'projekt_propeller.propellerDurchmesser_id as propellerDurchmesserID',
                                        'projekt_propeller.beschreibung as beschreibung',
                                        'projekt_propeller.mp_Vo_drehzahl as mp_Vo_drehzahl',
                                        'projekt_propeller.mp_Vo_schub as mp_Vo_schub',
                                        'projekt_propeller.mp_Vx_drehzahl as mp_Vx_drehzahl',
                                        'projekt_propeller.mp_Vx_steigrate as mp_Vx_steigrate',
                                        'projekt_propeller.mp_Vmax_drehzahl as mp_Vmax_drehzahl',
                                        'projekt_propeller.mp_Vmax_IAS as mp_Vmax_IAS',
                                        'projekt_propeller.mp1_drehzahl as mp1_drehzahl',
                                        'projekt_propeller.mp2_drehzahl as mp2_drehzahl',
                                        'projekt_propeller.mp3_drehzahl as mp3_drehzahl',
                                        'projekt_propeller.mp1_IAS as mp1_IAS',
                                        'projekt_propeller.mp2_IAS as mp2_IAS',
                                        'projekt_propeller.mp3_IAS as mp3_IAS',
                                        'projekt_propeller.notizProduktion as produktionsNotiz',
                                        'projekt_propeller.typenaufkleber as typenaufkleber',
                                        'propeller.id as propellerID',
                                        'propeller.name as propellername',
                                        'propeller.propeller_form_id as propellerFormID',
                                        'projekte.id as projektID',
                                        'projekte.name as projektname',
                                        'artikel_01Propeller.id as artikel_01PropellerID',
                                        'artikel_01Propeller.name as artikel_01PropellerName',
                                        'artikel_01Propeller.preis as artikel_01PropellerPreis',
                                        'artikel_01Propeller.blattanzahl as blattanzahl',
                                        'artikel_03_01Ausfuehrungen.name as ausfuehrung',
                                        'artikel_03_01Ausfuehrungen.preis as ausfuehrungPreis',
                                        'artikel_03_03Farben.name as farbe',
                                        'artikel_03_03Farben.preis as farbePreis',
                                        'artikel_03_05Kantenschuetze.text as kantenschutzband',
                                        'motor_ausrichtungen.name as ausrichtung',
                                        'motor_flansche.name as bohrschema',
                                        'artikel_05Distanzscheiben.name as ds',
                                        'artikel_06_01ASGP.name as asgp',
                                        'artikel_06_02SPGP.name as spgp',
                                        'artikel_06_03SPKP.name as spkp',
                                        'fluggeraete.name as fluggeraet',
                                        'projekt_geraeteklassen.name as geraeteklasse',
                                        'motoren.name as motorname',
                                        'motoren.nenndrehzahl as motorNenndrehzahl',
                                        'motoren.id as motorID',
                                        'motor_getriebe.untersetzungszahl as untersetzung',
                                        'artikel_07_04AP.name as ap',
                                        'propeller_durchmesser.wert as propellerDurchmesser',
                                        'propeller_aufkleber.text as propellerAufkleber'
                                        )
                                        ->join('projekte','projekt_propeller.projekt_id','=', 'projekte.id')
                                        ->join('propeller','projekt_propeller.propeller_id', '=', 'propeller.id')
                                        ->join('artikel_01Propeller', 'propeller.artikel_01Propeller_id', '=', 'artikel_01Propeller.id')
                                        ->leftjoin('artikel_03_01Ausfuehrungen', 'projekt_propeller.artikel_03Ausfuehrung_id', '=', 'artikel_03_01Ausfuehrungen.id')
                                        ->leftjoin('artikel_03_03Farben', 'projekt_propeller.artikel_03Farbe_id', '=', 'artikel_03_03Farben.id')
                                        ->leftjoin('artikel_03_05Kantenschuetze', 'projekt_propeller.artikel_03Kantenschutz_id', '=', 'artikel_03_05Kantenschuetze.id')
                                        ->leftjoin('motoren', 'projekte.motor_id', '=', 'motoren.id')
                                        ->leftjoin('motor_getriebe', 'projekt_propeller.motor_getriebe_id', '=', 'motor_getriebe.id')
                                        ->leftjoin('motor_flansche', 'projekte.motor_flansch_id', '=', 'motor_flansche.id')
                                        ->leftjoin('fluggeraete','projekte.fluggeraet_id','=','fluggeraete.id')
                                        ->leftjoin('projekt_geraeteklassen','projekte.projekt_geraeteklasse_id','=','projekt_geraeteklassen.id')
                                        ->leftjoin('motor_ausrichtungen','fluggeraete.motor_ausrichtung_id', '=', 'motor_ausrichtungen.id')
                                        ->leftjoin('artikel_05Distanzscheiben','fluggeraete.artikel_05Distanzscheibe_id', '=', 'artikel_05Distanzscheiben.id')
                                        ->leftjoin('artikel_06_01ASGP','fluggeraete.artikel_06ASGP_id', '=', 'artikel_06_01ASGP.id')
                                        ->leftjoin('artikel_06_02SPGP','fluggeraete.artikel_06SPGP_id', '=', 'artikel_06_02SPGP.id')
                                        ->leftjoin('artikel_06_03SPKP','fluggeraete.artikel_06SPKP_id', '=', 'artikel_06_03SPKP.id')
                                        ->leftjoin('artikel_07_04AP','motor_flansche.artikel_07AP_id', '=', 'artikel_07_04AP.id')
                                        ->leftjoin('propeller_durchmesser','projekt_propeller.propellerDurchmesser_id', '=', 'propeller_durchmesser.id')
                                        ->leftjoin('propeller_aufkleber','projekt_propeller.propeller_aufkleber_id', '=', 'propeller_aufkleber.id')
    
                                        ->where('motoren.id','=', $projekt->motor->id)
                                        ->where('projekt_propeller.ergebnis_bewertung','=', 1)

                                        ->orderBy('propellername', 'asc')
                                        ->get();

        if(request()->has('motorGetriebeID')){

            $motorGetriebeID = request('motorGetriebeID');
            $projektPropellerObjects = ProjektPropeller::select(
                                                    'projekt_propeller.id as projektPropellerID', 
                                                    'projekt_propeller.propeller_gek as propellerDurchmesserGek',
                                                    'projekt_propeller.beschreibung as beschreibung',
                                                    'projekt_propeller.mp_Vo_drehzahl as mp_Vo_drehzahl',
                                                    'projekt_propeller.mp_Vo_schub as mp_Vo_schub',
                                                    'projekt_propeller.mp_Vx_drehzahl as mp_Vx_drehzahl',
                                                    'projekt_propeller.mp_Vx_steigrate as mp_Vx_steigrate',
                                                    'projekt_propeller.mp_Vmax_drehzahl as mp_Vmax_drehzahl',
                                                    'projekt_propeller.mp_Vmax_IAS as mp_Vmax_IAS',
                                                    'projekt_propeller.mp1_drehzahl as mp1_drehzahl',
                                                    'projekt_propeller.mp2_drehzahl as mp2_drehzahl',
                                                    'projekt_propeller.mp3_drehzahl as mp3_drehzahl',
                                                    'projekt_propeller.mp1_IAS as mp1_IAS',
                                                    'projekt_propeller.mp2_IAS as mp2_IAS',
                                                    'projekt_propeller.mp3_IAS as mp3_IAS',
                                                    'projekt_propeller.notizProduktion as produktionsNotiz',
                                                    'propeller.id as propellerID',
                                                    'propeller.name as propellername',
                                                    'propeller.propeller_form_id as propellerFormID',
                                                    'projekte.id as projektID',
                                                    'projekte.name as projektname',
                                                    'artikel_01Propeller.id as artikel_01PropellerID',
                                                    'artikel_01Propeller.name as artikel_01PropellerName',
                                                    'artikel_01Propeller.preis as artikel_01PropellerPreis',
                                                    'artikel_01Propeller.blattanzahl as blattanzahl',
                                                    'artikel_03_01Ausfuehrungen.name as ausfuehrung',
                                                    'artikel_03_01Ausfuehrungen.preis as ausfuehrungPreis',
                                                    'artikel_03_03Farben.text as farbe',
                                                    'artikel_03_03Farben.preis as farbePreis',
                                                    'artikel_03_05Kantenschuetze.text as kantenschutzband',
                                                    'motor_ausrichtungen.name as ausrichtung',
                                                    'motor_flansche.name as bohrschema',
                                                    'artikel_05Distanzscheiben.name as ds',
                                                    'artikel_06_01ASGP.name as asgp',
                                                    'artikel_06_02SPGP.name as spgp',
                                                    'artikel_06_03SPKP.name as spkp',
                                                    'fluggeraete.name as fluggeraet',
                                                    'projekt_geraeteklassen.name as geraeteklasse',
                                                    'motoren.name as motorname',
                                                    'motoren.nenndrehzahl as motorNenndrehzahl',
                                                    'motor_getriebe.untersetzungszahl as untersetzung',
                                                    'artikel_07_04AP.name as ap',
                                                    'propeller_durchmesser.wert as propellerDurchmesser',
                                                    'propeller_aufkleber.text as propellerAufkleber'
                                                    )
                                                    ->join('projekte','projekt_propeller.projekt_id','=', 'projekte.id')
                                                    ->join('propeller','projekt_propeller.propeller_id', '=', 'propeller.id')
                                                    ->join('artikel_01Propeller', 'propeller.artikel_01Propeller_id', '=', 'artikel_01Propeller.id')
                                                    ->leftjoin('artikel_03_01Ausfuehrungen', 'projekt_propeller.artikel_03Ausfuehrung_id', '=', 'artikel_03_01Ausfuehrungen.id')
                                                    ->leftjoin('artikel_03_03Farben', 'projekt_propeller.artikel_03Farbe_id', '=', 'artikel_03_03Farben.id')
                                                    ->leftjoin('artikel_03_05Kantenschuetze', 'projekt_propeller.artikel_03Kantenschutz_id', '=', 'artikel_03_05Kantenschuetze.id')
                                                    ->leftjoin('motoren', 'projekte.motor_id', '=', 'motoren.id')
                                                    ->leftjoin('motor_getriebe', 'projekt_propeller.motor_getriebe_id', '=', 'motor_getriebe.id')
                                                    ->leftjoin('motor_flansche', 'projekte.motor_flansch_id', '=', 'motor_flansche.id')
                                                    ->leftjoin('fluggeraete','projekte.fluggeraet_id','=','fluggeraete.id')
                                                    ->leftjoin('projekt_geraeteklassen','projekte.projekt_geraeteklasse_id','=','projekt_geraeteklassen.id')
                                                    ->leftjoin('motor_ausrichtungen','fluggeraete.motor_ausrichtung_id', '=', 'motor_ausrichtungen.id')
                                                    ->leftjoin('artikel_05Distanzscheiben','fluggeraete.artikel_05Distanzscheibe_id', '=', 'artikel_05Distanzscheiben.id')
                                                    ->leftjoin('artikel_06_01ASGP','fluggeraete.artikel_06ASGP_id', '=', 'artikel_06_01ASGP.id')
                                                    ->leftjoin('artikel_06_02SPGP','fluggeraete.artikel_06SPGP_id', '=', 'artikel_06_02SPGP.id')
                                                    ->leftjoin('artikel_06_03SPKP','fluggeraete.artikel_06SPKP_id', '=', 'artikel_06_03SPKP.id')
                                                    ->leftjoin('artikel_07_04AP','motor_flansche.artikel_07AP_id', '=', 'artikel_07_04AP.id')
                                                    ->leftjoin('propeller_durchmesser','projekt_propeller.propellerDurchmesser_id', '=', 'propeller_durchmesser.id')
                                                    ->leftjoin('propeller_aufkleber','projekt_propeller.propeller_aufkleber_id', '=', 'propeller_aufkleber.id')


                                                    ->where('projekt_propeller.projekt_id','=', $id)
                                                    ->where('projekt_propeller.motor_getriebe_id','=', $motorGetriebeID)

                                                    ->orderBy('untersetzung', 'asc')
                                                    ->orderBy('propellername', 'asc')
                                                    ->get();
        }

        if(request()->has('propellerDurchmesserID')){

            $propellerDurchmesserID = request('propellerDurchmesserID');
            $projektPropellerObjects = ProjektPropeller::select(
                                                    'projekt_propeller.id as projektPropellerID', 
                                                    'projekt_propeller.propeller_gek as propellerDurchmesserGek',
                                                    'projekt_propeller.beschreibung as beschreibung',
                                                    'projekt_propeller.mp_Vo_drehzahl as mp_Vo_drehzahl',
                                                    'projekt_propeller.mp_Vo_schub as mp_Vo_schub',
                                                    'projekt_propeller.mp_Vx_drehzahl as mp_Vx_drehzahl',
                                                    'projekt_propeller.mp_Vx_steigrate as mp_Vx_steigrate',
                                                    'projekt_propeller.mp_Vmax_drehzahl as mp_Vmax_drehzahl',
                                                    'projekt_propeller.mp_Vmax_IAS as mp_Vmax_IAS',
                                                    'projekt_propeller.mp1_drehzahl as mp1_drehzahl',
                                                    'projekt_propeller.mp2_drehzahl as mp2_drehzahl',
                                                    'projekt_propeller.mp3_drehzahl as mp3_drehzahl',
                                                    'projekt_propeller.mp1_IAS as mp1_IAS',
                                                    'projekt_propeller.mp2_IAS as mp2_IAS',
                                                    'projekt_propeller.mp3_IAS as mp3_IAS',
                                                    'projekt_propeller.notizProduktion as produktionsNotiz',
                                                    'propeller.id as propellerID',
                                                    'propeller.name as propellername',
                                                    'propeller.propeller_form_id as propellerFormID',
                                                    'projekte.id as projektID',
                                                    'projekte.name as projektname',
                                                    'artikel_01Propeller.id as artikel_01PropellerID',
                                                    'artikel_01Propeller.name as artikel_01PropellerName',
                                                    'artikel_01Propeller.preis as artikel_01PropellerPreis',
                                                    'artikel_01Propeller.blattanzahl as blattanzahl',
                                                    'artikel_03_01Ausfuehrungen.name as ausfuehrung',
                                                    'artikel_03_01Ausfuehrungen.preis as ausfuehrungPreis',
                                                    'artikel_03_03Farben.text as farbe',
                                                    'artikel_03_03Farben.preis as farbePreis',
                                                    'artikel_03_05Kantenschuetze.text as kantenschutzband',
                                                    'motor_ausrichtungen.name as ausrichtung',
                                                    'motor_flansche.name as bohrschema',
                                                    'artikel_05Distanzscheiben.name as ds',
                                                    'artikel_06_01ASGP.name as asgp',
                                                    'artikel_06_02SPGP.name as spgp',
                                                    'artikel_06_03SPKP.name as spkp',
                                                    'fluggeraete.name as fluggeraet',
                                                    'projekt_geraeteklassen.name as geraeteklasse',
                                                    'motoren.name as motorname',
                                                    'motoren.nenndrehzahl as motorNenndrehzahl',
                                                    'motor_getriebe.untersetzungszahl as untersetzung',
                                                    'artikel_07_04AP.name as ap',
                                                    'propeller_durchmesser.wert as propellerDurchmesser',
                                                    'propeller_aufkleber.text as propellerAufkleber'
                                                    )
                                                    ->join('projekte','projekt_propeller.projekt_id','=', 'projekte.id')
                                                    ->join('propeller','projekt_propeller.propeller_id', '=', 'propeller.id')
                                                    ->join('artikel_01Propeller', 'propeller.artikel_01Propeller_id', '=', 'artikel_01Propeller.id')
                                                    ->leftjoin('artikel_03_01Ausfuehrungen', 'projekt_propeller.artikel_03Ausfuehrung_id', '=', 'artikel_03_01Ausfuehrungen.id')
                                                    ->leftjoin('artikel_03_03Farben', 'projekt_propeller.artikel_03Farbe_id', '=', 'artikel_03_03Farben.id')
                                                    ->leftjoin('artikel_03_05Kantenschuetze', 'projekt_propeller.artikel_03Kantenschutz_id', '=', 'artikel_03_05Kantenschuetze.id')
                                                    ->leftjoin('motoren', 'projekte.motor_id', '=', 'motoren.id')
                                                    ->leftjoin('motor_getriebe', 'projekt_propeller.motor_getriebe_id', '=', 'motor_getriebe.id')
                                                    ->leftjoin('motor_flansche', 'projekte.motor_flansch_id', '=', 'motor_flansche.id')
                                                    ->leftjoin('fluggeraete','projekte.fluggeraet_id','=','fluggeraete.id')
                                                    ->leftjoin('projekt_geraeteklassen','projekte.projekt_geraeteklasse_id','=','projekt_geraeteklassen.id')
                                                    ->leftjoin('motor_ausrichtungen','fluggeraete.motor_ausrichtung_id', '=', 'motor_ausrichtungen.id')
                                                    ->leftjoin('artikel_05Distanzscheiben','fluggeraete.artikel_05Distanzscheibe_id', '=', 'artikel_05Distanzscheiben.id')
                                                    ->leftjoin('artikel_06_01ASGP','fluggeraete.artikel_06ASGP_id', '=', 'artikel_06_01ASGP.id')
                                                    ->leftjoin('artikel_06_02SPGP','fluggeraete.artikel_06SPGP_id', '=', 'artikel_06_02SPGP.id')
                                                    ->leftjoin('artikel_06_03SPKP','fluggeraete.artikel_06SPKP_id', '=', 'artikel_06_03SPKP.id')
                                                    ->leftjoin('artikel_07_04AP','motor_flansche.artikel_07AP_id', '=', 'artikel_07_04AP.id')
                                                    ->leftjoin('propeller_durchmesser','projekt_propeller.propellerDurchmesser_id', '=', 'propeller_durchmesser.id')
                                                    ->leftjoin('propeller_aufkleber','projekt_propeller.propeller_aufkleber_id', '=', 'propeller_aufkleber.id')


                                                    ->where('projekt_propeller.projekt_id','=', $id)
                                                    ->where('projekt_propeller.propellerDurchmesser_id','=', $propellerDurchmesserID)

                                                    ->orderBy('untersetzung', 'asc')
                                                    ->orderBy('propellername', 'asc')
                                                    ->get();
        }

        //dd($projektPropellerObjects);

        return view('projekte.edit',
                    compact(
                        'projekt',
                        'kunde',
                        'fluggeraete',
                        'projektGeraeteklassen',
                        'projektKategorien',
                        'projektTypen',
                        'projektStatusObjects',
                        'projektZertifizierungen',
                        'motoren',
                        'motorGetriebeObjects',
                        'motorFlansche',
                        'projektPropellerObjects',
                        'RefProjektPropellerObjects',
                        'motorAusrichtungen',
                        'propellerDurchmesserObjects'
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
            'kunde_id' => 'required',
            'projekt_geraeteklasse_id' => 'required',
            'beschreibung' => 'min:2|max:15|string|nullable',
            'projekt_kategorie_id' => 'required',
            'projekt_typ_id' => 'required',
            'projekt_status_id' => 'required',
            'notiz' => 'string|max:1000|nullable',
            'motor' => 'required',
            //'motorGetriebe' => 'required',
            'motorFlansch' => 'nullable'    
        ]);

        $kunde_id = $request->input("kunde_id");
        $kunde = Kunde::find($kunde_id);
        $fluggeraet = Fluggeraet::find($request->input("fluggeraet_id"));
        $projekte = Projekt::pluck('name');
        $motor = Motor::find($request->input("motor"));
        // $getriebe = MotorGetriebe::find($request->input("motorGetriebe"));
        // $untersetzungszahl = number_format($getriebe->untersetzungszahl,2);
        $geraeteklasse = ProjektGeraeteklasse::find($request->input("projekt_geraeteklasse_id"));

        if($request->input("fluggeraet_id") != NULL){
            // $name_lang ="$kunde->matchcode / $fluggeraet->name / $motor->name / $untersetzungszahl ($geraeteklasse->name)"; 
            $name_lang ="$kunde->matchcode / $fluggeraet->name / $motor->name ($geraeteklasse->name)"; 
        }else{
            //$name_lang ="$kunde->matchcode / $motor->name / $untersetzungszahl ($geraeteklasse->name)";
            $name_lang ="$kunde->matchcode / $motor->name ($geraeteklasse->name)";
        }
        if($request->input("beschreibung") != NULL){
            $name_lang ="$name_lang / ".$request->input("beschreibung").""; 
        }

        // if($projekte->contains($name_lang)){
        //     return back()->withInput()->withErrors(["Projekt bereits vorhanden !!!"]);        
        // }

        $projekt = Projekt::find($id);
        $projekt->kunde_id = $request->input("kunde_id");
        $projekt->beschreibung = $request->input("beschreibung");
        $projekt->projekt_geraeteklasse_id = $request->input("projekt_geraeteklasse_id");
        $projekt->fluggeraet_id = $request->input("fluggeraet_id");
        $projekt->name = $name_lang;
        $projekt->projekt_kategorie_id = $request->input("projekt_kategorie_id");
        $projekt->projekt_typ_id = $request->input("projekt_typ_id");
        $projekt->projekt_status_id = $request->input("projekt_status_id");
        $projekt->notiz = $request->input("notiz");
        $projekt->motor_id = $request->input("motor");
        //$projekt->motor_getriebe_id = $request->input("motorGetriebe");
        $projekt->motor_flansch_id = $request->input("motorFlansch");
        $projekt->user_id = auth()->user()->id;

        $projekt->save();
        
        //return response()->json(['error'=>$validator->errors()->all()]);
        return redirect("/kunden/{$projekt->kunde_id}")->with('success', "Projekt $projekt->name bei Kunde ".$projekt->kunde->matchcode." geändert!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


        $projekt = Projekt::find($id);

        

        $projektPropellerObjects = ProjektPropeller::where('projekt_id',$id)->get();
        foreach($projektPropellerObjects as $projektPropeller){
            
            $projektPropeller->delete();
        }
        
        
        $projekt->delete();
        return back()->with('success', "Projekt mit Propellern gelöscht");
    }
}
