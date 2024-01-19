<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\PropellerModellWurzel;
use App\Models\PropellerKlasseGeometrie;
use App\Models\PropellerModellKompatibilitaet;
use App\Models\PropellerDrehrichtung;
use App\Models\PropellerModellWurzelTyp;

use PDF;

class PropellerModellWurzelnController extends Controller
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
        if(request()->has('geometrieklasse')){
            
            $geometrieklasse = request('geometrieklasse');

            $propellerModellWurzeln = PropellerModellWurzel::where('name','like',"%$geometrieklasse%")
            ->orderBy('name', 'asc')
            ->paginate(15)
            ->appends('name', 'like', "%$geometrieklasse%");
        }
        elseif(request()->has('suche')){
            $suche = request('suche');

            $propellerModellWurzeln = PropellerModellWurzel::where('name','like',"%$suche%")
            ->orderBy('name', 'asc')
            ->paginate(15)
            ->appends('name', 'like', "%$suche%");
        }else{
            $propellerModellWurzeln = PropellerModellWurzel::orderBy('name','asc')->paginate(30);;
        }
        
        return view('propellerModellWurzeln.index',compact('propellerModellWurzeln'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $propellerModellWurzeln = PropellerModellWurzel::orderBy('name','asc')->get();
        $propellerKlasseGeometrien = PropellerKlasseGeometrie::orderBy('name','asc')->get();
        $propellerModellKompatibilitaeten = PropellerModellKompatibilitaet::orderBy('name','asc')->get();
        $propellerDrehrichtungen = PropellerDrehrichtung::all();
        
        //dd($blattmodellCads);
        return view('propellerModellWurzeln.create',
                        compact(
                            'propellerModellWurzeln',
                            'propellerKlasseGeometrien',
                            'propellerModellKompatibilitaeten',
                            'propellerDrehrichtungen'
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
        $data = $this->getData($request);

        $propellerKlasseGeometrie = PropellerKlasseGeometrie::find($request->input('propeller_klasse_geometrie_id'));
        $propellerDrehrichtung = PropellerDrehrichtung::find($request->input('propeller_drehrichtung_id'));
        $propellerModellKompatibilitaet = PropellerModellKompatibilitaet::find($request->input('propeller_modell_kompatibilitaet_id'));
        $winkel = number_format($request->input('winkel'),1);
        $konuswinkel = number_format($request->input('konuswinkel'),0);
        if($konuswinkel == 0){
            $konuswinkel = NULL;
        }
        
        if(Str::of($winkel)->endsWith('0')){
            $winkel = number_format($request->input('winkel'),0);
        } 
        
        $vorhandene_propellerModellWurzeln = PropellerModellWurzel::pluck('name', 'id'); 
        
        $wurzeltyp = $propellerKlasseGeometrie->geometrieform;
        //dd($propellerKlasseGeometrie);

        if($wurzeltyp == "F" || $wurzeltyp == "K"){
            if($winkel > 0){
                $name = "W $propellerKlasseGeometrie->name $propellerDrehrichtung->name $propellerModellKompatibilitaet->name +$winkel";
            }
            else{
                $name = "W $propellerKlasseGeometrie->name $propellerDrehrichtung->name $propellerModellKompatibilitaet->name $winkel";
            }            
        }else{
            $name = "W $propellerKlasseGeometrie->name $propellerDrehrichtung->name $propellerModellKompatibilitaet->name";    
        }
        if($konuswinkel != NULL){
            $name = "$name $konuswinkel";
        }

        
        if($vorhandene_propellerModellWurzeln->contains($name)){
            return redirect('/propellerModellWurzeln')->with('error', "Wurzelmodell bereits vorhanden!");            
        }
        //dd($name);

        $propellerModellWurzel = new PropellerModellWurzel;
        $propellerModellWurzel->name = $name;
        $propellerModellWurzel->propeller_modell_kompatibilitaet_id = $request->input('propeller_modell_kompatibilitaet_id');
        $propellerModellWurzel->propeller_klasse_geometrie_id = $request->input('propeller_klasse_geometrie_id');
        $propellerModellWurzel->propeller_drehrichtung_id = $request->input('propeller_drehrichtung_id');
        $propellerModellWurzel->winkel = $request->input('winkel');
        $propellerModellWurzel->konuswinkel = $request->input('konuswinkel');
        $propellerModellWurzel->bereichslaenge = $request->input('bereichslaenge');
        $propellerModellWurzel->kommentar = $request->input('kommentar');
        $propellerModellWurzel->user_id = auth()->user()->id;

        $propellerModellWurzel->save();
        return redirect('/propellerModellWurzeln')->with('success', "neues Wurzelmodell $propellerModellWurzel->name gespeichert!");
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $propellerModellWurzel = PropellerModellWurzel::find($id);
        $propellerKlasseGeometrien = PropellerKlasseGeometrie::orderBy('name','asc')->get();
        $propellerModellKompatibilitaeten = PropellerModellKompatibilitaet::orderBy('name','asc')->get();
        $propellerDrehrichtungen = PropellerDrehrichtung::all();

        
        return view('propellerModellWurzeln.show',
                        compact(
                            'propellerModellWurzel',
                            'propellerKlasseGeometrien',
                            'propellerModellKompatibilitaeten',
                            'propellerDrehrichtungen'
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
        $propellerModellWurzel = PropellerModellWurzel::find($id);
        $propellerKlasseGeometrien = PropellerKlasseGeometrie::orderBy('name')->get();
        $propellerModellKompatibilitaeten = PropellerModellKompatibilitaet::orderBy('name')->get();
        $propellerDrehrichtungen = PropellerDrehrichtung::all();

        
        return view('propellerModellWurzeln.edit',
                        compact(
                            'propellerModellWurzel',
                            'propellerKlasseGeometrien',
                            'propellerModellKompatibilitaeten',
                            'propellerDrehrichtungen'
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
        $data = $this->getData($request);
        
        $propellerKlasseGeometrie = PropellerKlasseGeometrie::find($request->input('propeller_klasse_geometrie_id'));
        $propellerDrehrichtung = PropellerDrehrichtung::find($request->input('propeller_drehrichtung_id'));
        $propellerModellKompatibilitaet = PropellerModellKompatibilitaet::find($request->input('propeller_modell_kompatibilitaet_id'));
        $winkel = number_format($request->input('winkel'),1);
        $konuswinkel = number_format($request->input('konuswinkel'),0);
        if($konuswinkel == 0){
            $konuswinkel = NULL;
        }

        //dd($konuswinkel);
        if(Str::of($winkel)->endsWith('0')){
            $winkel = number_format($request->input('winkel'),0);
        } 
        //dd($winkel);

        $wurzeltyp = substr($propellerKlasseGeometrie->name,1,1);
        //dd($propellerKlasseGeometrie);

        if($wurzeltyp == "F" || $wurzeltyp == "K"){
            if($winkel > 0){
                $name = "W $propellerKlasseGeometrie->name $propellerDrehrichtung->name $propellerModellKompatibilitaet->name +$winkel";
            }
            else{
                $name = "W $propellerKlasseGeometrie->name $propellerDrehrichtung->name $propellerModellKompatibilitaet->name $winkel";
            }            
        }else{
            $name = "W $propellerKlasseGeometrie->name $propellerDrehrichtung->name $propellerModellKompatibilitaet->name";    
        }

        if($konuswinkel != NULL){
            $name = "$name $konuswinkel";
        }

        //dd($name);
        $propellerModellWurzel = PropellerModellWurzel::find($id);
        $propellerModellWurzel->name = $name;
        $propellerModellWurzel->propeller_modell_kompatibilitaet_id = $request->input('propeller_modell_kompatibilitaet_id');
        $propellerModellWurzel->propeller_klasse_geometrie_id = $request->input('propeller_klasse_geometrie_id');
        $propellerModellWurzel->propeller_drehrichtung_id = $request->input('propeller_drehrichtung_id');
        $propellerModellWurzel->winkel = $request->input('winkel');
        $propellerModellWurzel->konuswinkel = $request->input('konuswinkel');
        $propellerModellWurzel->bereichslaenge = $request->input('bereichslaenge');
        $propellerModellWurzel->kommentar = $request->input('kommentar');
        $propellerModellWurzel->user_id = auth()->user()->id;

        $propellerModellWurzel->save();
        return redirect('/propellerModellWurzeln')->with('success', "Wurzelmodell $propellerModellWurzel->name überarbeitet!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $propellerModellWurzel = PropellerModellWurzel::find($id);
        
//        //Check for correct user
//        if(auth()->user()->id !== $post->user_id){
//            return redirect('/posts')->with('error', 'Unauthorized Page');    
//        }
        
        $propellerModellWurzel->delete();
        
        return redirect('/propellerModellWurzeln')->with('success', "Wurzelmodell $propellerModellWurzel->name gelöscht");
    }

    protected function getData(Request $request)
    {
        $rules = [
            'propeller_modell_kompatibilitaet_id' => 'required',
            'propeller_klasse_geometrie_id' => 'required',
            'propeller_drehrichtung_id' => 'required',
            'winkel' => 'required|numeric',
            'bereichslaenge' => 'required|numeric',
            'kommentar' => 'max:100|nullable',
        ];
        
        $data = $request->validate($rules);

        return $data;
    }

    // public function wurzelmodellePDF()
    // {
    //     $title = 'Wurzelmodelle';

    //     $propellerModellWurzeln = PropellerModellWurzel::orderBy('name','asc')->get();
    //     $propellerKlasseGeometrien = PropellerKlasseGeometrie::all();
    //     $propellerModellKompatibilitaeten = PropellerModellKompatibilitaet::all();
    //     $propellerDrehrichtungen = PropellerDrehrichtung::all();

    //     $pdf = PDF::loadView('propellerModellWurzeln.pdf', [
    //                                 'propellerModellWurzeln' => $propellerModellWurzeln, 
    //                                 'propellerKlasseGeometrien' => $propellerKlasseGeometrien,
    //                                 'propellerDrehrichtungen' => $propellerDrehrichtungen, 
    //                                 'propellerModellKompatibilitaeten' => $propellerModellKompatibilitaeten,
    //                                 ]);

    //     $pdf->setOption('margin-top', 15); //** default 10mm */
    //     $pdf->setOption('header-right', "$title");
    //     $pdf->setOption('footer-left', 'PDF-Erstelldatum: [date]');
    //     $pdf->setOption('footer-right', '[page]/[toPage]');
    //     $pdf->setOption('footer-center', "ausgedruckte Exemplare unterliegen nicht dem Aenderungsdienst");
    //     $pdf->setOption('footer-font-size', '6');
    //     return $pdf->download('wurzelmodelle.pdf');
    // }

    private function pdfData($geometrieklasseID,$geometrieklasseName)
    {
        $title = "Wurzelmodelle $geometrieklasseName";

        $propellerModellWurzeln = PropellerModellWurzel::where('propeller_klasse_geometrie_id',$geometrieklasseID)->orderBy('name','asc')->get();
        $propellerKlasseGeometrien = PropellerKlasseGeometrie::all();
        $propellerModellKompatibilitaeten = PropellerModellKompatibilitaet::all();
        $propellerDrehrichtungen = PropellerDrehrichtung::all();

        $pdf = PDF::loadView('propellerModellWurzeln.pdf', [
            'propellerModellWurzeln' => $propellerModellWurzeln, 
            'propellerKlasseGeometrien' => $propellerKlasseGeometrien,
            'propellerDrehrichtungen' => $propellerDrehrichtungen, 
            'propellerModellKompatibilitaeten' => $propellerModellKompatibilitaeten,
            ]);

        $pdf->setOption('margin-top', 15); //** default 10mm */
        $pdf->setOption('header-right', "$title");
        $pdf->setOption('footer-left', 'PDF-Erstelldatum: [date]');
        $pdf->setOption('footer-right', '[page]/[toPage]');
        $pdf->setOption('footer-center', "ausgedruckte Exemplare unterliegen nicht dem Aenderungsdienst");
        $pdf->setOption('footer-font-size', '6');
        return $pdf->download('wurzelmodelle.pdf');
    }
    public function wurzelmodelle_GF05_0_PDF()
    {
            $geometrieklasseID = "15";
            $geometrieklasseName = "GF05-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function wurzelmodelle_GF10_0_PDF()
    {
            $geometrieklasseID = "13";
            $geometrieklasseName = "GF10-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 
    public function wurzelmodelle_GV10_0_PDF()
    {
            $geometrieklasseID = "38";
            $geometrieklasseName = "GV10-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function wurzelmodelle_GF20_0_PDF()
    {
            $geometrieklasseID = "14";
            $geometrieklasseName = "GF20-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function wurzelmodelle_GF25_0_PDF()
    {
            $geometrieklasseID = "1";
            $geometrieklasseName = "GF25-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function wurzelmodelle_GV25_0_PDF()
    {
            $geometrieklasseID = "39";
            $geometrieklasseName = "GF25-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    }

    public function wurzelmodelle_GF26_0_PDF()
    {
            $geometrieklasseID = "32";
            $geometrieklasseName = "GF26-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function wurzelmodelle_GF30_0_PDF()
    {
            $geometrieklasseID = "2";
            $geometrieklasseName = "GF30-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    }

    public function wurzelmodelle_GF31_0_PDF()
    {
            $geometrieklasseID = "6";
            $geometrieklasseName = "GF31-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function wurzelmodelle_GF40_0_PDF()
    {
            $geometrieklasseID = "3";
            $geometrieklasseName = "GF40-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function wurzelmodelle_GV40_0_PDF()
    {
            $geometrieklasseID = "37";
            $geometrieklasseName = "GV40-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function wurzelmodelle_GF45_0_PDF()
    {
            $geometrieklasseID = "5";
            $geometrieklasseName = "GF45-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function wurzelmodelle_GF50_0_PDF()
    {
            $geometrieklasseID = "4";
            $geometrieklasseName = "GF50-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function wurzelmodelle_GF60_0_PDF()
    {
            $geometrieklasseID = "12";
            $geometrieklasseName = "GF60-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function wurzelmodelle_GK20_0_PDF()
    {
            $geometrieklasseID = "22";
            $geometrieklasseName = "GK20-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function wurzelmodelle_GK25_0_PDF()
    {
            $geometrieklasseID = "26";
            $geometrieklasseName = "GK25-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function wurzelmodelle_GK30_0_PDF()
    {
            $geometrieklasseID = "16";
            $geometrieklasseName = "GK30-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function wurzelmodelle_GK40_0_PDF()
    {
            $geometrieklasseID = "30";
            $geometrieklasseName = "GK40-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function wurzelmodelle_GK50_0_PDF()
    {
            $geometrieklasseID = "18";
            $geometrieklasseName = "GK50-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function wurzelmodelle_GS60_0_PDF()
    {
            $geometrieklasseID = "31";
            $geometrieklasseName = "GS60-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function wurzelmodelle_GV30_0_PDF()
    {
            $geometrieklasseID = "17";
            $geometrieklasseName = "GV30-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function wurzelmodelle_GV50_0_PDF()
    {
            $geometrieklasseID = "19";
            $geometrieklasseName = "GV50-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function wurzelmodelle_GV60_0_PDF()
    {
            $geometrieklasseID = "21";
            $geometrieklasseName = "GV60-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function wurzelmodelle_GAV60_0_PDF()
    {
            $geometrieklasseID = "20";
            $geometrieklasseName = "GA/V60-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function wurzelmodelle_GA40_0_PDF()
    {
            $geometrieklasseID = "29";
            $geometrieklasseName = "GA40-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function wurzelmodelle_GA50_0_PDF()
    {
            $geometrieklasseID = "35";
            $geometrieklasseName = "GA50-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

}
