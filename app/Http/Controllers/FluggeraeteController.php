<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Kunde;
use App\Models\ProjektGeraeteklasse;
use App\Models\ProjektZertifizierung;
use App\Models\MotorAusrichtung;
use App\Models\Fluggeraet;
use App\Models\Artikel05Distanzscheibe;
use App\Models\Artikel06ASGP;
use App\Models\Artikel06SPGP;
use App\Models\Artikel06SPKP;
use App\Models\Artikel07Schraube;

class FluggeraeteController extends Controller
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

            $fluggeraete = Fluggeraet::sortable()
            ->where('name','like',"%$suche%")
            ->orderBy('name', 'asc')
            ->paginate(15)
            ->appends('name', 'like', "%$suche%");
        }
        else{
            $fluggeraete = Fluggeraet::sortable()
                                    ->orderBy('name','asc')
                                    ->paginate(15); 
        }

        

        //dd($fluggeraete);

        return view('fluggeraete.index',compact('fluggeraete'));
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

        $kunden = Kunde::where('kunde_gruppe_id','3')->orderBy('matchcode','asc')->get(); //id 3 bei Kundengruppe sind die Hersteller
        $projektZertifizierungen = ProjektZertifizierung::orderBy('name','asc')->get();
        $motorAusrichtungen = MotorAusrichtung::orderBy('name','asc')->get();
        $distanzscheiben = Artikel05Distanzscheibe::orderBy('artikelkreis','asc')->orderBy('materialtiefe','asc')->get();
        $spinnerASGP_Obj = Artikel06ASGP::orderBy('name','desc')->get();
        $spinnerSPGP_Obj = Artikel06SPGP::where('inaktiv',0)->orderBy('name','asc')->get();
        $spinnerSPKP_Obj = Artikel06SPKP::orderBy('name','asc')->get();
        $schraubenM8_Obj = Artikel07Schraube::where('durchmesser',8)->orderBy('laenge','asc')->get();
        $schraubenM6_Obj = Artikel07Schraube::where('durchmesser',6)->orderBy('laenge','asc')->get();

        return view('fluggeraete.create',
                    compact(
                        'kunde_id',
                        'kunde',
                        'kunden',
                        'projektZertifizierungen',
                        'motorAusrichtungen',
                        'distanzscheiben',
                        'spinnerASGP_Obj',
                        'spinnerSPGP_Obj',
                        'spinnerSPKP_Obj',
                        'schraubenM8_Obj',
                        'schraubenM6_Obj'
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
            'hersteller_id' => 'required',
            'name' => 'required|min:2|max:20|string|unique:fluggeraete',
            'muster' => 'required|min:2|max:20|string',
            'baureihe' => 'required|min:1|max:20|string|unique:fluggeraete',
            'motor_ausrichtung_id' => 'required',
            'projekt_zertifizierung_id' => 'required',
            'spannweite' => 'numeric|required',
            'v_max' => 'numeric|nullable',
            'v_reise' => 'numeric|nullable',
            'v_min' => 'numeric|nullable',
            'leermasse' => 'numeric|nullable',
            'mtow' => 'numeric|nullable',
            'fahrwerk' => 'required',
            'kennblattnummer' => 'max:20|string|nullable',
            'notiz' => 'string|max:100|nullable',
            'flanschposition' => 'numeric|nullable',
            'ds_id' => 'required',
            'asgp_id' => 'required',
            'spgp_id' => 'required',
            'spkp_id' => 'required',
            'schraubeM8FL' => 'nullable',
            'schraubeM8P' => 'nullable'
        ]);
        
        $name = $request->input("name");
        
        $hersteller_id = $request->input("hersteller_id"); //hersteller_id = kunde_id
        $fluggeraete = Fluggeraet::pluck('name');

        if($fluggeraete->contains($name)){
            return back()->withInput()->withErrors(["fluggeraetname bereits vorhanden !!!"]);        
        }

        $fluggeraet = new Fluggeraet;
        $fluggeraet->kunde_id = $request->input("hersteller_id");
        $fluggeraet->name = $request->input("name");
        $fluggeraet->muster = $request->input("muster");
        $fluggeraet->baureihe = $request->input("baureihe");
        $fluggeraet->motor_ausrichtung_id = $request->input("motor_ausrichtung_id");
        $fluggeraet->projekt_zertifizierung_id = $request->input("projekt_zertifizierung_id");
        $fluggeraet->spannweite = $request->input("spannweite");
        $fluggeraet->v_max = $request->input("v_max");
        $fluggeraet->v_reise = $request->input("v_reise");
        $fluggeraet->v_min = $request->input("v_min");
        $fluggeraet->leermasse = $request->input("leermasse");
        $fluggeraet->mtow = $request->input("mtow");
        $fluggeraet->fahrwerk = $request->input("fahrwerk");
        $fluggeraet->kennblattnummer = $request->input("kennblattnummer");
        $fluggeraet->notiz = $request->input("notiz");
        $fluggeraet->flanschposition = $request->input("flanschposition");
        $fluggeraet->artikel_05Distanzscheibe_id  = $request->input("ds_id");
        $fluggeraet->artikel_06ASGP_id  = $request->input("asgp_id");
        $fluggeraet->artikel_06SPGP_id  = $request->input("spgp_id");
        $fluggeraet->artikel_06SPKP_id  = $request->input("spkp_id");
        $fluggeraet->artikel_07SB_FL  = $request->input("schraubeM8FL");
        $fluggeraet->artikel_07SB_P  = $request->input("schraubeM8P");
        $fluggeraet->user_id = auth()->user()->id;

        $fluggeraet->save();
        
        //return response()->json(['error'=>$validator->errors()->all()]);
        return redirect("/fluggeraete")->with('success', "Fluggerät $fluggeraet->name gespeichert!");
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
        $fluggeraet = Fluggeraet::find($id);
        $kunden = Kunde::where('kunde_gruppe_id','3')->orderBy('name1','asc')->get(); //id 3 bei Kundengruppe sind die Hersteller
        $projektZertifizierungen = ProjektZertifizierung::orderBy('name','asc')->get();
        $motorAusrichtungen = MotorAusrichtung::orderBy('name','asc')->get();
        $distanzscheiben = Artikel05Distanzscheibe::orderBy('artikelkreis','asc')->orderBy('materialtiefe','asc')->get();
        $spinnerASGP_Obj = Artikel06ASGP::orderBy('name','desc')->get();
        $spinnerSPGP_Obj = Artikel06SPGP::orderBy('name','asc')->get();
        $spinnerSPKP_Obj = Artikel06SPKP::orderBy('name','asc')->get();
        $schraubenM8_Obj = Artikel07Schraube::where('durchmesser',8)->orderBy('laenge','asc')->get();
        $schraubenM6_Obj = Artikel07Schraube::where('durchmesser',6)->orderBy('laenge','asc')->get();

        //dd($fluggeraet);

        return view('fluggeraete.edit',
                    compact(
                        'fluggeraet',
                        'kunden',
                        'projektZertifizierungen',
                        'motorAusrichtungen',
                        'distanzscheiben',
                        'spinnerASGP_Obj',
                        'spinnerSPGP_Obj',
                        'spinnerSPKP_Obj',
                        'schraubenM8_Obj',
                        'schraubenM6_Obj'
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
            //'hersteller_id' => 'required',
            //'name' => 'required|min:2|max:20|string',
            'motor_ausrichtung_id' => 'required',
            'projekt_zertifizierung_id' => 'required',
            'spannweite' => 'numeric|required',
            'v_max' => 'numeric|nullable',
            'v_reise' => 'numeric|nullable',
            'v_min' => 'numeric|nullable',
            'leermasse' => 'numeric|nullable',
            'mtow' => 'numeric|nullable',
            'kennblattnummer' => 'max:20|string|nullable',
            'notiz' => 'string|max:100|nullable',
            'flanschposition' => 'numeric|nullable',
            'ds_id' => 'required',
            'asgp_id' => 'required',
            'spgp_id' => 'required',
            'spkp_id' => 'required',
            'schraubeM8FL' => 'nullable',
            'schraubeM8P' => 'required'
        ]);
        
        $name = $request->input("name");
        
        $hersteller_id = $request->input("hersteller_id"); //hersteller_id = kunde_id
        $fluggeraete = Fluggeraet::pluck('name');


        $fluggeraet = Fluggeraet::find($id);
        $fluggeraet->kunde_id = $request->input("hersteller_id");
        $fluggeraet->name = $request->input("name");
        $fluggeraet->muster = $request->input("muster");
        $fluggeraet->baureihe = $request->input("baureihe");
        $fluggeraet->motor_ausrichtung_id = $request->input("motor_ausrichtung_id");
        $fluggeraet->projekt_zertifizierung_id = $request->input("projekt_zertifizierung_id");
        $fluggeraet->spannweite = $request->input("spannweite");
        $fluggeraet->v_max = $request->input("v_max");
        $fluggeraet->v_reise = $request->input("v_reise");
        $fluggeraet->v_min = $request->input("v_min");
        $fluggeraet->leermasse = $request->input("leermasse");
        $fluggeraet->mtow = $request->input("mtow");
        $fluggeraet->fahrwerk = $request->input("fahrwerk");
        $fluggeraet->kennblattnummer = $request->input("kennblattnummer");
        $fluggeraet->notiz = $request->input("notiz");
        $fluggeraet->flanschposition = $request->input("flanschposition");
        $fluggeraet->artikel_05Distanzscheibe_id  = $request->input("ds_id");
        $fluggeraet->artikel_06ASGP_id  = $request->input("asgp_id");
        $fluggeraet->artikel_06SPGP_id  = $request->input("spgp_id");
        $fluggeraet->artikel_06SPKP_id  = $request->input("spkp_id");
        $fluggeraet->artikel_07SB_FL  = $request->input("schraubeM8FL");
        $fluggeraet->artikel_07SB_P  = $request->input("schraubeM8P");
        $fluggeraet->user_id = auth()->user()->id;

        $fluggeraet->save();
        
        //return response()->json(['error'=>$validator->errors()->all()]);
        return redirect("/fluggeraete")->with('success', "Fluggerät $fluggeraet->name geändert!");
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
