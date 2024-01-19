<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

use App\Models\PropellerModellBlattTyp;
use App\Models\PropellerModellKompatibilitaet;
use App\Models\PropellerKlasseDesign;
use App\Models\ProjektGeraeteklasse;
use PDF;


class PropellerModellBlattTypenController extends Controller
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

            $propellerModellBlattTypen = PropellerModellBlattTyp::where('name','like',"%$designklasse%")
            ->orderBy('name', 'asc')
            ->paginate(15)
            ->appends('name', 'like', "%$designklasse%");
 
        }elseif(request()->has('suche')){
            $suche = request('suche');

            $propellerModellBlattTypen = PropellerModellBlattTyp::where('name','like',"%$suche%")
            ->orderBy('name', 'asc')
            ->paginate(15)
            ->appends('name', 'like', "%$suche%");
        }
        else{
            $propellerModellBlattTypen = PropellerModellBlattTyp::orderBy('name','asc')
            ->paginate(15);
        }  

        return view('propellerModellBlattTypen.index',compact('propellerModellBlattTypen'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $propellerModellKompatibilitaeten = PropellerModellKompatibilitaet::orderBy('name','asc')->get();
        $propellerKlasseDesigns = PropellerKlasseDesign::orderBy('name','asc')->get();
        $projektGeraeteklassen = ProjektGeraeteklasse::orderBy('name','asc')->get();

        return view('propellerModellBlattTypen.create',
                    compact(
                        'propellerModellKompatibilitaeten',
                        'propellerKlasseDesigns',
                        'projektGeraeteklassen'
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
       
        $propellerKlasseDesign = PropellerKlassedesign::find($request->input('propeller_klasse_design_id'));
        $propellerKlasseDesign = $propellerKlasseDesign->name;
        $vorhandene_propellerModellBlattTypen = PropellerModellBlattTyp::pluck('name', 'id'); 

        $umrissform = Str::upper($request->input('umrissform'));
        $profilform = Str::upper($request->input('profilform'));
        $profillaenge = Str::upper($request->input('profillaenge'));

        $text = "-$umrissform"."$profilform"."$profillaenge-";
        $name = "T $propellerKlasseDesign $text";
        $name_alt = $request->input('name_alt');

        if($request->input('name_alt') != NULL){
            $name_alt = $name_alt;
        }
        if($request->input('name_alt') == NULL){
            $name_alt = '';
        }


        if($vorhandene_propellerModellBlattTypen->contains($name)){
            return redirect('/propellerModellBlattTypen')->with('error', "Typ bereits vorhanden!");            
        }

        $propellerModellBlattTypen = PropellerModellBlattTyp::pluck('artikel_modelcode');

        $sorted = array_values(Arr::sort($propellerModellBlattTypen));
        $letzterModelcode = end($sorted);
        $neuerModelcode = $letzterModelcode + 1;

        //dd($neuerModelcode);

        //dd($name);

        $propellerModellBlattTyp = new PropellerModellBlattTyp;
        $propellerModellBlattTyp->name = $name;
        $propellerModellBlattTyp->name_alt = $name_alt;
        $propellerModellBlattTyp->text = $text;
        $propellerModellBlattTyp->propeller_klasse_design_id = $request->input('propeller_klasse_design_id');
        $propellerModellBlattTyp->umrissform = $umrissform;
        $propellerModellBlattTyp->profilform = $profilform;
        $propellerModellBlattTyp->profillaenge = $profillaenge;
        $propellerModellBlattTyp->freifeld = $request->input('freifeld');
        $propellerModellBlattTyp->propeller_modell_kompatibilitaet_id = $request->input('propeller_modell_kompatibilitaet_id');
        $propellerModellBlattTyp->exclusiv = $request->input('exclusiv');
        $propellerModellBlattTyp->kunde = $request->input('kunde');
        $propellerModellBlattTyp->projekt_geraeteklasse_id = $request->input('projekt_geraeteklasse_id');
        $propellerModellBlattTyp->artikel_modelcode = $neuerModelcode;
        $propellerModellBlattTyp->kommentar = $request->input('kommentar');
        $propellerModellBlattTyp->user_id = auth()->user()->id;

        $propellerModellBlattTyp->save();
        return redirect('/propellerModellBlattTypen')->with('success', "neuer Blattmodelltyp $propellerModellBlattTyp->name gespeichert!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $propellerModellBlattTyp = PropellerModellBlattTyp::find($id);
        $propellerModellKompatibilitaeten = PropellerModellKompatibilitaet::orderBy('name')->get();
        $propellerKlasseDesigns = PropellerKlasseDesign::orderBy('name')->get();
        $projektGeraeteklassen = ProjektGeraeteklasse::orderBy('name')->get();
           
        return view('propellerModellBlattTypen.edit',
                        compact(
                            'propellerModellBlattTyp',
                            'propellerModellKompatibilitaeten',
                            'propellerKlasseDesigns',
                            'projektGeraeteklassen'
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

        $propellerKlasseDesign = PropellerKlasseDesign::find($request->input('propeller_klasse_design_id'));
        $propellerKlasseDesign = $propellerKlasseDesign->name;
        
        $umrissform = $request->input('umrissform');
        $profilform = $request->input('profilform');
        $profillaenge = $request->input('profillaenge');
        $name_alt = $request->input('name_alt');

        $text = "-$umrissform"."$profilform"."$profillaenge-";
        $name = "T $propellerKlasseDesign $text";

        if($request->input('name_alt') != NULL){
            $name_alt = $name_alt;
        }
        if($request->input('name_alt') == NULL){
            $name_alt = '';
        }
    
        $propellerModellBlattTyp = PropellerModellBlattTyp::find($id);
        $propellerModellBlattTyp->name = $name;
        $propellerModellBlattTyp->name_alt = $name_alt;
        $propellerModellBlattTyp->text = $text;
        $propellerModellBlattTyp->propeller_klasse_design_id = $request->input('propeller_klasse_design_id');
        $propellerModellBlattTyp->umrissform = $request->input('umrissform');
        $propellerModellBlattTyp->profilform = $request->input('profilform');
        $propellerModellBlattTyp->profillaenge = $request->input('profillaenge');
        $propellerModellBlattTyp->freifeld = $request->input('freifeld');
        $propellerModellBlattTyp->propeller_modell_kompatibilitaet_id = $request->input('propeller_modell_kompatibilitaet_id');
        $propellerModellBlattTyp->exclusiv = $request->input('exclusiv');
        $propellerModellBlattTyp->kunde = $request->input('kunde');
        $propellerModellBlattTyp->projekt_geraeteklasse_id = $request->input('projekt_geraeteklasse_id');
        $propellerModellBlattTyp->kommentar = $request->input('kommentar');
        $propellerModellBlattTyp->user_id = auth()->user()->id;

        $propellerModellBlattTyp->save();
        return redirect('/propellerModellBlattTypen')->with('success', "Blattmodelltyp $propellerModellBlattTyp->name geändert!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $propellerModellBlattTyp = PropellerModellBlattTyp::find($id);
        
//        //Check for correct user
//        if(auth()->user()->id !== $post->user_id){
//            return redirect('/posts')->with('error', 'Unauthorized Page');    
//        }
        
        $propellerModellBlattTyp->delete();
        
        return redirect('/propellerModellBlattTypen')->with('success', "Blattmodelltyp $propellerModellBlattTyp->name gelöscht");
    }


    protected function getData(Request $request)
    {
        $rules = [
            'propeller_klasse_design_id' => 'required',
            'name_alt' => 'bail|min:1|max:5|nullable',
            'umrissform' => 'bail|required|min:1|max:1',
            'profilform' => 'bail|required|min:1|max:1',
            'profillaenge' => 'bail|required|min:1|max:1',
            'freifeld' => 'bail|max:100',
            'propeller_modell_kompatibilitaet_id' => 'required',
            'exclusiv' => 'bail|max:100',
            'kunde' => 'bail|max:100',
            'projekt_geraeteklasse_id' => 'required',
            'kommentar' => 'bail|max:100'
        ];
        
        $data = $request->validate($rules);

        return $data;
    }




    public function typenPDF()
    {
        $title = 'Typen';

        $propellerModellBlattTypen = PropellerModellBlattTyp::orderBy('name','asc')->get();
        $propellerModellKompatibilitaet = PropellerModellKompatibilitaet::all();
        $propellerKlasseDesigns = PropellerKlasseDesign::all();
        $projektGeraeteklassen = ProjektGeraeteklasse::all();
        

        $pdf = PDF::loadView('propellerModellBlattTypen.pdf', [
                                'propellerModellBlattTypen' => $propellerModellBlattTypen, 
                                'blattmodellKompatibilitaeten' => $propellerModellKompatibilitaet,
                                'propellerKlasseDesigns' => $propellerKlasseDesigns,
                                'projektGeraeteklassen' => $projektGeraeteklassen]);
        //$pdf->setOption('toc', true);               
        $pdf->setOption('margin-top', 15); //** default 10mm */
        $pdf->setOption('header-right', "$title");
        $pdf->setOption('footer-left', 'PDF-Erstelldatum: [date]');
        $pdf->setOption('footer-right', '[page]/[toPage]');
        $pdf->setOption('footer-center', "ausgedruckte Exemplare unterliegen nicht dem Aenderungsdienst");
        $pdf->setOption('footer-font-size', '6');
        return $pdf->download('blattmodellTypen.pdf');    

    }


}
