<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Auth;

use App\Models\KundeAdresse;
use App\Models\KundeAdresseLand;
use App\Models\KundeAdresseTyp;



class KundeAdressenController extends Controller
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
        $kunde_id = request('kundenId');

        //$kunde = Kunde::pluck('id','matchcode')->where('id','like',"$kunde_id");
    
        $kundeAdresseTypen = KundeAdresseTyp::orderBy('name','asc')->get();
        $kundeAdresseLaender = KundeAdresseLand::orderBy('name','asc')->get();

        //dd($kundeAdressen);

        return view('kundeAdressen.create',
                    compact(
                        'kunde_id',
                        'kundeAdresseTypen',
                        'kundeAdresseLaender'
                    ));
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
        $kundeAdresse = KundeAdresse::find($id);
        $kundeAdresseTypen = KundeAdresseTyp::orderBy('name','asc')->get();
        $kundeAdresseLaender = KundeAdresseLand::orderBy('name','asc')->get();

        //dd($kundeAdressen);

        return view('kundeAdressen.edit',
                    compact(
                        'kundeAdresse',
                        'kundeAdresseTypen',
                        'kundeAdresseLaender'
                    ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name1' => 'nullable',
            'name2' => 'nullable',
            'kunde_adresse_typ_id' => 'required',
            'strasse' => 'bail|required|min:3|max:50|string',
            'postleitzahl' => 'bail|required|min:3|max:30|string',
            'stadt' => 'bail|required|min:3|max:30|string',
            'kunde_adresse_land_id' => 'required',
            'notiz' => 'nullable'
            ]);

        $kundeAdresse = new KundeAdresse;
        $kundeAdresse->kunde_adresse_typ_id = $request->input("kunde_adresse_typ_id");
        $kundeAdresse->name1 = $request->input("name1");
        $kundeAdresse->name2 = $request->input("name2");
        $kundeAdresse->strasse = $request->input("strasse");
        $kundeAdresse->postleitzahl = $request->input("postleitzahl");
        $kundeAdresse->stadt = $request->input("stadt");
        $kundeAdresse->kunde_adresse_land_id = $request->input("kunde_adresse_land_id");
        $kundeAdresse->notiz = $request->input("notiz");
        $kundeAdresse->kunde_id = $request->input("id");
        $kundeAdresse->user_id = auth()->user()->id;

        $kundeAdresse->save();
        
        //return response()->json(['error'=>$validator->errors()->all()]);
        return redirect("/kunden/{$request->input("id")}")->with('success', "Adresse gespeichert!");
    }

    public function update(Request $request, $id)
    {
        
        $this->validate($request,[
            'name1' => 'nullable',
            'name2' => 'nullable',
            'kunde_adresse_typ_id' => 'required',
            'strasse' => 'bail|required|min:3|max:30|string',
            'postleitzahl' => 'bail|required|min:3|max:30|string',
            'stadt' => 'bail|required|min:3|max:30|string',
            'kunde_adresse_land_id' => 'required'
            ]);

        //dd($request);

        $kundeAdresse = KundeAdresse::find($id);
        $kundeAdresse->kunde_adresse_typ_id = $request->input("kunde_adresse_typ_id");
        $kundeAdresse->name1 = $request->input("name1");
        $kundeAdresse->name2 = $request->input("name2");
        $kundeAdresse->strasse = $request->input("strasse");
        $kundeAdresse->postleitzahl = $request->input("postleitzahl");
        $kundeAdresse->stadt = $request->input("stadt");
        $kundeAdresse->kunde_adresse_land_id = $request->input("kunde_adresse_land_id");
        $kundeAdresse->kunde_id = $request->input("id");
        $kundeAdresse->user_id = auth()->user()->id;

        $kundeAdresse->save();
        return redirect("/kunden/{$request->input("id")}")->with('success', "Adressedaten überarbeitet!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kundeAdresse = KundeAdresse::find($id);
               
        $kundeAdresse->delete();
        return back()->with('success', "Adresse gelöscht");
    }
}
