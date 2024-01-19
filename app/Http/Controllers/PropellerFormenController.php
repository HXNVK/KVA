<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\PropellerForm;
use App\Models\Propeller;
use App\Models\PropellerModellBlatt;
use App\Models\PropellerModellBlattTyp;
use App\Models\PropellerModellWurzel;
use App\Models\PropellerModellWurzelTyp;
use App\Models\PropellerModellKompatibilitaet;
use App\Models\PropellerKlasseGeometrie;
use App\Models\PropellerKlasseDesign;
use App\Models\PropellerDurchmesser;
use App\Models\PropellerDrehrichtung;
use App\Models\PropellerVorderkantenTyp;
use App\Models\Kunde;
use App\Models\Auftrag;

use Session;
use Auth;
use DB;
use PDF;
use DNS1D;
use DNS2D;


class PropellerFormenController extends Controller
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

            $propellerFormen = PropellerForm::sortable()
            ->where('name','like',"%$geometrieklasse%")
            ->where('inaktiv','=',NULL)
            ->orderBy('name_kurz', 'asc')
            ->paginate(15)
            ->appends('name_kurz', 'like', "%$geometrieklasse%");
 
        }elseif(request()->has('suche')){
            $suche = request('suche');

            $propellerFormen = PropellerForm::sortable()
            ->where('name','like',"%$suche%")
            ->where('inaktiv','=',NULL)
            // ->orWhere('name_kurz', 'like', '%'. $suche .'%')
            ->orderBy('name_kurz', 'asc')
            ->paginate(15)
            ->appends('name_kurz', 'like', "%$suche%");
        }
        else{
            $propellerFormen = PropellerForm::sortable()
            ->orderBy('name_kurz','asc')
            ->where('inaktiv','=',NULL)
            ->paginate(15);
        }       
        
        //dd($propellerFormen);
        return view('propellerFormen.index', compact('propellerFormen'));   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $propellerFormen = PropellerForm::all();
        $propellerModellBlaetter = PropellerModellBlatt::orderBy('name')->get();
        $propellerModellWurzeln = PropellerModellWurzel::orderBy('name')->get();
        
        //dd($blattmodellCads);
        return view('propellerFormen.create', compact('propellerFormen','propellerModellBlaetter','propellerModellWurzeln'));
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
        
        $propellerModellBlatt = PropellerModellBlatt::find($request->input('propeller_modell_blatt_id'));
        $propellerModellWurzel = PropellerModellWurzel::find($request->input('propeller_modell_wurzel_id'));

        /**Generierung des Produktformnamens */
        $propellerKlasseGeometrie = $propellerModellWurzel->propellerKlasseGeometrie->name;                                      /**Ermittlung der Geometrieklasse "GF50" */
        $propellerBasisFestigkeit = $propellerModellWurzel->propellerKlasseGeometrie->basis_festigkeitsklasse;                   /**Ermittlung der Basis Festigkeitsklasse "50" */
        $propellerGeometrieform = $propellerModellWurzel->propellerKlasseGeometrie->geometrieform;                               /**Ermittlung der Geometriekform "F" */
         
        //dd($propellerGeometrieform);

        $propellerKlasseDesign = $propellerModellBlatt->propellerKlasseDesign->name;
        $durchmesser = number_format(2*($propellerModellBlatt->bereichslaenge + $propellerModellWurzel->bereichslaenge)/1000,2); /**Ermittlung des Durchmessers "2.20" */
        $drehrichtung = $propellerModellBlatt->propellerDrehrichtung->name;                                                      /**Ermittlung der Drehrichtung "R" */
        $blattmodelltyp = $propellerModellBlatt->propellerModellBlattTyp->text;                                                  /**Ermittlung des Typs "LS" */
        $vorhandene_propellerFormen = PropellerForm::pluck('name', 'id');
        $konuswinkel = sprintf("%02d",number_format($propellerModellWurzel->konuswinkel,0));  

        //dd($konuswinkel);
        $formwinkel = number_format($propellerModellBlatt->winkel + $propellerModellWurzel->winkel,0);
        if($formwinkel<10){
            $formwinkel =sprintf("%02d",$formwinkel); /**Formatiert zahlen kleiner Zehn auf "08" */
        }

        $vorderkantentypID = $propellerModellBlatt->propellerVorderkantenTyp->id; /**Ermittlung ob NC oder nicht */
        if($vorderkantentypID != 1){
            $vorderkantentyp = $propellerModellBlatt->propellerVorderkantenTyp->text;
        }else{
            $vorderkantentyp = '';
        }


        //if($propellerGeometrieform == 'V'){
        if($propellerGeometrieform == 'V' || $propellerGeometrieform == 'A/V'){
            $name = "F $propellerKlasseGeometrie $propellerKlasseDesign $durchmesser"."m $drehrichtung"."$blattmodelltyp $vorderkantentyp";             /**Bsp. F GV50-0 D50-0 1.45m L-SSI-  oder F GA60-0 D50-0 2.20m R-LS- NC */
            $name_kurz = "F$propellerBasisFestigkeit"."$propellerGeometrieform $durchmesser"."m $drehrichtung"."$blattmodelltyp $vorderkantentyp";  
            $formwinkel = 0;   
        }else{
            if($konuswinkel == NULL || $konuswinkel == '00'){
                $name = "F $propellerKlasseGeometrie $propellerKlasseDesign $durchmesser"."m $drehrichtung"."$blattmodelltyp"."$formwinkel $vorderkantentyp"; /**Bsp. F GF50-0 D50-0 2.20m R-LS-10 NC */   
                $name_kurz = "F$propellerBasisFestigkeit"."$propellerGeometrieform $durchmesser"."m $drehrichtung"."$blattmodelltyp"."$formwinkel $vorderkantentyp";
                $konuswinkel = 0; 
            }else{
                $name = "F $propellerKlasseGeometrie $propellerKlasseDesign $durchmesser"."m $drehrichtung"."$blattmodelltyp"."$formwinkel-$konuswinkel $vorderkantentyp"; /**Bsp. F GF26-0 D26-0 2.25m R-LFL-03-04 NC */ 
                $name_kurz = "F$propellerBasisFestigkeit"."$propellerGeometrieform $durchmesser"."m $drehrichtung"."$blattmodelltyp"."$formwinkel-$konuswinkel $vorderkantentyp";
            }
        }

        //dd($name_kurz);

        if($propellerModellBlatt->propellerDrehrichtung->name != $propellerModellWurzel->propellerDrehrichtung->name){
            return redirect('/propellerFormen')->with('error', "Modell Blatt und Modell Wurzel haben unterschiedliche Drehrichtung!");    
        }

        if($propellerModellBlatt->propellerModellKompatibilitaet->name != $propellerModellWurzel->propellerModellKompatibilitaet->name){
            return redirect('/propellerFormen')->with('error', "Fehler Kompatibilität!");    
        }
        
        if($vorhandene_propellerFormen->contains($name)){
            return redirect('/propellerFormen')->with('error', "Propellerform bereits vorhanden!");            
        }
        
        $propellerForm = new propellerForm;
        $propellerForm->name = $name;
        $propellerForm->name_kurz = $name_kurz;
        $propellerForm->propeller_modell_blatt_id = $request->input('propeller_modell_blatt_id');         
        $propellerForm->propeller_modell_wurzel_id = $request->input('propeller_modell_wurzel_id');
        $propellerForm->anzahl = $request->input('anzahl');
        $propellerForm->winkel = $formwinkel; 
        $propellerForm->konuswinkel = $konuswinkel;
        $propellerForm->kommentar = $request->input('kommentar'); 
        $propellerForm->user_id = auth()->user()->id;   
        
        $propellerForm->save();
        return redirect('/propellerFormen')->with('success', "neue Form $propellerForm->name gespeichert!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $propellerForm = PropellerForm::find($id);
        $propellerModellBlaetter = PropellerModellBlatt::orderBy('name')->get();
        $propellerModellWurzeln = PropellerModellWurzel::orderBy('name')->get();
        
        //dd($blattmodellCads);
        return view('propellerFormen.show',compact('propellerForm','propellerModellBlaetter','propellerModellWurzeln'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $propellerForm = PropellerForm::find($id);
        $propellerModellBlaetter = PropellerModellBlatt::orderBy('name')->get();
        $propellerModellWurzeln = PropellerModellWurzel::orderBy('name')->get();

        //dd($blattmodellCads);
        return view('propellerFormen.edit', compact('propellerForm','propellerModellBlaetter','propellerModellWurzeln'));
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

        $propellerModellBlatt = PropellerModellBlatt::find($request->input('propeller_modell_blatt_id'));
        $propellerModellWurzel = PropellerModellWurzel::find($request->input('propeller_modell_wurzel_id'));

        /**Generierung des Produktformnamens */
        $propellerKlasseGeometrie = $propellerModellWurzel->propellerKlasseGeometrie->name;                                      /**Ermittlung der Geometrieklasse "GF50-0" */
        $propellerBasisFestigkeit = $propellerModellWurzel->propellerKlasseGeometrie->basis_festigkeitsklasse;                   /**Ermittlung der Basis Festigkeitsklasse "50" */
        $propellerGeometrieform = $propellerModellWurzel->propellerKlasseGeometrie->geometrieform;                               /**Ermittlung der Geometriekform "F" */

        $propellerKlasseDesign = $propellerModellBlatt->propellerKlasseDesign->name;                                             /**Ermittlung der Designklasse D50-0 */
        $durchmesser = number_format(2*($propellerModellBlatt->bereichslaenge + $propellerModellWurzel->bereichslaenge)/1000,2); /**Ermittlung des Durchmessers "2.20" */
        $drehrichtung = $propellerModellBlatt->propellerDrehrichtung->name;                                                      /**Ermittlung der Drehrichtung "R" */
        $blattmodelltyp = $propellerModellBlatt->propellerModellBlattTyp->text;                                                  /**Ermittlung des Typs "LS" */
        $konuswinkel = sprintf("%02d",number_format($propellerModellWurzel->konuswinkel,0)); 

        $winkel = $request->input('winkel');
        if($winkel != NULL){
            $formwinkel = number_format($request->input('winkel'),1);
        }else{
            $formwinkel = number_format($propellerModellBlatt->winkel + $propellerModellWurzel->winkel,0);
            if($formwinkel<10){
                $formwinkel =sprintf("%02d",$formwinkel); /**Formatiert zahlen kleiner Zehn auf "08" */
            }
        }
        
        $vorderkantentypID = $propellerModellBlatt->propellerVorderkantenTyp->id; /**Ermittlung ob NC oder nicht */
        if($vorderkantentypID != 1){
            $vorderkantentyp = $propellerModellBlatt->propellerVorderkantenTyp->text;
        }else{
            $vorderkantentyp = '';
        }
        
        if($propellerGeometrieform == 'V'){
            $name = "F $propellerKlasseGeometrie $propellerKlasseDesign $durchmesser"."m $drehrichtung"."$blattmodelltyp $vorderkantentyp";             /**Bsp. F GA60-0 D50-0 2.20m R-LS- NC */
            $name_kurz = "F$propellerBasisFestigkeit"."$propellerGeometrieform $durchmesser"."m $drehrichtung"."$blattmodelltyp $vorderkantentyp";  
            $formwinkel = 0;   
        }else{
            if($konuswinkel == NULL || $konuswinkel == '00'){
                $name = "F $propellerKlasseGeometrie $propellerKlasseDesign $durchmesser"."m $drehrichtung"."$blattmodelltyp"."$formwinkel $vorderkantentyp"; /**Bsp. F GF50-0 D50-0 2.20m R-LS-10 NC */   
                $name_kurz = "F$propellerBasisFestigkeit"."$propellerGeometrieform $durchmesser"."m $drehrichtung"."$blattmodelltyp"."$formwinkel $vorderkantentyp";
                $konuswinkel = 0; 
            }else{
                $name = "F $propellerKlasseGeometrie $propellerKlasseDesign $durchmesser"."m $drehrichtung"."$blattmodelltyp"."$formwinkel-$konuswinkel $vorderkantentyp"; /**Bsp. F GF26-0 D26-0 2.25m R-LFL-03-04 NC */ 
                $name_kurz = "F$propellerBasisFestigkeit"."$propellerGeometrieform $durchmesser"."m $drehrichtung"."$blattmodelltyp"."$formwinkel-$konuswinkel $vorderkantentyp";
            }
        }

        if($propellerModellBlatt->propellerDrehrichtung->name != $propellerModellWurzel->propellerDrehrichtung->name){
            return redirect('/propellerFormen')->with('error', "Modell Blatt und Modell Wurzel haben unterschiedliche Drehrichtung!");    
        }
        if($propellerModellBlatt->propellerModellKompatibilitaet->name != $propellerModellWurzel->propellerModellKompatibilitaet->name){
            return redirect('/propellerFormen')->with('error', "Fehler Kompatibilität!");    
        }
        

        //dd($name_kurz);
        $propellerForm = PropellerForm::find($id);
        $propellerForm->name = $name;
        $propellerForm->name_kurz = $name_kurz;
        $propellerForm->propeller_modell_blatt_id = $request->input('propeller_modell_blatt_id');         
        $propellerForm->propeller_modell_wurzel_id = $request->input('propeller_modell_wurzel_id');
        $propellerForm->anzahl = $request->input('anzahl');
        $propellerForm->winkel = $formwinkel;
        $propellerForm->konuswinkel = $konuswinkel;
        $propellerForm->kommentar = $request->input('kommentar'); 
        $propellerForm->user_id = auth()->user()->id;   
        
        $propellerForm->save();
        return redirect('/propellerFormen')->with('success', "Form $propellerForm->name überarbeitet!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {       
        try {
            $propellerForm = PropellerForm::findOrFail($id);
            // $propellerForm->delete();
            $propellerForm->inaktiv = "1";
            $propellerForm->user_id = auth()->user()->id;
            $propellerForm->save();

            $propeller = Propeller::where('propeller_form_id', $id)
                        ->get(['id']);

            foreach ($propeller as &$datensatz) {
                $datensatz["inaktiv"] = 1;
                $datensatz->save();
            }

            //dd($propeller);


            return redirect('/propellerFormen')
                ->with('success', "Form $propellerForm->name inaktiv gesetzt");
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
        
    }

    protected function getData(Request $request)
    {
        $rules = [
            'propeller_modell_blatt_id' => 'required',
            'propeller_modell_wurzel_id' => 'required',
            'anzahl' => 'required|numeric',
            //'winkel' => 'nullable',
            'kommentar' => 'max:100|nullable',
        ];
        
        $data = $request->validate($rules);

        return $data;
    }

    public function fb018()
    {
        $kunden = Kunde::orderBy('matchcode','asc')->get();
        $propellerFormen = PropellerForm::orderBy('name_kurz','asc')
                                        //->where('inaktiv','!=', '1')
                                        ->where('inaktiv','=', NULL)
                                        ->get();

        //dd($blattmodellCads);
        return view('propellerFormen.fb018', compact(
                                                'propellerFormen',
                                                'kunden'
                                            ));
    }

    public function fb018speichern(Request $request)
    {
        //dd($request->input());
        $this->validate($request,[
            'anzahl' => 'required|numeric|min:1',
            'kunde_id' => 'required',
            'propeller_form_id' => 'required',
            'kommentar' => 'string|nullable|max:500'
        ]);

        if($request->input('myFactoryAB') == NULL){
            $myFactoryAB = '9999999';
        }else{
            $myFactoryAB = $request->input('myFactoryAB');   
        }

        $kundeID = $request->input('kunde_id');
        $kunde = Kunde::find($kundeID);  

        $propellerForm = Propellerform::find($request->input('propeller_form_id'));

        $auftragFB018 = new Auftrag;
        $auftragFB018->kundeID = $request->input('kunde_id');;
        $auftragFB018->kundeMatchcode = $kunde->matchcode;
        $auftragFB018->myFactoryID = $kunde->lexware_id;
        $auftragFB018->lexwareAB = $myFactoryAB;
        $auftragFB018->anzahl = $request->input('anzahl');
        $auftragFB018->propeller = $propellerForm->name_kurz;
        $auftragFB018->propellerForm = $propellerForm->name_kurz;
        $auftragFB018->propellerForm_id = $request->input('propeller_form_id');
        $auftragFB018->propellerForm_haelfte = $request->input('formenhaelfte');
        $auftragFB018->propellerFormBlatt_neu = $request->input('formBlattNeu');
        $auftragFB018->propellerFormWurzel_neu = $request->input('formWurzelNeu');
        $auftragFB018->auftrag_status_id = 11;
        $auftragFB018->auftrag_typ_id = 7;
        $auftragFB018->dringlichkeit = $request->input('dringlichkeit');
        $auftragFB018->ets = $request->input('eta');
        $auftragFB018->notiz = $request->input('kommentar'); 
        $auftragFB018->user_id = auth()->user()->id;
    
        $auftragFB018->save();

        return redirect('/propellerFormen')
        ->with('success', "FB018 $propellerForm->name_kurz gespeichert");
    }

    private function pdfData($geometrieklasseID,$geometrieklasseName)
    {
        $title = "Formen $geometrieklasseName";

        //$propellerModellWurzeln = PropellerModellWurzel::where('propeller_klasse_geometrie_id',$geometrieklasseID)->orderBy('name','asc')->get();

        //$propellerFormen = PropellerForm::where('propeller_modell_wurzel_id',$designklasseID)->orderBy('name', 'asc')->get();

        $propellerFormenObjects = PropellerForm::select(
            //'projekt_propeller.*',
            //'propeller.*',
            'propeller_formen.id as propellerFormID',
            'propeller_formen.name_kurz as propellerFormName',
            'propeller_formen.propeller_modell_wurzel_id as propellerModellWurzelID',
            'propeller_modell_wurzeln.propeller_klasse_geometrie_id as geometrieKlasseID',
            'propeller_modell_wurzeln.propeller_drehrichtung_id as propellerDrehrichtungID'

            )
            ->join('propeller_modell_wurzeln','propeller_formen.propeller_modell_wurzel_id', '=', 'propeller_modell_wurzeln.id')

            ->where('propeller_modell_wurzeln.propeller_klasse_geometrie_id','=', $geometrieklasseID)

            ->where('propeller_formen.inaktiv','=',NULL)

            ->orderBy('propellerFormName','asc')

            ->get();

        //dd($propellerFormenObjects);

        $pdf = PDF::loadView('propellerFormen.pdf', [
                                'propellerFormenObjects' => $propellerFormenObjects
                                ]);

        $pdf->setOption('margin-top', 15); //** default 10mm */
        $pdf->setOption('header-right', "$title");
        $pdf->setOption('footer-left', 'PDF-Erstelldatum: [date]');
        $pdf->setOption('footer-right', '[page]/[toPage]');
        $pdf->setOption('footer-center', "ausgedruckte Exemplare unterliegen nicht dem Aenderungsdienst");
        $pdf->setOption('footer-font-size', '6');
        return $pdf->download("$title.pdf");

    }
    public function formen_GF20_0_PDF()
    {
            $geometrieklasseID = "14";
            $geometrieklasseName = "GF20-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function formen_GF25_0_PDF()
    {
            $geometrieklasseID = "1";
            $geometrieklasseName = "GF25-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function formen_GV25_0_PDF()
    {
            $geometrieklasseID = "39";
            $geometrieklasseName = "GF25-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    }

    public function formen_GF26_0_PDF()
    {
            $geometrieklasseID = "32";
            $geometrieklasseName = "GF26-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function formen_GF30_0_PDF()
    {
            $geometrieklasseID = "2";
            $geometrieklasseName = "GF30-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    }

    public function formen_GV30_0_PDF()
    {
            $geometrieklasseID = "17";
            $geometrieklasseName = "GV30-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    }

    public function formen_GF31_0_PDF()
    {
            $geometrieklasseID = "6";
            $geometrieklasseName = "GF31-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function formen_GF40_0_PDF()
    {
            $geometrieklasseID = "3";
            $geometrieklasseName = "GF40-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function formen_GAV40_0_PDF()
    {
            $geometrieklasseID = "29";
            $geometrieklasseName = "GAV40-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 
    public function formen_GAV40_1_PDF()
    {
            $geometrieklasseID = "102";
            $geometrieklasseName = "GAV40-1";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function formen_GF45_0_PDF()
    {
            $geometrieklasseID = "5";
            $geometrieklasseName = "GF45-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function formen_GF50_0_PDF()
    {
            $geometrieklasseID = "4";
            $geometrieklasseName = "GF50-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function formen_GV50_0_PDF()
    {
            $geometrieklasseID = "19";
            $geometrieklasseName = "GV50-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    }

    public function formen_GF60_0_PDF()
    {
            $geometrieklasseID = "12";
            $geometrieklasseName = "GF60-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function formen_GAV60_0_PDF()
    {
            $geometrieklasseID = "20";
            $geometrieklasseName = "GAV60-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function formen_GK20_0_PDF()
    {
            $geometrieklasseID = "22";
            $geometrieklasseName = "GK20-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function formen_GK25_0_PDF()
    {
            $geometrieklasseID = "26";
            $geometrieklasseName = "GK25-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function formen_GK30_0_PDF()
    {
            $geometrieklasseID = "16";
            $geometrieklasseName = "GK30-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function formen_GK40_0_PDF()
    {
            $geometrieklasseID = "30";
            $geometrieklasseName = "GK40-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    } 

    public function formen_GK50_0_PDF()
    {
            $geometrieklasseID = "18";
            $geometrieklasseName = "GK50-0";
            return $this->pdfData($geometrieklasseID,$geometrieklasseName);

    }
}
