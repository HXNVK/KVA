<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MaterialHersteller;
use Illuminate\Http\Request;
use Exception;

use PDF;

class MaterialHerstellerController extends Controller
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

            $materialHerstellerObjekte = MaterialHersteller::sortable()
            ->where('name','like',"%$suche%")
            ->orderBy('name', 'asc')
            ->paginate(15)
            ->appends('name', 'like', "%$suche%");
        }
        else{
            $materialHerstellerObjekte = MaterialHersteller::sortable()
            ->orderBy('name', 'asc')
            ->paginate(15);
        }

        //dd($materialHerstellerObjekte);
        return view('materialHersteller.index', compact('materialHerstellerObjekte'));
    }

    /**
     * Show the form for creating a new material hersteller.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        return view('materialHersteller.create');
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

        $materialHerstellerObjekte = new MaterialHersteller;
        $materialHerstellerObjekte->name = $request->input('name');
        $materialHerstellerObjekte->kommentar = $request->input('kommentar');
        $materialHerstellerObjekte->user_id = auth()->user()->id;

        $materialHerstellerObjekte->save();
        return redirect('/materialHersteller')->with('success', "neuer Hersteller $materialHerstellerObjekte->name gespeichert!");
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
        $materialHersteller = MaterialHersteller::findOrFail($id);
        

        return view('materialHersteller.edit', compact('materialHersteller'));
    }

    public function update($id, Request $request)
    {
        $data = $this->getData($request);

        $materialHerstellerObjekte = MaterialHersteller::findOrFail($id);
        $materialHerstellerObjekte->name = $request->input('name');
        $materialHerstellerObjekte->kommentar = $request->input('kommentar');
        $materialHerstellerObjekte->user_id = auth()->user()->id;

        $materialHerstellerObjekte->save();
        return redirect('/materialHersteller')->with('success', "neuer Hersteller $materialHerstellerObjekte->name gespeichert!");
    }

    public function show($id)
    {
        //
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
            $materialHersteller = MaterialHersteller::findOrFail($id);
            $materialHersteller->delete();

            return redirect('/materialHersteller')
                ->with('success', "Hersteller $materialHersteller->name gelöscht");
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
                'name' => 'required|string|min:0|max:50', 
                'kommentar' => 'nullable|string|min:0|max:100'
        ];
        
        $data = $request->validate($rules);

        return $data;
    }


    public function herstellerPDF()
    {
        $title = 'Hersteller';

        $materialHerstellerObjekte = MaterialHersteller::orderBy('name', 'asc')->paginate(25);

        $pdf = PDF::loadView('materialHersteller.pdf', [
                                    'materialHerstellerObjekte' => $materialHerstellerObjekte]);

        $pdf->setOption('margin-top', 15); //** default 10mm */
        $pdf->setOption('header-right', "$title");
        $pdf->setOption('footer-left', 'PDF-Erstelldatum: [date]');
        $pdf->setOption('footer-right', '[page]/[toPage]');
        $pdf->setOption('footer-center', "ausgedruckte Exemplare unterliegen nicht dem Aenderungsdienst");
        $pdf->setOption('footer-font-size', '6');
        return $pdf->download('hersteller.pdf');

    }

}
