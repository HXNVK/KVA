<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Session;
use Auth;
use DB;
use PDF;
use Carbon\Carbon;

use App\Models\Kunde;
use App\Models\KundeAdresse;
use App\Models\Laermmessung;
use App\Models\LaermmessungDatei;
use App\Models\LaermmessungFaktorT;
use App\Models\Fluggeraet;
use App\Models\Motor;

class LaermmessungenController extends Controller
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
        $laermmessungen = Laermmessung::
                                orderby('fluggeraet','asc')->paginate(30);

        


        return view('laermmessungen.index',
                                    compact(
                                        'laermmessungen'
                                    ));

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $kunden = Kunde::orderBy('matchcode','asc')->get();
        $fluggeraete = Fluggeraet::orderBy('name', 'asc')->get();
        $motoren = Motor::orderBy('name', 'asc')->get();

        return view('laermmessungen.create',
                            compact(
                                'kunden',
                                'fluggeraete',
                                'motoren'
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

            'kunde_id' => 'required',
            'messdatum' => 'required',
            'messort' => 'required',
            'messortHoehe' => 'required|numeric',
            'fluggeraetGruppe' => 'required',
            'kennung' => 'required',
            'mtow' => 'required',
            //'propDM' => 'required',
            'D15' => 'nullable',
            'RC' => 'nullable',
            'Vy' => 'nullable',
            'untersetzung' => 'nullable',
            //'motor_id' => 'required',
            'drehzahlRC' => 'nullable',
            //'ladedruckRC' => 'required',
            'anzahlAbgasrohre' => 'nullable',
            'schalldaempfer' => 'nullable',
            'herstellerProp' => 'nullable',
            'modellProp' => 'nullable',
            'werknummerProp' => 'nullable',
            'durchmesserNominell' => 'nullable',
            'durchmesserGemessen' => 'nullable',
            'blattanzahl' => 'nullable',
            'blattspitzenform' => 'nullable',
            'drehrichtungProp' => 'nullable',
            'nabenbezeichnung' => 'nullable',
            'typenbezeichnung' => 'nullable',
            'leiter' => 'required',
            'messstelleBoden1' => 'required',
            'pilot' => 'required'

        ]);


        //dd($request->input());
        if($request->input("fluggeraet_id") != NULL){
            $fluggeraetID = $request->input("fluggeraet_id");
            $fluggeraet = Fluggeraet::find($fluggeraetID);

            $fluggeraetHersteller = $fluggeraet->kunde->name1;
            $fluggeraetName = $fluggeraet->name;
            $spannweite = $fluggeraet->spannweite;
            $zertifizierungsBehoerde = $fluggeraet->projektZertifizierung->name;
            $kennblattnummer = $fluggeraet->kennblattnummer;
            $kennblatt = "$zertifizierungsBehoerde $kennblattnummer";
            $muster = $fluggeraet->muster;
            $baureihe = $fluggeraet->baureihe;
            $fahrwerk = $fluggeraet->fahrwerk;
            $Vmax = $fluggeraet->v_max;
            $Vmin = $fluggeraet->v_min;
        }
        else{
            $fluggeraetHersteller = $request->input("fluggeraetHersteller");
            $fluggeraetName = $request->input("fluggeraet");
            $muster = $request->input("muster");
            $baureihe = $request->input("baureihe");
            $spannweite = $request->input("spannweite");
            $kennblatt = $request->input("kennblattNr");
            $Vmax = $request->input("Vmax");
            $Vmin = $request->input("Vmin");
        }

        if($request->input("motor_id") != NULL){
            $motorID = $request->input("motor_id");
            $motor = Motor::find($motorID);

            $kunde = Kunde::find($motor->kunde_id);
            $kundeMotor = $kunde->matchcode;

            $motorName = "$kundeMotor / $motor->name";
            $motorZylinder = $motor->zylinderanzahl;
            $motorArbeitsweise = $motor->motorArbeitsweise->name;
            $kraftstoffZufuhr = $motor->kraftstoffZufuhr;
            $nennleistung = $motor->nennleistung;
        }else{
            $motorName = $request->input("motor");
            $motorZylinder = $request->input("motorZylinder");
            $motorArbeitsweise = $request->input("motorArbeitsweise");
            $kraftstoffZufuhr = $request->input("kraftstoffZufuhr");
            $nennleistung = $request->input("nennleistung");
        }

        $mtow = $request->input("mtow");

        $D15 = $request->input("D15");
        $RC = $request->input("RC");
        $Vy = $request->input("Vy");

        if($D15 == NULL || $RC == NULL || $Vy == NULL){
            $Href = 150;
        }else{
            $Href = number_format(15 + (2500-$D15)*($RC/sqrt(pow($Vy,2)-pow($RC,2))),2); 

            if($Href >= 450){
                $Href = 450;
            }else{
                $Href = number_format(15 + (2500-$D15)*($RC/sqrt(pow($Vy,2)-pow($RC,2))),2);
            }
        }
            



        //Lärmgrenze nach Kap.10 Gruppe 1
        if($request->input("fluggeraetGruppe") == 'Kap10-G1'){
            if($mtow >= 1400 && $mtow <= 8618){
                $laermgrenzwert = 88;
            }
            if($mtow > 600 && $mtow < 1400){
                $laermgrenzwert = 83.23 + 32.67 * log($mtow/1000) / log(10);

            }
            if($mtow <= 600){
                $laermgrenzwert = 76;
            }
        }

        //Lärmgrenze nach Kap.10 Gruppe 2
        if($request->input("fluggeraetGruppe") == 'Kap10-G2'){
            if($mtow >= 1500 && $mtow <= 8618){
                $laermgrenzwert = 85;
            }
            if($mtow > 570 && $mtow < 1500){
                $laermgrenzwert = 78.71 + 35.7 * log($mtow/1000) / log(10);
            }
            if($mtow <= 570){
                $laermgrenzwert = 70;
            }
        }

        // Lärmgrenze nach Kap.10 Gruppe Ultraleichtflugzeuge
        if($request->input("fluggeraetGruppe") == 'Kap10-UL'){
            if($mtow >= 570 && $mtow <= 650){
                $laermgrenzwert = 70;
            }
            if($mtow > 472.5 && $mtow < 570){
                $laermgrenzwert = $mtow * 10/97.5 + 11.538;
            }
            if($mtow <= 472.5){
                $laermgrenzwert = 60;
            }
        }

        // Lärmgrenze nach Kap.11 Gruppe Ultraleichthubschrauber
        if($request->input("fluggeraetGruppe") == 'Kap11-UL'){
            if($mtow <= 600){
                $laermgrenzwert = 82;
            }
        }

        if($request->input("fluggeraetGruppe") == 'LVL'){
            if($mtow <= 472.5){
                $laermgrenzwert = 60;
            }
        }
        

        $laermmessung = new Laermmessung;
        $laermmessung->kunde_id = $request->input("kunde_id");
        $laermmessung->messdatum = $request->input("messdatum");
        $laermmessung->messort = $request->input("messort");
        $laermmessung->messortHoehe = $request->input("messortHoehe");
        $laermmessung->fluggeraetGruppe = $request->input("fluggeraetGruppe");
        $laermmessung->herstellerFluggeraet = $fluggeraetHersteller;
        $laermmessung->fluggeraet = $fluggeraetName;
        $laermmessung->muster = $muster;
        $laermmessung->baureihe = $baureihe;
        $laermmessung->werknummer = $request->input("werknummer");
        $laermmessung->baujahr = $request->input("baujahr");
        $laermmessung->fahrwerk = $request->input("fahrwerk");
        $laermmessung->kennblatt = $kennblatt;
        $laermmessung->kennung = $request->input("kennung");
        $laermmessung->mtow = $mtow;
        $laermmessung->D15 = $request->input("D15");
        $laermmessung->spannweite = $spannweite;
        $laermmessung->v_max = $Vmax;
        $laermmessung->v_min = $Vmin;
        $laermmessung->v_h = $request->input("Vh");
        $laermmessung->RC = $request->input("RC");
        $laermmessung->Vy = $request->input("Vy");
        $laermmessung->delta_CAS_IAS = $request->input("delta_CASIAS");
        $laermmessung->Href = $Href;
        $laermmessung->laermgrenzwert = $laermgrenzwert;

        $laermmessung->motor = $motorName;
        $laermmessung->untersetzung = $request->input("untersetzung");
        $laermmessung->motorWerknummer = $request->input("motorWerknummer");
        $laermmessung->motorZylinder = $motorZylinder;
        $laermmessung->motorArbeitsweise = $motorArbeitsweise;
        $laermmessung->kraftstoffZufuhr = $kraftstoffZufuhr;
        $laermmessung->nennleistung = $nennleistung;
        $laermmessung->drehzahlRC = $request->input("drehzahlRC");
        $laermmessung->ladedruckRC = $request->input("ladedruckRC");
        $laermmessung->anzahlAbgasrohre = $request->input("anzahlAbgasrohre");
        $laermmessung->schalldaempfer = $request->input("schalldaempfer");
        $laermmessung->kuehlklappen = $request->input("kuehlklappen");

        $laermmessung->herstellerProp = $request->input("herstellerProp");
        $laermmessung->modellProp = $request->input("modellProp");
        $laermmessung->werknummerProp = $request->input("werknummerProp");
        $laermmessung->bauartProp = $request->input("bauartProp");
        $laermmessung->durchmesserNominell = $request->input("durchmesserNominell");
        $laermmessung->durchmesserGemessen = $request->input("durchmesserGemessen");
        $laermmessung->blattanzahl = $request->input("blattanzahl");
        $laermmessung->blattspitzenform = $request->input("blattspitzenform");
        $laermmessung->drehrichtungProp = $request->input("drehrichtungProp");
        $laermmessung->nabenbezeichnung = $request->input("nabenbezeichnung");
        $laermmessung->typenbezeichnung = $request->input("typenbezeichnung");

        $laermmessung->leiter = $request->input("leiter");
        $laermmessung->messstelleBoden1 = $request->input("messstelleBoden1");
        $laermmessung->messstelleBoden2 = $request->input("messstelleBoden2");
        $laermmessung->pilot = $request->input("pilot");
        $laermmessung->beobachterFlugzeug = $request->input("beobachterFlugzeug");

        $laermmessung->notiz = $request->input("notiz");
        $laermmessung->user_id = auth()->user()->id;
        $laermmessung->save();

       
        //return response()->json(['error'=>$validator->errors()->all()]);
        return redirect("/laermmessungen")->with('success', "Lärmmessung $laermmessung->name gespeichert!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $laermmessung = Laermmessung::find($id);

        $laermmessungDateien = LaermmessungDatei::where('laermmessung_id',$id)->orderBy('messdatenNr_id','asc')->get();

        $pegelwert_durschnitt = DB::table('laermmessung_daten')
                                    ->where('laermmessung_id',$id)
                                    ->where('checked',1)
                                    ->where('verwendet',1)
                                    ->avg('messpegel_korr');
        
        //dd($pegelwert_durschnitt);

                return view('laermmessungen.show',
                compact(
                    'laermmessung',
                    'laermmessungDateien',
                    'pegelwert_durschnitt'
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
        $laermmessung = Laermmessung::find($id);

        $laermmessungDateien = LaermmessungDatei::where('laermmessung_id',$id)->orderBy('messdatenNr_id','asc')->get();

        $pegelwert_durschnitt = DB::table('laermmessung_daten')
                                    ->where('laermmessung_id',$id)
                                    ->where('checked',1)
                                    ->where('verwendet',1)
                                    ->avg('messpegel_korr');

        $anzahlMessfluege = DB::table('laermmessung_daten')
                                ->where('laermmessung_id',$id)
                                ->where('checked',1)
                                ->where('verwendet',1)
                                ->count();
        
        $pegelwert_summe = DB::table('laermmessung_daten')
                                ->where('laermmessung_id',$id)
                                ->where('checked',1)
                                ->where('verwendet',1)
                                ->sum('messpegel_korr');

        $pegelwert_korr_summe = DB::table('laermmessung_daten')
                                ->where('laermmessung_id',$id)
                                ->where('checked',1)
                                ->where('verwendet',1)
                                ->sum('messpegel_korr_quadr');


       if($pegelwert_durschnitt != NULL || $pegelwert_summe != NULL || $pegelwert_korr_summe != NULL || $anzahlMessfluege != NULL){

            $stabw_zaehler = $pegelwert_korr_summe - $pegelwert_durschnitt * $pegelwert_summe;
            $stabw_nenner = $anzahlMessfluege - 1;

            if($anzahlMessfluege >= 2){
                $standardabweichung = pow($stabw_zaehler / $stabw_nenner,0.5);    
                
            }else{
                $standardabweichung = 0;

            }

            

            //$standardabweichung = pow((($pegelwert_korr_summe-$pegelwert_durschnitt*$pegelwert_summe)/($anzahlMessfluege-1)),0.5);


            switch($anzahlMessfluege){
                case 0:
                    $faktor_t = 0;
                    break;
                    case 1:
                        $faktor_t = 0;
                        break;
                        case 2:
                            $faktor_t = 0;
                            break;
                case 3:
                    $faktor_t = 2.92;
                    break;
                case 4:
                    $faktor_t = 2.35;
                    break;
                case 5:
                    $faktor_t = 2.13;
                    break;
                case 6:
                    $faktor_t = 2.015;
                    break;
                case 7:
                    $faktor_t = 1.94;
                    break;
                case 8:
                    $faktor_t = 1.895;
                    break;
                case 9:
                    $faktor_t = 1.86;
                    break;
                case 10:
                    $faktor_t = 1.83;
                    break;
            }

            $vertrauensgrenze = ($standardabweichung*$faktor_t)/sqrt($anzahlMessfluege);

        }else{

            $faktor_t = 0;
            $vertrauensgrenze = 0;
            $standardabweichung = 0;
        }


        //dd($vertrauensgrenze);

                return view('laermmessungen.edit',
                                    compact(
                                        'laermmessung',
                                        'laermmessungDateien',
                                        'pegelwert_durschnitt',
                                        'anzahlMessfluege',
                                        'faktor_t',
                                        'standardabweichung',
                                        'vertrauensgrenze',
                                        'pegelwert_durschnitt',
                                        'pegelwert_summe',
                                        'pegelwert_korr_summe'
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

        $mtow = $request->input("mtow");

        $D15 = $request->input("D15");
        $RC = $request->input("RC");
        $Vy = $request->input("Vy");

        if($D15 == NULL || $RC == NULL || $Vy == NULL){
            $Href = 150;
        }else{
            $Href = number_format(15 + (2500-$D15)*($RC/sqrt(pow($Vy,2)-pow($RC,2))),2); 

            if($Href >= 450){
                $Href = 450;
            }else{
                $Href = number_format(15 + (2500-$D15)*($RC/sqrt(pow($Vy,2)-pow($RC,2))),2);
            }
        }



        //Lärmgrenze nach Kap.10 Gruppe 1
        if($request->input("fluggeraetGruppe") == 'Kap10-G1'){
            if($mtow >= 1400 && $mtow <= 8618){
                $laermgrenzwert = 88;
            }
            if($mtow > 600 && $mtow < 1400){
                $laermgrenzwert = 83.23 + 32.67 * log($mtow/1000) / log(10);

            }
            if($mtow <= 600){
                $laermgrenzwert = 76;
            }
        }


        //Lärmgrenze nach Kap.10 Gruppe 2
        if($request->input("fluggeraetGruppe") == 'Kap10-G2'){
            if($mtow >= 1500 && $mtow <= 8618){
                $laermgrenzwert = 85;
            }
            if($mtow > 570 && $mtow < 1500){
                $laermgrenzwert = 78.71 + 35.7 * log($mtow/1000) / log(10);

            }
            if($mtow <= 570){
                $laermgrenzwert = 70;
            }
        }


        // Lärmgrenze nach Kap.10 Gruppe Ultraleichtflugzeuge
        if($request->input("fluggeraetGruppe") == 'Kap10-UL'){
            if($mtow >= 570 && $mtow <= 650){
                $laermgrenzwert = 70;
            }
            if($mtow > 472.5 && $mtow < 570){
                $laermgrenzwert = $mtow * 10/97.5 + 11.538;
            }
            if($mtow <= 472.5){
                $laermgrenzwert = 60;
            }
        }

        // Lärmgrenze nach Kap.UL NfL-2-480-19 Gruppe Ultraleichtflugzeuge
        if($request->input("fluggeraetGruppe") == 'LVL'){
            if($mtow <= 472.5){
                $laermgrenzwert = 60;
            }
        }

        // Lärmgrenze nach Kap.11 Gruppe Ultraleichthubschrauber
        if($request->input("fluggeraetGruppe") == 'Kap11-UL'){
            if($mtow <= 600){
                $laermgrenzwert = 82;
            }
        }

        $laermmessung = Laermmessung::find($id);
        $laermmessung->kunde_id = $request->input("kunde_id");
        $laermmessung->berichtGesperrt = $request->input("berichtGesperrt");
        $laermmessung->messdatum = $request->input("messdatum");
        $laermmessung->messort = $request->input("messort");
        $laermmessung->messortHoehe = $request->input("messortHoehe");
        $laermmessung->fluggeraetGruppe = $request->input("fluggeraetGruppe");
        $laermmessung->herstellerFluggeraet = $request->input("fluggeraetHersteller");
        $laermmessung->fluggeraet = $request->input("fluggeraet");
        $laermmessung->muster = $request->input("muster");
        $laermmessung->baureihe = $request->input("baureihe");
        $laermmessung->werknummer = $request->input("werknummer");
        $laermmessung->baujahr = $request->input("baujahr");
        $laermmessung->fahrwerk = $request->input("fahrwerk");
        $laermmessung->kennblatt = $request->input("kennblattNr");
        $laermmessung->kennung = $request->input("kennung");
        $laermmessung->mtow = $request->input("mtow");
        $laermmessung->D15 = $request->input("D15");
        $laermmessung->spannweite = $request->input("spannweite");
        $laermmessung->v_max = $request->input("Vmax");
        $laermmessung->v_min = $request->input("Vmin");
        $laermmessung->v_h = $request->input("Vh");
        $laermmessung->RC = $request->input("RC");
        $laermmessung->Vy = $request->input("Vy");
        $laermmessung->delta_CAS_IAS = $request->input("delta_CASIAS");
        $laermmessung->Href = $Href;
        $laermmessung->laermgrenzwert = $laermgrenzwert;

        $laermmessung->motor = $request->input("motor");
        $laermmessung->untersetzung = $request->input("untersetzung");
        $laermmessung->motorWerknummer = $request->input("motorWerknummer");
        $laermmessung->motorZylinder = $request->input("motorZylinder");
        $laermmessung->motorArbeitsweise = $request->input("motorArbeitsweise");
        $laermmessung->kraftstoffZufuhr = $request->input("kraftstoffZufuhr");
        $laermmessung->nennleistung = $request->input("nennleistung");
        $laermmessung->drehzahlRC = $request->input("drehzahlRC");
        $laermmessung->ladedruckRC = $request->input("ladedruckRC");
        $laermmessung->anzahlAbgasrohre = $request->input("anzahlAbgasrohre");
        $laermmessung->schalldaempfer = $request->input("schalldaempfer");
        $laermmessung->kuehlklappen = $request->input("kuehlklappen");

        $laermmessung->herstellerProp = $request->input("herstellerProp");
        $laermmessung->herstellerProp2 = $request->input("herstellerProp2");
        $laermmessung->modellProp = $request->input("modellProp");
        $laermmessung->modellProp2 = $request->input("modellProp2");
        $laermmessung->werknummerProp = $request->input("werknummerProp");
        $laermmessung->werknummerProp2 = $request->input("werknummerProp2");
        $laermmessung->bauartProp = $request->input("bauartProp");
        $laermmessung->durchmesserNominell = $request->input("durchmesserNominell");
        $laermmessung->durchmesserNominell2 = $request->input("durchmesserNominell2");
        $laermmessung->durchmesserGemessen = $request->input("durchmesserGemessen");
        $laermmessung->durchmesserGemessen2 = $request->input("durchmesserGemessen2");
        $laermmessung->blattanzahl = $request->input("blattanzahl");
        $laermmessung->blattanzahl2 = $request->input("blattanzahl2");
        $laermmessung->blattspitzenform = $request->input("blattspitzenform");
        $laermmessung->drehrichtungProp = $request->input("drehrichtungProp");
        $laermmessung->nabenbezeichnung = $request->input("nabenbezeichnung");
        $laermmessung->typenbezeichnung = $request->input("typenbezeichnung");
        $laermmessung->notiz = $request->input("notiz");

        $laermmessung->leiter = $request->input("leiter");
        $laermmessung->messstelleBoden1 = $request->input("messstelleBoden1");
        $laermmessung->messstelleBoden2 = $request->input("messstelleBoden2");
        $laermmessung->pilot = $request->input("pilot");
        $laermmessung->beobachterFlugzeug = $request->input("beobachterFlugzeug");
        $laermmessung->protokolldatum = $request->input("protokolldatum");

        $laermmessung->user_id = auth()->user()->id;
        $laermmessung->save();

        return redirect("/laermmessungen/$laermmessung->id/edit")->with('success', "Basisdaten $laermmessung->type geändert!");
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

    public function laermmessBerichtPDF($id)
    {
        $laermmessung = Laermmessung::find($id);
        $laermmessDaten = LaermmessungDatei::where('laermmessung_id',$id)
                                                ->where('checked','1')
                                                ->where('verwendet','1')
                                                ->orderBy('messdatenNr_id','asc')
                                                ->get();

        $datum = $laermmessung->messdatum;
        //$jahrHeute = Carbon::now()->format('Y');
        $laermmessDatumJahr = substr($datum,0,-6);
        $berichtnummer = "$laermmessDatumJahr-$id";
        $fluggeraetGruppe = $laermmessung->fluggeraetGruppe;

        if (count($laermmessDaten) < 6){
            return redirect("/laermmessungen/$laermmessung->id/edit")->with('error', "Es benötigt 6 gültige Messungen für die Erstellung des Berichtes");
        }

        $pegelwert_durschnitt = DB::table('laermmessung_daten')
                                    ->where('laermmessung_id',$id)
                                    ->where('checked',1)
                                    ->where('verwendet','1')
                                    ->avg('messpegel_korr');
                                    
        $pegelwert_summe = DB::table('laermmessung_daten')
                                    ->where('laermmessung_id',$id)
                                    ->where('checked',1)
                                    ->where('verwendet',1)
                                    ->sum('messpegel_korr');

        $pegelwertUmgeb_durschnitt = DB::table('laermmessung_daten')
                                    ->where('laermmessung_id',$id)
                                    ->where('checked',1)
                                    ->where('verwendet','1')
                                    ->avg('messpegel_umgeb');

        $laermmessDatei_beginn = LaermmessungDatei::where('laermmessung_id',$id)
                                                ->Where('checked','1')
                                                ->where('verwendet','1')
                                                ->orderBy('messdatenNr_id','asc')
                                                ->first();

        $laermmessDatei_ende = LaermmessungDatei::where('laermmessung_id',$id)
                                                ->Where('checked','1')
                                                ->where('verwendet','1')
                                                ->orderBy('messdatenNr_id','desc')
                                                ->first();

        $anzahlMessfluege = DB::table('laermmessung_daten')
                                                ->where('laermmessung_id',$id)
                                                ->where('checked',1)
                                                ->where('verwendet',1)
                                                ->count();

        $pegelwert_korr_summe = DB::table('laermmessung_daten')
                                ->where('laermmessung_id',$id)
                                ->where('checked',1)
                                ->where('verwendet',1)
                                ->sum('messpegel_korr_quadr');


        $stabw_zaehler = $pegelwert_korr_summe - $pegelwert_durschnitt * $pegelwert_summe;
        $stabw_nenner = $anzahlMessfluege - 1;

        $standardabweichung = pow($stabw_zaehler / $stabw_nenner,0.5);

        //$faktor_t = LaermmessungFaktorT::where('n',$anzahlMessfluege)->pluck('t','n');

        switch($anzahlMessfluege){
            case 3:
                $faktor_t = 2.92;
                break;
            case 4:
                $faktor_t = 2.35;
                break;
            case 5:
                $faktor_t = 2.13;
                break;
            case 6:
                $faktor_t = 2.015;
                break;
            case 7:
                $faktor_t = 1.94;
                break;
            case 8:
                $faktor_t = 1.895;
                break;
            case 9:
                $faktor_t = 1.86;
                break;
            case 10:
                $faktor_t = 1.83;
                break;
        }


        $vertrauensgrenze = ($standardabweichung*$faktor_t)/sqrt($anzahlMessfluege);

        //dd($luftdruck_beginn->QNH);

        $kundeAdresse = KundeAdresse::select('kunde_adressen.*',
                                        'kunde_adresse_laender.name as land')
                                        ->leftjoin('kunde_adresse_laender','kunde_adressen.kunde_adresse_land_id','=', 'kunde_adresse_laender.id')
                                        ->where('kunde_id',$laermmessung->kunde_id)
                                        ->get();


        foreach($kundeAdresse as $detail){
            $strasse = $detail->strasse;
            $plz = $detail->postleitzahl;
            $stadt = $detail->stadt;
            $land = $detail->land;
            break;
        }
        //dd($stadt);   

        $pdf = PDF::loadView('laermmessungen.pdf', [
                                'laermmessung' => $laermmessung,
                                'kundeStrasse' => $strasse,
                                'kundePlz' => $plz,
                                'kundeStadt' => $stadt,
                                'kundeLand' => $land,
                                'laermmessDaten' => $laermmessDaten,
                                'laermmessDatei_beginn' => $laermmessDatei_beginn,
                                'laermmessDatei_ende' => $laermmessDatei_ende,
                                'pegelwert_durschnitt' => $pegelwert_durschnitt,
                                'pegelwertUmgeb_durschnitt' => $pegelwertUmgeb_durschnitt,
                                'anzahlMessfluege' => $anzahlMessfluege,
                                'faktor_t' => $faktor_t,
                                'standardabweichung' => $standardabweichung,
                                'vertrauensgrenze' => $vertrauensgrenze,
                                'pegelwert_durschnitt' => $pegelwert_durschnitt,
                                'pegelwert_summe' => $pegelwert_summe,
                                'pegelwert_korr_summe' => $pegelwert_korr_summe
                            ]);
        //$pdf->setOption('toc', true);               
        $pdf->setOption('margin-top', 15); //** default 10mm */
        $pdf->setOption('header-left', "Bericht-Nr.: ".$berichtnummer."");
        $pdf->setOption('header-font-size', '12');
        if($fluggeraetGruppe == 'Kap11-UL'){
            $pdf->setOption('footer-center', "Protokoll Laermmessung ".$fluggeraetGruppe." / ".$laermmessung->messdatum." / ".$laermmessung->fluggeraet." / ".$laermmessung->kennung."");
        }else{
            $pdf->setOption('footer-center', "Protokoll Laermmessung ".$fluggeraetGruppe." / ".$laermmessung->messdatum." / ".$laermmessung->fluggeraet." / ".$laermmessung->kennung." / ".$laermmessung->typenbezeichnung."");
        }
        $pdf->setOption('footer-right', '[page]/[toPage]');
        $pdf->setOption('footer-font-size', '8');
        return $pdf->download("LFA-Bericht_".$laermmessung->fluggeraet."_".$laermmessung->kennung."_".$laermmessung->typenbezeichnung.".pdf");

    }
}
