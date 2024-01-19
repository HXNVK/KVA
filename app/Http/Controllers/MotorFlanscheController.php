<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;

use App\Models\Motor;
use App\Models\MotorFlansch;
use App\Models\Artikel07AP;

class MotorFlanscheController extends Controller
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

        if(request()->has('suche')){
            $suche = request('suche');

            $motorFlansche = MotorFlansch::join('users','motor_flansche.user_id','=', 'users.id')
                ->join('motoren','motor_flansche.motor_id','=', 'motoren.id')
                ->join('artikel_07_04AP', 'motor_flansche.artikel_07AP_id', '=', 'artikel_07_04AP.id')
                ->orderBy('motor_flansche.name_lang', 'asc')
                ->where('motor_flansche.name_lang','like',"%$suche%")
                ->paginate(20, array(
                    'motor_flansche.id',
                    'motor_flansche.name_lang as motorFlanschname',             
                    'motor_flansche.anzahl_schrauben',
                    'motor_flansche.schraubengroesse',
                    'motor_flansche.mitnehmerzapfen_durchmesser',
                    'motor_flansche.mitnehmerzapfen_hoehe',
                    'motor_flansche.teilkreis_durchmesser',
                    'motor_flansche.zentrier_durchmesser',
                    'motor_flansche.zentrier_hoehe',
                    'motor_flansche.bemerkung_flansch',
                    'motor_flansche.created_at',
                    'motor_flansche.updated_at',
                    'motoren.name as motorname', 
                    'artikel_07_04AP.name as andruckplatte', 
                    'users.name as username'));

        }elseif(request()->has('abcSuche')){
            $suche = request('abcSuche');
         
            $motorFlansche = MotorFlansch::join('users','motor_flansche.user_id','=', 'users.id')
                ->join('motoren','motor_flansche.motor_id','=', 'motoren.id')
                ->join('artikel_07_04AP', 'motor_flansche.artikel_07AP_id', '=', 'artikel_07_04AP.id')
                ->orderBy('motor_flansche.name_lang', 'asc')
                ->where('motoren.name','like',"$suche%")
                ->paginate(20, array(
                    'motor_flansche.id',
                    'motor_flansche.name_lang as motorFlanschname',             
                    'motor_flansche.anzahl_schrauben',
                    'motor_flansche.schraubengroesse',
                    'motor_flansche.mitnehmerzapfen_durchmesser',
                    'motor_flansche.mitnehmerzapfen_hoehe',
                    'motor_flansche.teilkreis_durchmesser',
                    'motor_flansche.zentrier_durchmesser',
                    'motor_flansche.zentrier_hoehe',
                    'motor_flansche.bemerkung_flansch',
                    'motor_flansche.created_at',
                    'motor_flansche.updated_at',
                    'motoren.name as motorname',
                    'artikel_07_04AP.name as andruckplatte',  
                    'users.name as username'));



        }else{
            $motorFlansche = MotorFlansch::join('users','motor_flansche.user_id','=', 'users.id')
                ->join('motoren','motor_flansche.motor_id','=', 'motoren.id')
                ->join('artikel_07_04AP', 'motor_flansche.artikel_07AP_id', '=', 'artikel_07_04AP.id')
                ->orderBy('motor_flansche.name_lang', 'asc')
                ->paginate(20, array(
                    'motor_flansche.id',
                    'motor_flansche.name_lang as motorFlanschname',             
                    'motor_flansche.anzahl_schrauben',
                    'motor_flansche.schraubengroesse',
                    'motor_flansche.mitnehmerzapfen_durchmesser',
                    'motor_flansche.mitnehmerzapfen_hoehe',
                    'motor_flansche.teilkreis_durchmesser',
                    'motor_flansche.zentrier_durchmesser',
                    'motor_flansche.zentrier_hoehe',
                    'motor_flansche.bemerkung_flansch',
                    'motor_flansche.created_at',
                    'motor_flansche.updated_at',
                    'motoren.name as motorname',
                    'artikel_07_04AP.name as andruckplatte', 
                    'users.name as username'));


        }

     

        //dd($motorFlansche);
        return view('motorFlansche.index',compact(
                                'motorFlansche'
                            ));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $motoren = Motor::orderBy('name','asc')->get();
        $andruckplatten = Artikel07AP::orderBy('name','asc')->get();
        $motorflansche = MotorFlansch::orderBy('name_lang','asc')->pluck('name_lang');

        return view('motorFlansche.create',compact(
                                            'motoren',
                                            'andruckplatten',
                                            'motorflansche'
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
        //dd($request->input());
        $this->validate($request,[
            'name_zusatz' => 'min:3|max:50|string|nullable',
            'anzahl_schrauben' => 'required',
            'schraubengroesse' => 'required',
            'mitnehmerzapfen_durchmesser' => 'numeric|max:16|nullable',
            'teilkreis_durchmesser' => 'required|numeric|max:200',
            'zentrier_durchmesser' => 'numeric|max:55|nullable',
            'zentrier_hoehe' => 'numeric|max:10|nullable',
            'andruckplatten_id' => 'required',
            'bemerkung_flansch' => 'string|max:500|nullable',
        ]);    
        
        $motorFlansche = MotorFlansch::pluck('name_lang');
        $motor = Motor::find($request->input("motor_id"));
        $anzahl_schrauben = $request->input("anzahl_schrauben");
        $schraubengroesse = $request->input("schraubengroesse");
        $mitnehmerzapfen_durchmesser = $request->input("mitnehmerzapfen_durchmesser");
        $teilkreis_durchmesser = number_format($request->input("teilkreis_durchmesser"),1);
        $zentrier_durchmesser = number_format($request->input("zentrier_durchmesser"),1);

        if(Str::endsWith("$mitnehmerzapfen_durchmesser",['0'])){
            $mitnehmerzapfen_durchmesser = number_format($request->input("mitnehmerzapfen_durchmesser"),0);
        }
        if(Str::endsWith("$teilkreis_durchmesser",['0'])){
            $teilkreis_durchmesser = number_format($request->input("teilkreis_durchmesser"),0);
        }
        if(Str::endsWith("$zentrier_durchmesser",['0'])){
            $zentrier_durchmesser = number_format($request->input("zentrier_durchmesser"),0);
        }
        
        if(!empty($request->input("zentrier_durchmesser"))){
            if(!empty($request->input("mitnehmerzapfen_durchmesser"))){
                $name = "".$anzahl_schrauben."x".$schraubengroesse."/".$mitnehmerzapfen_durchmesser."x".$teilkreis_durchmesser."/".$zentrier_durchmesser."mm";   
            }else{
                $name = "".$anzahl_schrauben."x".$schraubengroesse."x".$teilkreis_durchmesser."/".$zentrier_durchmesser."mm";
            }
        }else{
            if(!empty($request->input("mitnehmerzapfen_durchmesser"))){
                $name = "".$anzahl_schrauben."x".$schraubengroesse."/".$mitnehmerzapfen_durchmesser."x".$teilkreis_durchmesser."mm";   
            }else{
                $name = "".$anzahl_schrauben."x".$schraubengroesse."x".$teilkreis_durchmesser."mm";
            }
        }

        //$name_lang = "$name [".$motor->name."]";
        $name_lang = "$motor->name / $name";

        if($motorFlansche->contains($name_lang)){
            return redirect('/motorFlansche/create')->withInput()->withErrors(["Motorflansch bereits vorhanden !!!"]);        
        }

        $motorFlansch = new MotorFlansch;
        $motorFlansch->name = $name;
        $motorFlansch->name_lang = $name_lang;
        $motorFlansch->name_zusatz = $request->input("name_zusatz");
        $motorFlansch->motor_id = $request->input("motor_id");
        $motorFlansch->anzahl_schrauben = $request->input("anzahl_schrauben");
        $motorFlansch->schraubengroesse = $request->input("schraubengroesse");
        $motorFlansch->mitnehmerzapfen_durchmesser = $request->input("mitnehmerzapfen_durchmesser");
        $motorFlansch->teilkreis_durchmesser = $request->input("teilkreis_durchmesser");
        $motorFlansch->zentrier_durchmesser = $request->input("zentrier_durchmesser");
        $motorFlansch->zentrier_hoehe = $request->input("zentrier_hoehe");
        $motorFlansch->artikel_07AP_id = $request->input("andruckplatten_id");
        $motorFlansch->bemerkung_flansch = $request->input("bemerkung_flansch");
        $motorFlansch->user_id = auth()->user()->id;
        $motorFlansch->save();
        
        return redirect("/motorFlansche")->with('success', "Motorflansch $motorFlansch->name_lang neu gespeichert!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $motorFlansch = MotorFlansch::find($id);
        $motoren = Motor::orderBy('name','asc')->get();
        $andruckplatten = Artikel07AP::orderBy('name','asc')->get();

        return view('motorFlansche.show',compact(
                                            'motorFlansch',
                                            'motoren',
                                            'andruckplatten'
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
        $motorFlansch = MotorFlansch::find($id);
        $motoren = Motor::orderBy('name','asc')->get();
        $andruckplatten = Artikel07AP::orderBy('name','asc')->get();

        return view('motorFlansche.edit',compact(
                                            'motorFlansch',
                                            'motoren',
                                            'andruckplatten'
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
            'name_zusatz' => 'min:3|max:50|string|nullable',
            'anzahl_schrauben' => 'required',
            'schraubengroesse' => 'required',
            'mitnehmerzapfen_durchmesser' => 'numeric|max:16|nullable',
            'teilkreis_durchmesser' => 'required|numeric|max:200',
            'zentrier_durchmesser' => 'numeric|max:55|nullable',
            'zentrier_hoehe' => 'numeric|max:10|nullable',
            'andruckplatten_id' => 'required',
            'bemerkung_flansch' => 'string|max:500|nullable',
        ]);   
        
        
        $motorFlansche = MotorFlansch::pluck('name_lang');
        $motor = Motor::find($request->input("motor_id"));
        $anzahl_schrauben = $request->input("anzahl_schrauben");
        $schraubengroesse = $request->input("schraubengroesse");
        $mitnehmerzapfen_durchmesser = $request->input("mitnehmerzapfen_durchmesser");
        $teilkreis_durchmesser = number_format($request->input("teilkreis_durchmesser"),1);
        $zentrier_durchmesser = number_format($request->input("zentrier_durchmesser"),1);

        if(Str::endsWith("$mitnehmerzapfen_durchmesser",['0'])){
            $mitnehmerzapfen_durchmesser = number_format($request->input("mitnehmerzapfen_durchmesser"),0);
        }
        if(Str::endsWith("$teilkreis_durchmesser",['0'])){
            $teilkreis_durchmesser = number_format($request->input("teilkreis_durchmesser"),0);
        }
        if(Str::endsWith("$zentrier_durchmesser",['0'])){
            $zentrier_durchmesser = number_format($request->input("zentrier_durchmesser"),0);
        }
        

        if(!empty($request->input("zentrier_durchmesser"))){
            if(!empty($request->input("mitnehmerzapfen_durchmesser"))){
                $name = "".$anzahl_schrauben."x".$schraubengroesse."/".$mitnehmerzapfen_durchmesser."x".$teilkreis_durchmesser."/".$zentrier_durchmesser."mm";   
            }else{
                $name = "".$anzahl_schrauben."x".$schraubengroesse."x".$teilkreis_durchmesser."/".$zentrier_durchmesser."mm";
            }
        }else{
            if(!empty($request->input("mitnehmerzapfen_durchmesser"))){
                $name = "".$anzahl_schrauben."x".$schraubengroesse."/".$mitnehmerzapfen_durchmesser."x".$teilkreis_durchmesser."mm";   
            }else{
                $name = "".$anzahl_schrauben."x".$schraubengroesse."x".$teilkreis_durchmesser."mm";
            }
        }

        //$name_lang = "$name [".$motor->name."]";
        $name_lang = "$motor->name / $name";

        $motorFlansch = MotorFlansch::find($id);
        $motorFlansch->name = $name;
        $motorFlansch->name_lang = $name_lang;
        $motorFlansch->name_zusatz = $request->input("name_zusatz");
        $motorFlansch->motor_id = $request->input("motor_id");
        $motorFlansch->anzahl_schrauben = $request->input("anzahl_schrauben");
        $motorFlansch->schraubengroesse = $request->input("schraubengroesse");
        $motorFlansch->mitnehmerzapfen_durchmesser = $request->input("mitnehmerzapfen_durchmesser");
        $motorFlansch->teilkreis_durchmesser = $request->input("teilkreis_durchmesser");
        $motorFlansch->zentrier_durchmesser = $request->input("zentrier_durchmesser");
        $motorFlansch->zentrier_hoehe = $request->input("zentrier_hoehe");
        $motorFlansch->artikel_07AP_id = $request->input("andruckplatten_id");
        $motorFlansch->bemerkung_flansch = $request->input("bemerkung_flansch");
        $motorFlansch->user_id = auth()->user()->id;
        $motorFlansch->save();
        
        return redirect("/motorFlansche")->with('success', "Motorflansch $motorFlansch->name_lang überarbeitet!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $motorFlansch = MotorFlansch::find($id);
               
        $motorFlansch->delete();
        return back()->with('success', "Motorflansch $motorFlansch->name_lang gelöscht");
    }
}
