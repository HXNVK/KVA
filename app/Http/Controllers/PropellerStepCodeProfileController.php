<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Auth;

use App\Models\PropellerStepCodeProfil;


class PropellerStepCodeProfileController extends Controller
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
        $propellerStepCodeProfile = PropellerStepCodeProfil::orderBy('name', 'asc')->get();

        return view('propellerStepCodeProfile.index', compact('propellerStepCodeProfile'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('propellerStepCodeProfile.create');
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
            'name' => 'bail|required|min:4|max:500|string|unique:propeller_step_code_profile'

        ]);

        $propellerStepCodeProfil = NEW PropellerStepCodeProfil;
        $propellerStepCodeProfil->name = $request->input('name');
        $propellerStepCodeProfil->inputProfil = $request->input('profilpunkte');


        $propellerStepCodeProfil->user_id = auth()->user()->id;
        $propellerStepCodeProfil->save();

        return redirect("/propellerStepCodeProfil")->with('success');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $propellerStepCodeProfil = PropellerStepCodeProfil::find($id);

        return view('propellerStepCodeProfile.edit', compact('propellerStepCodeProfil'));
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
            'name' => 'bail|required|min:4|max:500|string',
            'beschreibung' => 'bail|max:100|string'

        ]);

        $propellerStepCodeProfil = PropellerStepCodeProfil::find($id);
        $propellerStepCodeProfil->name = $request->input('name');
        $propellerStepCodeProfil->beschreibung = $request->input('beschreibung');
        $propellerStepCodeProfil->inputProfil = $request->input('profilpunkte');


        $propellerStepCodeProfil->user_id = auth()->user()->id;
        $propellerStepCodeProfil->save();

        return redirect("/propellerStepCodeProfile")->with('success');
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
