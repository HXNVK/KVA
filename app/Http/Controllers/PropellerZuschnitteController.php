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

class PropellerZuschnitteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the material mersteller.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        if(request()->has('suche')){
            $suche = request('suche');

            $propellerZuschnitte = PropellerZuschnitt::sortable()
            ->where('name','like',"%$suche%")
            ->orderBy('name', 'asc')
            ->paginate(15)
            ->appends('name', 'like', "%$suche%");
        }
        else{
            $propellerZuschnitte = PropellerZuschnitt::sortable()
            ->orderBy('name', 'asc')
            ->paginate(15);
        }

        //dd($materialHerstellerObjekte);
        return view('propellerZuschnitte.index', compact('propellerZuschnitte'));
    }


    public function create()
    {
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

        $propellerGeometrieklassen = PropellerKlasseGeometrie::orderBy('name','asc')->get();
        $propellerModellKompatibilitaeten = PropellerModellKompatibilitaet::orderBy('name','asc')->get();
        $propellerAusfuehrungen = Artikel03Ausfuehrung::orderBy('name','asc')->get();

        //dd($materialHalbzeuge);
        return view('propellerZuschnitte.create', compact(
                                                    'materialien', 
                                                    'propellerGeometrieklassen',
                                                    'propellerModellKompatibilitaeten',
                                                    'propellerAusfuehrungen'
                                                ));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'propellerGeometrieklasse_id' => 'required',
            'propellerAusfuehrung_id' => 'required',
            'typen' => 'required',
            'durchmesserMin' => 'required',
            'durchmesserMax' => 'required'
            ]);
        
        
        $propellerGeometrieklasse = PropellerKlasseGeometrie::find($request->input('propellerGeometrieklasse_id'));
        $propellerAusfuehrung = Artikel03Ausfuehrung::find($request->input('propellerAusfuehrung_id'));
        

        $name = "H$propellerGeometrieklasse->basis_festigkeitsklasse"."$propellerGeometrieklasse->geometrieform, $propellerAusfuehrung->name, $propellerAusfuehrung->bezeichnung";
        //dd($name);

        $propellerZuschnitt = new PropellerZuschnitt;
        $propellerZuschnitt->name = $name;
        $propellerZuschnitt->bezeichnung = $propellerAusfuehrung->bezeichnung;
        $propellerZuschnitt->typen = $request->input('typen');
        $propellerZuschnitt->durchmesser_min = $request->input('durchmesserMin');
        $propellerZuschnitt->durchmesser_max = $request->input('durchmesserMax');
        $propellerZuschnitt->propellerKlasseGeometrie_id = $request->input('propellerGeometrieklasse_id');
        $propellerZuschnitt->propellerAusfuehrung_id = $request->input('propellerAusfuehrung_id');
        $propellerZuschnitt->user_id = auth()->user()->id;   
        $propellerZuschnitt->save();
        return redirect('/propellerZuschnitte')->with('success', "neuer Zuschnittplan gespeichert!");
    }

    public function edit($id)
    {
        $propellerZuschnitt = PropellerZuschnitt::find($id);

        $propellerZuschnittLagen = PropellerZuschnittLage::where('propeller_zuschnitt_id', '=', $id)->orderBy('sortiernummer', 'asc')->get();

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

        $propellerGeometrieklassen = PropellerKlasseGeometrie::orderBy('name','asc')->get();
        $propellerModellKompatibilitaeten = PropellerModellKompatibilitaet::orderBy('name','asc')->get();
        $propellerAusfuehrungen = Artikel03Ausfuehrung::orderBy('name','asc')->get();

        //dd($propellerZuschnittLagen);
        return view('propellerZuschnitte.edit', compact(
                                                        'propellerZuschnitt',
                                                        'materialien', 
                                                        'propellerGeometrieklassen',
                                                        'propellerModellKompatibilitaeten',
                                                        'propellerAusfuehrungen',
                                                        'propellerZuschnittLagen'
                                                    ));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'propellerGeometrieklasse_id' => 'required',
            'propellerAusfuehrung_id' => 'required',
            'typen' => 'required',
            'durchmesserMin' => 'required',
            'durchmesserMax' => 'required'
            ]);
        

        $propellerAusfuehrung = Artikel03Ausfuehrung::find($request->input('propellerAusfuehrung_id'));
        

        //dd($request->input('typen'));

        $propellerZuschnitt = PropellerZuschnitt::find($id);
        $propellerZuschnitt->name = $request->input('name');
        $propellerZuschnitt->bezeichnung = $request->input('bezeichnung');
        $propellerZuschnitt->typen = $request->input('typen');
        $propellerZuschnitt->durchmesser_min = $request->input('durchmesserMin');
        $propellerZuschnitt->durchmesser_max = $request->input('durchmesserMax');
        $propellerZuschnitt->propellerKlasseGeometrie_id = $request->input('propellerGeometrieklasse_id');
        $propellerZuschnitt->propellerAusfuehrung_id = $request->input('propellerAusfuehrung_id');
        $propellerZuschnitt->user_id = auth()->user()->id;   

        //dd($propellerZuschnitt);

        $propellerZuschnitt->save();
        return redirect('/propellerZuschnitte')->with('success', "Zuschnittplan wurde geändert und gespeichert!");
    }


    public function show()
    {
        //
    }

    public function destroy($id)
    {
        try {
            $propellerZuschnitt = PropellerZuschnitt::findOrFail($id);

            $propellerZuschnittLagen = PropellerZuschnittLage::where('propeller_zuschnitt_id',$id)->get();
            foreach($propellerZuschnittLagen as $propellerZuschnittLage){
            
                $propellerZuschnittLage->delete();
            }



            $propellerZuschnitt->delete();

            return redirect('/propellerZuschnitte')
                ->with('success', "Zuschnitt $propellerZuschnitt->name gelöscht");
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }

    }


}
