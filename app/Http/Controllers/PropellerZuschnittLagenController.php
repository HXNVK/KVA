<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\PropellerKlasseGeometrie;
use App\Models\PropellerModellKompatibilitaet;
use App\Models\PropellerZuschnitt;
use App\Models\PropellerZuschnittLage;
use App\Models\PropellerZuschnittSchablone;
use App\Models\Artikel03Ausfuehrung;

use DB;

class PropellerZuschnittLagenController extends Controller
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

        $propellerZuschnitt = PropellerZuschnitt::find(request('propellerZuschnittId'));

        $propellerZuschnittLage_letzte = PropellerZuschnittLage::where('propeller_zuschnitt_id', '=', "$propellerZuschnitt->id")
                                                        ->orderBy('sortiernummer', 'desc')    
                                                        ->first();
        $naechsteSortiernummer = $propellerZuschnittLage_letzte->sortiernummer + 1;

        $materialien = Material::select(
                                    //'materialien.*',
                                    'materialien.id as MaterialID',
                                    'materialien.name as MaterialName',
                                    'materialien.name_lang as MaterialNameLang',
                                    'material_typen.name as MaterialTyp',
                                    'material_typen.werkstoff as Werkstoff',
                                    'material_gruppen.id as MaterialGruppeID',
                                    )

                                    ->leftjoin('material_gruppen','materialien.material_gruppe_id','=','material_gruppen.id')
                                    ->leftjoin('material_typen','materialien.material_typ_id', '=', 'material_typen.id')

                                    ->where('material_gruppen.id', '=', 1)

                                    ->orderBy('Werkstoff','asc')
                                    ->orderBy('MaterialTyp','asc')

                                    ->get();



        $schablonen = PropellerZuschnittSchablone::orderBy('name','asc')->get();


        //dd($materialien);
        return view('propellerZuschnittLagen.create', compact(
            'propellerZuschnitt',
            'materialien',
            'schablonen',
            'naechsteSortiernummer'
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
        $zuschnittID = $request->input('propellerZuschnitt_id');
        //dd($request->input('propellerZuschnitt_id'));

        $this->validate($request,[
            'material_id' => 'required',
            'anzahl' => 'required|numeric',
            'schablone_id' => 'required',
            'reihenfolge' => 'required|string|max:40',
            'sortiernummer' => 'required',
            'bemerkung' => 'nullable|string|max:50'
            ]);

        

        $reihenfolge =sprintf("%02d",$request->input('reihenfolge'));

        $propellerZuschnittLage = new PropellerZuschnittLage;
        $propellerZuschnittLage->propeller_zuschnitt_id = $request->input('propellerZuschnitt_id');
        $propellerZuschnittLage->material_id = $request->input('material_id');
        $propellerZuschnittLage->anzahl = $request->input('anzahl');
        $propellerZuschnittLage->propeller_zuschnitt_schablone_id = $request->input('schablone_id');
        $propellerZuschnittLage->reihenfolge = $request->input('reihenfolge');
        $propellerZuschnittLage->sortiernummer = $request->input('sortiernummer');
        $propellerZuschnittLage->bemerkung = $request->input('bemerkung');

        $propellerZuschnittLage->user_id = auth()->user()->id;   
        $propellerZuschnittLage->save();

        return redirect("/propellerZuschnitte/$zuschnittID/edit")->with('success', "neue Lage gespeichert!");
        
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
        $propellerZuschnittLage = PropellerZuschnittLage::find($id);

        //dd($propellerZuschnitt);

        $materialien = Material::select(
                                    //'materialien.*',
                                    'materialien.id as MaterialID',
                                    'materialien.name as MaterialName',
                                    'materialien.name_lang as MaterialNameLang',
                                    'material_typen.name as MaterialTyp',
                                    'material_typen.werkstoff as Werkstoff',
                                    'material_gruppen.id as MaterialGruppeID',
                                    )

                                    ->leftjoin('material_gruppen','materialien.material_gruppe_id','=','material_gruppen.id')
                                    ->leftjoin('material_typen','materialien.material_typ_id', '=', 'material_typen.id')

                                    ->where('material_gruppen.id', '=', 1)

                                    ->orderBy('Werkstoff','asc')
                                    ->orderBy('MaterialTyp','asc')

                                    ->get();



        $schablonen = PropellerZuschnittSchablone::orderBy('name','asc')->get();


        //dd($propellerZuschnittLage);
        return view('propellerZuschnittLagen.edit', compact(
                                                            'propellerZuschnittLage',
                                                            'materialien',
                                                            'schablonen'
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
        
        $zuschnittLageID = $id;
        $propellerZuschnittID = $request->input('propellerZuschnittID');
        //dd($request->input());

        $this->validate($request,[
            'material_id' => 'required',
            'anzahl' => 'required|numeric',
            'schablone_id' => 'required',
            'reihenfolge' => 'required|string|max:40',
            'sortiernummer' => 'required',
            'bemerkung' => 'nullable|string|max:50'
            ]);

        

        $propellerZuschnittLage = PropellerZuschnittLage::find($id);
        $propellerZuschnittLage->propeller_zuschnitt_id = $propellerZuschnittID;
        $propellerZuschnittLage->material_id = $request->input('material_id');
        $propellerZuschnittLage->anzahl = $request->input('anzahl');
        $propellerZuschnittLage->propeller_zuschnitt_schablone_id = $request->input('schablone_id');
        $propellerZuschnittLage->reihenfolge = $request->input('reihenfolge');
        $propellerZuschnittLage->sortiernummer = $request->input('sortiernummer');
        $propellerZuschnittLage->bemerkung = $request->input('bemerkung');

        $propellerZuschnittLage->user_id = auth()->user()->id;   
        $propellerZuschnittLage->save();

        return redirect("/propellerZuschnitte/$propellerZuschnittID/edit")->with('success', "Lage überarbeitet!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $propellerZuschnittLage = PropellerZuschnittLage::findOrFail($id);
        $propellerZuschnittLage->delete();

        return back()->with('success_msg', "Zuschnittlage ".$propellerZuschnittLage->material->name." im Zuschnittplan gelöscht");
    }
}
