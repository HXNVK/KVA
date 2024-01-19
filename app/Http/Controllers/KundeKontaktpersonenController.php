<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Auth;

use App\Models\KundeKontaktperson;
use App\Models\KundeKontaktpersonAnrede;
use App\Models\KundeKontaktpersonPosition;
use App\Models\Kunde;

class KundeKontaktpersonenController extends Controller
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
    
        $kunde = Kunde::find($kunde_id);
        $kundeKontaktpersonAnreden = KundeKontaktpersonAnrede::orderBy('name','asc')->get();
        $kundeKontaktpersonPositionen = KundeKontaktpersonPosition::orderBy('name','asc')->get();

        //dd($kundeAdressen);

        return view('kundeKontaktpersonen.create',
                    compact(
                        'kunde_id',
                        'kunde',
                        'kundeKontaktpersonAnreden',
                        'kundeKontaktpersonPositionen'
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
            'kunde_kontaktperson_anrede_id' => 'required',
            'vorname' => 'bail|required|min:3|max:30|string',
            'nachname' => 'bail|required|min:3|max:30|string',
            'kunde_kontaktperson_position_id' => 'required',
            'buero' => 'regex:/(0)[0-9]/|not_regex:/[a-z]/|min:5|nullable',
            'mobile' => 'regex:/(0)[0-9]/|not_regex:/[a-z]/|min:5|nullable',
            'email' => 'email|unique:kunde_kontaktpersonen|nullable',
            'notiz' => 'max:100|string|nullable'
            ]);

        $kundeKontaktperson = new KundeKontaktperson;
        $kundeKontaktperson->kunde_kontaktperson_anrede_id = $request->input("kunde_kontaktperson_anrede_id");
        $kundeKontaktperson->vorname = $request->input("vorname");
        $kundeKontaktperson->nachname = $request->input("nachname");
        $kundeKontaktperson->kunde_kontaktperson_position_id = $request->input("kunde_kontaktperson_position_id");
        $kundeKontaktperson->buero = $request->input("buero");
        $kundeKontaktperson->mobile = $request->input("mobile");
        $kundeKontaktperson->email = $request->input("email");
        $kundeKontaktperson->notiz = $request->input("notiz");
        $kundeKontaktperson->kunde_id = $request->input("id");
        $kundeKontaktperson->user_id = auth()->user()->id;

        $kundeKontaktperson->save();

        return redirect("/kunden/{$request->input("id")}")->with('success', "Kontakt $kundeKontaktperson->kunde_kontaktperson_anrede_id $kundeKontaktperson->nachname gespeichert!");
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
        $kundeKontaktperson = KundeKontaktperson::find($id);
    
        $kundeKontaktpersonAnreden = KundeKontaktpersonAnrede::orderBy('name','asc')->get();
        $kundeKontaktpersonPositionen = KundeKontaktpersonPosition::orderBy('name','asc')->get();

        //dd($kundeAdressen);

        return view('kundeKontaktpersonen.edit',
                    compact(
                        'kundeKontaktperson',
                        'kundeKontaktpersonAnreden',
                        'kundeKontaktpersonPositionen'
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
            'kunde_kontaktperson_anrede_id' => 'required',
            'vorname' => 'bail|required|min:3|max:30|string',
            'nachname' => 'bail|required|min:3|max:30|string',
            'kunde_kontaktperson_position_id' => 'required',
            'buero' => 'min:5|nullable',
            'mobile' => 'min:5|nullable',
            'email' => 'email|nullable',
            'notiz' => 'max:100|string|nullable'
            ]);

        $kundeKontaktperson = KundeKontaktperson::find($id);
        $kundeKontaktperson->kunde_kontaktperson_anrede_id = $request->input("kunde_kontaktperson_anrede_id");
        $kundeKontaktperson->vorname = $request->input("vorname");
        $kundeKontaktperson->nachname = $request->input("nachname");
        $kundeKontaktperson->kunde_kontaktperson_position_id = $request->input("kunde_kontaktperson_position_id");
        $kundeKontaktperson->buero = $request->input("buero");
        $kundeKontaktperson->mobile = $request->input("mobile");
        $kundeKontaktperson->email = $request->input("email");
        $kundeKontaktperson->notiz = $request->input("notiz");
        $kundeKontaktperson->kunde_id = $request->input("id");
        $kundeKontaktperson->user_id = auth()->user()->id;

        $kundeKontaktperson->save();

        return redirect("/kunden/{$request->input("id")}")->with('success', "Kontakt $kundeKontaktperson->nachname überarbeitet!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kundeKontaktperson = KundeKontaktperson::find($id);
               
        $kundeKontaktperson->delete();
        return back()->with('success', "Kontakt gelöscht");
    }
}
