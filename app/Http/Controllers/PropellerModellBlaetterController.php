<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PropellerModellBlatt;
use App\Models\PropellerForm;
use App\Models\PropellerKlasseGeometrie;
use App\Models\PropellerKlasseDesign;
use App\Models\PropellerDurchmesser;
use App\Models\PropellerModellKompatibilitaet;
use App\Models\PropellerModellBlattTyp;
use App\Models\PropellerDrehrichtung;
use App\Models\PropellerVorderkantenTyp;
use App\Models\PropellerModellBlattLogo;

use DB;
use PDF;

class PropellerModellBlaetterController extends Controller
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
        if(request()->has('designklasse')){
            
            $designklasse = request('designklasse');

            $propellerModellBlaetter = PropellerModellBlatt::where('name','like',"%$designklasse%")
            ->orderBy('name', 'asc')
            ->paginate(15)
            ->appends('name', 'like', "%$designklasse%");
        }
        elseif(request()->has('suche')){
            $suche = request('suche');

            $propellerModellBlaetter = PropellerModellBlatt::where('name','like',"%$suche%")
            ->orderBy('name', 'asc')
            ->paginate(15)
            ->appends('name', 'like', "%$suche%");
        }
        else{
            $propellerModellBlaetter = PropellerModellBlatt::sortable()
            ->orderBy('name')->Paginate(10);
        }

        //dd($propellerModellBlaetter);
        return view('propellerModellBlaetter.index', compact('propellerModellBlaetter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() 
    {
        $propellerModellBlattTypen = PropellerModellBlattTyp::orderBy('name')->get();
        $propellerDrehrichtungen = PropellerDrehrichtung::all();
        $propellerModellKompatibilitaeten = PropellerModellKompatibilitaet::orderBy('name')->get();
        $propellerVorderkantenTypen = PropellerVorderkantenTyp::all();
        $propellerLogoTypen = PropellerModellBlattLogo::all();
        $propellerKlasseDesigns = PropellerKlasseDesign::orderBy('name')->get();
        $propellerDurchmesser = PropellerDurchmesser::orderBy('name')->get();
      
        
        return view('propellerModellBlaetter.create', 
                        compact(
                            'propellerModellBlattTypen',
                            'propellerDrehrichtungen',
                            'propellerModellKompatibilitaeten',
                            'propellerKlasseDesigns',
                            'propellerDurchmesser',
                            'propellerVorderkantenTypen',
                            'propellerLogoTypen'
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

        $propellerDrehrichtung = PropellerDrehrichtung::find($request->input('propeller_drehrichtung_id'));
        $propellerModellBlattTyp = PropellerModellBlattTyp::find($request->input('propeller_modell_blatt_typ_id'));
        $propellerModellBlattLogo = PropellerModellBlattLogo::find($request->input('propeller_modell_blatt_logo_id'));
        $propellerVorderkantenTyp = PropellerVorderkantenTyp::find($request->input('propeller_vorderkanten_typ_id'));
        $propellerModellKompatibilitaet = PropellerModellKompatibilitaet::find($request->input('propeller_modell_kompatibilitaet_id'));
        $vorhandene_propellerModellBlaetter = PropellerModellBlatt::pluck('name', 'id');
        $propellerKlasseDesign = PropellerKlasseDesign::find($request->input('propeller_klasse_design_id'));
        //dd($propellerModellBlattLogo);

        /**Generierung des Blattmodellnamens */
        
        $durchmesser = number_format(2*($propellerModellKompatibilitaet->rps + $request->input('bereichslaenge'))/1000,2);                         /**Ermittlung des Durchmessers "2.20m" */
        $drehrichtung = $propellerDrehrichtung->name;                                /**Ermittlung der Drehrichtung "R" */
        $blattmodelltyp = $propellerModellBlattTyp->text;                            /**Ermittlung des Typs "LS" */
        $vorderkantentypID = $request->input('propeller_vorderkanten_typ_id');       /**Ermittlung des Vorderkantentyps "NC" */
        $modellBlattLogoID = $request->input('propeller_modell_blatt_logo_id');      /**Ermittlung des Logotyps */
        $formwinkel = $request->input('winkel');

        //dd($vorderkantentypID);
        if($vorderkantentypID != 1){
            $vorderkantentyp = $propellerVorderkantenTyp->text;
        }else{
            $vorderkantentyp = '';
        }

        if($modellBlattLogoID != 1){
            $logo = $propellerModellBlattLogo->name;
        }else{
            $logo = '';
        }

        if($propellerModellKompatibilitaet->id == 18){                              /**ID 18 ==> ist Kompatibilität "n.a." */
            $name = "B $propellerKlasseDesign->name $durchmesser"."m $drehrichtung"."$blattmodelltyp"."$formwinkel $vorderkantentyp $logo";
        }else{
            $name = "B $propellerKlasseDesign->name $durchmesser"."m $drehrichtung"."$blattmodelltyp $vorderkantentyp $logo";
        }

        
        //dd($name); 

        if($vorhandene_propellerModellBlaetter->contains($name)){
            return redirect('/propellerModellBlaetter')->with('error', "Blattmodell bereits vorhanden!");            
        }
         

        $propellerModellBlatt = new PropellerModellBlatt;
        $propellerModellBlatt->name = $name;
        $propellerModellBlatt->pitch_mitte = $request->input('pitch_mitte');
        $propellerModellBlatt->pitch_aussen = $request->input('pitch_aussen');
        $propellerModellBlatt->pitch_75 = $request->input('pitch_75');
        $propellerModellBlatt->winkel = $request->input('winkel');
        $propellerModellBlatt->propeller_klasse_design_id = $request->input('propeller_klasse_design_id');
        $propellerModellBlatt->propeller_modell_kompatibilitaet_id = $request->input('propeller_modell_kompatibilitaet_id');
        $propellerModellBlatt->profil_laenge = $request->input('profil_laenge');
        $propellerModellBlatt->profil_laenge_75 = $request->input('profil_laenge_75');
        $propellerModellBlatt->propeller_modell_blatt_typ_id = $request->input('propeller_modell_blatt_typ_id');
        $propellerModellBlatt->zoom_faktor = $request->input('zoom_faktor');
        $propellerModellBlatt->bereichslaenge = $request->input('bereichslaenge');
        $propellerModellBlatt->propeller_drehrichtung_id = $request->input('propeller_drehrichtung_id');
        $propellerModellBlatt->propeller_vorderkanten_typ_id = $request->input('propeller_vorderkanten_typ_id');
        $propellerModellBlatt->propeller_modell_blatt_logo_id = $request->input('propeller_modell_blatt_logo_id');
        $propellerModellBlatt->kommentar = $request->input('kommentar');
        $propellerModellBlatt->user_id = auth()->user()->id;
        
        $propellerModellBlatt->save();
        return redirect('/propellerModellBlaetter')->with('success', "neues Blattmodell $propellerModellBlatt->name gespeichert!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $propellerModellBlatt = PropellerModellBlatt::find($id);
        $propellerModellBlattTypen = PropellerModellBlattTyp::orderBy('name')->get();
        $propellerLogoTypen = PropellerModellBlattLogo::all();
        $propellerDrehrichtungen = PropellerDrehrichtung::all();
        $propellerVorderkantenTypen = PropellerVorderkantenTyp::all();
        $propellerModellKompatibilitaeten = PropellerModellKompatibilitaet::orderBy('name')->get();
        $propellerKlasseDesigns = PropellerKlasseDesign::orderBy('name')->get();
        $propellerDurchmesser = PropellerDurchmesser::orderBy('name')->get();   

        return view('propellerModellBlaetter.show',
                        compact(
                            'propellerModellBlatt',
                            'propellerModellBlattTypen',
                            'propellerDrehrichtungen',
                            'propellerModellKompatibilitaeten',
                            'propellerKlasseDesigns',
                            'propellerDurchmesser',
                            'propellerVorderkantenTypen',
                            'propellerLogoTypen'
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
        
//        if(auth()->user()->id !== $blattmodellCad->user_id){
//            return redirect('/blattmodellCads')->with('error', 'Unauthorized Page');    
//        }  
        
        
        $propellerModellBlatt = PropellerModellBlatt::find($id);
        $propellerModellBlattTypen = PropellerModellBlattTyp::orderBy('name')->get();
        $propellerDrehrichtungen = PropellerDrehrichtung::all();
        $propellerVorderkantenTypen = PropellerVorderkantenTyp::all();
        $propellerLogoTypen = PropellerModellBlattLogo::all();
        $propellerModellKompatibilitaeten = PropellerModellKompatibilitaet::orderBy('name')->get();
        $propellerKlasseDesigns = PropellerKlasseDesign::orderBy('name')->get();
        $propellerDurchmesser = PropellerDurchmesser::orderBy('name')->get();

        //dd($propellerModellBlatt);
           
        return view('propellerModellBlaetter.edit',
                        compact(
                            'propellerModellBlatt',
                            'propellerModellBlattTypen',
                            'propellerDrehrichtungen',
                            'propellerModellKompatibilitaeten',
                            'propellerKlasseDesigns',
                            'propellerDurchmesser',
                            'propellerVorderkantenTypen',
                            'propellerLogoTypen'
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
        
        $propellerDrehrichtung = PropellerDrehrichtung::find($request->input('propeller_drehrichtung_id'));
        $propellerModellBlattTyp = PropellerModellBlattTyp::find($request->input('propeller_modell_blatt_typ_id'));
        $propellerModellBlattLogo = PropellerModellBlattLogo::find($request->input('propeller_modell_blatt_logo_id'));
        $propellerVorderkantenTyp = PropellerVorderkantenTyp::find($request->input('propeller_vorderkanten_typ_id'));
        $propellerModellKompatibilitaet = PropellerModellKompatibilitaet::find($request->input('propeller_modell_kompatibilitaet_id'));
        $vorhandene_propellerModellBlaetter = PropellerModellBlatt::pluck('name', 'id');
        $propellerKlasseDesign = PropellerKlasseDesign::find($request->input('propeller_klasse_design_id'));
        //dd($propellerModellBlattLogo);

        /**Generierung des Blattmodellnamens */
        
        $durchmesser = number_format(2*($propellerModellKompatibilitaet->rps + $request->input('bereichslaenge'))/1000,2);                         /**Ermittlung des Durchmessers "2.20m" */
        $drehrichtung = $propellerDrehrichtung->name;                                /**Ermittlung der Drehrichtung "R" */
        $blattmodelltyp = $propellerModellBlattTyp->text;                            /**Ermittlung des Typs "LS" */
        $vorderkantentypID = $request->input('propeller_vorderkanten_typ_id');       /**Ermittlung des Vorderkantentyps "NC" */
        $modellBlattLogoID = $request->input('propeller_modell_blatt_logo_id');      /**Ermittlung des Logotyps */
        $formwinkel = $request->input('winkel');

        //dd($vorderkantentypID);
        if($vorderkantentypID != 1){
            $vorderkantentyp = $propellerVorderkantenTyp->text;
        }else{
            $vorderkantentyp = '';
        }

        if($modellBlattLogoID != 1){
            $logo = $propellerModellBlattLogo->name;
        }else{
            $logo = '';
        }

        if($propellerModellKompatibilitaet->id == 18){                              /**ID 18 ==> ist Kompatibilität "n.a." */
            $name = "B $propellerKlasseDesign->name $durchmesser"."m $drehrichtung"."$blattmodelltyp"."$formwinkel $vorderkantentyp $logo";
        }else{
            $name = "B $propellerKlasseDesign->name $durchmesser"."m $drehrichtung"."$blattmodelltyp $vorderkantentyp $logo";
        }
        
        //dd($name);

        $propellerModellBlatt = PropellerModellBlatt::find($id);
        $propellerModellBlatt->name = $name;
        $propellerModellBlatt->pitch_mitte = $request->input('pitch_mitte');
        $propellerModellBlatt->pitch_aussen = $request->input('pitch_aussen');
        $propellerModellBlatt->pitch_75 = $request->input('pitch_75');
        $propellerModellBlatt->winkel = $request->input('winkel');
        $propellerModellBlatt->propeller_modell_kompatibilitaet_id = $request->input('propeller_modell_kompatibilitaet_id');
        $propellerModellBlatt->profil_laenge = $request->input('profil_laenge');
        $propellerModellBlatt->profil_laenge_75 = $request->input('profil_laenge_75');
        $propellerModellBlatt->propeller_klasse_design_id = $request->input('propeller_klasse_design_id');
        $propellerModellBlatt->propeller_modell_blatt_typ_id = $request->input('propeller_modell_blatt_typ_id');
        $propellerModellBlatt->zoom_faktor = $request->input('zoom_faktor');
        $propellerModellBlatt->bereichslaenge = $request->input('bereichslaenge');
        $propellerModellBlatt->propeller_drehrichtung_id = $request->input('propeller_drehrichtung_id');
        $propellerModellBlatt->propeller_vorderkanten_typ_id = $request->input('propeller_vorderkanten_typ_id');
        $propellerModellBlatt->propeller_modell_blatt_logo_id = $request->input('propeller_modell_blatt_logo_id');
        $propellerModellBlatt->kommentar = $request->input('kommentar'); 
        $propellerModellBlatt->user_id = auth()->user()->id;

        $propellerModellBlatt->save();
        return redirect('/propellerModellBlaetter')->with('success', "Blattmodell $propellerModellBlatt->name überarbeitet!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $propellerModellBlatt = PropellerModellBlatt::find($id);
        
//        //Check for correct user
//        if(auth()->user()->id !== $post->user_id){
//            return redirect('/posts')->with('error', 'Unauthorized Page');    
//        }
        
        $propellerModellBlatt->delete();
        
        return redirect('/propellerModellBlaetter')->with('success', "Blattmodell $propellerModellBlatt->name gelöscht");
    }

    protected function getData(Request $request)
    {
        $rules = [
            'propeller_klasse_design_id'=> 'required',
            'pitch_mitte' => 'required|numeric',
            'pitch_aussen' => 'required|numeric',
            'winkel' => 'required|numeric',
            'propeller_modell_kompatibilitaet_id' => 'required',
            'profil_laenge' => 'nullable|min:1|max:5|numeric',
            'zoom_faktor' => 'nullable|min:0.000|max:5|numeric',
            'bereichslaenge' => 'required|numeric',
            'propeller_drehrichtung_id' => 'required',
            'propeller_vorderkanten_typ_id' => 'required',
            'kommentar' => 'max:100|nullable',
        ];
        
        $data = $request->validate($rules);

        return $data;
    }


    private function pdfData($designklasseID,$designklasseName)
    {
        $title = "Blattmodelle $designklasseName";

        $propellerModellBlaetter = PropellerModellBlatt::where('propeller_klasse_design_id',$designklasseID)->orderBy('name', 'asc')->get();
        $propellerModellBlattTypen = PropellerModellBlattTyp::all();
        $propellerDrehrichtungen = PropellerDrehrichtung::orderBy('name', 'asc')->get();
        $propellerVorderkantenTypen = PropellerVorderkantenTyp::all();
        $propellerModellKompatibilitaeten = PropellerModellKompatibilitaet::all();

        $pdf = PDF::loadView('propellerModellBlaetter.pdf', [
                                'propellerModellBlaetter' => $propellerModellBlaetter, 
                                'propellerModellBlattTypen' => $propellerModellBlattTypen,
                                'propellerDrehrichtungen' => $propellerDrehrichtungen, 
                                'propellerModellKompatibilitaeten' => $propellerModellKompatibilitaeten,
                                'propellerVorderkantenTypen' => $propellerVorderkantenTypen]);

        $pdf->setOption('margin-top', 15); //** default 10mm */
        $pdf->setOption('header-right', "$title");
        $pdf->setOption('footer-left', 'PDF-Erstelldatum: [date]');
        $pdf->setOption('footer-right', '[page]/[toPage]');
        $pdf->setOption('footer-center', "ausgedruckte Exemplare unterliegen nicht dem Aenderungsdienst");
        $pdf->setOption('footer-font-size', '6');
        return $pdf->download("$title.pdf");

    } 

    public function blattmodelle_D05_PDF()
    {
            $designklasseID = "20";
            $designklasseName = "D05-0";
            return $this->pdfData($designklasseID,$designklasseName);

    }
    public function blattmodelle_D10_PDF()
    {
            $designklasseID = "19";
            $designklasseName = "D10-0";
            return $this->pdfData($designklasseID,$designklasseName);

    }
    public function blattmodelle_D20_PDF()
    {
            $designklasseID = "10";
            $designklasseName = "D20-0";
            return $this->pdfData($designklasseID,$designklasseName);

    }
    public function blattmodelle_D25_PDF()
    {
            $designklasseID = "1";
            $designklasseName = "D25-0";
            return $this->pdfData($designklasseID,$designklasseName);

    }
    public function blattmodelle_D30_PDF()
    {
            $designklasseID = "2";
            $designklasseName = "D30-0";
            return $this->pdfData($designklasseID,$designklasseName);

    }
    public function blattmodelle_D45_PDF()
    {
            $designklasseID = "7";
            $designklasseName = "D45-0";
            return $this->pdfData($designklasseID,$designklasseName);

    }
    public function blattmodelle_D50_PDF()
    {
            $designklasseID = "4";
            $designklasseName = "D50-0";
            return $this->pdfData($designklasseID,$designklasseName);

    }
    public function blattmodelle_D60_PDF()
    {
            $designklasseID = "21";
            $designklasseName = "D60-0";
            return $this->pdfData($designklasseID,$designklasseName);

    }


    // public function blattmodellePDF()
    // {
    //     $title = 'Blattmodelle';

    //     $propellerModellBlaetter = PropellerModellBlatt::orderBy('name', 'asc')->get();
    //     $propellerModellBlattTypen = PropellerModellBlattTyp::all();
    //     $propellerDrehrichtungen = PropellerDrehrichtung::orderBy('name', 'asc')->get();
    //     $propellerVorderkantenTypen = PropellerVorderkantenTyp::all();
    //     $propellerModellKompatibilitaeten = PropellerModellKompatibilitaet::all();

    //     $pdf = PDF::loadView('propellerModellBlaetter.pdf', [
    //                             'propellerModellBlaetter' => $propellerModellBlaetter, 
    //                             'propellerModellBlattTypen' => $propellerModellBlattTypen,
    //                             'propellerDrehrichtungen' => $propellerDrehrichtungen, 
    //                             'propellerModellKompatibilitaeten' => $propellerModellKompatibilitaeten,
    //                             'propellerVorderkantenTypen' => $propellerVorderkantenTypen]);

    //     $pdf->setOption('margin-top', 15); //** default 10mm */
    //     $pdf->setOption('header-right', "$title");
    //     $pdf->setOption('footer-left', 'PDF-Erstelldatum: [date]');
    //     $pdf->setOption('footer-right', '[page]/[toPage]');
    //     $pdf->setOption('footer-center', "ausgedruckte Exemplare unterliegen nicht dem Aenderungsdienst");
    //     $pdf->setOption('footer-font-size', '6');
    //     return $pdf->download('blattmodelle.pdf');

    // }
}
