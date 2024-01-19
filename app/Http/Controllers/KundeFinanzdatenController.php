<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KundeFinanzdatei;
use App\Models\KundeFinanzdateiZahlungsart;
use App\Models\KundeFinanzdateiZahlungsziel;

class KundeFinanzdatenController extends Controller
{
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
        $kunde_id = request('kundenId');

        $kundeFinanzdateiZahlungsarten = KundeFinanzdateiZahlungsart::orderBy('name','asc')->get();
        $kundeFinanzdateiZahlungsziele = KundeFinanzdateiZahlungsziel::orderBy('name','asc')->get();

        //dd($kundeAdressen);

        return view('kundeFinanzdaten.create',
                    compact(
                        'kunde_id',
                        'kundeFinanzdateiZahlungsarten',
                        'kundeFinanzdateiZahlungsziele'
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
            'kunde_finanzdatei_zahlungsart_id' => 'required',
            'kunde_finanzdatei_zahlungsziel_id' => 'required',
            ]);

        $kundeFinanzdatei = new kundeFinanzdatei;
        $kundeFinanzdatei->kunde_finanzdatei_zahlungsart_id = $request->input("kunde_finanzdatei_zahlungsart_id");
        $kundeFinanzdatei->kunde_finanzdatei_zahlungsziel_id = $request->input("kunde_finanzdatei_zahlungsziel_id");
        $kundeFinanzdatei->steuernummer = $request->input("steuernummer");
        $kundeFinanzdatei->notiz = $request->input("notiz");
        $kundeFinanzdatei->kunde_id = $request->input("id");
        $kundeFinanzdatei->user_id = auth()->user()->id;

        $kundeFinanzdatei->save();
        
        //return response()->json(['error'=>$validator->errors()->all()]);
        return redirect("/kunden/{$request->input("id")}")->with('success', "Finanzdaten gespeichert!");
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
        $kundeFinanzdatei = KundeFinanzdatei::find($id);
        $kundeFinanzdateiZahlungsarten = KundeFinanzdateiZahlungsart::orderBy('name','asc')->get();
        $kundeFinanzdateiZahlungsziele = KundeFinanzdateiZahlungsziel::orderBy('name','asc')->get();

        //dd($kundeFinanzdatei);

        return view('kundeFinanzdaten.edit',
                    compact(
                        'kundeFinanzdatei',
                        'kundeFinanzdateiZahlungsarten',
                        'kundeFinanzdateiZahlungsziele'
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
        $this->validate($request,[
            'kunde_finanzdatei_zahlungsart_id' => 'required',
            'kunde_finanzdatei_zahlungsziel_id' => 'required',
            ]);

        $kundeFinanzdatei = KundeFinanzdatei::find($id);
        $kundeFinanzdatei->kunde_finanzdatei_zahlungsart_id = $request->input("kunde_finanzdatei_zahlungsart_id");
        $kundeFinanzdatei->kunde_finanzdatei_zahlungsziel_id = $request->input("kunde_finanzdatei_zahlungsziel_id");
        $kundeFinanzdatei->steuernummer = $request->input("steuernummer");
        $kundeFinanzdatei->notiz = $request->input("notiz");
        $kundeFinanzdatei->kunde_id = $request->input("id");
        $kundeFinanzdatei->user_id = auth()->user()->id;

        $kundeFinanzdatei->save();
        
        return redirect("/kunden/{$request->input("id")}")->with('success', "Finanzdaten geändert!");
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
