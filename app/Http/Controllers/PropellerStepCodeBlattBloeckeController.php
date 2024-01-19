<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Auth;

use App\Models\PropellerModellBlatt;
use App\Models\PropellerStepCodeProfil;
use App\Models\PropellerStepCodeBlatt;
use App\Models\PropellerStepCodeBlattBlock;

class PropellerStepCodeBlattBloeckeController extends Controller
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
        $psc_blattBloecke = PropellerStepCodeBlattBlock::sortable()
            ->orderBy('name','asc')
            ->paginate(15);

        return view('propellerStepCodeBlattBloecke.index',
                compact(
                    'psc_blattBloecke'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $propellerModellBlaetter = PropellerModellBlatt::orderBy('name','asc')->get();


        //dd($propellerProfile);

        //dd($propellerModellBlaetter);
        return view('propellerStepCodeBlattBloecke.create', 
                compact(
                    'propellerModellBlaetter'
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
            'propeller_modell_blatt_id' => 'required|unique:propeller_step_code_blattBloecke',
            'bTR' => 'numeric',
            'bB' => 'numeric',
            'Blockx' => 'numeric',
            'Blocky' => 'numeric',
            'Blockz' => 'numeric',
            'Blockx0' => 'numeric',
            'Blocky0' => 'numeric',
            'Blockz0' => 'numeric',
            'Konusx' => 'numeric',
            'Konusx' => 'numeric',
            'Konusy' => 'numeric',
            'Konusz' => 'numeric'
        ]);

        for($x=0;$x<=14;$x++){
            $i = $x + 1; 
            $inputBlattBlock[0][$x] = $request->input("zKW$i");
        }
        $inputBlattBlock[1][0] = $request->input("bTR");
        $inputBlattBlock[2][0] = $request->input("bB");
        $inputBlattBlock[3][0] = $request->input("Blockx");
        $inputBlattBlock[3][1] = $request->input("Blocky");
        $inputBlattBlock[3][2] = $request->input("Blockz");
        $inputBlattBlock[4][0] = $request->input("Blockx0");
        $inputBlattBlock[4][1] = $request->input("Blocky0");
        $inputBlattBlock[4][2] = $request->input("Blockz0");
        $inputBlattBlock[5][0] = $request->input("Konusx");
        $inputBlattBlock[5][1] = $request->input("Konusy");
        $inputBlattBlock[5][2] = $request->input("Konusz");
        // $inputBlatt_Block[6][0] = $request->input("DFB");
        $inputBlatt_Block[7][0] = $request->input("include_tip_tangent");
        if ($inputBlatt_Block[7][0] == "ja"){
        } else {
            $inputBlatt_Block[7][0] ="nein";
        }
    
        for($x=0;$x<count($inputBlatt_Block);$x++){
            $inputBlatt_Block[$x]  = array_filter($inputBlatt_Block[$x], function($val) {
                return ($val!==null && $val!==false && $val!=='');
            });
        }

        $propeller_modell_blatt_id = $request->input('propeller_modell_blatt_id');
        $propellerModellBlatt = PropellerModellBlatt::find($propeller_modell_blatt_id);
        

        $psc_blattBlock = NEW PropellerStepCodeBlattBlock;
        $psc_blattBlock->name = $propellerModellBlatt->name;
        $psc_blattBlock->beschreibung = $request->input('beschreibung');
        $psc_blattBlock->propeller_modell_blatt_id = $propeller_modell_blatt_id;
        $psc_blattBlock->inputBlattBlock = json_encode($inputBlattBlock);
        $psc_blattBlock->user_id = auth()->user()->id;

        //dd($propellerStepCodeBlatt);
        $psc_blattBlock->save();

        return redirect("/propellerStepCodeBlattBloecke")->with('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $propellerModellBlaetter = PropellerModellBlatt::orderBy('name','asc')->get();
        $psc_blattBlock = PropellerStepCodeBlattBlock::find($id);

        $inputBlattBlock = json_decode($psc_blattBlock->inputBlattBlock);


        //dd($inputBlatt[14][0]);

        return view('propellerStepCodeBlattBloecke.show', 
                compact(
                        'psc_blattBlock',
                        'propellerModellBlaetter',
                        'inputBlattBlock'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $psc_blattBlock = PropellerStepCodeBlattBlock::find($id);

        $inputBlattBlock = json_decode($psc_blattBlock->inputBlattBlock);


        //dd($inputBlatt[14][0]);

        return view('propellerStepCodeBlattBloecke.edit', 
                compact(
                        'psc_blattBlock',
                        'inputBlattBlock'));
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
    
        //dd($request->input());

        // $this->validate($request,[
        //     'propeller_modell_blatt_id' => 'required'
        // ]);

        for($x=0;$x<=14;$x++){
            $i = $x + 1; 
            $inputBlattBlock[0][$x] = $request->input("zKW$i");
        }
        $inputBlattBlock[1][0] = $request->input("bTR");
        $inputBlattBlock[2][0] = $request->input("bB");
        $inputBlattBlock[3][0] = $request->input("Blockx");
        $inputBlattBlock[3][1] = $request->input("Blocky");
        $inputBlattBlock[3][2] = $request->input("Blockz");
        $inputBlattBlock[4][0] = $request->input("Blockx0");
        $inputBlattBlock[4][1] = $request->input("Blocky0");
        $inputBlattBlock[4][2] = $request->input("Blockz0");
        $inputBlattBlock[5][0] = $request->input("Konusx");
        $inputBlattBlock[5][1] = $request->input("Konusy");
        $inputBlattBlock[5][2] = $request->input("Konusz");

        $psc_blattBlock = PropellerStepCodeBlattBlock::find($id);
        $psc_blattBlock->beschreibung = $request->input('beschreibung');
        $psc_blattBlock->inputBlattBlock = json_encode($inputBlattBlock);
        $psc_blattBlock->user_id = auth()->user()->id;

        //dd($propellerStepCodeBlatt);
        $psc_blattBlock->save();

        return redirect("/propellerStepCodeBlattBloecke")->with('success');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
