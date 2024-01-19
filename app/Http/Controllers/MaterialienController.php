<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MaterialHersteller;
use App\Models\Material;
use App\Models\MaterialGruppe;
use App\Models\MaterialTyp;
use Illuminate\Http\Request;
use Exception;
use Auth;

use PDF;

class MaterialienController extends Controller
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

            $materialien = Material::sortable()
            ->where('name','like',"%$suche%")
            ->orderBy('name', 'asc')
            ->paginate(15)
            ->appends('name', 'like', "%$suche%");
        }
        else{
            $materialien = Material::sortable()
            ->orderBy('name', 'asc')
            ->paginate(15);
        }

       
        $materialGruppen = MaterialGruppe::orderBy('name')->get();
        $materialTypen = MaterialTyp::orderBy('name')->get();

        //dd($materialien);
        return view('materialien.index', compact(
                                                'materialien',
                                                'materialGruppen',
                                                'materialTypen'
                                            ));
    }

    /**
     * Show the form for creating a new material hersteller.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $materialHerstellerObjekte = MaterialHersteller::orderBy('name','asc')->get();
        $materialGruppen = MaterialGruppe::orderBy('name')->get();
        $materialTypen = MaterialTyp::orderBy('name')->get();

        return view('materialien.create',compact(
                                                'materialHerstellerObjekte',
                                                'materialGruppen',
                                                'materialTypen'
                                            ));
    }

    /**
     * Store a new material hersteller in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $data = $this->getData($request);

        $material = new Material;
        $material->name = $request->input('name');
        $material->name_lang = $request->input('name_lang');
        $material->material_gruppe_id = $request->input('material_gruppe_id');
        $material->material_typ_id = $request->input('material_typ_id');
        $material->material_hersteller_id = $request->input('material_hersteller_id');
        //$material->chargennummer = $request->input('chargennummer');
        $material->flaechengewicht = $request->input('flaechengewicht');
        $material->kommentar = $request->input('kommentar');
        $material->user_id = auth()->user()->id;

        $material->save();
        return redirect('/materialien')->with('success', "neuer Hersteller $material->name gespeichert!");
    }

    /**
     * Show the form for editing the specified material hersteller.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $material = Material::findOrFail($id);
        $materialHerstellerObjekte = MaterialHersteller::orderBy('name','asc')->get();
        $materialGruppen = MaterialGruppe::orderBy('name')->get();
        $materialTypen = MaterialTyp::orderBy('name')->get();
        

        return view('materialien.edit', compact(
                                                'material',
                                                'materialHerstellerObjekte',
                                                'materialGruppen',
                                                'materialTypen'
                                            ));
    }

    public function update($id, Request $request)
    {
        $data = $this->getData($request);

        $material = Material::findOrFail($id);
        $material->name = $request->input('name');
        $material->name_lang = $request->input('name_lang');
        $material->material_gruppe_id = $request->input('material_gruppe_id');
        $material->material_hersteller_id = $request->input('material_hersteller_id');
        //$material->chargennummer = $request->input('chargennummer');
        $material->flaechengewicht = $request->input('flaechengewicht');
        $material->kommentar = $request->input('kommentar');
        $material->user_id = auth()->user()->id;

        $material->save();
        return redirect('/materialien')->with('success', "neues Halbzeug $material->name gespeichert!");
    }

    /**
     * Remove the specified material hersteller from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $material = Material::findOrFail($id);
            $material->delete();

            return redirect('/materialien')
                ->with('success', "Halbzeug $material->name gelöscht");
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    
    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request 
     * @return array
     */
    protected function getData(Request $request)
    {
        $rules = [
            'name' => 'required|string|min:1|max:100',
            'name_lang' => 'required|string|min:1|max:100',
            'material_hersteller_id' => 'required',
            'material_gruppe_id' => 'required',
            'material_typ_id' => 'required',
            'flaechengewicht' => 'numeric|nullable',
            'zugfestigkeit' => 'nullable',
            'eModul' => 'nullable',
            'dichte' => 'nullable',
            'bruchdehnung' => 'nullable',
            'dichteAusdehnungskoeff' => 'nullable', 
            'kommentar' => 'nullable',
        ];
        
        $data = $request->validate($rules);


        return $data;
    }

    
    public function materialienPDF()
    {
        $title = 'Materialien';

        $materialien = Material::orderBy('name', 'asc')->paginate(25);

        $pdf = PDF::loadView('materialien.pdf', [
                                    'materialien' => $materialien]);

        $pdf->setOption('margin-top', 15); //** default 10mm */
        $pdf->setOption('header-right', "$title");
        $pdf->setOption('footer-left', 'PDF-Erstelldatum: [date]');
        $pdf->setOption('footer-right', '[page]/[toPage]');
        $pdf->setOption('footer-center', "ausgedruckte Exemplare unterliegen nicht dem Aenderungsdienst");
        $pdf->setOption('footer-font-size', '6');
        return $pdf->download('materialien.pdf');

    }

}
