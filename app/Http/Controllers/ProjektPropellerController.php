<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Projekt;
use App\Models\ProjektPropeller;
use App\Models\Propeller;
use App\Models\PropellerModellBlattTyp;
use App\Models\Fluggeraet;
use App\Models\Artikel03Ausfuehrung;
use App\Models\Artikel03Farbe;
use App\Models\Artikel03Kantenschutz;
use App\Models\PropellerDurchmesser;
use App\Models\MotorGetriebe;
use App\Models\Kunde;
use App\Models\PropellerAufkleber;

class ProjektPropellerController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projekt_id = request('projektId');
        $projektPropeller_id = request('projektPropellerID');

        $projekt = Projekt::find($projekt_id);
        $projektPropellerObjects = ProjektPropeller::find($projektPropeller_id);

        $kunde_id = $projekt->kunde_id;
        $kunde = Kunde::find($kunde_id);

        //dd($projektPropellerObjects);


        //$drehrichtung_motor = $projekt->motor->motorDrehrichtung->name;
        $propellerDurchmesserNeu = PropellerDurchmesser::orderBy('name', 'asc')->get();

        $getriebeObjects = MotorGetriebe::where('motor_id',$projekt->motor_id)->orderBy('name','asc')->get();

        $propellerModellBlattTypen = PropellerModellBlattTyp::orderBy('name','asc')->get();

        $kantenschuetze = Artikel03Kantenschutz::where('inaktiv', 0)->orderBy('id','asc')->get();

        $farben = Artikel03Farbe::orderBy('name','asc')->get();

        $propellerAufkleberObjects = PropellerAufkleber::orderBy('name','asc')->get();


        
        $nennleistung = $projekt->motor->nennleistung;
        //dd($nennleistung);
        if($nennleistung >= 50 && $nennleistung <= 105){
            $propellerObjects = Propeller::where('name','like','H5%')
                                        ->orWhere('name','like','H6%')
                                        ->orderBy('name','asc')
                                        ->where('propeller.inaktiv','=', NULL)
                                        ->get(); 

            $ausfuehrungen = Artikel03Ausfuehrung::where('inaktiv','=', 0)
                                                ->orWhere('name','like','A5%')
                                                ->orWhere('name','like','A6%')
                                                ->orderBy('name','asc')
                                                ->get();

        }
        
        if($nennleistung >= 15 && $nennleistung < 50){
            $propellerObjects = Propeller::where('name','like','H3%')
                                        ->orWhere('name','like','H4%')
                                        ->orWhere('name','like','H5%')
                                        ->orWhere('name','like','H6%')
                                        ->orderBy('name','asc')
                                        ->where('propeller.inaktiv','=', NULL)
                                        ->get(); 

            $ausfuehrungen = Artikel03Ausfuehrung::where('inaktiv','=', 0)
                                        ->orWhere('name','like','A3%')
                                        ->orWhere('name','like','A4%')
                                        ->orWhere('name','like','A5%')
                                        ->orWhere('name','like','A6%')
                                        ->orderBy('name','asc')
                                        ->get();     
        
        }
        
        if($nennleistung >= 5 && $nennleistung <= 15){
                                        $propellerObjects = Propeller::where('name','like','H2%')
                                                                    ->orWhere('name','like','H3%')
                                                                    ->orWhere('name','like','H4%')
                                                                    ->orderBy('name','asc')
                                                                    ->where('propeller.inaktiv','=', NULL)
                                                                    ->get(); 
                            
                                        $ausfuehrungen = Artikel03Ausfuehrung::where('inaktiv','=', 0)
                                                                    ->orWhere('name','like','A2%')
                                                                    ->orWhere('name','like','A3%')
                                                                    ->orWhere('name','like','A4%')
                                                                    ->orderBy('name','asc')
                                                                    ->get();                        
        }
        
        if($nennleistung == NULL){
            $propellerObjects = Propeller::orderBy('name','asc')
                                            ->where('propeller.inaktiv','=', NULL)
                                            ->get();  
            $ausfuehrungen = Artikel03Ausfuehrung::where('inaktiv','=', 0)
                                                ->orderBy('name','asc')
                                                ->get();   
        }else{
            $propellerObjects = Propeller::orderBy('name','asc')
                                                ->where('propeller.inaktiv','=', NULL)
                                                ->get();  
            $ausfuehrungen = Artikel03Ausfuehrung::where('inaktiv','=', 0)
                                                ->orderBy('name','asc')
                                                ->get();   
        }
    

        


        //dd($ausfuehrungen);
        return view('projektPropeller.create',
                        compact(
                            'projekt',
                            'propellerObjects',
                            'projektPropellerObjects',
                            //'drehrichtung_motor',
                            'ausfuehrungen',
                            'farben',
                            'kantenschuetze',
                            'propellerDurchmesserNeu',
                            'getriebeObjects',
                            'propellerModellBlattTypen',
                            'kunde',
                            'propellerAufkleberObjects'
                        ))
                .view('projektPropeller.modalTypenbezeichnung',
                        compact('propellerModellBlattTypen'
                        ))
                .view('projektPropeller.modalAusfuehrung',
                        compact('ausfuehrungen'
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
            'beschreibung' => 'min:2|max:20|string|nullable',
            'projekt_id' => 'required',
            'motorGetriebe_id' => 'required',
            'propeller_id' => 'required',
            'ausfuehrung_id' => 'required',
            'farbe_id' => 'required',
            'propellerDurchmesserNeu_id' => 'nullable',
            'typenaufkleber' => 'string|max:40|nullable',
            'propellerAufkleber_id' => 'nullable',
            'gewicht' => 'numeric|nullable',
            'klappen_set' => 'integer|min:0|max:1|nullable',
            'startzeit' => 'numeric|nullable',
            'landezeit' => 'numeric|nullable',
            'luftdruck' => 'numeric|nullable',
            'temperatur' => 'numeric|nullable',
            'metar' => 'string|nullable',
            'leermasse' => 'numeric|nullable',
            'notiz' => 'string|max:500|nullable',
            'notizProduktion' => 'string|max:500|nullable',
            'ergebnis_bewertung' => 'integer|min:0|max:3|nullable',

            'mp_Vo_drehzahl' => 'numeric|nullable',
            'mp_Vo_schub' => 'numeric|nullable',
            'mp_Vx_drehzahl' => 'numeric|nullable',
            'mp_Vmax_drehzahl' => 'numeric|nullable',
            'mp1_drehzahl' => 'numeric|nullable',
            'mp2_drehzahl' => 'numeric|nullable',
            'mp3_drehzahl' => 'numeric|nullable',

            'mp_Vx_steigrate' => 'numeric|nullable',
            'mp_Vmax_verbrauch' => 'numeric|nullable',
            'mp1_verbrauch' => 'numeric|nullable',
            'mp2_verbrauch' => 'numeric|nullable',
            'mp3_verbrauch' => 'numeric|nullable',
            
            'mp_Vo_ladedruck' => 'numeric|nullable',
            'mp_Vx_ladedruck' => 'numeric|nullable',
            'mp_Vmax_ladedruck' => 'numeric|nullable',
            'mp1_ladedruck' => 'numeric|nullable',
            'mp2_ladedruck' => 'numeric|nullable',
            'mp3_ladedruck' => 'numeric|nullable',

            'mp_Vx_IAS' => 'numeric|nullable',
            'mp_Vmax_IAS' => 'numeric|nullable',
            'mp_Vmax_drehzahl' => 'numeric|nullable',
            'mp1_IAS' => 'numeric|nullable',
            'mp2_IAS' => 'numeric|nullable',
            'mp3_IAS' => 'numeric|nullable',

            'mp_beginn_Vx_temp_oel' => 'numeric|nullable',
            'mp_beginn_Vx_temp_luft' => 'numeric|nullable',
            'mp_beginn_Vx_drehzahl' => 'numeric|nullable',
            'mp_beginn_Vx_ladedruck' => 'numeric|nullable',

            'mp_nach60s_Vx_hoehe' => 'numeric|nullable',
            'mp_nach60s_Vx_temp_oel' => 'numeric|nullable',
            'mp_nach60s_Vx_temp_luft' => 'numeric|nullable',
            'mp_nach60s_Vx_drehzahl' => 'numeric|nullable',
            'mp_nach60s_Vx_ladedruck' => 'numeric|nullable',

            'mp_nach60s_Vx_hoehe' => 'numeric|nullable',
            'mp_nach60s_Vx_temp_oel' => 'numeric|nullable',
            'mp_nach60s_Vx_temp_luft' => 'numeric|nullable',
            'mp_nach60s_Vx_drehzahl' => 'numeric|nullable',
            'mp_nach60s_Vx_ladedruck' => 'numeric|nullable',

            'mp_nach90s_Vx_hoehe' => 'numeric|nullable',
            'mp_nach90s_Vx_temp_oel' => 'numeric|nullable',
            'mp_nach90s_Vx_temp_luft' => 'numeric|nullable',
            'mp_nach90s_Vx_drehzahl' => 'numeric|nullable',
            'mp_nach90s_Vx_ladedruck' => 'numeric|nullable',
            
            'mp_nach120s_Vx_hoehe' => 'numeric|nullable',
            'mp_nach120s_Vx_temp_oel' => 'numeric|nullable',
            'mp_nach120s_Vx_temp_luft' => 'numeric|nullable',
            'mp_nach120s_Vx_drehzahl' => 'numeric|nullable',
            'mp_nach120s_Vx_ladedruck' => 'numeric|nullable',
            
            'mp_nach150s_Vx_hoehe' => 'numeric|nullable',
            'mp_nach150s_Vx_temp_oel' => 'numeric|nullable',
            'mp_nach150s_Vx_temp_luft' => 'numeric|nullable',
            'mp_nach150s_Vx_drehzahl' => 'numeric|nullable',
            'mp_nach150s_Vx_ladedruck' => 'numeric|nullable'
        ]);

        $propeller = Propeller::find($request->input('propeller_id'));

        //dd($propeller->propellerForm->propellerModellBlatt->bereichslaenge);

        if($propeller->artikel_01Propeller_id != 666){  //ID 666 ist die ID der Konkurrenzpropeller
            
            $propellerDurchmesser = number_format(2* ($propeller->propellerForm->propellerModellBlatt->bereichslaenge + $propeller->propellerForm->propellerModellWurzel->bereichslaenge) / 1000,2);
            $propellerDurchmesserID = PropellerDurchmesser::where('wert','=',$propellerDurchmesser)->get()->toArray();
            $propellerDurchmesserID = $propellerDurchmesserID[0]['id'];
            $propellerDurchmesserGek = 0;    
            //dd($propellerDurchmesserID);

            $propellerDurchmesserNeu = PropellerDurchmesser::find($request->input('propellerDurchmesserNeu_id'));

            if($request->input('propellerDurchmesserNeu_id') != NULL){
                if($propellerDurchmesserNeu->wert > $propellerDurchmesser){
                    return redirect("/projektPropeller/create?projektId=".$request->input('projekt_id')."")->with('alert_msg', "Der Einkürzdurchmesser ist größer als der ungekürzte Propellerdurchmesser");
                }
                $propellerDurchmesserID = $request->input('propellerDurchmesserNeu_id');
                $propellerDurchmesserGek = 1;
            }
        


            if($request->input("farbe_id") == null){
                $farbe = 100;
            }else{
                $farbe = $request->input("farbe_id");
            }
        }
        else{

            $farbe = 99;
            $propellerDurchmesserGek = 0;
            $propellerDurchmesserID = 99;
        }

        $projekt_id = $request->input("projekt_id");
        $projekt = Projekt::find($projekt_id);

        $projektPropeller = new projektPropeller;

        $projektPropeller->beschreibung = $request->input("beschreibung");
        $projektPropeller->projekt_id = $request->input("projekt_id");
        $projektPropeller->motor_getriebe_id = $request->input("motorGetriebe_id");
        $projektPropeller->propeller_id = $request->input("propeller_id");
        $projektPropeller->artikel_03Ausfuehrung_id = $request->input("ausfuehrung_id");
        $projektPropeller->artikel_03Farbe_id = $farbe;
        $projektPropeller->artikel_03Kantenschutz_id = $request->input("kantenschutz_id");
        $projektPropeller->propeller_aufkleber_id = $request->input("propellerAufkleber_id");
        $projektPropeller->propeller_gek = $propellerDurchmesserGek;
        $projektPropeller->propellerDurchmesser_id = $propellerDurchmesserID;
        $projektPropeller->typenaufkleber = $request->input("typenaufkleber");
        $projektPropeller->gewicht = $request->input("gewicht");
        $projektPropeller->klappen_set = $request->input("klappen_set");
        $projektPropeller->startzeit = $request->input("startzeit");
        $projektPropeller->landezeit = $request->input("landezeit");
        $projektPropeller->luftdruck_qnh = $request->input("luftdruck");
        $projektPropeller->temperatur_gnd = $request->input("temperatur");
        $projektPropeller->metar = $request->input("metar");
        $projektPropeller->notiz = $request->input("notiz");
        $projektPropeller->notizProduktion = $request->input("notizProduktion");
        $projektPropeller->ergebnis_bewertung = $request->input("ergebnis_bewertung");

        $projektPropeller->mp_Vo_drehzahl = $request->input("mp_Vo_drehzahl");
        $projektPropeller->mp_Vo_schub = $request->input("mp_Vo_schub");
        $projektPropeller->mp_Vx_drehzahl = $request->input("mp_Vx_drehzahl");
        $projektPropeller->mp_Vmax_drehzahl = $request->input("mp_Vmax_drehzahl");
        $projektPropeller->mp1_drehzahl = $request->input("mp1_drehzahl");
        $projektPropeller->mp2_drehzahl = $request->input("mp2_drehzahl");
        $projektPropeller->mp3_drehzahl = $request->input("mp3_drehzahl");

        $projektPropeller->mp_Vx_steigrate = $request->input("mp_Vx_steigrate");
        $projektPropeller->mp_Vmax_verbrauch = $request->input("mp_Vmax_verbrauch");
        $projektPropeller->mp1_verbrauch = $request->input("mp1_verbrauch");
        $projektPropeller->mp2_verbrauch = $request->input("mp2_verbrauch");
        $projektPropeller->mp3_verbrauch = $request->input("mp3_verbrauch");

        $projektPropeller->mp_Vo_ladedruck = $request->input("mp_Vo_ladedruck");
        $projektPropeller->mp_Vx_ladedruck = $request->input("mp_Vx_ladedruck");
        $projektPropeller->mp_Vmax_ladedruck = $request->input("mp_Vmax_ladedruck");
        $projektPropeller->mp1_ladedruck = $request->input("mp1_ladedruck");
        $projektPropeller->mp2_ladedruck = $request->input("mp2_ladedruck");
        $projektPropeller->mp3_ladedruck = $request->input("mp3_ladedruck");

        $projektPropeller->mp_Vx_IAS = $request->input("mp_Vx_IAS");
        $projektPropeller->mp_Vmax_IAS = $request->input("mp_Vmax_IAS");
        $projektPropeller->mp_Vmax_drehzahl = $request->input("mp_Vmax_drehzahl");
        $projektPropeller->mp1_IAS = $request->input("mp1_IAS");
        $projektPropeller->mp2_IAS = $request->input("mp2_IAS");
        $projektPropeller->mp3_IAS = $request->input("mp3_IAS");

        $projektPropeller->mp_beginn_Vx_temp_oel = $request->input("mp_beginn_Vx_temp_oel");
        $projektPropeller->mp_beginn_Vx_temp_luft = $request->input("mp_beginn_Vx_temp_luft");
        $projektPropeller->mp_beginn_Vx_drehzahl = $request->input("mp_beginn_Vx_drehzahl");
        $projektPropeller->mp_beginn_Vx_ladedruck = $request->input("mp_beginn_Vx_ladedruck");

        $projektPropeller->mp_nach60s_Vx_hoehe = $request->input("mp_nach60s_Vx_hoehe");
        $projektPropeller->mp_nach60s_Vx_temp_oel = $request->input("mp_nach60s_Vx_temp_oel");
        $projektPropeller->mp_nach60s_Vx_temp_luft = $request->input("mp_nach60s_Vx_temp_luft");
        $projektPropeller->mp_nach60s_Vx_drehzahl = $request->input("mp_nach60s_Vx_drehzahl");
        $projektPropeller->mp_nach60s_Vx_ladedruck = $request->input("mp_nach60s_Vx_ladedruck");

        $projektPropeller->mp_nach60s_Vx_hoehe = $request->input("mp_nach60s_Vx_hoehe");
        $projektPropeller->mp_nach60s_Vx_temp_oel = $request->input("mp_nach60s_Vx_temp_oel");
        $projektPropeller->mp_nach60s_Vx_temp_luft = $request->input("mp_nach60s_Vx_temp_luft");
        $projektPropeller->mp_nach60s_Vx_drehzahl = $request->input("mp_nach60s_Vx_drehzahl");
        $projektPropeller->mp_nach60s_Vx_ladedruck = $request->input("mp_nach60s_Vx_ladedruck");

        $projektPropeller->mp_nach90s_Vx_hoehe = $request->input("mp_nach90s_Vx_hoehe");
        $projektPropeller->mp_nach90s_Vx_temp_oel = $request->input("mp_nach90s_Vx_temp_oel");
        $projektPropeller->mp_nach90s_Vx_temp_luft = $request->input("mp_nach90s_Vx_temp_luft");
        $projektPropeller->mp_nach90s_Vx_drehzahl = $request->input("mp_nach90s_Vx_drehzahl");
        $projektPropeller->mp_nach90s_Vx_ladedruck = $request->input("mp_nach90s_Vx_ladedruck");

        $projektPropeller->mp_nach120s_Vx_hoehe = $request->input("mp_nach120s_Vx_hoehe");
        $projektPropeller->mp_nach120s_Vx_temp_oel = $request->input("mp_nach120s_Vx_temp_oel");
        $projektPropeller->mp_nach120s_Vx_temp_luft = $request->input("mp_nach120s_Vx_temp_luft");
        $projektPropeller->mp_nach120s_Vx_drehzahl = $request->input("mp_nach120s_Vx_drehzahl");
        $projektPropeller->mp_nach120s_Vx_ladedruck = $request->input("mp_nach120s_Vx_ladedruck");

        $projektPropeller->mp_nach150s_Vx_hoehe = $request->input("mp_nach150s_Vx_hoehe");
        $projektPropeller->mp_nach150s_Vx_temp_oel = $request->input("mp_nach150s_Vx_temp_oel");
        $projektPropeller->mp_nach150s_Vx_temp_luft = $request->input("mp_nach150s_Vx_temp_luft");
        $projektPropeller->mp_nach150s_Vx_drehzahl = $request->input("mp_nach150s_Vx_drehzahl");
        $projektPropeller->mp_nach150s_Vx_ladedruck = $request->input("mp_nach150s_Vx_ladedruck");


        $projektPropeller->user_id = auth()->user()->id;

        $projektPropeller->save();
        
        //return response()->json(['error'=>$validator->errors()->all()]);
        return redirect("/projekte/{$projekt->id}/edit")->with('success_msg', "Propeller ".$projektPropeller->propeller->name." im Projekt $projekt->name gespeichert!");
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
        //dd($id);

        $projektPropeller = ProjektPropeller::find($id);

        $projekt = Projekt::find($projektPropeller->projekt_id);

        $kunde_id = $projekt->kunde_id;
        $kunde = Kunde::find($kunde_id);

        $propellerDurchmesserNeu = PropellerDurchmesser::orderBy('name', 'asc')->get();

        $getriebeObjects = MotorGetriebe::where('motor_id',$projekt->motor_id)->orderBy('name','asc')->get();

        $kantenschuetze = Artikel03Kantenschutz::where('inaktiv', 0)->orderBy('id','asc')->get();

        $propellerAufkleberObjects = PropellerAufkleber::orderBy('name','asc')->get();

        //dd($projektPropeller);
        $nennleistung = $projekt->motor->nennleistung;
        if($nennleistung >= 50 && $nennleistung <= 105){
            $propellerObjects = Propeller::where('name','like','H5%')
                                        ->orWhere('name','like','H6%')
                                        ->orderBy('name','asc')->get(); 

            $ausfuehrungen = Artikel03Ausfuehrung::where('inaktiv','=', 0)
                                                ->orWhere('name','like','A5%')
                                                ->orWhere('name','like','A6%')
                                                ->orderBy('name','asc')->get();

        }elseif($nennleistung >= 25 && $nennleistung <= 50){
            $propellerObjects = Propeller::where('name','like','H3%')
                                        ->orWhere('name','like','H4%')
                                        ->orWhere('name','like','H5%')
                                        ->orderBy('name','asc')
                                        ->get(); 

            $ausfuehrungen = Artikel03Ausfuehrung::where('inaktiv','=', 0)
                                        ->orWhere('name','like','A3%')
                                        ->orWhere('name','like','A4%')
                                        ->orWhere('name','like','A5%')
                                        ->orderBy('name','asc')
                                        ->get();     
        
        }elseif($nennleistung >= 15 && $nennleistung < 25){
                                        $propellerObjects = Propeller::where('name','like','H2%')
                                                                    ->orWhere('name','like','H3%')
                                                                    ->orderBy('name','asc')
                                                                    ->get(); 
                            
                                        $ausfuehrungen = Artikel03Ausfuehrung::where('inaktiv','=', 0)
                                                                    ->orWhere('name','like','A2%')
                                                                    ->orWhere('name','like','A3%')
                                                                    ->orderBy('name','asc')
                                                                    ->get();                        
        }elseif($nennleistung == NULL){
            $propellerObjects = Propeller::orderBy('name','asc')->get();  
            $ausfuehrungen = Artikel03Ausfuehrung::where('inaktiv','=', 0)
                                                ->orderBy('name','asc')
                                                ->get(); 
        }else{
            $propellerObjects = Propeller::orderBy('name','asc')->get();  
            $ausfuehrungen = Artikel03Ausfuehrung::where('inaktiv','=', 0)
                                                ->orderBy('name','asc')
                                                ->get(); 
        }

        $ausfuehrungen = Artikel03Ausfuehrung::where('inaktiv','=', 0)
                                            ->orderBy('name','asc')
                                            ->get();

        $farben = Artikel03Farbe::orderBy('name','asc')->get();

        return view('projektPropeller.edit',
                                        compact(
                                            'projektPropeller',
                                            'projekt',
                                            'propellerObjects',
                                            'ausfuehrungen',
                                            'kantenschuetze',
                                            'farben',
                                            'propellerDurchmesserNeu',
                                            'getriebeObjects',
                                            'kunde',
                                            'propellerAufkleberObjects'
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
            'beschreibung' => 'min:2|max:20|string|nullable',
            'projekt_id' => 'required',
            'motorGetriebe_id' => 'required',
            'propeller_id' => 'required',
            'ausfuehrung_id' => 'required',
            'farbe_id' => 'required',
            'propellerDurchmesserNeu_id' => 'nullable',
            'typenaufkleber' => 'string|max:40|nullable',
            'propellerAufkleber_id' => 'nullable',
            'gewicht' => 'numeric|nullable',
            'klappen_set' => 'integer|min:0|max:1|nullable',
            'startzeit' => 'numeric|nullable',
            'landezeit' => 'numeric|nullable',
            'luftdruck' => 'numeric|nullable',
            'temperatur' => 'numeric|nullable',
            'metar' => 'string|nullable',
            'leermasse' => 'numeric|nullable',
            'notiz' => 'string|max:500|nullable',
            'notizProduktion' => 'string|max:500|nullable',
            'ergebnis_bewertung' => 'integer|min:0|max:3|nullable',

            'mp_Vo_drehzahl' => 'numeric|nullable',
            'mp_Vo_schub' => 'numeric|nullable',
            'mp_Vx_drehzahl' => 'numeric|nullable',
            'mp_Vmax_drehzahl' => 'numeric|nullable',
            'mp1_drehzahl' => 'numeric|nullable',
            'mp2_drehzahl' => 'numeric|nullable',
            'mp3_drehzahl' => 'numeric|nullable',

            'mp_Vx_steigrate' => 'numeric|nullable',
            'mp_Vmax_verbrauch' => 'numeric|nullable',
            'mp1_verbrauch' => 'numeric|nullable',
            'mp2_verbrauch' => 'numeric|nullable',
            'mp3_verbrauch' => 'numeric|nullable',
            
            'mp_Vo_ladedruck' => 'numeric|nullable',
            'mp_Vx_ladedruck' => 'numeric|nullable',
            'mp_Vmax_ladedruck' => 'numeric|nullable',
            'mp1_ladedruck' => 'numeric|nullable',
            'mp2_ladedruck' => 'numeric|nullable',
            'mp3_ladedruck' => 'numeric|nullable',

            'mp_Vx_IAS' => 'numeric|nullable',
            'mp_Vmax_IAS' => 'numeric|nullable',
            'mp_Vmax_drehzahl' => 'numeric|nullable',
            'mp1_IAS' => 'numeric|nullable',
            'mp2_IAS' => 'numeric|nullable',
            'mp3_IAS' => 'numeric|nullable',

            'mp_beginn_Vx_temp_oel' => 'numeric|nullable',
            'mp_beginn_Vx_temp_luft' => 'numeric|nullable',
            'mp_beginn_Vx_drehzahl' => 'numeric|nullable',
            'mp_beginn_Vx_ladedruck' => 'numeric|nullable',

            'mp_nach60s_Vx_hoehe' => 'numeric|nullable',
            'mp_nach60s_Vx_temp_oel' => 'numeric|nullable',
            'mp_nach60s_Vx_temp_luft' => 'numeric|nullable',
            'mp_nach60s_Vx_drehzahl' => 'numeric|nullable',
            'mp_nach60s_Vx_ladedruck' => 'numeric|nullable',

            'mp_nach60s_Vx_hoehe' => 'numeric|nullable',
            'mp_nach60s_Vx_temp_oel' => 'numeric|nullable',
            'mp_nach60s_Vx_temp_luft' => 'numeric|nullable',
            'mp_nach60s_Vx_drehzahl' => 'numeric|nullable',
            'mp_nach60s_Vx_ladedruck' => 'numeric|nullable',

            'mp_nach90s_Vx_hoehe' => 'numeric|nullable',
            'mp_nach90s_Vx_temp_oel' => 'numeric|nullable',
            'mp_nach90s_Vx_temp_luft' => 'numeric|nullable',
            'mp_nach90s_Vx_drehzahl' => 'numeric|nullable',
            'mp_nach90s_Vx_ladedruck' => 'numeric|nullable',
            
            'mp_nach120s_Vx_hoehe' => 'numeric|nullable',
            'mp_nach120s_Vx_temp_oel' => 'numeric|nullable',
            'mp_nach120s_Vx_temp_luft' => 'numeric|nullable',
            'mp_nach120s_Vx_drehzahl' => 'numeric|nullable',
            'mp_nach120s_Vx_ladedruck' => 'numeric|nullable',
            
            'mp_nach150s_Vx_hoehe' => 'numeric|nullable',
            'mp_nach150s_Vx_temp_oel' => 'numeric|nullable',
            'mp_nach150s_Vx_temp_luft' => 'numeric|nullable',
            'mp_nach150s_Vx_drehzahl' => 'numeric|nullable',
            'mp_nach150s_Vx_ladedruck' => 'numeric|nullable'
        ]);

        $projekt_id = $request->input("projekt_id");
        $projekt = Projekt::find($projekt_id);
        $propeller = Propeller::find($request->input('propeller_id'));

        if($propeller->artikel_01Propeller_id != 666){
            $propellerDurchmesser = number_format(2* ($propeller->propellerForm->propellerModellBlatt->bereichslaenge + $propeller->propellerForm->propellerModellWurzel->bereichslaenge) / 1000,2);
            $propellerDurchmesserID = PropellerDurchmesser::where('wert','=',$propellerDurchmesser)->get()->toArray();
            $propellerDurchmesserID = $propellerDurchmesserID[0]['id'];
            $propellerDurchmesserGek = 0;
                
            //dd($propellerDurchmesserID);

            $propellerDurchmesserNeu = PropellerDurchmesser::find($request->input('propellerDurchmesserNeu_id'));

            if($request->input('propellerDurchmesserNeu_id') != NULL){
                if($propellerDurchmesserNeu->wert > $propellerDurchmesser){
                    return redirect("/projektPropeller/create?projektId=".$request->input('projekt_id')."")->with('alert_msg', "Der Einkürzdurchmesser ist größer als der ungekürzte Propellerdurchmesser");
                }
                $propellerDurchmesserID = $request->input('propellerDurchmesserNeu_id');
                $propellerDurchmesserGek = 1;
            }

            if($request->input("farbe_id") == null){
                $farbe = 100;
            }else{
                $farbe = $request->input("farbe_id");
            }
        }
        else{

            $farbe = 99;
            $propellerDurchmesserGek = 0;
            $propellerDurchmesserID = 99;
        }

        $projektPropeller = projektPropeller::find($id);

        $projektPropeller->beschreibung = $request->input("beschreibung");
        $projektPropeller->projekt_id = $request->input("projekt_id");
        $projektPropeller->motor_getriebe_id = $request->input("motorGetriebe_id");
        $projektPropeller->propeller_id = $request->input("propeller_id");
        $projektPropeller->artikel_03Ausfuehrung_id = $request->input("ausfuehrung_id");
        $projektPropeller->artikel_03Farbe_id = $farbe;
        $projektPropeller->artikel_03Kantenschutz_id = $request->input("kantenschutz_id");
        $projektPropeller->propeller_gek = $propellerDurchmesserGek;
        $projektPropeller->propellerDurchmesser_id = $propellerDurchmesserID;
        $projektPropeller->typenaufkleber = $request->input("typenaufkleber");
        $projektPropeller->propeller_aufkleber_id = $request->input("propellerAufkleber_id");
        $projektPropeller->gewicht = $request->input("gewicht");
        $projektPropeller->klappen_set = $request->input("klappen_set");
        $projektPropeller->startzeit = $request->input("startzeit");
        $projektPropeller->landezeit = $request->input("landezeit");
        $projektPropeller->luftdruck_qnh = $request->input("luftdruck");
        $projektPropeller->temperatur_gnd = $request->input("temperatur");
        $projektPropeller->metar = $request->input("metar");
        $projektPropeller->notiz = $request->input("notiz");
        $projektPropeller->notizProduktion = $request->input("notizProduktion");
        $projektPropeller->ergebnis_bewertung = $request->input("ergebnis_bewertung");

        $projektPropeller->mp_Vo_drehzahl = $request->input("mp_Vo_drehzahl");
        $projektPropeller->mp_Vo_schub = $request->input("mp_Vo_schub");
        $projektPropeller->mp_Vx_drehzahl = $request->input("mp_Vx_drehzahl");
        $projektPropeller->mp_Vmax_drehzahl = $request->input("mp_Vmax_drehzahl");
        $projektPropeller->mp1_drehzahl = $request->input("mp1_drehzahl");
        $projektPropeller->mp2_drehzahl = $request->input("mp2_drehzahl");
        $projektPropeller->mp3_drehzahl = $request->input("mp3_drehzahl");

        $projektPropeller->mp_Vx_steigrate = $request->input("mp_Vx_steigrate");
        $projektPropeller->mp_Vmax_verbrauch = $request->input("mp_Vmax_verbrauch");
        $projektPropeller->mp1_verbrauch = $request->input("mp1_verbrauch");
        $projektPropeller->mp2_verbrauch = $request->input("mp2_verbrauch");
        $projektPropeller->mp3_verbrauch = $request->input("mp3_verbrauch");

        $projektPropeller->mp_Vo_ladedruck = $request->input("mp_Vo_ladedruck");
        $projektPropeller->mp_Vx_ladedruck = $request->input("mp_Vx_ladedruck");
        $projektPropeller->mp_Vmax_ladedruck = $request->input("mp_Vmax_ladedruck");
        $projektPropeller->mp1_ladedruck = $request->input("mp1_ladedruck");
        $projektPropeller->mp2_ladedruck = $request->input("mp2_ladedruck");
        $projektPropeller->mp3_ladedruck = $request->input("mp3_ladedruck");

        $projektPropeller->mp_Vx_IAS = $request->input("mp_Vx_IAS");
        $projektPropeller->mp_Vmax_IAS = $request->input("mp_Vmax_IAS");
        $projektPropeller->mp_Vmax_drehzahl = $request->input("mp_Vmax_drehzahl");
        $projektPropeller->mp1_IAS = $request->input("mp1_IAS");
        $projektPropeller->mp2_IAS = $request->input("mp2_IAS");
        $projektPropeller->mp3_IAS = $request->input("mp3_IAS");

        $projektPropeller->mp_beginn_Vx_temp_oel = $request->input("mp_beginn_Vx_temp_oel");
        $projektPropeller->mp_beginn_Vx_temp_luft = $request->input("mp_beginn_Vx_temp_luft");
        $projektPropeller->mp_beginn_Vx_drehzahl = $request->input("mp_beginn_Vx_drehzahl");
        $projektPropeller->mp_beginn_Vx_ladedruck = $request->input("mp_beginn_Vx_ladedruck");

        $projektPropeller->mp_nach60s_Vx_hoehe = $request->input("mp_nach60s_Vx_hoehe");
        $projektPropeller->mp_nach60s_Vx_temp_oel = $request->input("mp_nach60s_Vx_temp_oel");
        $projektPropeller->mp_nach60s_Vx_temp_luft = $request->input("mp_nach60s_Vx_temp_luft");
        $projektPropeller->mp_nach60s_Vx_drehzahl = $request->input("mp_nach60s_Vx_drehzahl");
        $projektPropeller->mp_nach60s_Vx_ladedruck = $request->input("mp_nach60s_Vx_ladedruck");

        $projektPropeller->mp_nach60s_Vx_hoehe = $request->input("mp_nach60s_Vx_hoehe");
        $projektPropeller->mp_nach60s_Vx_temp_oel = $request->input("mp_nach60s_Vx_temp_oel");
        $projektPropeller->mp_nach60s_Vx_temp_luft = $request->input("mp_nach60s_Vx_temp_luft");
        $projektPropeller->mp_nach60s_Vx_drehzahl = $request->input("mp_nach60s_Vx_drehzahl");
        $projektPropeller->mp_nach60s_Vx_ladedruck = $request->input("mp_nach60s_Vx_ladedruck");

        $projektPropeller->mp_nach90s_Vx_hoehe = $request->input("mp_nach90s_Vx_hoehe");
        $projektPropeller->mp_nach90s_Vx_temp_oel = $request->input("mp_nach90s_Vx_temp_oel");
        $projektPropeller->mp_nach90s_Vx_temp_luft = $request->input("mp_nach90s_Vx_temp_luft");
        $projektPropeller->mp_nach90s_Vx_drehzahl = $request->input("mp_nach90s_Vx_drehzahl");
        $projektPropeller->mp_nach90s_Vx_ladedruck = $request->input("mp_nach90s_Vx_ladedruck");

        $projektPropeller->mp_nach120s_Vx_hoehe = $request->input("mp_nach120s_Vx_hoehe");
        $projektPropeller->mp_nach120s_Vx_temp_oel = $request->input("mp_nach120s_Vx_temp_oel");
        $projektPropeller->mp_nach120s_Vx_temp_luft = $request->input("mp_nach120s_Vx_temp_luft");
        $projektPropeller->mp_nach120s_Vx_drehzahl = $request->input("mp_nach120s_Vx_drehzahl");
        $projektPropeller->mp_nach120s_Vx_ladedruck = $request->input("mp_nach120s_Vx_ladedruck");

        $projektPropeller->mp_nach150s_Vx_hoehe = $request->input("mp_nach150s_Vx_hoehe");
        $projektPropeller->mp_nach150s_Vx_temp_oel = $request->input("mp_nach150s_Vx_temp_oel");
        $projektPropeller->mp_nach150s_Vx_temp_luft = $request->input("mp_nach150s_Vx_temp_luft");
        $projektPropeller->mp_nach150s_Vx_drehzahl = $request->input("mp_nach150s_Vx_drehzahl");
        $projektPropeller->mp_nach150s_Vx_ladedruck = $request->input("mp_nach150s_Vx_ladedruck");


        $projektPropeller->user_id = auth()->user()->id;

        $projektPropeller->save();

        
        //return response()->json(['error'=>$validator->errors()->all()]);
        return redirect("/projekte/{$projekt->id}/edit")->with('success_msg', "Propeller ".$projektPropeller->propeller->name." im Projekt $projekt->name überarbeitet!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $projektPropeller = ProjektPropeller::find($id);
               
        $projektPropeller->delete();
        return back()->with('success_msg', "Propeller ".$projektPropeller->propeller->name." im Projekt gelöscht");
    }
}
