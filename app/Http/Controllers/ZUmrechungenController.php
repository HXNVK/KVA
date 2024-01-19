<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Auth;
use DB;

use App\Models\Auftrag;
use App\Models\Auftrag01Alt;
use App\Models\Kunde;
use App\Models\Kunde01Alt;
use App\Models\Fluggeraet;
use App\Models\Projekt;
use App\Models\Projekt01Alt;
use App\Models\Projekt01Neu;
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


class AuftraegeNeuController extends Controller
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
        
        $auftraegeAlt = Auftrag01Alt::orderBy('AA0', 'desc')->get();
        
        //dd($projekteAlt);

        return view('auftraegeNeu.index',compact(
                                            'auftraegeAlt'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $auftraegeAlt = Auftrag01Alt::all();

        foreach($auftraegeAlt as $auftragAlt){


            if(Str::of($auftragAlt->AA18)->containsAll(['NVK'])){
                $userID = 1;
            }
            elseif(Str::of($auftragAlt->AA18)->containsAll(['BS'])){
                $userID = 5;
            }
            elseif(Str::of($auftragAlt->AA18)->containsAll(['TKA'])){
                $userID = 6;
            }
            elseif(Str::of($auftragAlt->AA18)->containsAll(['RKS'])){
                $userID = 7;
            }else{
                $userID = 1;
            }

            if($auftragAlt->AA9 == "nc"){
                $propeller = "$auftragAlt->AA7 / $auftragAlt->AA9";
            }else{
                $propeller = $auftragAlt->AA7;
            }
            
            if($auftragAlt->AA10 == "zug"){
                $anordnung = "Zug";
            }
            elseif($auftragAlt->AA10 == "druck"){
                $anordnung = "Druck";
            }
            else{
                $anordnung = NULL;
            }

            switch($auftragAlt->AA13){
                case "ohne":
                    $aufkleber = 'ohne';
                    break;
                case "gross":
                    $aufkleber = "Helix";
                    break;
                case "mittel":
                    $aufkleber = "Helix";
                    break;
                case "mini":
                    $aufkleber = "Helix";
                    break;
                case "kunde":
                    $aufkleber = "Kunde";
                    break;
            }

            switch($auftragAlt->AA11){
                case "bk":
                    $farbe = 'S';
                    break;
                case "sw":
                    $farbe = "SW";
                    break;
                case "cv":
                    $farbe = "CV";
                    break;
            }

            if($auftragAlt->AA5 == '-' || $auftragAlt->AA5 == NULL){
                $untersetzung = NULL;
            }
            if(Str::of($auftragAlt->AA18)->containsAll(['1:'])){
                $untersetzung = str_replace(Str::of($auftragAlt->AA5)->after('1:'),',','.');
            }

            if($auftragAlt->AA33 == '25' && $auftragAlt->AA36 == '12'){
                $buchsen = 'Set 6x BU-HX 8/13x24.5mm';
            }
            else{
                $buchsen = NULL;
            }

            if($auftragAlt->AA19 == "normal"){
                $dringlichkeit = NULL;
            }
            if($auftragAlt->AA19 == "dringend"){
                $dringlichkeit = "dringend";
            }
            if($auftragAlt->AA19 == "nochheute"){
                $dringlichkeit = "nochHeute";
            }

            $teilauftrag = "$auftragAlt->AA23 / $auftragAlt->AA24";

            switch($auftragAlt->AA34){
                case "nichtversendet":
                    $auftrag_status_id = 1;
                    break;
                case "versendet":
                    $auftrag_status_id = 8;
                    break;
                case "storno":
                    $auftrag_status_id = 13;
                    break;
            }

            if($auftragAlt->AA12 == NULL){
                $anzahl = 0;
            }
            elseif($auftragAlt->AA12 == '-'){
                $anzahl = 0;
            }
            elseif($auftragAlt->AA12 == '!'){
                $anzahl = 1;
            }
            else{
                $anzahl = $auftragAlt->AA12;
            }
            
            
            $created_at = date('Y-m-d H:i:s', strtotime($auftragAlt->AA17));
    
            $auftrag = new Auftrag;

            $auftrag->id = $auftragAlt->AA0;
            $auftrag->lexwareAB = $auftragAlt->AB0;
            $auftrag->kundeID = $auftragAlt->AA1;
            $auftrag->kundeMatchcode = $auftragAlt->AA2;
            $auftrag->anzahl = $anzahl;
            $auftrag->propeller = $propeller;
            $auftrag->ausfuehrung = $auftragAlt->AA10;
            $auftrag->anordnung = $anordnung;
            $auftrag->aufkleber = $aufkleber;
            $auftrag->farbe = $farbe;
            $auftrag->projekt = $auftragAlt->AA3;
            $auftrag->motor = $auftragAlt->AA4;
            $auftrag->untersetzung = $untersetzung;
            $auftrag->distanzscheibe = $auftragAlt->AA25;
            $auftrag->asgp = $auftragAlt->AA26;
            $auftrag->spgp = $auftragAlt->AA27;
            $auftrag->spkp = $auftragAlt->AA43;
            $auftrag->ap = $auftragAlt->AA28;
            $auftrag->buchsen = $buchsen;
            $auftrag->dringlichkeit = $dringlichkeit;
            $auftrag->teilauftrag = $teilauftrag;
            $auftrag->auftrag_status_id = $auftrag_status_id;
            $auftrag->auftrag_typ_id = 1;
            $auftrag->created_at = $created_at;
            $auftrag->updated_at = $created_at;


            $auftrag->user_id = $userID;
            $auftrag->save();
                
            
        }

        return view('auftraegeNeu.save');

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
}
