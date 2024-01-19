<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\Motor;
use App\Models\MotorGetriebe;
use App\Models\MotorGetriebeArt;



class MotorGetriebeController extends Controller
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

            $getriebeObjects = MotorGetriebe::join('motoren','motor_getriebe.motor_id','=', 'motoren.id')
            ->join('motor_getriebe_arten','motor_getriebe.motor_getriebe_art_id','=', 'motor_getriebe_arten.id')
            ->join('users','motor_getriebe.user_id','=', 'users.id')
            ->where('motoren.name','like',"%$suche%")
            ->orWhere('motor_getriebe_arten.name','like',"%$suche%")
            ->orderBy('motoren.name', 'asc')
            ->paginate(20, array(
                'motor_getriebe.id',
                'motoren.name as motorname', 
                'motor_getriebe.name as motorGetriebename', 
                'motor_getriebe_arten.name as motorGetriebeArt', 
                'users.name as username', 
                'motor_getriebe.untersetzungszahl',
                'motor_getriebe.bemerkung_getriebe',
                'motor_getriebe.bemerkung_flansch'))
            ->appends('motoren.name', 'like', "%$suche%");

            //dd($getriebeObjects);
        }elseif(request()->has('abcSuche')){
            $suche = request('abcSuche');

            $getriebeObjects = MotorGetriebe::join('motoren','motor_getriebe.motor_id','=', 'motoren.id')
            ->join('motor_getriebe_arten','motor_getriebe.motor_getriebe_art_id','=', 'motor_getriebe_arten.id')
            ->join('users','motor_getriebe.user_id','=', 'users.id')
            ->where('motoren.name','like',"$suche%")
            ->orWhere('motor_getriebe_arten.name','like',"$suche%")
            ->orderBy('motoren.name', 'asc')
            ->paginate(20, array(
                'motor_getriebe.id',
                'motoren.name as motorname', 
                'motor_getriebe.name as motorGetriebename', 
                'motor_getriebe_arten.name as motorGetriebeArt', 
                'users.name as username',
                'motor_getriebe.untersetzungszahl',
                'motor_getriebe.bemerkung_getriebe',
                'motor_getriebe.bemerkung_flansch'))
            ->appends('motoren.name', 'like', "$suche%");

            //dd($getriebeObjects);
        }else{
            $getriebeObjects = MotorGetriebe::join('motor_getriebe_arten','motor_getriebe.motor_getriebe_art_id','=', 'motor_getriebe_arten.id')
            ->join('users','motor_getriebe.user_id','=', 'users.id')
            ->join('motoren','motor_getriebe.motor_id','=', 'motoren.id')
            ->orderBy('motor_getriebe.name', 'asc')
            ->paginate(20, array(
                'motor_getriebe.id',
                'motor_getriebe.name as motorGetriebename', 
                'motor_getriebe_arten.name as motorGetriebeArt',                
                'motor_getriebe.untersetzungszahl',
                'motor_getriebe.bemerkung_getriebe',
                'motor_getriebe.bemerkung_flansch',
                'motor_getriebe.created_at',
                'motor_getriebe.updated_at',
                'motoren.name as motorname', 
                'users.name as username'));

            //dd($getriebeObjects);
        }


        //dd($getriebeObjects);
        return view('motorGetriebe.index',compact(
                                'getriebeObjects'
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
        $getriebeArten = MotorGetriebeArt::orderBy('name','asc')->get();
        $motorGetriebeObj = MotorGetriebe::orderBy('name','asc')->pluck('name');

        //dd($motorGetriebeObj);
        return view('motorGetriebe.create',compact(
                                        'motoren',
                                        'getriebeArten',
                                        'motorGetriebeObj'
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
            'name_zusatz' => 'min:3|max:10|string|nullable',
            'motor_id' => 'required',
            'motor_getriebe_art_id' => 'required',
            'untersetzungszahl' => 'required|numeric|min:1|max:5',
            'bemerkung_flansch' => 'string|max:500|nullable',
            'bemerkung_getriebe' => 'string|max:500|nullable'
        ]);

        $getriebeObjects = MotorGetriebe::pluck('name');
        $motor = Motor::find($request->input("motor_id"));
            
        $name_zusatz = $request->input("name_zusatz");
        $untersetzungszahl = number_format($request->input("untersetzungszahl"),2);
        if(!empty($request->input("name_zusatz"))){
            $name = "$motor->name / $name_zusatz / $untersetzungszahl";    
        }else{
            $name = "$motor->name / $untersetzungszahl"; 
        }
        
        if($getriebeObjects->contains($name)){
            return redirect('/motorGetriebe/create')->withInput()->withErrors(["Getriebename bereits vorhanden !!!"]);        
        }
        //dd($request->input());

        if($name == $request->input("name")){
            return redirect('/motorGetriebe/create')->withInput()->withErrors(["Getriebename bereits vorhanden !!!"]);
        }
        else{
            $getriebe = new MotorGetriebe;
            $getriebe->name = $name;
            $getriebe->name_zusatz = $request->input("name_zusatz");
            $getriebe->motor_id = $request->input("motor_id");
            $getriebe->motor_getriebe_art_id = $request->input("motor_getriebe_art_id");
            $getriebe->untersetzungszahl = $request->input("untersetzungszahl");
            $getriebe->bemerkung_getriebe = $request->input("bemerkung_getriebe");
            $getriebe->bemerkung_flansch = $request->input("bemerkung_flansch");
            $getriebe->user_id = auth()->user()->id;
            $getriebe->save();
            
            return redirect("/motorFlansche/create")->with('success', "Getriebe $getriebe->name neu abgespeichert -> neuen Flansch anlegen!");
            //return back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $getriebe = MotorGetriebe::find($id);
        $motoren = Motor::orderBy('name','asc')->get();
        $getriebeArten = MotorGetriebeArt::orderBy('name','asc')->get();

        //dd($getriebe);
        return view('motorGetriebe.show',compact(
                	                    'getriebe',
                                        'motoren',
                                        'getriebeArten'
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
        $getriebe = MotorGetriebe::find($id);
        $motoren = Motor::orderBy('name','asc')->get();
        $getriebeArten = MotorGetriebeArt::orderBy('name','asc')->get();

        //dd($getriebe);
        return view('motorGetriebe.edit',compact(
                	                    'getriebe',
                                        'motoren',
                                        'getriebeArten'
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
            'name_zusatz' => 'min:3|max:10|string|nullable',
            'untersetzungszahl' => 'required|numeric|min:1|max:5',
            'bemerkung_flansch' => 'string|max:500|nullable',
            'bemerkung_getriebe' => 'string|max:500|nullable'
        ]);
        
        $motorname = $request->input("motorname");
        $name_zusatz = $request->input("name_zusatz");
        $untersetzungszahl = number_format($request->input("untersetzungszahl"),2);
        if(!empty($request->input("name_zusatz"))){
            $name = "$motorname / $name_zusatz / $untersetzungszahl";    
        }else{
            $name = "$motorname / $untersetzungszahl"; 
        }
        

        $getriebe = MotorGetriebe::find($id);
        $getriebe->name = $name;
        $getriebe->name_zusatz = $request->input("name_zusatz");
        $getriebe->motor_id = $request->input("motor_id");
        $getriebe->motor_getriebe_art_id = $request->input("getriebe_art_id");
        $getriebe->untersetzungszahl = $request->input("untersetzungszahl");
        $getriebe->bemerkung_getriebe = $request->input("bemerkung_getriebe");
        $getriebe->bemerkung_flansch = $request->input("bemerkung_flansch");
        $getriebe->user_id = auth()->user()->id;
        $getriebe->save();
        
        return redirect("/motorGetriebe")->with('success', "Getriebe [$getriebe->name] überarbeitet!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $getriebe = MotorGetriebe::find($id);
               
        $getriebe->delete();
        return back()->with('success', "Getriebe gelöscht");
    }
}
