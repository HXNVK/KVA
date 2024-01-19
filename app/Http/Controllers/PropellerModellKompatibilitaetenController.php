<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PropellerModellKompatibilitaet;

use PDF;


class PropellerModellKompatibilitaetenController extends Controller
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
        $propellerModellKompatibilitaeten = PropellerModellKompatibilitaet::orderBy('name','asc')->paginate(20);
    
        //dd($modellKompatibilitaeten);
        return view('propellerModellKompatibilitaeten.index', compact('propellerModellKompatibilitaeten'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('propellerModellKompatibilitaeten.create');
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

        $propellerModellKompatibilitaeten = new PropellerModellKompatibilitaet;
        $propellerModellKompatibilitaeten->name = $request->input('name');
        $propellerModellKompatibilitaeten->typen = $request->input('typen');
        $propellerModellKompatibilitaeten->typen_alt = $request->input('typen_alt');
        $propellerModellKompatibilitaeten->rps = $request->input('rps');
        $propellerModellKompatibilitaeten->pli = $request->input('pli');
        $propellerModellKompatibilitaeten->ps = $request->input('ps');
        $propellerModellKompatibilitaeten->beta = $request->input('beta');
        $propellerModellKompatibilitaeten->pmi = $request->input('pmi');
        $propellerModellKompatibilitaeten->pzi = $request->input('pzi');
        $propellerModellKompatibilitaeten->block_ay = $request->input('block_ay');
        $propellerModellKompatibilitaeten->block_fy = $request->input('block_fy');
        $propellerModellKompatibilitaeten->rand = $request->input('rand');
        $propellerModellKompatibilitaeten->block_rand = $request->input('block_rand');
        $propellerModellKompatibilitaeten->kommentar = $request->input('kommentar');
        $propellerModellKompatibilitaeten->user_id = auth()->user()->id;

        $propellerModellKompatibilitaeten->save();
        return redirect('/propellerModellKompatibilitaeten')->with('success', "Kompatibilität $propellerModellKompatibilitaeten->name gespeichert!");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $propellerModellKompatibilitaet = PropellerModellKompatibilitaet::find($id);
        //dd($modellKompatibilitaeten);
        return view('propellerModellKompatibilitaeten.edit', compact('propellerModellKompatibilitaet'));
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

        $propellerModellKompatibilitaet = PropellerModellKompatibilitaet::find($id);
        $propellerModellKompatibilitaet->name = $request->input('name');
        $propellerModellKompatibilitaet->typen = $request->input('typen');
        $propellerModellKompatibilitaet->typen_alt = $request->input('typen_alt');
        $propellerModellKompatibilitaet->rps = $request->input('rps');
        $propellerModellKompatibilitaet->pli = $request->input('pli');
        $propellerModellKompatibilitaet->ps = $request->input('ps');
        $propellerModellKompatibilitaet->beta = $request->input('beta');
        $propellerModellKompatibilitaet->pmi = $request->input('pmi');
        $propellerModellKompatibilitaet->pzi = $request->input('pzi');
        $propellerModellKompatibilitaet->block_ay = $request->input('block_ay');
        $propellerModellKompatibilitaet->block_fy = $request->input('block_fy');
        $propellerModellKompatibilitaet->rand = $request->input('rand');
        $propellerModellKompatibilitaet->block_rand = $request->input('block_rand');
        $propellerModellKompatibilitaet->kommentar = $request->input('kommentar');
        $propellerModellKompatibilitaet->user_id = auth()->user()->id;

        $propellerModellKompatibilitaet->save();
        return redirect('/propellerModellKompatibilitaeten')->with('success', "Kompatibilität $propellerModellKompatibilitaet->name geändert!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $propellerModellKompatibilitaet = PropellerModellKompatibilitaet::find($id);
        
//        //Check for correct user
//        if(auth()->user()->id !== $post->user_id){
//            return redirect('/posts')->with('error', 'Unauthorized Page');    
//        }
        
        $propellerModellKompatibilitaet->delete();
        return redirect('/propellerModellKompatibilitaeten')->with('success', "Kompatibilitaet $propellerModellKompatibilitaet->name gelöscht");
    }


    protected function getData(Request $request)
    {
        $rules = [
            'name' => 'bail|required|min:1',
            'typen' => 'bail|required|min:1',
            'typen_alt' => 'nullable',
            'rps' => 'numeric',
            'pli' => 'numeric',
            'ps' => 'numeric',
            'beta' => 'numeric',
            'pmi' => 'numeric',
            'pzi' => 'numeric',
            'block_ay' => 'numeric',
            'block_fy' => 'numeric',
            'rand' => 'numeric',
            'block_rand' => 'numeric',
            'kommentar' => 'bail|max:100'
        ];
        
        $data = $request->validate($rules);

        return $data;
    }



    public function kompatibilitaetenPDF()
    {
        $title = 'Kompatibilitaeten';

        $propellerModellKompatibilitaeten = PropellerModellKompatibilitaet::orderBy('name','asc')->get();

        $pdf = PDF::loadView('propellerModellKompatibilitaeten.pdf', [
                                    'propellerModellKompatibilitaeten' => $propellerModellKompatibilitaeten
                                    ]);

        //$pdf->setOrientation('landscape');                            
        $pdf->setOption('margin-top', 15); //** default 10mm */
        $pdf->setOption('header-right', "$title");
        $pdf->setOption('footer-left', 'PDF-Erstelldatum: [date]');
        $pdf->setOption('footer-right', '[page]/[toPage]');
        $pdf->setOption('footer-center', "ausgedruckte Exemplare unterliegen nicht dem Aenderungsdienst");
        $pdf->setOption('footer-font-size', '6');
        return $pdf->download('kompatibilitaeten.pdf');

    }

}
