<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Session;
use Auth;

use App\Models\Laermmessung;
use App\Models\LaermmessungDatei;
use App\Models\LaermmessungAlpha;
use App\Models\LaermmessungVertrauensbereichT;

class LaermmessungDatenController extends Controller
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



    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $laermmessung_id = request('laermmessungID');
        $laermmessung = Laermmessung::find($laermmessung_id);

        $laermmessungDaten = LaermmessungDatei::orderBy('id','desc')->where('laermmessung_id',$laermmessung_id)->get();

        //dd($laermmessungDaten);

        return view('laermmessungDaten.create',
                                compact(
                                    'laermmessung',
                                    'laermmessungDaten'
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
            'messzeit' => 'required',
            'windgeschwindigkeit' => 'required',
            'windrichtung' => 'required',
            'flugbahn' => 'required',
            'temperaturBoden' => 'required',
            'relFeuchte' => 'required',
            'QNH' => 'required',
            'PropDrehzahl' => 'required',
            'ladedruck' => 'nullable',
            'IAS' => 'required',
            'flughoeheGND' => 'required',
            //'messpegel' => 'required',
            'checked' => 'required'
        ]);
        
        //dd($request->input());
        $laermmessung_id = $request->input("laermmessungID");
        $laermmessung = Laermmessung::find($laermmessung_id);
        $alpha500Tabelle = LaermmessungAlpha::all();

        $laermmessungDaten = LaermmessungDatei::orderBy('id','asc')->where('laermmessung_id',$laermmessung_id)->get();

        $anzahlMessungen = count($laermmessungDaten);

        //dd($anzahlMessungen);

        if($anzahlMessungen == 0){
            $messdatenNr_aktuell = 1;
        }
        else{
            $messdatenNr_aktuell = $anzahlMessungen + 1;
        }

        //dd($messdatenNr_aktuell);

        //Standardwerte der einzelnen Lärmmessung pro Fluggerät
        $fluggeraetGruppe = $laermmessung->fluggeraetGruppe;
        $RC = $laermmessung->RC;
        $Vy = $laermmessung->Vy;
        $D15 = $laermmessung->D15;
        $propDM = $laermmessung->durchmesserGemessen;
        $maxTOpropRPM = $laermmessung->drehzahlRC / $laermmessung->untersetzung;
        $Pt = NULL;
        $Pref = NULL;

        //Messdaten
        $windgeschwindigkeit = $request->input("windgeschwindigkeit");
        $windrichtung = $request->input("windrichtung");
        $flugbahn = $request->input("flugbahn");
        $relFeuchte = $request->input("relFeuchte");
        $tempBoden = $request->input("temperaturBoden");
        $QNH = $request->input("QNH");
        $propDrehzahl = $request->input("PropDrehzahl");
        $ladedruck = $request->input("ladedruck");
        $IAS = $request->input("IAS");
        $flughoeheGND = $request->input("flughoeheGND");
        $seitlAbw = $request->input("seitlAbw");
        $messpegel = $request->input("messpegel");


        if($laermmessung->fluggeraetGruppe == 'Kap11-UL'){    //Kap11 - Gruppe UL Hubschrauber bis 600kg
            //v_h und v_max in km/h werden in kt umgerechnet
            $vh1 = $laermmessung->v_max * 0.9 * 0.5399568;
            $vh2 = $laermmessung->v_h * 0.9 * 0.5399568;
            $vh3 = $laermmessung->v_max * 0.45 * 0.5399568 + 65;
            $vh4 = $laermmessung->v_h * 0.45 * 0.5399568 + 65;

            $v_messung = $IAS / 0.5144444; //Eingabe IAS in m/s wird in kt umgerechnet

            //Auslegung
            //v_r ist Referenzgeschwindigkeit für die Berechnung von v_ar (korrigierte Referenzgeschwindigkeit)
            $v_r = round(min($vh1,$vh2,$vh3,$vh4) * 0.514444,1); // [m/s]  
            $c_r_25 = pow(1.4*287.1*(25+273.1),0.5);
            $v_tip_ref = $laermmessung->durchmesserGemessen * 3.141 * $laermmessung->drehzahlRC / 60;
            $v_atr = $v_r + $v_tip_ref;
            $M_atr = $v_atr / $c_r_25;
            $H_ziel = 150; //konstante Überflughöhe Heli

            $temperaturHoehe = $tempBoden - (0.65*$H_ziel/100);
            $c_hoehe = pow(1.4*287.1*($temperaturHoehe+273.1),0.5);
            $v_ar = ($c_hoehe*$M_atr) - $v_tip_ref;
            $v_r_ziel = $v_ar / 0.5144444; //Referenzgeschwindkeit in m/s für Überflug in 150m wird in kt umgerechnet --> Abweichung +- 3kt
            $v_r_ziel_max = $v_r_ziel + 3;
            $v_r_ziel_min = $v_r_ziel - 3;
        

            if($v_messung >= $v_r_ziel_min && $v_messung <= $v_r_ziel_max){
                $v_messung = $IAS / 0.5144444;
                $gueltig = 1;
            }else{
                $v_messung = $IAS / 0.5144444;
                $gueltig = 0;
            }

            $H_messung = $flughoeheGND;

            $delta_1 = 12.5 * log($H_messung / $H_ziel) / log(10);
            $v_ar = $v_ar / 0.5144444; //Referenzgeschwindigekeit von m/s in kt umgerechnet
            $delta_2 = 10 * log($v_ar / $v_messung) / log(10);

            

            $messpegel_korr = round($messpegel + $delta_1 + $delta_2,2);

            $messpegel_korr_quadr = pow($messpegel_korr,2);
            //dd($messpegel_korr);

            $laermmessungDaten = new LaermmessungDatei;

            $laermmessungDaten->messdatenNr_id = $messdatenNr_aktuell;
            $laermmessungDaten->laermmessung_id = $request->input("laermmessungID");
            $laermmessungDaten->messzeit = $request->input("messzeit");
            $laermmessungDaten->windgeschwindigkeit = $request->input("windgeschwindigkeit");
            $laermmessungDaten->windrichtung = $request->input("windrichtung");
            $laermmessungDaten->flugbahn = $request->input("flugbahn");
            $laermmessungDaten->IAS = $request->input("IAS");
            $laermmessungDaten->temperatur_boden = $request->input("temperaturBoden"); 
            $laermmessungDaten->temperatur_flugh = $temperaturHoehe;
            $laermmessungDaten->luftfeuchte_rel = $request->input("relFeuchte");
            $laermmessungDaten->QNH = $request->input("QNH");
            $laermmessungDaten->drehzahl = $request->input("PropDrehzahl");
            $laermmessungDaten->ladedruck = $request->input("ladedruck");
            $laermmessungDaten->hoehe_ueb_micro = $request->input("flughoeheGND");
            $laermmessungDaten->seitl_abweichung = $request->input("seitlAbw");
            $laermmessungDaten->messpegel = $request->input("messpegel");
            $laermmessungDaten->messpegel_umgeb = $request->input("messpegelUmgeb");
            $laermmessungDaten->v_r = $v_r;
            $laermmessungDaten->v_tip_ref = $v_tip_ref;
            $laermmessungDaten->v_atr = $v_atr;
            $laermmessungDaten->M_atr = $M_atr;
            $laermmessungDaten->v_r_ziel = $v_r_ziel;

            $laermmessungDaten->delta_1 = $delta_1;
            $laermmessungDaten->delta_2 = $delta_2;

            $laermmessungDaten->messpegel_korr = $messpegel_korr;
            $laermmessungDaten->messpegel_korr_quadr = $messpegel_korr_quadr;
            $laermmessungDaten->checked = $gueltig;
            $laermmessungDaten->verwendet = $request->input("verwendet");
            $laermmessungDaten->notiz = $request->input("notiz");

            $laermmessungDaten->user_id = auth()->user()->id;
            $laermmessungDaten->save();
            
        }
        else{ //restliche Gruppen

            if($fluggeraetGruppe == 'LVL'){
                $Href = number_format(15 + (2500-$D15)*($RC/sqrt(pow($Vy,2)-pow($RC,2))),2);
                $HrefMin = 75;
                $HrefMax = 150;
            }else{
                //Berechnungen
                $Href = number_format(15 + (2500-$D15)*($RC/sqrt(pow($Vy,2)-pow($RC,2))),2);
                $HrefMin = $Href - 0.2*$Href;
                $HrefMax = $Href + 0.2*$Href;
            }
            
            if($request->input("seitlAbw") != NULL){
                $flughoeheGND_korr = $flughoeheGND / cos($seitlAbw*pi()/180);
            }
            else{
                $flughoeheGND_korr = $flughoeheGND;
            }
            
            if($flughoeheGND_korr < $HrefMin || $flughoeheGND_korr > $HrefMax){
                $gueltig = 0;
            }else{
                $gueltig = $request->input("checked");
            }
        
            $u = ($propDM * pi() * $maxTOpropRPM) / 60;     //Referenz Umfangsgeschw. des Propellers errechnet aus angegebenen Motordrehzahl im besten Steigen
            $ut = ($propDM * pi() * $propDrehzahl) / 60;    //tatsächliche Umfangsgeschw. des Propellers

            $CAS = $IAS;                                                   
            $vt = $CAS;

            $u_helical = pow(pow($ut,2)+pow($vt,2),1/2);


            $temperaturHoehe = $tempBoden - (0.65*$flughoeheGND/100);

            //delta 1
                //Prüfung ob Messung im Messfenster ist
                if($tempBoden < 27 && $tempBoden > 15 && $relFeuchte < 95 && $relFeuchte > 40){
                    $inOut = 1;
                    $delta_1 = 22 * log($flughoeheGND_korr / $Href) / log(10);
                }else{
                    if($tempBoden < 15 && $tempBoden > 2 && $relFeuchte < 95 && $relFeuchte > 80){
                        $inOut = 1;
                        $delta_1 = 22 * log($flughoeheGND_korr / $Href) / log(10);
                    }else{
                        $lineare = -(40/13) * $tempBoden + (1120/13);
                        if($tempBoden > 2 && $tempBoden < 15 && $relFeuchte < 80 && $relFeuchte > $lineare){
                            $inOut = 1;
                            $delta_1 = 22 * log($flughoeheGND_korr / $Href) / log(10);
                        }else{
                            $inOut = 0;
                            $delta_1 = 20 * log($flughoeheGND_korr / $Href) / log(10);
                        }
                    }
                }

            //delta 2
                $at = pow((1.4 * 287.053 * ($temperaturHoehe + 273.15)),1/2);  //tatsächliche Machzahl im Steigflug
                $Mt = pow(pow($ut,2)+pow($vt,2),1/2) / $at;                    //tatsächliche Blattspitzenmachzahl mit Vt = angezeigte Fluggeschwindigkeit

                $aref = pow((1.4 * 287.053 * (-($flughoeheGND_korr/100) * 0.65 + 288.15)),1/2);
                $Mref = pow(pow($u,2)+pow($Vy,2),1/2) / $aref;                  //ref Blattspitzenmachzahl mit Vy

                $Mref_minus_Mt = $Mref-$Mt;

                if($Mt > $Mref){
                    $delta_2 = 0;
                }else{
                    if($Mt <= 0.7 && ($Mref-$Mt) < 0.014){
                        $delta_2 = 0;
                    }else{
                        if(0.7 < $Mt && $Mt <= 0.8 && ($Mref-$Mt) < 0.007){
                            $delta_2 = 0;
                        }else{
                            if($Mt > 0.8 && ($Mref-$Mt) < 0.005){
                                $delta_2 = 0;
                            }else{
                                $delta_2 = 150 * log($Mref/$Mt) / log(10);
                            }
                        }
                    }
                }

            //delta 3
                if($Pt || $Pref == NULL){
                    $delta_3 = 0;
                }else{
                    $delta_3 = 17 * log($Pref/$Pt) / log(10);
                }

            //delta 4
                if($inOut == 1){
                    $delta_4 = 0;
                }else{
                    $relFeuchte = ceil(round($relFeuchte / 10)) * 10;
                    $tempBoden = ceil(round($tempBoden / 10)) * 10;
                    
                    // $alpha500_relFeuchte_10 = LaermmessungAlpha::find(10);
                    // $alpha500_10_minus10 = $alpha500_relFeuchte_10->tempMinus10;

                    $alpha500_relFeuchte = LaermmessungAlpha::find($relFeuchte);
                    switch($tempBoden){
                        case -10:
                            $alpha500_relFeuchte_tempBoden = $alpha500_relFeuchte->tempMinus10;
                            break;
                        case -5:
                            $alpha500_relFeuchte_tempBoden = $alpha500_relFeuchte->tempMinus5;
                            break;
                        case 0:
                            $alpha500_relFeuchte_tempBoden = $alpha500_relFeuchte->temp0;
                            break;
                        case 5:
                            $alpha500_relFeuchte_tempBoden = $alpha500_relFeuchte->tempPlus5;
                            break;
                        case 10:
                            $alpha500_relFeuchte_tempBoden = $alpha500_relFeuchte->tempPlus10;
                            break;
                        case 15:
                            $alpha500_relFeuchte_tempBoden = $alpha500_relFeuchte->tempPlus15;
                            break;
                        case 20:
                            $alpha500_relFeuchte_tempBoden = $alpha500_relFeuchte->tempPlus20;
                            break;
                        case 25:
                            $alpha500_relFeuchte_tempBoden = $alpha500_relFeuchte->tempPlus25;
                            break;
                        case 30:
                            $alpha500_relFeuchte_tempBoden = $alpha500_relFeuchte->tempPlus30;
                            break;
                        case 35:
                            $alpha500_relFeuchte_tempBoden = $alpha500_relFeuchte->tempPlus35;
                            break;
                        case 40:
                            $alpha500_relFeuchte_tempBoden = $alpha500_relFeuchte->tempPlus40;
                            break;
                    }

                    $delta_4 = 0.01 * (($flughoeheGND_korr * $alpha500_relFeuchte_tempBoden) - (0.2 * $Href));
                }

            $messpegel_korr = round($messpegel + $delta_1 + $delta_2 + $delta_3 + $delta_4,2);

            $messpegel_korr_quadr = pow($messpegel_korr,2);

            //dd($messpegel,$delta_1,$delta_2,$delta_3,$delta_4,$messpegel_korr);

            $laermmessungDaten = new LaermmessungDatei;

            $laermmessungDaten->messdatenNr_id = $messdatenNr_aktuell;
            $laermmessungDaten->laermmessung_id = $request->input("laermmessungID");
            $laermmessungDaten->messzeit = $request->input("messzeit");
            $laermmessungDaten->windgeschwindigkeit = $request->input("windgeschwindigkeit");
            $laermmessungDaten->windrichtung = $request->input("windrichtung");
            $laermmessungDaten->flugbahn = $request->input("flugbahn");
            $laermmessungDaten->IAS = $request->input("IAS");
            $laermmessungDaten->temperatur_boden = $request->input("temperaturBoden"); 
            $laermmessungDaten->temperatur_flugh = $temperaturHoehe;
            $laermmessungDaten->luftfeuchte_rel = $request->input("relFeuchte");
            $laermmessungDaten->QNH = $request->input("QNH");
            $laermmessungDaten->drehzahl = $request->input("PropDrehzahl");
            $laermmessungDaten->ladedruck = $request->input("ladedruck");
            $laermmessungDaten->hoehe_ueb_micro = $request->input("flughoeheGND");
            $laermmessungDaten->seitl_abweichung = $request->input("seitlAbw");
            $laermmessungDaten->messpegel = $request->input("messpegel");
            $laermmessungDaten->messpegel_umgeb = $request->input("messpegelUmgeb");
            $laermmessungDaten->blattspitzengeschw = $ut;
            $laermmessungDaten->schallgeschw = $at;
            $laermmessungDaten->spitzen_machzahl = $Mt;
            $laermmessungDaten->Mr_minus_Mt = $Mref_minus_Mt;
            $laermmessungDaten->delta_1 = $delta_1;
            $laermmessungDaten->delta_2 = $delta_2;
            $laermmessungDaten->delta_3 = $delta_3;
            $laermmessungDaten->delta_4 = $delta_4;
            $laermmessungDaten->messpegel_korr = $messpegel_korr;
            $laermmessungDaten->messpegel_korr_quadr = $messpegel_korr_quadr;
            $laermmessungDaten->checked = $gueltig;
            $laermmessungDaten->verwendet = $request->input("verwendet");
            $laermmessungDaten->notiz = $request->input("notiz");

            $laermmessungDaten->user_id = auth()->user()->id;
            $laermmessungDaten->save();
        }
        return redirect("/laermmessungen/$laermmessung->id/edit")->with('success', "Lärmmessungdaten gespeichert!");


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
        $laermmessungDatei = LaermmessungDatei::find($id);

        //dd($laermmessungDatei);

        return view('laermmessungDaten.edit',
                                compact(
                                    'laermmessungDatei'
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
        $this->validate($request,[
                    'messzeit' => 'required',
                    'windgeschwindigkeit' => 'required',
                    'windrichtung' => 'required',
                    'flugbahn' => 'required',
                    'temperaturBoden' => 'required',
                    'relFeuchte' => 'required',
                    'QNH' => 'required',
                    'PropDrehzahl' => 'required',
                    'ladedruck' => 'nullable',
                    'IAS' => 'required',
                    'flughoeheGND' => 'required',
                    'messpegel' => 'required'
                ]);
        
        //dd($request->input());
        $laermmessung_id = $request->input("laermmessungID");
        $laermmessung = Laermmessung::find($laermmessung_id);
        $alpha500Tabelle = LaermmessungAlpha::all();

        $laermmessungDaten = LaermmessungDatei::orderBy('id','asc')->where('laermmessung_id',$laermmessung_id)->get();

        $messdatenNr_aktuell = $request->input("messdatenNr_id");;
 

        //dd($messdatenNr_aktuell);

        //Standardwerte der einzelnen Lärmmessung pro Fluggerät
        $fluggeraetGruppe = $laermmessung->fluggeraetGruppe;
        $RC = $laermmessung->RC;
        $Vy = $laermmessung->Vy;
        $D15 = $laermmessung->D15;
        $propDM = $laermmessung->durchmesserGemessen;
        $maxTOpropRPM = round($laermmessung->drehzahlRC / $laermmessung->untersetzung,0);
        $Pt = NULL;
        $Pref = NULL;

        //Messdaten
        $windgeschwindigkeit = $request->input("windgeschwindigkeit");
        $windrichtung = $request->input("windrichtung");
        $flugbahn = $request->input("flugbahn");
        $relFeuchte = $request->input("relFeuchte");
        $tempBoden = $request->input("temperaturBoden");
        $QNH = $request->input("QNH");
        $propDrehzahl = $request->input("PropDrehzahl");
        $ladedruck = $request->input("ladedruck");
        $IAS = $request->input("IAS");
        $flughoeheGND = $request->input("flughoeheGND");
        $seitlAbw = $request->input("seitlAbw");
        $messpegel = $request->input("messpegel");

        if($laermmessung->fluggeraetGruppe == 'Kap11-UL'){
            //v_h und v_max in km/h werden in kt umgerechnet
            $vh1 = $laermmessung->v_max * 0.9 * 0.5399568;
            $vh2 = $laermmessung->v_h * 0.9 * 0.5399568;
            $vh3 = $laermmessung->v_max * 0.45 * 0.5399568 + 65;
            $vh4 = $laermmessung->v_h * 0.45 * 0.5399568 + 65;

            $v_messung = $IAS / 0.5144444; //Eingabe IAS in m/s wird in kt umgerechnet

            //Auslegung
            //v_r ist Referenzgeschwindigkeit für die Berechnung von v_ar (korrigierte Referenzgeschwindigkeit)
            $v_r = round(min($vh1,$vh2,$vh3,$vh4) * 0.514444,1); // [m/s]  
            $c_r_25 = pow(1.4*287.1*(25+273.1),0.5);
            $v_tip_ref = $laermmessung->durchmesserGemessen * 3.141 * $laermmessung->drehzahlRC / 60;
            $v_atr = $v_r + $v_tip_ref;
            $M_atr = $v_atr / $c_r_25;
            $H_ziel = 150; //konstante Überflughöhe Heli

            $temperaturHoehe = $tempBoden - (0.65*$H_ziel/100);
            $c_hoehe = pow(1.4*287.1*($temperaturHoehe+273.1),0.5);
            $v_ar = ($c_hoehe*$M_atr) - $v_tip_ref;
            $v_r_ziel = $v_ar / 0.5144444; //Referenzgeschwindkeit in m/s für Überflug in 150m wird in kt umgerechnet --> Abweichung +- 3kt
            $v_r_ziel_max = $v_r_ziel + 3;
            $v_r_ziel_min = $v_r_ziel - 3;
        

            if($v_messung >= $v_r_ziel_min && $v_messung <= $v_r_ziel_max){
                $v_messung = $IAS / 0.5144444;
                $gueltig = 1;
            }else{
                $v_messung = $IAS / 0.5144444;
                $gueltig = 0;
            }

            $H_messung = $flughoeheGND;

            $delta_1 = 12.5 * log($H_messung / $H_ziel) / log(10);
            $v_ar = $v_ar / 0.5144444; //Referenzgeschwindigekeit von m/s in kt umgerechnet
            $delta_2 = 10 * log($v_ar / $v_messung) / log(10);

            

            $messpegel_korr = round($messpegel + $delta_1 + $delta_2,2);

            $messpegel_korr_quadr = pow($messpegel_korr,2);
            //dd($messpegel_korr);

            $laermmessungDaten = LaermmessungDatei::find($id);

            $laermmessungDaten->messdatenNr_id = $messdatenNr_aktuell;
            $laermmessungDaten->laermmessung_id = $request->input("laermmessungID");
            $laermmessungDaten->messzeit = $request->input("messzeit");
            $laermmessungDaten->windgeschwindigkeit = $request->input("windgeschwindigkeit");
            $laermmessungDaten->windrichtung = $request->input("windrichtung");
            $laermmessungDaten->flugbahn = $request->input("flugbahn");
            $laermmessungDaten->IAS = $request->input("IAS");
            $laermmessungDaten->temperatur_boden = $request->input("temperaturBoden"); 
            $laermmessungDaten->temperatur_flugh = $temperaturHoehe;
            $laermmessungDaten->luftfeuchte_rel = $request->input("relFeuchte");
            $laermmessungDaten->QNH = $request->input("QNH");
            $laermmessungDaten->drehzahl = $request->input("PropDrehzahl");
            $laermmessungDaten->ladedruck = $request->input("ladedruck");
            $laermmessungDaten->hoehe_ueb_micro = $request->input("flughoeheGND");
            $laermmessungDaten->seitl_abweichung = $request->input("seitlAbw");
            $laermmessungDaten->messpegel = $request->input("messpegel");
            $laermmessungDaten->messpegel_umgeb = $request->input("messpegelUmgeb");
            $laermmessungDaten->v_r = $v_r;
            $laermmessungDaten->v_tip_ref = $v_tip_ref;
            $laermmessungDaten->v_atr = $v_atr;
            $laermmessungDaten->M_atr = $M_atr;
            $laermmessungDaten->v_r_ziel = $v_r_ziel;

            $laermmessungDaten->delta_1 = $delta_1;
            $laermmessungDaten->delta_2 = $delta_2;

            $laermmessungDaten->messpegel_korr = $messpegel_korr;
            $laermmessungDaten->messpegel_korr_quadr = $messpegel_korr_quadr;
            $laermmessungDaten->checked = $gueltig;
            $laermmessungDaten->verwendet = $request->input("verwendet");
            $laermmessungDaten->notiz = $request->input("notiz");

            $laermmessungDaten->user_id = auth()->user()->id;
            $laermmessungDaten->save();
            
        }
        else{

            if($fluggeraetGruppe == 'LVL'){
                $Href = number_format(15 + (2500-$D15)*($RC/sqrt(pow($Vy,2)-pow($RC,2))),2);
                $HrefMin = 75;
                $HrefMax = 150;
            }else{
                //Berechnungen
                $Href = number_format(15 + (2500-$D15)*($RC/sqrt(pow($Vy,2)-pow($RC,2))),2);
                $HrefMin = $Href - 0.2*$Href;
                $HrefMax = $Href + 0.2*$Href;
            }
            
            if($request->input("seitlAbw") != NULL){
                $flughoeheGND_korr = $flughoeheGND / cos($seitlAbw*pi()/180);
            }
            else{
                $flughoeheGND_korr = $flughoeheGND;
            }
            
            if($flughoeheGND_korr < $HrefMin || $flughoeheGND_korr > $HrefMax){
                $gueltig = 0;
            }else{
                $gueltig = $request->input("checked");
            }
        
            $u = ($propDM * pi() * $maxTOpropRPM) / 60;     //Referenz Umfangsgeschw. des Propellers errechnet aus angegebenen Motordrehzahl im besten Steigen
            $ut = ($propDM * pi() * $propDrehzahl) / 60;    //tatsächliche Umfangsgeschw. des Propellers

            $CAS = $IAS;                                                   
            $vt = $CAS;

            $u_helical = pow(pow($ut,2)+pow($vt,2),1/2);


            $temperaturHoehe = $tempBoden - (0.65*$flughoeheGND/100);

            //delta 1 Höhenkorrektur
                //Prüfung ob Messung im Messfenster ist
                if($tempBoden < 27 && $tempBoden > 15 && $relFeuchte < 95 && $relFeuchte > 40){
                    $inOut = 1;
                    $delta_1 = 22 * log($flughoeheGND_korr / $Href) / log(10);
                }else{
                    if($tempBoden < 15 && $tempBoden > 2 && $relFeuchte < 95 && $relFeuchte > 80){
                        $inOut = 1;
                        $delta_1 = 22 * log($flughoeheGND_korr / $Href) / log(10);
                    }else{
                        $lineare = -(40/13) * $tempBoden + (1120/13);
                        if($tempBoden > 2 && $tempBoden < 15 && $relFeuchte < 80 && $relFeuchte > $lineare){
                            $inOut = 1;
                            $delta_1 = 22 * log($flughoeheGND_korr / $Href) / log(10);
                        }else{
                            $inOut = 0;
                            $delta_1 = 20 * log($flughoeheGND_korr / $Href) / log(10);
                        }
                    }
                }

            //delta 2 Korrektur der Blattspitzenmachzahl
                $at = pow((1.4 * 287.053 * ($temperaturHoehe + 273.15)),1/2);  //tatsächliche Machzahl im Steigflug
                $Mt = pow(pow($ut,2)+pow($vt,2),1/2) / $at;                    //tatsächliche Blattspitzenmachzahl mit Vt = angezeigte Fluggeschwindigkeit

                $aref = pow((1.4 * 287.053 * (-($flughoeheGND_korr/100) * 0.65 + 288.15)),1/2);
                $Mref = pow(pow($u,2)+pow($Vy,2),1/2) / $aref;                  //ref Blattspitzenmachzahl mit Vy

                $Mref_minus_Mt = $Mref-$Mt;

                if($Mt > $Mref){
                    $delta_2 = 0;
                }else{
                    if($Mt <= 0.7 && ($Mref-$Mt) < 0.014){
                        $delta_2 = 0;
                    }else{
                        if(0.7 < $Mt && $Mt <= 0.8 && ($Mref-$Mt) < 0.007){
                            $delta_2 = 0;
                        }else{
                            if($Mt > 0.8 && ($Mref-$Mt) < 0.005){
                                $delta_2 = 0;
                            }else{
                                $delta_2 = 150 * log($Mref/$Mt) / log(10);
                            }
                        }
                    }
                }

            //delta 3 Leistungskorrektur
                if($Pt || $Pref == NULL){
                    $delta_3 = 0;
                }else{
                    $delta_3 = 17 * log($Pref/$Pt) / log(10);
                }

            //delta 4 Korrektur der atmosphärischen Dämpfung
                if($inOut == 1){
                    $delta_4 = 0;
                }else{
                    $relFeuchte = ceil(round($relFeuchte / 10)) * 10;
                    $tempBoden = ceil(round($tempBoden / 10)) * 10;
                    
                    // $alpha500_relFeuchte_10 = LaermmessungAlpha::find(10);
                    // $alpha500_10_minus10 = $alpha500_relFeuchte_10->tempMinus10;

                    $alpha500_relFeuchte = LaermmessungAlpha::find($relFeuchte);
                    switch($tempBoden){
                        case -10:
                            $alpha500_relFeuchte_tempBoden = $alpha500_relFeuchte->tempMinus10;
                            break;
                        case -5:
                            $alpha500_relFeuchte_tempBoden = $alpha500_relFeuchte->tempMinus5;
                            break;
                        case 0:
                            $alpha500_relFeuchte_tempBoden = $alpha500_relFeuchte->temp0;
                            break;
                        case 5:
                            $alpha500_relFeuchte_tempBoden = $alpha500_relFeuchte->tempPlus5;
                            break;
                        case 10:
                            $alpha500_relFeuchte_tempBoden = $alpha500_relFeuchte->tempPlus10;
                            break;
                        case 15:
                            $alpha500_relFeuchte_tempBoden = $alpha500_relFeuchte->tempPlus15;
                            break;
                        case 20:
                            $alpha500_relFeuchte_tempBoden = $alpha500_relFeuchte->tempPlus20;
                            break;
                        case 25:
                            $alpha500_relFeuchte_tempBoden = $alpha500_relFeuchte->tempPlus25;
                            break;
                        case 30:
                            $alpha500_relFeuchte_tempBoden = $alpha500_relFeuchte->tempPlus30;
                            break;
                        case 35:
                            $alpha500_relFeuchte_tempBoden = $alpha500_relFeuchte->tempPlus35;
                            break;
                        case 40:
                            $alpha500_relFeuchte_tempBoden = $alpha500_relFeuchte->tempPlus40;
                            break;
                    }

                    $delta_4 = 0.01 * (($flughoeheGND_korr * $alpha500_relFeuchte_tempBoden) - (0.2 * $Href));
                }

            $messpegel_korr = round($messpegel + $delta_1 + $delta_2 + $delta_3 + $delta_4,2);

            $messpegel_korr_quadr = pow($messpegel_korr,2);

            //dd($messpegel,$delta_1,$delta_2,$delta_3,$delta_4,$messpegel_korr);

            $laermmessungDaten = LaermmessungDatei::find($id);

            $laermmessungDaten->messdatenNr_id = $messdatenNr_aktuell;
            $laermmessungDaten->laermmessung_id = $request->input("laermmessungID");
            $laermmessungDaten->messzeit = $request->input("messzeit");
            $laermmessungDaten->windgeschwindigkeit = $request->input("windgeschwindigkeit");
            $laermmessungDaten->windrichtung = $request->input("windrichtung");
            $laermmessungDaten->flugbahn = $request->input("flugbahn");
            $laermmessungDaten->IAS = $request->input("IAS");
            $laermmessungDaten->temperatur_boden = $request->input("temperaturBoden"); 
            $laermmessungDaten->temperatur_flugh = $temperaturHoehe;
            $laermmessungDaten->luftfeuchte_rel = $request->input("relFeuchte");
            $laermmessungDaten->QNH = $request->input("QNH");
            $laermmessungDaten->drehzahl = $request->input("PropDrehzahl");
            $laermmessungDaten->ladedruck = $request->input("ladedruck");
            $laermmessungDaten->hoehe_ueb_micro = $request->input("flughoeheGND");
            $laermmessungDaten->seitl_abweichung = $request->input("seitlAbw");
            $laermmessungDaten->messpegel = $request->input("messpegel");
            $laermmessungDaten->messpegel_umgeb = $request->input("messpegelUmgeb");
            $laermmessungDaten->blattspitzengeschw = $ut;
            $laermmessungDaten->schallgeschw = $at;
            $laermmessungDaten->spitzen_machzahl = $Mt;
            $laermmessungDaten->Mr_minus_Mt = $Mref_minus_Mt;
            $laermmessungDaten->delta_1 = $delta_1;
            $laermmessungDaten->delta_2 = $delta_2;
            $laermmessungDaten->delta_3 = $delta_3;
            $laermmessungDaten->delta_4 = $delta_4;
            $laermmessungDaten->messpegel_korr = $messpegel_korr;
            $laermmessungDaten->messpegel_korr_quadr = $messpegel_korr_quadr;
            $laermmessungDaten->checked = $gueltig;
            $laermmessungDaten->verwendet = $request->input("verwendet");
            $laermmessungDaten->notiz = $request->input("notiz");

            $laermmessungDaten->user_id = auth()->user()->id;
            $laermmessungDaten->save();
        }

            return redirect("/laermmessungen/$laermmessung->id/edit")->with('success', "Lärmmessungdaten geändert!");
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
