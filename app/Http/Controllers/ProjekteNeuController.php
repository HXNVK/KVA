<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Auth;
use DB;


use App\Models\Kunde;
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


class ProjekteNeuController extends Controller
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
        
        $projekteAlt = Projekt01Alt::all('AA0','AC0','AA1','AA4','BB1','CC9','FF2','EE1','EE7','EE8','FF1','FF7','FF8','GG1','GG7','GG8');
        
        //dd($projekteAlt);

        return view('projekteNeu.index',compact(
                                            'projekteAlt'));
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
        $projekteAlt = Projekt01Alt::all('AA0','AB0','AC0',
                                        'AA1','AA4',
                                        'BB1',
                                        'CC9',
                                        'EE1','EE2','EE3','EE4','EE5','EE6','EE7','EE8','EE9','EE10','EE11',
                                        'FF1','FF2','FF5','FF6','FF7','FF8','FF10','FF12','FF14','FF18','FF19','FF20','FF21','FF22','FF23','FF24','FF25','FF26','FF27','FF28','FF29',
                                        'GG1','GG2','GG5','GG6','GG7','GG8','FF10','FF12','FF14','GG18','GG19','GG20','GG21','GG22','GG23','GG24','GG25','GG26','GG27','GG28','GG29',
                                        'HH1','HH2','HH5','HH6','HH7','HH8','FF10','FF12','FF14','HH18','HH19','HH20','HH21','HH22','HH23','HH24','HH25','HH26','HH27','HH28','HH29',
                                        'II1','II2','II5','II6','II7','II8','FF10','FF12','FF14','II18','II19','II20','II21','II22','II23','II24','II25','II26','II27','II28','II29',
                                        'JJ1','JJ2','JJ5','JJ6','JJ7','JJ8','FF10','FF12','FF14','JJ18','JJ19','JJ20','JJ21','JJ22','JJ23','JJ24','JJ25','JJ26','JJ27','JJ28','JJ29');

        $motoren = Motor::pluck('name','id');

        
        foreach($projekteAlt as $projektAlt){

            if($projektAlt->AA0 == 'PPG'
                || $projektAlt->AA0 == 'SPEZIAL'
                || $projektAlt->AA0 == 'UL-Trike'
                || $projektAlt->AA0 == 'PPG-Trike'){
                
$notiz =
"Prop1: $projektAlt->EE1
RPM: $projektAlt->EE2
Bem.: $projektAlt->EE7
Style: $projektAlt->EE8

Prop2: $projektAlt->FF1
RPM: $projektAlt->FF2
Bem.: $projektAlt->FF7
Style: $projektAlt->FF8

Prop3: $projektAlt->GG1
RPM: $projektAlt->GG2
Bem.: $projektAlt->GG7
Style: $projektAlt->GG8";

            }
            if($projektAlt->AA0 == 'UL'
            || $projektAlt->AA0 == 'GYRO'){
$notiz =
"Prop1: $projektAlt->FF5
RPM Boden: $projektAlt->FF6
RPM Steigen bei $projektAlt->EE5 km/h: $projektAlt->FF7
Zeiten für 1000ft: $projektAlt->FF8,$projektAlt->FF10,$projektAlt->FF12,$projektAlt->FF14
RPM Reise bei $projektAlt->EE1 km/h: $projektAlt->FF18
RPM Reise bei $projektAlt->EE2 km/h: $projektAlt->FF19
RPM Reise bei $projektAlt->EE3 km/h: $projektAlt->FF20
RPM Reise bei $projektAlt->EE4 km/h: $projektAlt->FF21
RPM Reise bei $projektAlt->EE6 km/h: $projektAlt->FF22
RPM Reise bei $projektAlt->EE7 km/h: $projektAlt->FF23
RPM Reise bei $projektAlt->EE8 km/h: $projektAlt->FF25
RPM Reise bei $projektAlt->EE9 km/h: $projektAlt->FF26
RPM Reise bei $projektAlt->EE10 km/h: $projektAlt->FF27
RPM Reise bei $projektAlt->EE11 km/h: $projektAlt->FF28
RPM Drehzahl bei Vmax [km/h]: $projektAlt->FF29
Bem.: $projektAlt->FF24

Prop2: $projektAlt->GG5
RPM Boden: $projektAlt->GG6
RPM Steigen bei $projektAlt->EE5 km/h: $projektAlt->GG7
Zeiten für 1000ft: $projektAlt->GG8,$projektAlt->GG10,$projektAlt->GG12,$projektAlt->GG14
RPM Reise bei $projektAlt->EE1 km/h: $projektAlt->GG18
RPM Reise bei $projektAlt->EE2 km/h: $projektAlt->GG19
RPM Reise bei $projektAlt->EE3 km/h: $projektAlt->GG20
RPM Reise bei $projektAlt->EE4 km/h: $projektAlt->GG21
RPM Reise bei $projektAlt->EE6 km/h: $projektAlt->GG22
RPM Reise bei $projektAlt->EE7 km/h: $projektAlt->GG23
RPM Reise bei $projektAlt->EE8 km/h: $projektAlt->GG25
RPM Reise bei $projektAlt->EE9 km/h: $projektAlt->GG26
RPM Reise bei $projektAlt->EE10 km/h: $projektAlt->GG27
RPM Reise bei $projektAlt->EE11 km/h: $projektAlt->GG28
RPM Drehzahl bei Vmax [km/h]: $projektAlt->GG29
Bem.: $projektAlt->GG24

Prop3: $projektAlt->HH5
RPM Boden: $projektAlt->HH6
RPM Steigen bei $projektAlt->EE5 km/h: $projektAlt->HH7
Zeiten für 1000ft: $projektAlt->HH8,$projektAlt->HH10,$projektAlt->HH12,$projektAlt->HH14
RPM Reise bei $projektAlt->EE1 km/h: $projektAlt->HH18
RPM Reise bei $projektAlt->EE2 km/h: $projektAlt->HH19
RPM Reise bei $projektAlt->EE3 km/h: $projektAlt->HH20
RPM Reise bei $projektAlt->EE4 km/h: $projektAlt->HH21
RPM Reise bei $projektAlt->EE6 km/h: $projektAlt->HH22
RPM Reise bei $projektAlt->EE7 km/h: $projektAlt->HH23
RPM Reise bei $projektAlt->EE8 km/h: $projektAlt->HH25
RPM Reise bei $projektAlt->EE9 km/h: $projektAlt->HH26
RPM Reise bei $projektAlt->EE10 km/h: $projektAlt->HH27
RPM Reise bei $projektAlt->EE11 km/h: $projektAlt->HH28
RPM Drehzahl bei Vmax [km/h]: $projektAlt->HH29
Bem.: $projektAlt->HH24

Prop4: $projektAlt->II5
RPM Boden: $projektAlt->II6
RPM Steigen bei $projektAlt->EE5 km/h: $projektAlt->II7
Zeiten für 1000ft: $projektAlt->II8,$projektAlt->II10,$projektAlt->II12,$projektAlt->II14
RPM Reise bei $projektAlt->EE1 km/h: $projektAlt->II18
RPM Reise bei $projektAlt->EE2 km/h: $projektAlt->II19
RPM Reise bei $projektAlt->EE3 km/h: $projektAlt->II20
RPM Reise bei $projektAlt->EE4 km/h: $projektAlt->II21
RPM Reise bei $projektAlt->EE6 km/h: $projektAlt->II22
RPM Reise bei $projektAlt->EE7 km/h: $projektAlt->II23
RPM Reise bei $projektAlt->EE8 km/h: $projektAlt->II25
RPM Reise bei $projektAlt->EE9 km/h: $projektAlt->II26
RPM Reise bei $projektAlt->EE10 km/h: $projektAlt->II27
RPM Reise bei $projektAlt->EE11 km/h: $projektAlt->II28
RPM Drehzahl bei Vmax [km/h]: $projektAlt->II29
Bem.: $projektAlt->II24

Prop5: $projektAlt->JJ5
RPM Boden: $projektAlt->JJ6
RPM Steigen bei $projektAlt->EE5 km/h: $projektAlt->JJ7
Zeiten für 1000ft: $projektAlt->JJ8,$projektAlt->JJ10,$projektAlt->JJ12,$projektAlt->JJ14
RPM Reise bei $projektAlt->EE1 km/h: $projektAlt->JJ18
RPM Reise bei $projektAlt->EE2 km/h: $projektAlt->JJ19
RPM Reise bei $projektAlt->EE3 km/h: $projektAlt->JJ20
RPM Reise bei $projektAlt->EE4 km/h: $projektAlt->JJ21
RPM Reise bei $projektAlt->EE6 km/h: $projektAlt->JJ22
RPM Reise bei $projektAlt->EE7 km/h: $projektAlt->JJ23
RPM Reise bei $projektAlt->EE8 km/h: $projektAlt->JJ25
RPM Reise bei $projektAlt->EE9 km/h: $projektAlt->JJ26
RPM Reise bei $projektAlt->EE10 km/h: $projektAlt->JJ27
RPM Reise bei $projektAlt->EE11 km/h: $projektAlt->JJ28
RPM Drehzahl bei Vmax [km/h]: $projektAlt->JJ29
Bem.: $projektAlt->JJ24
";
            }

            switch($projektAlt->AA0){
                case "PPG":
                    $projektGeraeteklasseID = 1;
                    break;
                case "PPG-Trike":
                    $projektGeraeteklasseID = 2;
                    break;
                case "SPEZIAL":
                    $projektGeraeteklasseID = 3;
                    break;
                case "UL-Trike":
                    $projektGeraeteklasseID = 11;
                    break;
                case "UL":
                    $projektGeraeteklasseID = 3;
                    break;
            }

            if(Str::of($projektAlt->AA4)->containsAll(['NVK'])){
                $userID = 1;
            }
            if(Str::of($projektAlt->AA4)->containsAll(['BS'])){
                $userID = 5;
            }
            if(Str::of($projektAlt->AA4)->containsAll(['TKA'])){
                $userID = 6;
            }
            if(Str::of($projektAlt->AA4)->containsAll(['RKS'])){
                $userID = 7;
            }



                //dd($kunden);

            $projekt = new Projekt;
            $projekt->kunde_id = $projektAlt->AA1;
            $projekt->beschreibung = null;
            $projekt->projekt_geraeteklasse_id = $projektGeraeteklasseID;
            $projekt->fluggeraet_id = null;
            $projekt->name = $projektAlt->AB0;
            $projekt->projekt_kategorie_id = 1;
            $projekt->projekt_typ_id = 2;
            $projekt->projekt_status_id = 2;
            $projekt->notiz = $notiz;
            $projekt->motor_id = null;
            $projekt->motor_flansch_id = null;
            $projekt->user_id = $userID;
            
            foreach($kunden as $id => $matchcode){
                if($id == $projektAlt->AA1){
                    $projekt->save();
                }
            }    
        }


        return view('projekteNeu.save');
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
