<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Session;
use Auth;
use DB;
use PDF;
use DNS1D;
use DNS2D;


use App\Models\Kunde;
use App\Models\Projekt;
use App\Models\ProjektPropeller;
use App\Models\Auftrag;
use App\Models\AuftragTyp;
use App\Models\Artikel01Propeller;
use App\Models\Artikel03Ausfuehrung;
use App\Models\Artikel03Farbe;
use App\Models\Artikel03Kantenschutz;
use App\Models\Artikel05Distanzscheibe;
use App\Models\Artikel06ASGP;
use App\Models\Artikel06SPGP;
use App\Models\Artikel06SPKP;
use App\Models\Artikel07AP;
use App\Models\Artikel07Buchsen;
use App\Models\Artikel07Adapterscheiben;
use App\Models\Artikel08Zubehoer;
use App\Models\Propeller;
use App\Models\PropellerForm;
use App\Models\Material;
use App\Models\PropellerZuschnitt;
use App\Models\PropellerZuschnittLage;

class AuftraegeController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
