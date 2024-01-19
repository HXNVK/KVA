<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use App\Models\PropellerForm;
use App\Models\PropellerModellBlatt;
use App\Models\PropellerModellBlattKompatibilitaet;
use App\Models\PropellerModellBlattTyp;
use App\Models\PropellerDrehrichtung;
use App\Models\PropellerFestigkeitsklasse;
use App\Models\PropellerVorderkantenTyp;
use App\Models\PropellerModellWurzel;
use App\Models\PropellerModellWurzelTyp;
use App\Models\UserNotiz;
use App\Models\Auftrag;
use App\Models\Artikel03Ausfuehrung;

use DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        
        $datumHeute = Carbon::now()->format('Y-m-d');
        $datumMorgen = Carbon::now()->addDay()->format('Y-m-d');
        $datumMinus7d = Carbon::now()->subDays(7)->format('Y-m-d');
        $datumPlus7d = Carbon::now()->addDays(7)->format('Y-m-d');

        //dd($datumMinus7d);

        $user_id = auth()->user()->id;
        $user = User::find($user_id);

        \Cart::clear();
        \Cart::session($user_id)->clear();
       
        $propellerModellBlaetter = PropellerModellBlatt::where('user_id',$user_id)->orderBy('updated_at', 'desc')->get();
        $propellerModellWurzeln = PropellerModellWurzel::where('user_id',$user_id)->orderBy('updated_at', 'desc')->get();
        $propellerFormen = PropellerForm::where('user_id',$user_id)->orderBy('updated_at', 'desc')->get();
        $notizen = UserNotiz::where('user_id',$user_id)
                            ->where('public', 0)
                            ->orderBy('created_at', 'desc')
                            ->get();

        $notizenAlleObj = UserNotiz::where('public', 1)
                                ->orderBy('created_at', 'desc')
                                ->get();

        $auftraege = Auftrag::orderBy('dringlichkeit','desc')
                        ->orderBy('ets','asc')
                        ->orderBy('id','asc')
                        ->get();

        foreach($auftraege as $auftrag){
            if($auftrag->ets == $datumPlus7d){
                $auftrag = Auftrag::find($auftrag->id);
                $auftrag->ets_alt = $auftrag->ets;

                $auftrag->ets = NULL;
                
                $auftrag->save();
            }
        }


        if(request()->has('suche')){
            $suche = request('suche');

            $auftraege = Auftrag::where('propeller','like',"%$suche%")
            ->orderBy('dringlichkeit','desc')
            ->orderBy('ets','asc')
            ->orderBy('id','asc')
            ->get();
        }else{
            $auftraege = Auftrag::orderBy('dringlichkeit','desc')
            ->orderBy('ets','asc')
            ->orderBy('id','asc')
            ->get();
        }

        $auftraegeAnzAnnahme = count(Auftrag::where('auftrag_status_id', '=', 1)->get());

        $auftraegeAnzFertigung = count(Auftrag::where('auftrag_status_id', '=', 2)
                                        ->orWhere('auftrag_status_id', '=', 9)
                                        ->orWhere('auftrag_status_id', '=', 17)
                                        ->get());

        $auftraegeAnzExtern = count(Auftrag::where('auftrag_status_id', '=', 3)->get());

        $auftraegeAnzLager = count(Auftrag::where('auftrag_status_id', '=', 10)
                                    ->orWhere('auftrag_status_id', '=', 15)
                                    ->orWhere('auftrag_status_id', '=', 16)
                                    ->get());
        
        $auftraegeAnzEndfertigung = count(Auftrag::where('auftrag_status_id', '=', 4)->get());
        $auftraegeAnzVersandbereit = count(Auftrag::where('auftrag_status_id', '=', 14)->get());

        $ausfuehrungen = Artikel03Ausfuehrung::where('inaktiv','=', 0)
                                    ->orderBy('name','asc')
                                    ->get();  


         return view('dashboard.index',compact(
                        'propellerModellBlaetter',
                        'propellerModellWurzeln',
                        'propellerFormen',
                        'user',
                        'notizen',
                        'notizenAlleObj',
                        'auftraege',
                        'datumHeute',
                        'auftraegeAnzAnnahme',
                        'auftraegeAnzFertigung',
                        'auftraegeAnzExtern',
                        'auftraegeAnzLager',
                        'auftraegeAnzEndfertigung',
                        'auftraegeAnzVersandbereit',
                        'ausfuehrungen'
                        
         ));
                    // .view('dashboard.button',
                    // compact('auftraege'
                    // ));
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {

        $this->validate($request,[
            'notiz' => 'string|max:500|nullable',
            'notizAlle' => 'string|max:500|nullable'
        ]);

        if($request->input("teamInfo") == NULL){
            $public = 0;
        }
        else{
            $public = 1;
        }

        $notiz = new UserNotiz;
        $notiz->text = $request->input("notiz");
        $notiz->public = $public;
        $notiz->user_id = auth()->user()->id;
        $notiz->save();


        return redirect('dashboard');
    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy($id)
    {
        $notiz = UserNotiz::find($id);
               
        $notiz->delete();
        return back()->with('success', "Notiz gelöscht");
    }


}
