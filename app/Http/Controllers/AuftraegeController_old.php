<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Session;
use Auth;
use DB;
use PDF;
use DNS1D;
use DNS2D;


use App\Models\Kunde;
use App\Models\Projekt;
use App\Models\ProjektPropeller;
use App\Models\Auftrag;
use App\Models\AuftragTyp;
use App\Models\AuftragPropellernummer;
use App\Models\Artikel01Propeller;
use App\Models\Artikel03Ausfuehrung;
use App\Models\Artikel03Farbe;
use App\Models\Artikel03Kantenschutz;
use App\Models\Artikel05Distanzscheibe;
use App\Models\Artikel06ASGP;
use App\Models\Artikel06SPGP;
use App\Models\Artikel06SPKP;
use App\Models\Artikel07AP;
use App\Models\Artikel07Buchsen;
use App\Models\Artikel07Adapterscheiben;
use App\Models\Artikel08Zubehoer;
use App\Models\Propeller;
use App\Models\PropellerForm;
use App\Models\Material;
use App\Models\PropellerZuschnitt;
use App\Models\PropellerZuschnittLage;

class AuftraegeController extends Controller
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
        if(request()->has('suche')){
            $suche = request('suche');

            $auftraege = Auftrag::sortable()
            ->where('kundeMatchcode','like',"%$suche%")
            ->orWhere('projekt', 'like', '%'. $suche .'%')
            ->orWhere('motor', 'like', '%'. $suche .'%')
            ->orWhere('propeller', 'like', '%'. $suche .'%')
            ->orWhere('id', 'like', '%'. $suche .'%')
            ->orWhere('lexwareAB', 'like', '%'. $suche .'%')
            ->orderBy('id', 'asc')
            ->paginate(20)
            ->appends('id', 'like', "%$suche%");
        }else{
            $auftraege = Auftrag::sortable()
            ->orderBy('updated_at','desc')
            ->paginate(20);
        }

        

        //dd($auftraege);
        return view('auftraege.index',compact(
                                        'auftraege'
                                        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userId = auth()->user()->id; 
        \Cart::session($userId);
        
        $kunde_id = request('kundenId');
        $kunde = Kunde::find($kunde_id);

        //$projekte = Projekt::where('kunde_id',$kunde_id)->orderBy('name','asc')->get();

        //$projektPropellerObj = ProjektPropeller::orderBy('name','asc')->get();

        $projektPropellerObjects = ProjektPropeller::select(
                                    //'projekt_propeller.*',
                                    //'propeller.*',
                                    'projekt_propeller.id as projektPropellerID',
                                    'projekt_propeller.propeller_gek as propellerGek',
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
                                    'motor_getriebe.untersetzungszahl as untersetzung',
                                    'artikel_07_04AP.name as ap',
                                    'propeller_durchmesser.wert as propellerDurchmesserNeu',
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
                                    ->leftjoin('propeller_aufkleber','projekt_propeller.propeller_aufkleber_id', '=', 'propeller_aufkleber.id')
                                    ->leftjoin('propeller_durchmesser','projekt_propeller.propellerDurchmesser_id', '=', 'propeller_durchmesser.id')

                                    ->where('projekte.kunde_id','=', $kunde_id)

                                    ->orderBy('projektname','asc')
                                    ->orderBy('propellername', 'asc')

                                    ->get();

        
        //dd($projektPropellerObjects);

        return view('auftraege.create',
                    compact(
                        'kunde_id',
                        'kunde',
                        'projektPropellerObjects'
                    ));
    }


    public function add(Request $request)
    {
        $userId = auth()->user()->id; 
        \Cart::session($userId);

        $kundeID = session('customerID');
        $kunde = Kunde::find($kundeID);

        if($kunde->lexware_id == NULL){

            //dd($kunde);
            return redirect("/kunden/{$kundeID}")->with('alert_msg', "Bitte erst MyFactory Kundennummer eintragen bei $kunde->matchcode.");
        }
        

        $cartCollection = \Cart::getContent();

        if($request->input('myFactoryAB') == NULL){
            $myFactoryAB = '9999999';
        }else{
            $myFactoryAB = $request->input('myFactoryAB');   
        }

        


        //dd($kunde);

        // $cart = $cartCollection->toArray();
        // $anzahlAuftraege = count($cart);

        $buchstaben = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
                            'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ'
                        );

        $anzahl_auftraege = count($cartCollection);
        $id_letzter_auftrag = $anzahl_auftraege - 1;

        $buchstabe_letzter_teilauftrag = $buchstaben[$id_letzter_auftrag];    

        $x = 0;

        foreach($cartCollection as $item){
            $buchstabe_teilauftrag = $buchstaben[$x];

            $teilauftrag = "$buchstabe_teilauftrag / $buchstabe_letzter_teilauftrag";

            $x = $x + 1;

            if($item->type == 1){
                $projekt = Projekt::find($item->projectID);
                $projektPropeller = ProjektPropeller::find($item->id);
                $propellerForm = Propellerform::find($item->propellerFormID);

                //dd($projektPropeller);
                $auftrag = new Auftrag;
                $auftrag->lexwareAB = $myFactoryAB;
                $auftrag->kundeID = $kundeID;
                $auftrag->kundeMatchcode = $kunde->matchcode;
                $auftrag->myFactoryID = $kunde->lexware_id;
                $auftrag->anzahl = $item->quantity;
                $auftrag->propeller = $item->name;
                $auftrag->propellerForm = $propellerForm->name_kurz;
                $auftrag->propellerForm_id = $item->propellerFormID;
                $auftrag->ausfuehrung = $item->option;
                $auftrag->projekt = $item->projectname;
                $auftrag->projektKlasse = $item->projectclass;
                $auftrag->motor = $projekt->motor->name;
                $auftrag->untersetzung = $projektPropeller->motorGetriebe->untersetzungszahl;
                $auftrag->motorFlansch = $projekt->motorFlansch->name;
                $auftrag->distanzscheibe = $item->ds;
                $auftrag->asgp = $item->asgp;
                $auftrag->spgp = $item->spgp;
                $auftrag->spkp = $item->spkp;
                $auftrag->ap = $item->ap;
                $auftrag->adapterscheibe = $item->as;
                $auftrag->buchsen = $item->buHX;
                $auftrag->schrauben = $item->btSet;
                $auftrag->schraubenFlansch = $item->btSet2;
                $auftrag->zubehoer = $item->addParts;
                $auftrag->auftrag_status_id = 1;
                $auftrag->auftrag_typ_id = $item->type;
                $auftrag->testpropeller = $item->testpropeller;
                $auftrag->anordnung = $item->assembly;
                $auftrag->aufkleber = $item->sticker;
                $auftrag->typenaufkleber = $item->typesticker;
                $auftrag->kantenschutzband = $item->protectionTape;
                $auftrag->farbe = $item->color;
                $auftrag->dringlichkeit = $item->urgency;
                $auftrag->ets = $item->ets;
                $auftrag->form1 = $item->certification;
                $auftrag->teilauftrag = $teilauftrag;
                $auftrag->notiz = $item->comment;  


            }elseif($item->type == 5 || $item->type == 6){

                //dd($projektPropeller);
                $auftrag = new Auftrag;
                $auftrag->lexwareAB = $myFactoryAB;
                $auftrag->kundeID = $kundeID;
                $auftrag->kundeMatchcode = $kunde->matchcode;
                $auftrag->myFactoryID = $kunde->lexware_id;
                $auftrag->anzahl = $item->quantity;
                $auftrag->propeller = $item->name;

                $auftrag->distanzscheibe = $item->ds;
                $auftrag->asgp = $item->asgp;
                $auftrag->spgp = $item->spgp;
                $auftrag->spkp = $item->spkp;
                $auftrag->ap = $item->ap;
                $auftrag->adapterscheibe = $item->as;
                $auftrag->buchsen = $item->buHX;
                $auftrag->schrauben = $item->btSet;
                $auftrag->schraubenFlansch = $item->btSet2;
                $auftrag->zubehoer = $item->addParts;
                $auftrag->auftrag_status_id = 1;
                $auftrag->auftrag_typ_id = $item->type;

                $auftrag->dringlichkeit = $item->urgency;
                $auftrag->ets = $item->ets;

                $auftrag->teilauftrag = $teilauftrag;
                $auftrag->notiz = $item->comment;   

            }else{

                $auftrag = new Auftrag;
                $auftrag->lexwareAB = $myFactoryAB;
                $auftrag->kundeID = $kundeID;
                $auftrag->kundeMatchcode = $kunde->matchcode;
                $auftrag->myFactoryID = $kunde->lexware_id;
                $auftrag->anzahl = $item->quantity;
                $auftrag->propeller = $item->name;
                $auftrag->auftrag_status_id = 1;
                $auftrag->auftrag_typ_id = $item->type;
                $auftrag->dringlichkeit = $item->urgency;
                $auftrag->ets = $item->ets;
                $auftrag->teilauftrag = $teilauftrag;
                $auftrag->notiz = $item->comment;                  
            }

            $log[0][0] = date('Y-m-d H:i:s');
            $log[0][1] = auth()->user()->kuerzel;
            $log[0][2] = 'Auftrag erstellt';

            $auftrag->log = json_encode($log);
            $auftrag->createdAT_user_id = auth()->user()->id;
            $auftrag->user_id = auth()->user()->id;
    
            $auftrag->save();

            $produktionsjahr = date('Y');


            for($i = 0; $i < $item->quantity; $i++){

                $auftragPropNr = new AuftragPropellernummer;
                $auftragPropNr->produktionsjahr = $produktionsjahr;
                $auftragPropNr->kvaID = $auftrag->id;
                $auftragPropNr->lexwareAB = $myFactoryAB;
                $auftragPropNr->kundeID = $kundeID;
                $auftragPropNr->kundeMatchcode = $kunde->matchcode;
                $auftragPropNr->propeller = $item->name;
                $auftragPropNr->createdAT_user_id = auth()->user()->id;
                $auftragPropNr->user_id = auth()->user()->id;

                $auftragPropNr->save();
            }

        }

        \Cart::session($userId)->clear();

        return redirect("/kunden/{$kundeID}")->with('success_msg', "Aufträge gespeichert von $kunde->matchcode.");
    }


    public function auftragPDF($id)
    {
        $auftrag = Auftrag::find($id);

        if($auftrag->auftrag_typ_id == 7){ // +++++++++++++++++++++++ PDF FB018 Formenbauauftrag
            
            $propellerForm = Propellerform::find($auftrag->propellerForm_id);

            // $propellernummern = AuftragPropellernummer::select(
            //                             'id.*',
            //                     )
            //                     ->where('auftrag_propellernummern.kvaID','=', $auftrag)
            //                     ->get();

           
            //dd($propellernummern);
            $url_pdf = url()->current();
            $url = "https://kva.helix-propeller.de/auftraege/status/$id";
            //dd($materialHalbzeuge);   

            $myFactoryQR = "#".$id."#AB".$auftrag->lexwareAB."#D".$auftrag->myFactoryID."";
    
            $pdf = PDF::loadView('auftraege.pdf', [
                                    'auftrag' => $auftrag,
                                    'url' => $url,
                                    'myFactoryQR' => $myFactoryQR,
                                    'propellerForm' => $propellerForm
                                ]);
            //$pdf->setOption('toc', true);               
            $pdf->setOption('margin-top', 15); //** default 10mm */
            $pdf->setOption('footer-center', 'Ausgabe 19.02.2021 / ausgedruckte Exemplare unterliegen nicht dem Aenderungsdienst');
            $pdf->setOption('footer-right', '[page]/[toPage]');
            $pdf->setOption('footer-font-size', '6');
            return $pdf->download("FB018_".$propellerForm->name_kurz.".pdf");  

        }else{// +++++++++++++++++++++++ PDF FB019 Fertigungsauftrag

            $materialien = Material::select(
                                                        //'material_halbzeuge.*',
                                                        'materialien.id as MaterialID',
                                                        'materialien.name as MaterialName',
                                                        'materialien.name_lang as MaterialNameLang',
                                                        'material_typen.name as MaterialTyp',
                                                        'material_typen.werkstoff as Werkstoff',
                                                        'material_gruppen.id as MaterialGruppeID',
                                                        )

                                                        ->leftjoin('material_gruppen','materialien.material_gruppe_id','=','material_gruppen.id')
                                                        ->leftjoin('material_typen','materialien.material_typ_id', '=', 'material_typen.id')
                    
                                                        ->orderBy('Werkstoff','asc')
                                                        ->orderBy('MaterialTyp','asc')
                    
                                                        ->get();    


            // Details abrufen zum aktuellem Propeller im Auftrag
            if($auftrag->propellerForm_id != NULL){ //Fangabfrag da nicht alle "älteren" Aufträge die FormID gespreichert haben

                $propellerForm = Propellerform::find($auftrag->propellerForm_id);
                $durchmesser = number_format(2*($propellerForm->propellerModellBlatt->bereichslaenge + $propellerForm->propellerModellWurzel->bereichslaenge)/1000,2);
                $modellBlattTyp = $propellerForm->propellerModellBlatt->propellerModellBlattTyp->text;
                $festigkeitsKlasse = $propellerForm->propellerModellWurzel->propellerKlasseGeometrie->basis_festigkeitsklasse;
                $geometrieForm = $propellerForm->propellerModellWurzel->propellerKlasseGeometrie->geometrieform;

                // $FG = "H$festigkeitsKlasse"."$geometrieForm";

                // $propellerZuschnitt = PropellerZuschnitt::where('typen', 'like', "%$modellBlattTyp%")
                //                                         ->where('name','like',"%$FG%")
                //                                         ->pluck('id');
                // if($propellerZuschnitt->isEmpty()){

                //     return redirect("/kunden/".$auftrag->kundeID."")->with('error', "***** Zuschnitt für diesen Propellertyp noch nicht angelegt ******");;

                // }

                // $propellerZuschnittID = $propellerZuschnitt[0];

                // $propellerZuschnitt_aktuell = PropellerZuschnitt::find($propellerZuschnittID);


                // $propellerZuschnittLagen = PropellerZuschnittLage::where('propeller_zuschnitt_id', '=', $propellerZuschnitt_aktuell->id)->orderBy('sortiernummer','asc')->get();

                //Temporär ausgeblendet da noch nicht alle Zuschnittpläne vorhanden
                $propellerZuschnitt_aktuell = '';
                $propellerZuschnittLagen = '';


            
            }else{

                $propellerZuschnitt_aktuell = '';
                $propellerZuschnittLagen = '';

            }

            $url_pdf = url()->current();
            $url = "https://kva.helix-propeller.de/auftraege/status/$id";
            //dd($materialHalbzeuge);   

            $myFactoryQR = "#".$id."#AB".$auftrag->lexwareAB."#D".$auftrag->myFactoryID."";
            //dd($myFactoryQR);
    
            $pdf = PDF::loadView('auftraege.pdf', [
                                    'auftrag' => $auftrag,
                                    'materialien' => $materialien,
                                    'url' => $url,
                                    'myFactoryQR' => $myFactoryQR,
                                    'propellerZuschnitt_aktuell' => $propellerZuschnitt_aktuell,
                                    'propellerZuschnittLagen' => $propellerZuschnittLagen
                                ]);
            //$pdf->setOption('toc', true);               
            $pdf->setOption('margin-top', 15); //** default 10mm */
            $pdf->setOption('footer-center', 'Ausgabe 23.02.2023 / ausgedruckte Exemplare unterliegen nicht dem Aenderungsdienst');
            $pdf->setOption('footer-right', '[page]/[toPage]');
            $pdf->setOption('footer-font-size', '6');
            return $pdf->download("FB019_".$auftrag->kundeMatchcode."_".$auftrag->id.".pdf");  
        }


          

    }


    public function fb009($id)
    {

        $userId = auth()->user()->id; 
        \Cart::session($userId);

        $kunde = Kunde::find($id);
        $auftragTypen = AuftragTyp::orderBy('name','asc')
                                        ->where('id','=',2)
                                        ->orWhere('id','=',3)
                                        ->orWhere('id','=',4)
                                        ->get();

        //$propellerObj = Propeller::orderBy('name','asc')->pluck('name');
        $propellerObj = Propeller::orderBy('name','asc')->get();

        $artikel05DistanzscheibeObj = Artikel05Distanzscheibe::orderBy('name')->where('inaktiv',0)->pluck('name');
        $artikel06ASGPObj = Artikel06ASGP::orderBy('name')->where('inaktiv',0)->pluck('name');
        $artikel06SPGPObj = Artikel06SPGP::orderBy('name')->where('inaktiv',0)->pluck('name');
        $artikel06SPKPObj = Artikel06SPKP::orderBy('name')->where('inaktiv',0)->pluck('name');
        $artikel07APObj = Artikel07AP::orderBy('name')->where('inaktiv',0)->pluck('name');
        $artikel07BuchsenObj = Artikel07Buchsen::orderBy('name')->where('inaktiv',0)->pluck('name');
        $artikel08ZubehoerObj = Artikel08Zubehoer::orderBy('name')->where('inaktiv',0)->pluck('name');

        //dd($propellerObj);
        return view('auftraege.fb009',
                                    compact(
                                        'kunde',
                                        'auftragTypen',
                                        'propellerObj',
                                        'artikel05DistanzscheibeObj',
                                        'artikel06ASGPObj',
                                        'artikel06SPGPObj',
                                        'artikel06SPKPObj',
                                        'artikel07APObj',
                                        'artikel07BuchsenObj',
                                        'artikel08ZubehoerObj'
                                    ));
    }

    public function fb094($id)
    {

        $userId = auth()->user()->id; 
        \Cart::session($userId);

        $kunde = Kunde::find($id);
        $auftragTypen = AuftragTyp::where('id','=',5)->orderBy('name','asc')->get();

        $spkpObj = Artikel06SPKP::orderBy('name','asc')->pluck('name');

        //dd($propellerObj);
        return view('auftraege.fb094',
                                    compact(
                                        'kunde',
                                        'auftragTypen',
                                        'spkpObj'
                                    ));
    }

    public function store(Request $request)
    {

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        if(request()->has('auftragsstatus')){

            $statusID = request('auftragsstatus');

            $auftrag = Auftrag::find($id);
            $auftrag->auftrag_status_id = $statusID;

            $status = $auftrag->auftragStatus->name;

            if($auftrag->log != NULL){
                $log_vorh = json_decode($auftrag->log);
                $anzahl_log = count($log_vorh) - 1;
                $anzahl_neu = $anzahl_log + 1;

            }else{
                $anzahl_neu = 0;
            }
            $log_vorh[$anzahl_neu][0] = date('Y-m-d H:i:s');
            $log_vorh[$anzahl_neu][1] = auth()->user()->kuerzel;
            $log_vorh[$anzahl_neu][2] = "Status geandert: $status";
            $auftrag->log = $log_vorh;

            $auftrag->user_id = auth()->user()->id;
    
            $auftrag->save();

            $kundeID = $auftrag->kundeID;

            return redirect("/kunden/{$kundeID}");

        }

        if(request()->has('auftragbezahlt')){

            $auftrag_bezahltstatus = request('auftragbezahlt');

            $auftrag = Auftrag::find($id);
            $auftrag->auftrag_bezahltstatus = $auftrag_bezahltstatus;

            if($auftrag->log != NULL){
                $log_vorh = json_decode($auftrag->log);
                $anzahl_log = count($log_vorh) - 1;
                $anzahl_neu = $anzahl_log + 1;

            }else{
                $anzahl_neu = 0;
            }
            $log_vorh[$anzahl_neu][0] = date('Y-m-d H:i:s');
            $log_vorh[$anzahl_neu][1] = auth()->user()->kuerzel;
            $log_vorh[$anzahl_neu][2] = "Status bezahlt";
            $auftrag->log = $log_vorh;

            $auftrag->user_id = auth()->user()->id;
    
            $auftrag->save();

        }


        $auftrag = Auftrag::find($id);

        //dd($kunde);

        return view('auftraege.show',
                                compact(
                                    'auftrag'
                                ));
    }

    public function status($id)
    {
        if(request()->has('auftragsstatus')){

            $statusID = request('auftragsstatus');

            $auftrag = Auftrag::find($id);
            $auftrag->auftrag_status_id = $statusID;

            $status = $auftrag->auftragStatus->name;

            if($auftrag->log != NULL){
                $log_vorh = json_decode($auftrag->log);
                $anzahl_log = count($log_vorh) - 1;
                $anzahl_neu = $anzahl_log + 1;
            }else{
                $anzahl_neu = 0;
            }

            $log_vorh[$anzahl_neu][0] = date('Y-m-d H:i:s');
            $log_vorh[$anzahl_neu][1] = auth()->user()->kuerzel;
            $log_vorh[$anzahl_neu][2] = "Status geandert: $status";
            $auftrag->log = $log_vorh;
            $auftrag->user_id = auth()->user()->id;
    
            $auftrag->save();
        }

        $auftrag = Auftrag::find($id);
     
        return view('auftraege.status',
                                compact(
                                    'auftrag'
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
        $auftrag = Auftrag::find($id);
        $propeller = Propeller::orderBy('name')->pluck('name');
        $propellerFormen = PropellerForm::orderBy('name')->pluck('name_kurz');
        $ausfuehrungen = Artikel03Ausfuehrung::orderBy('name')->pluck('name');
        $farben = Artikel03Farbe::orderBy('name')->pluck('name');
        $kantenschuetze = Artikel03Kantenschutz::orderBy('name')->pluck('text');
        $distanzscheiben = Artikel05Distanzscheibe::orderBy('name')->pluck('name');
        $asgpObj = Artikel06ASGP::orderBy('name')->pluck('name');
        $spgpObj = Artikel06SPGP::where('inaktiv',0)->orderBy('name')->pluck('name');
        $spkpObj = Artikel06SPKP::orderBy('name')->pluck('name');
        $apObj = Artikel07AP::orderBy('name')->pluck('name');
        $buchsenObj = Artikel07Buchsen::orderBy('name')->pluck('name');

        //dd($kunde);

        return view('auftraege.edit',
                                compact(
                                    'auftrag',
                                    'propeller',
                                    'propellerFormen',
                                    'ausfuehrungen',
                                    'farben',
                                    'kantenschuetze',
                                    'distanzscheiben',
                                    'asgpObj',
                                    'spgpObj',
                                    'spkpObj',
                                    'apObj',
                                    'buchsenObj'
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
            'anzahl' => 'numeric',
            'propeller' => 'nullable',
            'propellerForm' => 'nullable',
            'propellerAusfuehrung' => 'nullable',
            'propellerFarbe' => 'nullable',
            'kantenschutz' => 'nullable',
            'motorFlansch' => 'string|nullable',
            'dringlichkeit' => 'string|nullable',
            'distanzscheibe' => 'nullable',
            'asgp' => 'nullable',
            'spgp' => 'nullable',
            'spkp' => 'nullable',
            'buchsen' => 'string|nullable',
            'andruckplatte' => 'string|nullable',
            'notiz' => 'string|nullable|max:500'
        ]);

        if($request->input("propeller") != NULL){
            $propellerOderForm = $request->input("propeller");
        }else{
            $propellerOderForm = $request->input("propellerForm"); 
        }
        
        $auftrag = Auftrag::find($id);

        if($auftrag->log != NULL){
            $log_vorh = json_decode($auftrag->log);
            $anzahl_log = count($log_vorh) - 1;
            $anzahl_neu = $anzahl_log + 1;
        }else{
            $anzahl_neu = 0;
        }
        $log_vorh[$anzahl_neu][0] = date('Y-m-d H:i:s');
        $log_vorh[$anzahl_neu][1] = auth()->user()->kuerzel;
        $log_vorh[$anzahl_neu][2] = 'Auftrag geaendert';
        
        if($auftrag->lexwareAB != $request->input("lexwareAB")){
            $auftrag->lexwareAB = $request->input("lexwareAB");
            $log_vorh[$anzahl_neu][3] = $request->input("lexwareAB");
        }else{
            $log_vorh[$anzahl_neu][3] = $auftrag->lexwareAB;
        }

        if($auftrag->anzahl != $request->input("anzahl")){
            $auftrag->anzahl = $request->input("anzahl");
            $log_vorh[$anzahl_neu][4] = $request->input("anzahl");
        }else{
            $log_vorh[$anzahl_neu][4] = $auftrag->anzahl;
        }

        if($auftrag->propeller != $propellerOderForm){
            $auftrag->propeller = $propellerOderForm;
            $log_vorh[$anzahl_neu][5] = $propellerOderForm;
        }else{
            $log_vorh[$anzahl_neu][5] = $auftrag->propeller;
        }

        if($auftrag->ausfuehrung != $request->input("propellerAusfuehrung")){
            $auftrag->ausfuehrung = $request->input("propellerAusfuehrung");
            $log_vorh[$anzahl_neu][6] = $request->input("propellerAusfuehrung");
        }else{
            $log_vorh[$anzahl_neu][6] = $auftrag->ausfuehrung;
        }

        if($auftrag->anordnung != $request->input("propellerAnordung")){
            $auftrag->anordnung = $request->input("propellerAnordung");
            $log_vorh[$anzahl_neu][7] = $request->input("propellerAnordung");
        }else{
            $log_vorh[$anzahl_neu][7] = $auftrag->anordnung;
        }

        if($auftrag->farbe != $request->input("propellerFarbe")){
            $auftrag->farbe = $request->input("propellerFarbe");
            $log_vorh[$anzahl_neu][8] = $request->input("propellerFarbe");
        }else{
            $log_vorh[$anzahl_neu][8] = $auftrag->farbe;
        }

        if($auftrag->motorFlansch != $request->input("motorFlansch")){
            $auftrag->motorFlansch = $request->input("motorFlansch");
            $log_vorh[$anzahl_neu][9] = $request->input("motorFlansch");
        }else{
            $log_vorh[$anzahl_neu][9] = $auftrag->motorFlansch;
        }

        if($auftrag->aufkleber != $request->input("aufkleber")){
            $auftrag->aufkleber = $request->input("aufkleber");
            $log_vorh[$anzahl_neu][10] = $request->input("aufkleber");
        }else{
            $log_vorh[$anzahl_neu][10] = $auftrag->aufkleber;
        }

        if($auftrag->typenaufkleber != $request->input("typenaufkleber")){
            $auftrag->typenaufkleber = $request->input("typenaufkleber");
            $log_vorh[$anzahl_neu][11] = $request->input("typenaufkleber");
        }else{
            $log_vorh[$anzahl_neu][11] = $auftrag->typenaufkleber;
        }

        if($auftrag->kantenschutzband != $request->input("kantenschutz")){
            $auftrag->kantenschutzband = $request->input("kantenschutz");
            $log_vorh[$anzahl_neu][12] = $request->input("kantenschutz");
        }else{
            $log_vorh[$anzahl_neu][12] = $auftrag->kantenschutzband;
        }

        if($auftrag->dringlichkeit != $request->input("dringlichkeit")){
            $auftrag->dringlichkeit = $request->input("dringlichkeit");
            $log_vorh[$anzahl_neu][13] = $request->input("dringlichkeit");
        }else{
            $log_vorh[$anzahl_neu][13] = $auftrag->dringlichkeit;
        }

        if($auftrag->ets != $request->input("ets")){
            $auftrag->ets = $request->input("ets");
            $log_vorh[$anzahl_neu][14] = $request->input("ets");
        }else{
            $log_vorh[$anzahl_neu][14] = $auftrag->ets;
        }


        $auftrag->distanzscheibe = $request->input("distanzscheibe");
        $auftrag->asgp = $request->input("asgp");
        $auftrag->spgp = $request->input("spgp");
        $auftrag->spkp = $request->input("spkp");
        $auftrag->ap = $request->input("andruckplatte");
        $auftrag->buchsen = $request->input("buchsen");
        $auftrag->schrauben = $request->input("schrauben");
        $auftrag->notiz = $request->input("notiz");


       

        
        //dd($log_vorhanden);
        $auftrag->log = $log_vorh;
        $auftrag->user_id = auth()->user()->id;

        //dd($auftrag);
    
        $auftrag->save();

        return redirect("/auftraege/{$id}")->with('success_msg', "Auftragsdetails von $auftrag->id überarbeitet!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $auftrag = Auftrag::find($id);
        
        
        $auftrag->delete();
        
        return redirect('/auftraege')->with('success', "Auftrag $auftrag->id gelöscht");
    }
}
