<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Auth;
use DB;


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


class KundenNeuController extends Controller
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
        
        $kundenAlt = Kunde01Alt::all('AA0','AB0','AC0','AA1','AA2','AA3','AA4','AA14','FF1','ZZ1');
        
        //dd($projekteAlt);

        return view('kundenNeu.index',compact(
                                            'kundenAlt'));
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
        $kunden = Kunde::pluck('matchcode','id');
        $kundenAlt = Kunde01Alt::all('AA0','AB0','AC0','AA1','AA2','AA3','AA4','AA14','FF1','ZZ1');

        foreach($kundenAlt as $kundeAlt){

            switch($kundeAlt->AA0){
                case "JA":
                    $kundeChecked = 1;
                    break;
                case "NEIN":
                    $kundeChecked = 0;
                    break;
                case NULL:
                    $kundeChecked = 0;
                    break;    
            }
            switch($kundeAlt->AB0){
                case "Normal":
                    $kundenGruppeID = 1;
                    break;
                case "Motorhersteller":
                    $kundenGruppeID = 4;
                    break;
                case "Projekt":
                    $kundenGruppeID = 99;
                    break;
                case "Sonder":
                    $kundenGruppeID = 99;
                    break;
            }
            switch($kundeAlt->AC0){
                case "aktiv":
                    $kundeStatusID = 1;
                    break;
                case "nichtaktiv":
                    $kundeStatusID = 2;
                    break;   
                case NULL:
                    $kundeStatusID = 99;
                    break; 
            }
            switch($kundeAlt->AA3){
                case "0.0":
                    $kundeRatingID = 99;
                    break;
                case "2.0":
                    $kundeRatingID = 1;
                    break;
                case "12.5":
                    $kundeRatingID = 2;
                    break; 
                case "30.0":
                    $kundeRatingID = 3;
                    break; 
                case "37.0":
                    $kundeRatingID = 4;
                    break; 
                case "40.5":
                    $kundeRatingID = 5;
                    break;  
                case "42.6":
                    $kundeRatingID = 6;
                    break;
                case "44":
                    $kundeRatingID = 7;
                    break;
                case "47.5":
                    $kundeRatingID = 8;
                    break;
                case "60.0":
                    $kundeRatingID = 9;
                    break;
                case "100.0":
                    $kundeRatingID = 10;
                    break;
            }
            switch($kundeAlt->FF1){
                case "ohne":
                    $kundeAufkleberID = 2;
                    break;
                case "gross":
                    $kundeAufkleberID = 1;
                    break;   
                case "-":
                    $kundeAufkleberID = 1;
                    break; 
                case NULL:
                    $kundeAufkleberID = 1;
                    break;
            }

            if(Str::of($kundeAlt->ZZ1)->containsAll(['NVK'])){
                $userID = 1;
            }
            elseif(Str::of($kundeAlt->ZZ1)->containsAll(['BS'])){
                $userID = 5;
            }
            elseif(Str::of($kundeAlt->ZZ1)->containsAll(['TKA'])){
                $userID = 6;
            }
            elseif(Str::of($kundeAlt->ZZ1)->containsAll(['RKS'])){
                $userID = 7;
            }else{
                $userID = 1;
            }

         
                    $kunde = new Kunde;
                    $kunde->id = $kundeAlt->AA1;
                    $kunde->matchcode = $kundeAlt->AA2;
                    $kunde->name1 = $kundeAlt->AA4;
                    $kunde->kunde_typ_id = 99;
                    $kunde->kunde_rating_id = $kundeRatingID;
                    $kunde->kunde_gruppe_id = $kundenGruppeID;
                    $kunde->checked = $kundeChecked;
                    $kunde->kunde_status_id = $kundeStatusID;
                    $kunde->webseite = $kundeAlt->AA14;
                    $kunde->kunde_aufkleber_id = $kundeAufkleberID;
                    $kunde->notiz = $kundeAlt->ZZ1;
                    $kunde->user_id = $userID;
                    $kunde->save();
                
            
        }

        return view('kundenNeu.save');

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
