<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class PropellerStepCodeDateienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dateiPfad = public_path('storage');

        //dd($dateiPfad);
        //$dateienVorh = Storage::disk('public')->listContents();

        $stpDateien = Storage::disk('public')->allFiles();

        // $stpDateien = array_filter(Storage::disk('public')->allfiles(),
        //     //only stp's
        //     function ($item) {
        //         return strpos($item, '.stp');
        //     }
    	// );

        // $stpDateien=array();
    	// foreach ($files as $key => $value) {
    	// 	$value= str_replace("public/","",$value);
    	// 	array_push($stpDateien,$value);
    	// }

        //dd($stpDateien);
        

        return view('propellerStepCodeDateien.index', compact(
                                                        'stpDateien',
                                                        'dateiPfad'    
                                                    ));
    }

    function getFile($filename){
    	$file=Storage::disk('public')->get($filename);
 
		return Storage::disk('public')->download($filename);
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

    public function stpDownload(){

        //return Storage::disk('public')->download('H30F -GML-GMM-GMZ-.stp'); 
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
