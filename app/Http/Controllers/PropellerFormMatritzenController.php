<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\PropellerForm;
use App\Models\PropellerModellBlatt;
use App\Models\PropellerModellBlattTyp;
use App\Models\PropellerModellWurzel;
use App\Models\PropellerModellWurzelTyp;
use App\Models\PropellerModellKompatibilitaet;
use App\Models\PropellerKlasseGeometrie;
use App\Models\PropellerKlasseDesign;
use App\Models\PropellerDurchmesser;
use App\Models\PropellerDrehrichtung;
use App\Models\PropellerVorderkantenTyp;

use DB;
use PDF;

class PropellerFormMatritzenController extends Controller
{
        public function __construct()
        {
            $this->middleware('auth');
        }

        private function data($drehrichtung,$geometrieklasse,$kompatibilitaet,$link)
        {
                $propellerFormen = DB::table('propeller_formen')
                        ->select(
                                DB::raw('propeller_formen.name as propellerForm_name'),
                                DB::raw('propeller_formen.winkel as propellerForm_winkel'),
                                DB::raw('propeller_formen.konuswinkel as propellerForm_konuswinkel'),
                                
                                DB::raw('propeller_modell_blaetter.name as propellerModellBlatt_name'),
                                DB::raw('propeller_modell_blaetter.winkel as propellerModellBlatt_winkel'),
                                DB::raw('propeller_modell_blaetter.bereichslaenge as propellerModellBlatt_bereichslaenge'),
                                
                                DB::raw('propeller_modell_wurzeln.name as propellerModellWurzel_name'),
                                DB::raw('propeller_modell_wurzeln.winkel as propellerModellWurzel_winkel'),
                                DB::raw('propeller_modell_wurzeln.bereichslaenge as propellerModellWurzel_bereichslaenge'),

                                DB::raw('propeller_drehrichtungen.name as drehrichtung'),
                                DB::raw('propeller_vorderkanten_typen.id as vorderkantentypID'),
                                DB::raw('propeller_vorderkanten_typen.text as vorderkantentyp'),
                                DB::raw('propeller_modell_blatt_typen.name as propellerModellBlatt_typ'),
                                DB::raw('users.name as benutzer')
                                )

                        ->join('propeller_modell_blaetter','propeller_formen.propeller_modell_blatt_id','=', 'propeller_modell_blaetter.id')        
                        ->join('propeller_modell_wurzeln','propeller_formen.propeller_modell_wurzel_id','=', 'propeller_modell_wurzeln.id')
                        ->join('propeller_drehrichtungen', 'propeller_drehrichtungen.id', '=', 'propeller_modell_blaetter.propeller_drehrichtung_id')
                        ->join('propeller_vorderkanten_typen', 'propeller_vorderkanten_typen.id', '=', 'propeller_modell_blaetter.propeller_vorderkanten_typ_id')
                        ->join('propeller_modell_blatt_typen', 'propeller_modell_blatt_typen.id', '=', 'propeller_modell_blaetter.propeller_modell_blatt_typ_id')
                        ->join('users', 'users.id', '=', 'propeller_formen.user_id')

                        ->where('propeller_drehrichtungen.name' , 'like', "%$drehrichtung%")
                        ->where('propeller_formen.name', 'like', "%$geometrieklasse%")
                        ->where('propeller_formen.inaktiv','=',NULL)

                        ->get();


                        //dd($propellerFormen);

                $propellerModellBlaetter = DB::table('propeller_modell_blaetter')
                        ->select(
                                DB::raw('propeller_modell_blaetter.name as propellerModellBlatt_name'),
                                DB::raw('propeller_modell_blaetter.winkel as propellerModellBlatt_winkel'),
                                DB::raw('propeller_modell_blaetter.bereichslaenge as propellerModellBlatt_bereichslaenge'),
                                DB::raw('propeller_drehrichtungen.name as drehrichtung'),
                                DB::raw('propeller_modell_kompatibilitaeten.name as kompatibilitaet_name'),
                                DB::raw('propeller_modell_blatt_typen.text as propellerModellBlatt_typ'),
                                DB::raw('propeller_modell_blatt_typen.name_alt as propellerModellBlatt_typalt'),
                                DB::raw('propeller_vorderkanten_typen.text as propellerModellBlatt_vorderkantentyp'),
                                DB::raw('users.name as benutzer')
                        )
                        ->join('propeller_drehrichtungen','propeller_modell_blaetter.propeller_drehrichtung_id','=', 'propeller_drehrichtungen.id')
                        ->join('propeller_modell_blatt_typen','propeller_modell_blaetter.propeller_modell_blatt_typ_id','=', 'propeller_modell_blatt_typen.id')
                        ->join('propeller_modell_kompatibilitaeten','propeller_modell_blaetter.propeller_modell_kompatibilitaet_id','=', 'propeller_modell_kompatibilitaeten.id')
                        ->join('propeller_vorderkanten_typen','propeller_modell_blaetter.propeller_vorderkanten_typ_id','=', 'propeller_vorderkanten_typen.id')
                        ->join('users', 'users.id', '=', 'propeller_modell_blaetter.user_id')

                        ->orderBy('propellerModellBlatt_bereichslaenge', 'asc')
                        ->orderBy('propellerModellBlatt_typ', 'asc')
                        ->orderBy('propellerModellBlatt_vorderkantentyp', 'asc')
                        //->orderBy('kompatibilitaet_name', 'asc')

                        ->where('propeller_drehrichtungen.name' , 'like', "%$drehrichtung%")
                        ->where('propeller_modell_kompatibilitaeten.name', 'like', "%$kompatibilitaet%")
                        

                        ->get();
                        //dd($propellerModellBlaetter);

                $propellerModellWurzeln = DB::table('propeller_modell_wurzeln')
                        ->select(
                                DB::raw('propeller_modell_wurzeln.name as propellerModellWurzel_name'),
                                DB::raw('propeller_modell_wurzeln.winkel as propellerModellWurzel_winkel'),
                                DB::raw('propeller_modell_wurzeln.konuswinkel as propellerModellWurzel_konuswinkel'),
                                DB::raw('propeller_drehrichtungen.name as drehrichtung'),
                                DB::raw('propeller_klasse_geometrien.name as geometrieklasse'),
                                DB::raw('propeller_modell_kompatibilitaeten.name as kompatibilitaet_name'),
                                DB::raw('users.name as benutzer')
                        )
                        ->join('propeller_drehrichtungen','propeller_modell_wurzeln.propeller_drehrichtung_id','=', 'propeller_drehrichtungen.id')
                        ->join('propeller_klasse_geometrien','propeller_modell_wurzeln.propeller_klasse_geometrie_id','=', 'propeller_klasse_geometrien.id')
                        ->join('propeller_modell_kompatibilitaeten','propeller_modell_wurzeln.propeller_modell_kompatibilitaet_id','=', 'propeller_modell_kompatibilitaeten.id')
                        ->join('users', 'users.id', '=', 'propeller_modell_wurzeln.user_id')
                        
                        ->where('propeller_drehrichtungen.name' , 'like', "%$drehrichtung%")
                        ->where('propeller_modell_kompatibilitaeten.name', 'like', "%$kompatibilitaet%")
                        ->where('propeller_modell_wurzeln.name', 'like', "%$geometrieklasse%")

                        ->orderBy('propellerModellWurzel_name', 'asc')
                        ->get();

                        //dd($propellerModellWurzeln);
                
                return view($link)
                        ->with('propellerFormen', $propellerFormen)
                        ->with('propellerModellBlaetter', $propellerModellBlaetter)
                        ->with('propellerModellWurzeln', $propellerModellWurzeln); 

        }

        public function index()
        {
                return view('propellerFormMatritzen.index');         
        }

        public function indexGF25_0L()
        {
                $drehrichtung = "L";
                $geometrieklasse = "GF25-0";
                $kompatibilitaet = "K25";
                $link = 'propellerFormMatritzen/indexGruppen/gf25/indexGF25_0L';

                return $this->data($drehrichtung,$geometrieklasse,$kompatibilitaet,$link);

        }

        public function indexGF25_0R()
        {
                $drehrichtung = "R";
                $geometrieklasse = "GF25-0";
                $kompatibilitaet = "K25";
                $link = 'propellerFormMatritzen/indexGruppen/gf25/indexGF25_0R';

                return $this->data($drehrichtung,$geometrieklasse,$kompatibilitaet,$link);
        }

        public function indexGF26_0L()
        {
                $drehrichtung = "L";
                $geometrieklasse = "GF26-0";
                $kompatibilitaet = "K25";
                $link = 'propellerFormMatritzen/indexGruppen/gf26/indexGF26_0L';

                return $this->data($drehrichtung,$geometrieklasse,$kompatibilitaet,$link);

        }

        public function indexGF26_0R()
        {
                $drehrichtung = "R";
                $geometrieklasse = "GF26-0";
                $kompatibilitaet = "K25";
                $link = 'propellerFormMatritzen/indexGruppen/gf26/indexGF26_0R';

                return $this->data($drehrichtung,$geometrieklasse,$kompatibilitaet,$link);
        }

        public function indexGF30_0L()
        {
                $drehrichtung = "L";
                $geometrieklasse = "GF30-0";
                $kompatibilitaet = "K30";
                $link = 'propellerFormMatritzen/indexGruppen/gf30/indexGF30_0L';

                return $this->data($drehrichtung,$geometrieklasse,$kompatibilitaet,$link);
        }

        public function indexGF30_0R()
        {
                $drehrichtung = "R";
                $geometrieklasse = "GF30-0";
                $kompatibilitaet = "K30";
                $link = 'propellerFormMatritzen/indexGruppen/gf30/indexGF30_0R';

                return $this->data($drehrichtung,$geometrieklasse,$kompatibilitaet,$link);
        }

        public function indexGK30_0L()
        {
                $drehrichtung = "L";
                $geometrieklasse = "GK30-0";
                $kompatibilitaet = "K30";
                $link = 'propellerFormMatritzen/indexGruppen/gk30/indexGK30_0L';

                return $this->data($drehrichtung,$geometrieklasse,$kompatibilitaet,$link);
        }

        public function indexGK30_0R()
        {
                $drehrichtung = "R";
                $geometrieklasse = "GK30-0";
                $kompatibilitaet = "K30";
                $link = 'propellerFormMatritzen/indexGruppen/gk30/indexGK30_0R';

                return $this->data($drehrichtung,$geometrieklasse,$kompatibilitaet,$link);
        }

        public function indexGF31_0L()
        {
                $drehrichtung = "L";
                $geometrieklasse = "GF31-0";
                $kompatibilitaet = "K30";
                $link = 'propellerFormMatritzen/indexGruppen/gf31/indexGF31_0L';

                return $this->data($drehrichtung,$geometrieklasse,$kompatibilitaet,$link);
        }

        public function indexGF31_0R()
        {
                $drehrichtung = "R";
                $geometrieklasse = "GF31-0";
                $kompatibilitaet = "K30";
                $link = 'propellerFormMatritzen/indexGruppen/gf31/indexGF31_0R';

                return $this->data($drehrichtung,$geometrieklasse,$kompatibilitaet,$link);
        }

        public function indexGF40_0L()
        {
                $drehrichtung = "L";
                $geometrieklasse = "GF40-0";
                $kompatibilitaet = "K30";
                $link = 'propellerFormMatritzen/indexGruppen/gf40/indexGF40_0L';

                return $this->data($drehrichtung,$geometrieklasse,$kompatibilitaet,$link);
        }

        public function indexGF40_0R()
        {
                $drehrichtung = "R";
                $geometrieklasse = "GF40-0";
                $kompatibilitaet = "K30";
                $link = 'propellerFormMatritzen/indexGruppen/gf40/indexGF40_0R';

                return $this->data($drehrichtung,$geometrieklasse,$kompatibilitaet,$link);
        }

        public function indexGF45_0L()
        {
                $drehrichtung = "L";
                $geometrieklasse = "GF45-0";
                $kompatibilitaet = "K45";
                $link = 'propellerFormMatritzen/indexGruppen/gf45/indexGF45_0L';

                return $this->data($drehrichtung,$geometrieklasse,$kompatibilitaet,$link);
        }

        public function indexGF45_0R()
        {
                $drehrichtung = "R";
                $geometrieklasse = "GF45-0";
                $kompatibilitaet = "K45";
                $link = 'propellerFormMatritzen/indexGruppen/gf45/indexGF45_0R';

                return $this->data($drehrichtung,$geometrieklasse,$kompatibilitaet,$link);
        }

        public function indexGF50_0L()
        {
                $drehrichtung = "L";
                $geometrieklasse = "GF50-0";
                $kompatibilitaet = "K50";
                $link = 'propellerFormMatritzen/indexGruppen/gf50/indexGF50_0L';

                return $this->data($drehrichtung,$geometrieklasse,$kompatibilitaet,$link);
        }

        public function indexGF50_0R()
        {
                $drehrichtung = "R";
                $geometrieklasse = "GF50-0";
                $kompatibilitaet = "K50";
                $link = 'propellerFormMatritzen/indexGruppen/gf50/indexGF50_0R';

                return $this->data($drehrichtung,$geometrieklasse,$kompatibilitaet,$link);
        }




        //** Ab hier: Funktionen für die Einzelnen PDF´s */
        private function PDFdata($drehrichtung,$geometrieklasse,$kompatibilitaet,$link,$title)
        {
                $propellerFormen = DB::table('propeller_formen')
                ->select(
                        DB::raw('propeller_formen.name as propellerForm_name'),
                        DB::raw('propeller_formen.winkel as propellerForm_winkel'),
                        DB::raw('propeller_formen.konuswinkel as propellerForm_konuswinkel'),
                        
                        DB::raw('propeller_modell_blaetter.name as propellerModellBlatt_name'),
                        DB::raw('propeller_modell_blaetter.winkel as propellerModellBlatt_winkel'),
                        DB::raw('propeller_modell_blaetter.bereichslaenge as propellerModellBlatt_bereichslaenge'),
                        
                        DB::raw('propeller_modell_wurzeln.name as propellerModellWurzel_name'),
                        DB::raw('propeller_modell_wurzeln.winkel as propellerModellWurzel_winkel'),
                        DB::raw('propeller_modell_wurzeln.bereichslaenge as propellerModellWurzel_bereichslaenge'),

                        DB::raw('propeller_drehrichtungen.name as drehrichtung'),
                        DB::raw('propeller_vorderkanten_typen.id as vorderkantentypID'),
                        DB::raw('propeller_vorderkanten_typen.text as vorderkantentyp'),
                        DB::raw('propeller_modell_blatt_typen.name as propellerModellBlatt_typ'),
                        DB::raw('users.name as benutzer')
                        )

                ->join('propeller_modell_blaetter','propeller_formen.propeller_modell_blatt_id','=', 'propeller_modell_blaetter.id')        
                ->join('propeller_modell_wurzeln','propeller_formen.propeller_modell_wurzel_id','=', 'propeller_modell_wurzeln.id')
                ->join('propeller_drehrichtungen', 'propeller_drehrichtungen.id', '=', 'propeller_modell_blaetter.propeller_drehrichtung_id')
                ->join('propeller_vorderkanten_typen', 'propeller_vorderkanten_typen.id', '=', 'propeller_modell_blaetter.propeller_vorderkanten_typ_id')
                ->join('propeller_modell_blatt_typen', 'propeller_modell_blatt_typen.id', '=', 'propeller_modell_blaetter.propeller_modell_blatt_typ_id')
                ->join('users', 'users.id', '=', 'propeller_formen.user_id')

                ->where('propeller_drehrichtungen.name' , 'like', "%$drehrichtung%")
                ->where('propeller_formen.name', 'like', "%$geometrieklasse%")
                ->where('propeller_formen.inaktiv','=',NULL)

                ->get();


                //dd($propellerFormen);

                $propellerModellBlaetter = DB::table('propeller_modell_blaetter')
                        ->select(
                                DB::raw('propeller_modell_blaetter.name as propellerModellBlatt_name'),
                                DB::raw('propeller_modell_blaetter.winkel as propellerModellBlatt_winkel'),
                                DB::raw('propeller_modell_blaetter.bereichslaenge as propellerModellBlatt_bereichslaenge'),
                                DB::raw('propeller_drehrichtungen.name as drehrichtung'),
                                DB::raw('propeller_modell_kompatibilitaeten.name as kompatibilitaet_name'),
                                DB::raw('propeller_modell_blatt_typen.text as propellerModellBlatt_typ'),
                                DB::raw('propeller_modell_blatt_typen.name_alt as propellerModellBlatt_typalt'),
                                DB::raw('propeller_vorderkanten_typen.text as propellerModellBlatt_vorderkantentyp'),
                                DB::raw('users.name as benutzer')
                        )
                        ->join('propeller_drehrichtungen','propeller_modell_blaetter.propeller_drehrichtung_id','=', 'propeller_drehrichtungen.id')
                        ->join('propeller_modell_blatt_typen','propeller_modell_blaetter.propeller_modell_blatt_typ_id','=', 'propeller_modell_blatt_typen.id')
                        ->join('propeller_modell_kompatibilitaeten','propeller_modell_blaetter.propeller_modell_kompatibilitaet_id','=', 'propeller_modell_kompatibilitaeten.id')
                        ->join('propeller_vorderkanten_typen','propeller_modell_blaetter.propeller_vorderkanten_typ_id','=', 'propeller_vorderkanten_typen.id')
                        ->join('users', 'users.id', '=', 'propeller_modell_blaetter.user_id')

                        ->orderBy('propellerModellBlatt_bereichslaenge', 'asc')
                        ->orderBy('propellerModellBlatt_typ', 'asc')
                        ->orderBy('propellerModellBlatt_vorderkantentyp', 'asc')
                        //->orderBy('kompatibilitaet_name', 'asc')

                        ->where('propeller_drehrichtungen.name' , 'like', "%$drehrichtung%")
                        ->where('propeller_modell_kompatibilitaeten.name', 'like', "%$kompatibilitaet%")

                        ->get();
                //dd($propellerModellBlaetter);

                $propellerModellWurzeln = DB::table('propeller_modell_wurzeln')
                ->select(
                        DB::raw('propeller_modell_wurzeln.name as propellerModellWurzel_name'),
                        DB::raw('propeller_modell_wurzeln.winkel as propellerModellWurzel_winkel'),
                        DB::raw('propeller_drehrichtungen.name as drehrichtung'),
                        DB::raw('propeller_klasse_geometrien.name as geometrieklasse'),
                        DB::raw('propeller_modell_kompatibilitaeten.name as kompatibilitaet_name'),
                        DB::raw('users.name as benutzer')
                )
                ->join('propeller_drehrichtungen','propeller_modell_wurzeln.propeller_drehrichtung_id','=', 'propeller_drehrichtungen.id')
                ->join('propeller_klasse_geometrien','propeller_modell_wurzeln.propeller_klasse_geometrie_id','=', 'propeller_klasse_geometrien.id')
                ->join('propeller_modell_kompatibilitaeten','propeller_modell_wurzeln.propeller_modell_kompatibilitaet_id','=', 'propeller_modell_kompatibilitaeten.id')
                ->join('users', 'users.id', '=', 'propeller_modell_wurzeln.user_id')
                
                ->where('propeller_drehrichtungen.name' , 'like', "%$drehrichtung%")
                ->where('propeller_modell_kompatibilitaeten.name', 'like', "%$kompatibilitaet%")

                ->orderBy('propellerModellWurzel_name', 'asc')
                ->get();

                //dd($propellerModellWurzeln);
                $pdf = PDF::loadView($link, [
                        'propellerFormen' => $propellerFormen, 
                        'propellerModellBlaetter' => $propellerModellBlaetter,
                        'propellerModellWurzeln' => $propellerModellWurzeln
                        ]);

                $pdf->setPaper('a3');                            
                $pdf->setOption('margin-top', 15); //** default 10mm */
                //$pdf->setOption('header-right', "$title");
                $pdf->setOption('footer-left', 'PDF-Erstelldatum: [date]');
                $pdf->setOption('footer-right', '[page]/[toPage]');
                $pdf->setOption('footer-center', "ausgedruckte Exemplare unterliegen nicht dem Aenderungsdienst");
                $pdf->setOption('footer-font-size', '6');
                return $pdf->download("$title.pdf");

        }

        public function formenMatrixPDF_GF25_0_L()
        {
                $drehrichtung = "L";
                $geometrieklasse = "GF25";
                $kompatibilitaet = "K25";
                $link = '/propellerFormMatritzen/indexGruppen/gf25.pdf_gf25_0_links';
                $title = 'FormenMatrix GF25-0 L';

                return $this->PDFdata($drehrichtung,$geometrieklasse,$kompatibilitaet,$link,$title);
        }

        public function formenMatrixPDF_GF25_0_R()
        {
                $drehrichtung = "R";
                $geometrieklasse = "GF25";
                $kompatibilitaet = "K25";
                $link = '/propellerFormMatritzen/indexGruppen/gf25.pdf_gf25_0_rechts';
                $title = 'FormenMatrix GF25-0 R';

                return $this->PDFdata($drehrichtung,$geometrieklasse,$kompatibilitaet,$link,$title);
        }

        public function formenMatrixPDF_GF26_0_L()
        {
                $drehrichtung = "L";
                $geometrieklasse = "GF26";
                $kompatibilitaet = "K25";
                $link = '/propellerFormMatritzen/indexGruppen/gf26.pdf_gf26_0_links';
                $title = 'FormenMatrix GF26-0 L';

                return $this->PDFdata($drehrichtung,$geometrieklasse,$kompatibilitaet,$link,$title);
        }

        public function formenMatrixPDF_GF26_0_R()
        {
                $drehrichtung = "R";
                $geometrieklasse = "GF26";
                $kompatibilitaet = "K25";
                $link = '/propellerFormMatritzen/indexGruppen/gf26.pdf_gf26_0_rechts';
                $title = 'FormenMatrix GF26-0 R';

                return $this->PDFdata($drehrichtung,$geometrieklasse,$kompatibilitaet,$link,$title);
        }

        public function formenMatrixPDF_GF30_0_L()
        {
                $drehrichtung = "L";
                $geometrieklasse = "GF30-0";
                $kompatibilitaet = "K30";
                $link = '/propellerFormMatritzen/indexGruppen/gf30.pdf_gf30_0_links';
                $title = 'FormenMatrix GF30-0 L';

                return $this->PDFdata($drehrichtung,$geometrieklasse,$kompatibilitaet,$link,$title);
        }

        public function formenMatrixPDF_GF30_0_R()
        {
                $drehrichtung = "R";
                $geometrieklasse = "GF30-0";
                $kompatibilitaet = "K30";
                $link = '/propellerFormMatritzen/indexGruppen/gf30.pdf_gf30_0_rechts';
                $title = 'FormenMatrix GF30-0 R';

                return $this->PDFdata($drehrichtung,$geometrieklasse,$kompatibilitaet,$link,$title);
        }

        public function formenMatrixPDF_GK30_0_L()
        {
                $drehrichtung = "L";
                $geometrieklasse = "GK30-0";
                $kompatibilitaet = "K30";
                $link = '/propellerFormMatritzen/indexGruppen/gk30.pdf_gk30_0_links';
                $title = 'FormenMatrix GK30-0 L';

                return $this->PDFdata($drehrichtung,$geometrieklasse,$kompatibilitaet,$link,$title);
        }

        public function formenMatrixPDF_GK30_0_R()
        {
                $drehrichtung = "R";
                $geometrieklasse = "GK30-0";
                $kompatibilitaet = "K30";
                $link = '/propellerFormMatritzen/indexGruppen/gk30.pdf_gk30_0_rechts';
                $title = 'FormenMatrix GK30-0 R';

                return $this->PDFdata($drehrichtung,$geometrieklasse,$kompatibilitaet,$link,$title);
        }

        public function formenMatrixPDF_GF31_0_L()
        {
                $drehrichtung = "L";
                $geometrieklasse = "GF31-0";
                $kompatibilitaet = "K30";
                $link = '/propellerFormMatritzen/indexGruppen/gf31.pdf_gf31_0_links';
                $title = 'FormenMatrix GF31-0 L';

                return $this->PDFdata($drehrichtung,$geometrieklasse,$kompatibilitaet,$link,$title);
        }

        public function formenMatrixPDF_GF31_0_R()
        {
                $drehrichtung = "R";
                $geometrieklasse = "GF31-0";
                $kompatibilitaet = "K30";
                $link = '/propellerFormMatritzen/indexGruppen/gf31.pdf_gf31_0_rechts';
                $title = 'FormenMatrix GF31-0 R';

                return $this->PDFdata($drehrichtung,$geometrieklasse,$kompatibilitaet,$link,$title);
        }

        public function formenMatrixPDF_GF40_0_L()
        {
                $drehrichtung = "L";
                $geometrieklasse = "GF40-0";
                $kompatibilitaet = "K30";
                $link = '/propellerFormMatritzen/indexGruppen/gf40.pdf_gf40_0_links';
                $title = 'FormenMatrix GF40-0 L';

                return $this->PDFdata($drehrichtung,$geometrieklasse,$kompatibilitaet,$link,$title);
        }

        public function formenMatrixPDF_GF40_0_R()
        {
                $drehrichtung = "R";
                $geometrieklasse = "GF40-0";
                $kompatibilitaet = "K30";
                $link = '/propellerFormMatritzen/indexGruppen/gf40.pdf_gf40_0_rechts';
                $title = 'FormenMatrix GF40-0 R';

                return $this->PDFdata($drehrichtung,$geometrieklasse,$kompatibilitaet,$link,$title);
        }

        public function formenMatrixPDF_GF45_0_L()
        {
                $drehrichtung = "L";
                $geometrieklasse = "GF45-0";
                $kompatibilitaet = "K45";
                $link = '/propellerFormMatritzen/indexGruppen/gf45.pdf_gf45_0_links';
                $title = 'FormenMatrix GF45-0 L';

                return $this->PDFdata($drehrichtung,$geometrieklasse,$kompatibilitaet,$link,$title);
        }

        public function formenMatrixPDF_GF45_0_R()
        {
                $drehrichtung = "R";
                $geometrieklasse = "GF45-0";
                $kompatibilitaet = "K45";
                $link = '/propellerFormMatritzen/indexGruppen/gf45.pdf_gf45_0_rechts';
                $title = 'FormenMatrix GF45-0 R';

                return $this->PDFdata($drehrichtung,$geometrieklasse,$kompatibilitaet,$link,$title);
        }

        public function formenMatrixPDF_GF50_0_L()
        {
                $drehrichtung = "L";
                $geometrieklasse = "GF50-0";
                $kompatibilitaet = "K50";
                $link = '/propellerFormMatritzen/indexGruppen/gf50.pdf_gf50_0_links';
                $title = 'FormenMatrix GF50-0 L';

                return $this->PDFdata($drehrichtung,$geometrieklasse,$kompatibilitaet,$link,$title);
        }

        public function formenMatrixPDF_GF50_0_R()
        {
                $drehrichtung = "R";
                $geometrieklasse = "GF50-0";
                $kompatibilitaet = "K50";
                $link = '/propellerFormMatritzen/indexGruppen/gf50.pdf_gf50_0_rechts';
                $title = 'FormenMatrix GF50-0 R';

                return $this->PDFdata($drehrichtung,$geometrieklasse,$kompatibilitaet,$link,$title);
        }


}
