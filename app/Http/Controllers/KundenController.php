<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Auth;
use Carbon\Carbon;

use App\Models\Kunde;
use App\Models\KundeTyp;
use App\Models\KundeGruppe;
use App\Models\KundeRating;
use App\Models\KundeStatus;
use App\Models\KundeAdresse;
use App\Models\KundeAdresseLand;
use App\Models\KundeAdresseTyp;
use App\Models\KundeAnrede;
use App\Models\KundeFinanzdatei;
use App\Models\KundeKontaktperson;
use App\Models\KundeKontaktpersonPosition;
use App\Models\KundeAufkleber;
use App\Models\Projekt;
use App\Models\ProjektPropeller;
use App\Models\Motor;
use App\Models\Fluggeraet;
use App\Models\Auftrag;
use App\Models\MyFactoryTransferKunde;


class KundenController extends Controller
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
    public function index(Request $request)
    {
        $userId = auth()->user()->id; 
        \Cart::clear();
        \Cart::session($userId)->clear();

        $request->session()->forget('customerID');

        if(request()->has('rating')){
            
            $rating = request('rating');

            $kunden = Kunde::sortable()
            ->where('kunde_rating_id','like',"%$rating%")
            ->orderBy('name1', 'asc')
            ->paginate(20)
            ->appends('name1', 'like', "%$rating%");
        }
        elseif(request()->has('suche')){
            $suche = request('suche');

            $kunden = Kunde::sortable()
            ->where('name1','like',"%$suche%")
            ->orWhere('name2', 'like', '%'. $suche .'%')
            ->orWhere('matchcode', 'like', '%'. $suche .'%')
            ->orWhere('id', 'like', '%'. $suche .'%')
            ->orderBy('name1', 'asc')
            ->paginate(20)
            ->appends('name1', 'like', "%$suche%");
        }
        elseif(request()->has('abcSuche')){
            $abcSuche = request('abcSuche');

            $kunden = Kunde::sortable()
            ->where('name1','like',"$abcSuche%")
            ->orWhere('name1', 'like', ''.$abcSuche .'%')
            ->orderBy('name1', 'asc')
            ->paginate(20)
            ->appends('name1', 'like', "%$abcSuche%");
        }
        elseif(request()->has('gruppe')){
            
            $gruppe = request('gruppe');

            $kunden = Kunde::sortable()
            ->where('kunde_gruppe_id','like',"%$gruppe%")
            ->orderBy('name1', 'asc')
            ->paginate(20)
            ->appends('name1', 'like', "%$gruppe%");
        }
        elseif(request()->has('myFactory')){
            
            $kunden = Kunde::sortable()
                ->orderBy('name1','asc')
                ->paginate(20);
        }
        else{
            $kunden = Kunde::sortable()
                ->orderBy('name1','asc')
                ->paginate(20);
        }

        //dd($kunden);

        return view('kunden.index',compact('kunden'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userId = auth()->user()->id; 
        \Cart::clear();
        \Cart::session($userId)->clear();

        $kundeTypen = KundeTyp::orderBy('name','asc')->get();
        $kundeGruppen = KundeGruppe::orderBy('name','asc')->get();
        $kundeRatingObjects = KundeRating::orderBy('value','asc')->get();
        $kundeStatusObjects = KundeStatus::orderBy('name','asc')->get();
        $kundeAufkleberObjects = KundeAufkleber::orderBy('name','asc')->get();


        return view('kunden.create',
                    compact(
                        'kundeTypen',
                        'kundeGruppen',
                        'kundeRatingObjects',
                        'kundeStatusObjects',
                        'kundeAufkleberObjects'
                    ))
                .view('kunden.modalKundeGruppe',
                compact('kundeGruppen'
                    ))
                .view('kunden.modalKundeRating',
                compact('kundeRatingObjects'
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
            'lexware_id' => 'numeric|min:10000|max:99999|unique:kunden',
            'matchcode' => 'bail|required|min:2|max:50|string|unique:kunden',
            'name1' => 'bail|required|min:3|max:60|string',
            'name2' => 'bail|max:60|string|nullable',
            'kunde_typ_id' => 'required',
            'kunde_gruppe_id' => 'required',
            'kunde_rating_id' => 'required',
            'kunde_status_id' => 'required',
            'kunde_aufkleber_id' => 'required',
            'checked' => 'required|in:0,1',
            'webseite' => 'string|max:50|nullable',
            'notiz' => 'string|max:1000|nullable'
        ]);

        //if Abfrage nur solange bis Datenbank nachpflegt ist, da sehr viele Kunden keine Zuordnungen haben. 
        if( $request->input('kunde_status_id') == 99 ||
            $request->input('kunde_rating_id') == 99 ||
            $request->input('kunde_gruppe_id') == 99 ||
            $request->input('kunde_typ_id') == 99
            ){
            return redirect('/kunden/create')->withInput()->withErrors(["Kundentyp, -gruppe, -rating, und -status auswählen !!!"]);
            //return redirect('/kunden/create')->withInput()->with('error',"Kundenstatus wählen !!!");
        }
        else{

            $kunde = new Kunde;
            $kunde->lexware_id = $request->input('lexwareID');
            $kunde->matchcode = $request->input('matchcode');
            $kunde->name1 = $request->input('name1');
            $kunde->name2 = $request->input('name2');
            $kunde->kunde_typ_id = $request->input('kunde_typ_id');
            $kunde->kunde_gruppe_id = $request->input('kunde_gruppe_id');
            $kunde->kunde_rating_id = $request->input('kunde_rating_id');
            $kunde->kunde_status_id = $request->input('kunde_status_id');
            $kunde->checked = $request->input('checked');
            $kunde->webseite = $request->input('webseite');
            $kunde->kunde_aufkleber_id = $request->input('kunde_aufkleber_id');
            $kunde->notiz = $request->input('notiz'); 
            $kunde->user_id = auth()->user()->id;   
            $kunde->save();

            //Abspeichern von Propellern in MyFactory Transfertabelle
            $kundeID = Kunde::where('matchcode', $request->input('matchcode'))->pluck('id');
            $kundeKVAId = $kundeID[0];

            $datumHeute = Carbon::now()->format('Y-m-d H:i:s');

            $myF_TransferKunde = new MyFactoryTransferKunde;
            $myF_TransferKunde->Origin = "helix";
            $myF_TransferKunde->RecordDate = $datumHeute;
            $myF_TransferKunde->CurrencyUnit = "EUR";
            $myF_TransferKunde->Name1 = $request->input('name1');
            $myF_TransferKunde->Matchcode = $request->input('matchcode');
            $myF_TransferKunde->CInaktiv = 0;
            $myF_TransferKunde->AInaktiv = 0;
            $myF_TransferKunde->Taxation = 1;
            $myF_TransferKunde->PriceType = 0;
            $myF_TransferKunde->Flag = 0;
            $myF_TransferKunde->IsPrivateAddress = 0;
            $myF_TransferKunde->Attr_Hel_KVACustID = $kundeKVAId;
            $myF_TransferKunde->save();


            //return redirect('/kunden')->with('success_msg', "neuer Kunde $kunde->name gespeichert!");
            return redirect('/kunden?myFactory=1')->with('success_msg', "neuer Kunde $kunde->name gespeichert!");
            //return redirect()->action('KundenController@myFactory')->with('success_msg', "neuer Kunde $kunde->name gespeichert!");
        }
    }

    public function myFactory()
    {
        return redirect()->away('https://showroom.ipt-solution.de/mf/ie50/Helix/KVA/Events.aspx?Type=Kunde&ID=321');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userId = auth()->user()->id; 
        \Cart::session($userId);

        session(['customerID' => $id]);

        $kunde = Kunde::findorFail($id);
        $kundeTypen = KundeTyp::orderBy('name','asc')->get();
        $kundeGruppen = KundeGruppe::orderBy('name','asc')->get();
        $kundeRatingObjects = KundeRating::orderBy('value','asc')->get();
        $kundeStatusObjects = KundeStatus::orderBy('name','asc')->get();
        $kundeAufkleberObjects = KundeAufkleber::orderBy('name','asc')->get();
        $kundeAdressen = KundeAdresse::where('kunde_id','like',"$id")->get();
        $kundeFinanzdaten = KundeFinanzdatei::where('kunde_id','like',"$id")->get();
        $kundeKontaktpersonen = KundeKontaktperson::where('kunde_id','like',"$id")->orderBy('kunde_kontaktperson_position_id','asc')->get();
        $projekte = Projekt::where('kunde_id','like',"$id")->orderBy('name','asc')->get();
        $motoren = Motor::where('kunde_id','like',"$id")->orderBy('name','asc')->get();
        $fluggeraete = Fluggeraet::where('kunde_id','like',"$id")->orderBy('name','asc')->get();
        $projektPropellerObj = ProjektPropeller::all();
        $auftraege = Auftrag::where('kundeID','like',"$id")->orderBy('id','desc')->get();

        //dd($auftraege);

        return view('kunden.show',
                    compact(
                        'kunde',
                        'kundeTypen',
                        'kundeGruppen',
                        'kundeRatingObjects',
                        'kundeStatusObjects',
                        'kundeAufkleberObjects',
                        'kundeAdressen',
                        'kundeFinanzdaten',
                        'kundeKontaktpersonen',
                        'projekte',
                        'motoren',
                        'fluggeraete',
                        'projektPropellerObj',
                        'auftraege'
                    ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userId = auth()->user()->id; 
        \Cart::session($userId);
        
        $kunde = Kunde::find($id);
        $kundeTypen = KundeTyp::orderBy('name','asc')->get();
        $kundeGruppen = KundeGruppe::orderBy('name','asc')->get();
        $kundeRatingObjects = KundeRating::orderBy('value','asc')->get();
        $kundeStatusObjects = KundeStatus::orderBy('name','asc')->get();
        $kundeAufkleberObjects = KundeAufkleber::orderBy('name','asc')->get();

        //dd($kundeAdressen);

        return view('kunden.edit',
                    compact(
                        'kunde',
                        'kundeTypen',
                        'kundeGruppen',
                        'kundeRatingObjects',
                        'kundeStatusObjects',
                        'kundeAufkleberObjects'
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
        //dd($request->input());
        
        $this->validate($request,[
            'lexware_id' => 'numeric|min:10000|max:99999',
            'matchcode' => 'bail|required|min:2|max:40|string',
            'name1' => 'bail|required|min:3|max:50|string',
            'name2' => 'bail|max:50|string|nullable',
            'kunde_typ_id' => 'required',
            'kunde_gruppe_id' => 'required',
            'kunde_rating_id' => 'required',
            'kunde_status_id' => 'required',
            'kunde_aufkleber_id' => 'required',
            'checked' => 'required|in:0,1',
            'webseite' => 'string|max:50|nullable',
            'notiz' => 'string|max:1000|nullable'
            ]);

        //if Abfrage nur solange bis Datenbank nachpflegt ist, da sehr viele Kunden keine Zuordnungen haben. 
        if( $request->input('kunde_status_id') == 0 ||
            $request->input('kunde_rating_id') == 0 ||
            $request->input('kunde_gruppe_id') == 0 ||
            $request->input('kunde_typ_id') == 0
            ){
            return redirect('/kunden/create')->withInput()->withErrors(["Kundenstatus, -rating, -gruppe und -typ auswählen !!!"]);
            //return redirect('/kunden/create')->withInput()->with('error',"Kundenstatus wählen !!!");
        }
        else{
            $kunde = Kunde::find($id);
            $kunde->lexware_id = $request->input('lexware_id');
            $kunde->matchcode = $request->input('matchcode');
            $kunde->name1 = $request->input('name1');
            $kunde->name2 = $request->input('name2');
            $kunde->kunde_typ_id = $request->input('kunde_typ_id');
            $kunde->kunde_gruppe_id = $request->input('kunde_gruppe_id');
            $kunde->kunde_rating_id = $request->input('kunde_rating_id');
            $kunde->kunde_status_id = $request->input('kunde_status_id');
            $kunde->checked = $request->input('checked');
            $kunde->webseite = $request->input('webseite');
            $kunde->kunde_aufkleber_id = $request->input('kunde_aufkleber_id');
            $kunde->notiz = $request->input('notiz'); 
            $kunde->user_id = auth()->user()->id;   
            
            $kunde->save();
            return redirect("/kunden/{$id}")->with('success_msg', "Kundendetails von $kunde->matchcode überarbeitet!");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kunde = Kunde::find($id);
        
//        //Check for correct user
//        if(auth()->user()->id !== $post->user_id){
//            return redirect('/posts')->with('error', 'Unauthorized Page');    
//        }

        $projekte = Projekt::where('kunde_id',$id)->get();
        //dd($projekte);
        
        foreach($projekte as $projekt){
            
            $projektPropellerObjects = ProjektPropeller::where('projekt_id',$projekt->id)->get();
            

            foreach($projektPropellerObjects as $projektPropeller){
                
                $projektPropeller->delete();
            }
            
            $projekt->delete();
        }
                

       
        
        $kunde->delete();
        return redirect("/kunden")->with('success_msg', "Kunde $kunde->name1 gelöscht");
    }
}
