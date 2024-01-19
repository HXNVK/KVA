<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Auth;

use App\Models\PropellerModellWurzel;
use App\Models\PropellerStepCodeWurzelBlock;

class PropellerStepCodeWurzelBloeckeController extends Controller
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
        $psc_wurzelBloecke = PropellerStepCodeWurzelBlock::sortable()
            ->orderBy('name','asc')
            ->paginate(15);

        return view('propellerStepCodeWurzelBloecke.index',
                compact(
                    'psc_wurzelBloecke'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $propellerModellWurzeln = PropellerModellWurzel::orderBy('name','asc')->get();


        //dd($propellerProfile);

        //dd($propellerModellBlaetter);
        return view('propellerStepCodeWurzelBloecke.create', 
                compact(
                    'propellerModellWurzeln'
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
            'propeller_modell_wurzel_id' => 'required|unique:propeller_step_code_wurzelBloecke',
            'bTRW' => 'numeric',
            'bBW' => 'numeric',
            'BlockWx' => 'numeric',
            'BlockWy' => 'numeric',
            'BlockWz' => 'numeric',
            'BlockWx0' => 'numeric',
            'BlockWy0' => 'numeric',
            'BlockWz0' => 'numeric',
            'KonusWx' => 'numeric',
            'KonusWx' => 'numeric',
            'KonusWy' => 'numeric',
            'KonusWz' => 'numeric'
        ]);

        for($x=0;$x<5;$x++){
            $i = $x + 1; 
            $inputWurzel_Block[0][$x] = $request->input("zKWW$i"); 
        }
        
       
        $inputWurzel_Block[1][0] = $request->input("bTRW");
        $inputWurzel_Block[2][0] = $request->input("bBW");
        $inputWurzel_Block[3][0] = $request->input("BlockWx");
        $inputWurzel_Block[3][1] = $request->input("BlockWy");
        $inputWurzel_Block[3][2] = $request->input("BlockWz");
        $inputWurzel_Block[4][0] = $request->input("BlockWx0"); 
        $inputWurzel_Block[4][1] = $request->input("BlockWy0");
        $inputWurzel_Block[4][2] = $request->input("BlockWz0");
        $inputWurzel_Block[5][0] = $request->input("KonusWx");
        $inputWurzel_Block[5][1] = $request->input("KonusWy");
        $inputWurzel_Block[5][2] = $request->input("KonusWz");
    
        for($x=0;$x<count($inputWurzel_Block);$x++){
            $inputWurzel_Block[$x]  = array_filter($inputWurzel_Block[$x], function($val) {
                return ($val!==null && $val!==false && $val!=='');
            });
        }

        $propeller_modell_wurzel_id = $request->input('propeller_modell_wurzel_id');
        $propellerModellWurzel = PropellerModellWurzel::find($propeller_modell_wurzel_id);
        

        $psc_wurzelBlock = NEW PropellerStepCodeWurzelBlock;
        $psc_wurzelBlock->name = $propellerModellWurzel->name;
        $psc_wurzelBlock->beschreibung = $request->input('beschreibung');
        $psc_wurzelBlock->propeller_modell_wurzel_id = $propeller_modell_wurzel_id;
        $psc_wurzelBlock->inputWurzelBlock = json_encode($inputWurzel_Block);
        $psc_wurzelBlock->user_id = auth()->user()->id;

        //dd($propellerStepCodeBlatt);
        $psc_wurzelBlock->save();

        return redirect("/propellerStepCodeWurzelBloecke")->with('success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $propellerModellWurzeln = PropellerModellWurzel::orderBy('name','asc')->get();
        $psc_wurzelBlock = PropellerStepCodeWurzelBlock::find($id);

        $inputWurzelBlock = json_decode($psc_wurzelBlock->inputWurzelBlock);


        //dd($inputBlatt[14][0]);

        return view('propellerStepCodeWurzelBloecke.show', 
                compact(
                        'psc_wurzelBlock',
                        'propellerModellWurzeln',
                        'inputWurzelBlock'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $psc_wurzelBlock = PropellerStepCodeWurzelBlock::find($id);

        $inputWurzelBlock = json_decode($psc_wurzelBlock->inputWurzelBlock);


        //dd($inputBlatt[14][0]);

        return view('propellerStepCodeWurzelBloecke.edit', 
                compact(
                        'psc_wurzelBlock',
                        'inputWurzelBlock'));
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
    
        $this->validate($request,[

            'bTRW' => 'numeric',
            'bBW' => 'numeric',
            'BlockWx' => 'numeric',
            'BlockWy' => 'numeric',
            'BlockWz' => 'numeric',
            'BlockWx0' => 'numeric',
            'BlockWy0' => 'numeric',
            'BlockWz0' => 'numeric',
            'KonusWx' => 'numeric',
            'KonusWx' => 'numeric',
            'KonusWy' => 'numeric',
            'KonusWz' => 'numeric'
        ]);

        for($x=0;$x<5;$x++){
            $i = $x + 1; 
            $inputWurzel_Block[0][$x] = $request->input("zKWW$i"); 
        }
        
       
        $inputWurzel_Block[1][0] = $request->input("bTRW");
        $inputWurzel_Block[2][0] = $request->input("bBW");
        $inputWurzel_Block[3][0] = $request->input("BlockWx");
        $inputWurzel_Block[3][1] = $request->input("BlockWy");
        $inputWurzel_Block[3][2] = $request->input("BlockWz");
        $inputWurzel_Block[4][0] = $request->input("BlockWx0"); 
        $inputWurzel_Block[4][1] = $request->input("BlockWy0");
        $inputWurzel_Block[4][2] = $request->input("BlockWz0");
        $inputWurzel_Block[5][0] = $request->input("KonusWx");
        $inputWurzel_Block[5][1] = $request->input("KonusWy");
        $inputWurzel_Block[5][2] = $request->input("KonusWz");
    
        for($x=0;$x<count($inputWurzel_Block);$x++){
            $inputWurzel_Block[$x]  = array_filter($inputWurzel_Block[$x], function($val) {
                return ($val!==null && $val!==false && $val!=='');
            });
        }

        $propeller_modell_wurzel_id = $request->input('propeller_modell_wurzel_id');
        $propellerModellWurzel = PropellerModellWurzel::find($propeller_modell_wurzel_id);
        

        $psc_wurzelBlock = PropellerStepCodeWurzelBlock::find($id);

        $psc_wurzelBlock->beschreibung = $request->input('beschreibung');

        $psc_wurzelBlock->inputWurzelBlock = json_encode($inputWurzel_Block);
        $psc_wurzelBlock->user_id = auth()->user()->id;


        //dd($propellerStepCodeBlatt);
        $psc_wurzelBlock->save();

        return redirect("/propellerStepCodeWurzelBloecke")->with('success');


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
