<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;

use App\Models\Kunde;
use App\Models\Motor;
use App\Models\MotorArbeitsweise;
use App\Models\MotorDrehrichtung;
use App\Models\MotorFlansch;
use App\Models\MotorKuehlung;
use App\Models\MotorKupplung;
use App\Models\MotorStatus;
use App\Models\MotorTyp;
use App\Models\ProjektGeraeteklasse;

class MotorenController extends Controller
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

            $motoren = Motor::sortable()
            ->where('projekt_geraeteklasse_id','like',"%$geraeteklasse%")
            ->orderBy('name', 'asc')
            ->paginate(100)
            ->appends('name', 'like', "%$geraeteklasse%");
        }
        elseif(request()->has('deleted')){
            
            $motoren = Motor::sortable()
            ->orderBy('name', 'asc')
            ->onlyTrashed()
            ->paginate(100);
        }
        elseif(request()->has('suche')){
            $suche = request('suche');

            $motoren = Motor::sortable()
            ->where('name','like',"%$suche%")
            ->orderBy('name', 'asc')
            ->paginate(50)
            ->appends('name', 'like', "%$suche%");
        }
        else{
            $motoren = Motor::sortable()
            ->orderBy('name','asc')
            ->paginate(100); 
        }

        return view('motoren.index',compact('motoren'));
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

        $kunden = Kunde::orderBy('matchcode','asc')->get();

        $projektGeraeteklassen = ProjektGeraeteklasse::orderBy('name','asc')->get();
        $motorArbeitsweisen = MotorArbeitsweise::orderBy('name','asc')->get();
        $motorStatusObjects = MotorStatus::orderBy('name','asc')->get();
        $motorTypen = MotorTyp::orderBy('name','asc')->get();
        $motorKupplungen = MotorKupplung::orderBy('name','asc')->get();
        $motorKuehlungen = MotorKuehlung::orderBy('name','asc')->get();
        $motorDrehrichtungen = MotorDrehrichtung::orderBy('name','asc')->get();

        //dd($projekt);

        return view('motoren.create',
                    compact(
                        'kunde_id',
                        'kunde',
                        'kunden',
                        'projektGeraeteklassen',
                        'motorArbeitsweisen',
                        'motorStatusObjects',
                        'motorTypen',
                        'motorKupplungen',
                        'motorKuehlungen',
                        'motorDrehrichtungen'
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
            'name' => 'bail|required|min:1|max:30|string',
            'motor_arbeitsweise_id' => 'required',
            'motor_status_id' => 'required',
            'projekt_geraeteklasse_id' => 'required',
            'motor_typ_id' => 'required',
            'motor_kupplung_id' => 'required',
            'motor_kuehlung_id' => 'required',
            'motor_drehrichtung_id' => 'required',
            'zylinderanzahl' => 'numeric|min:0|max:12|required',
            'hubraum' => 'numeric|min:50|max:6000|nullable',
            'bohrung' => 'numeric|min:50|max:1000|nullable',
            'hub' => 'numeric|min:10|max:100|nullable',
            'nenndrehzahl' => 'numeric|min:1000|max:20000|nullable',
            'nennleistung' => 'numeric|min:2|max:200|nullable',
            'realleistung' => 'numeric|min:2|max:200|nullable',
            'revision' => 'numeric|min:1900|max:2100|nullable',
            'kennlinie' => 'in:0,1',
            'kraftstoffZufuhr' => 'required',
            'vergaserInfo' => 'bail|min:1|max:100|string|nullable',
            'notiz' => 'string|max:500|nullable'
        ]);

        $motor = new Motor;
        $motor->name = $request->input('name');
        $motor->motor_arbeitsweise_id = $request->input('motor_arbeitsweise_id');
        $motor->motor_status_id = $request->input('motor_status_id');
        $motor->projekt_geraeteklasse_id = $request->input('projekt_geraeteklasse_id');
        $motor->motor_typ_id = $request->input('motor_typ_id');
        $motor->motor_kupplung_id = $request->input('motor_kupplung_id');
        $motor->motor_kuehlung_id = $request->input('motor_kuehlung_id');
        $motor->motor_drehrichtung_id = $request->input('motor_drehrichtung_id');
        $motor->zylinderanzahl = $request->input('zylinderanzahl');
        $motor->hubraum = $request->input('hubraum');
        $motor->bohrung = $request->input('bohrung');
        $motor->hub = $request->input('hub');
        $motor->nenndrehzahl = $request->input('nenndrehzahl');
        $motor->nennleistung = $request->input('nennleistung');
        $motor->realleistung = $request->input('realleistung');
        $motor->revision = $request->input('revision');
        $motor->kennlinie = $request->input('kennlinie');
        $motor->kraftstoffZufuhr = $request->input('kraftstoffZufuhr');
        $motor->vergaserInfo = $request->input('vergaserInfo');
        $motor->notiz = $request->input('notiz'); 
        $motor->kunde_id = $request->input('kunde_id'); 
        $motor->user_id = auth()->user()->id;   
        
        $motor->save();
        //return redirect("/kunden/{$motor->kunde_id}")->with('success', "Projekt $motor->name bei Kunde ".$motor->kunde->matchcode." gespeichert!");
        return redirect("/motorGetriebe/create")->with('success', "Motor $motor->name neu abgespeichert -> neues Getriebe anlegen!");
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
        $motor = Motor::find($id);
        $projektGeraeteklassen = ProjektGeraeteklasse::orderBy('name','asc')->get();
        $motorArbeitsweisen = MotorArbeitsweise::orderBy('name','asc')->get();
        $motorStatusObjects = MotorStatus::orderBy('name','asc')->get();
        $motorTypen = MotorTyp::orderBy('name','asc')->get();
        $motorKupplungen = MotorKupplung::orderBy('name','asc')->get();
        $motorKuehlungen = MotorKuehlung::orderBy('name','asc')->get();
        $motorDrehrichtungen = MotorDrehrichtung::orderBy('name','asc')->get();

        //dd($projekt);

        return view('motoren.edit',
                    compact(
                        'motor',
                        'projektGeraeteklassen',
                        'motorArbeitsweisen',
                        'motorStatusObjects',
                        'motorTypen',
                        'motorKupplungen',
                        'motorKuehlungen',
                        'motorDrehrichtungen'
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
            'name' => 'bail|required|min:2|max:30|string',
            'motor_arbeitsweise_id' => 'required',
            'motor_status_id' => 'required',
            'projekt_geraeteklasse_id' => 'required',
            'motor_typ_id' => 'required',
            'motor_kupplung_id' => 'required',
            'motor_kuehlung_id' => 'required',
            'motor_drehrichtung_id' => 'required',
            'zylinderanzahl' => 'numeric|min:0|max:12|nullable',
            'hubraum' => 'numeric|min:50|max:6000|nullable',
            'bohrung' => 'numeric|min:50|max:1000|nullable',
            'hub' => 'numeric|min:10|max:100|nullable',
            'nenndrehzahl' => 'numeric|min:1000|max:20000|nullable',
            'nennleistung' => 'numeric|min:2|max:200|nullable',
            'realleistung' => 'numeric|min:2|max:200|nullable',
            'revision' => 'numeric|min:1900|max:2100|nullable',
            'kennlinie' => 'in:0,1',
            'vergaserInfo' => 'bail|min:1|max:100|string|nullable',
            'notiz' => 'string|max:500|nullable'
        ]);

        $motor = Motor::find($id);
        $motor->name = $request->input('name');
        $motor->motor_arbeitsweise_id = $request->input('motor_arbeitsweise_id');
        $motor->motor_status_id = $request->input('motor_status_id');
        $motor->projekt_geraeteklasse_id = $request->input('projekt_geraeteklasse_id');
        $motor->motor_typ_id = $request->input('motor_typ_id');
        $motor->motor_kupplung_id = $request->input('motor_kupplung_id');
        $motor->motor_kuehlung_id = $request->input('motor_kuehlung_id');
        $motor->motor_drehrichtung_id = $request->input('motor_drehrichtung_id');
        $motor->zylinderanzahl = $request->input('zylinderanzahl');
        $motor->hubraum = $request->input('hubraum');
        $motor->bohrung = $request->input('bohrung');
        $motor->hub = $request->input('hub');
        $motor->nenndrehzahl = $request->input('nenndrehzahl');
        $motor->nennleistung = $request->input('nennleistung');
        $motor->realleistung = $request->input('realleistung');
        $motor->revision = $request->input('revision');
        $motor->kennlinie = $request->input('kennlinie');
        $motor->kraftstoffZufuhr = $request->input('kraftstoffZufuhr');
        $motor->vergaserInfo = $request->input('vergaserInfo');
        $motor->notiz = $request->input('notiz'); 
        $motor->kunde_id = $request->input('kunde_id'); 
        $motor->user_id = auth()->user()->id;   
        
        $motor->save();
        return redirect("/kunden/$motor->kunde_id")->with('success', "Motorenndetails von $motor->name überarbeitet!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $motor = Motor::find($id);
               
        $motor->delete();
        return back()->with('success', "Motor $motor->name gelöscht");
    }
}
