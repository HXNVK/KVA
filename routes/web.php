<?php

use Illuminate\Support\Facades\Route;

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
//+++++++++++++++++++++++++++++++ KVA ++++++++++++++++++++++++++++++++++++++ */

//Auth
Route::view('/','auth.login');
Auth::routes([
  'register' => false, // Registration Routes...
  // 'reset' => false, // Password Reset Routes...
  // 'verify' => false, // Email Verification Routes...
]);


//Bereich Kunde
Route::resource('kunden','KundenController');
Route::resource('kundeAdressen','KundeAdressenController');
Route::resource('kundeFinanzdaten','KundeFinanzdatenController');
Route::resource('kundeKontaktpersonen','KundeKontaktpersonenController');

Route::resource('kundenNeu','KundenNeuController');

Route::get('/myFactory', 'KundenController@myFactory');


//Bereich Projekte & Fluggeräte
Route::resource('projekte','ProjekteController');
Route::get('projekte/create/json-motorGetriebe/{id}',array('as'=>'projekte.getriebeAjax','uses'=>'ProjekteController@getriebeAjax'));
Route::get('projekte/create/json-motorFlansch/{id}',array('as'=>'projekte.FlanschAjax','uses'=>'ProjekteController@flanschAjax'));

Route::resource('projektPropeller','ProjektPropellerController');

Route::resource('fluggeraete','FluggeraeteController');

Route::resource('projekteNeu','ProjekteNeuController');


//Bereich Aufträge
Route::resource('auftraege','AuftraegeController');
Route::post('auftraege/add', 'AuftraegeController@add')->name('auftrag.add');
Route::get('/fb009/{fb009}', 'AuftraegeController@fb009');
Route::get('/fb094/{fb094}', 'AuftraegeController@fb094');
Route::get('/auftragPDF/{auftragPDF}', 'AuftraegeController@auftragPDF');
Route::get('/auftraege/status/{status}', 'AuftraegeController@status')->name('auftraege.status');

Route::get('shop/cart', 'CartController@cart')->name('cart.index');
Route::post('shop/add', 'CartController@add')->name('cart.add');
Route::post('shop/update', 'CartController@update')->name('cart.update');
Route::post('shop/remove', 'CartController@remove')->name('cart.remove');
Route::post('shop/clear', 'CartController@clear')->name('cart.clear');

Route::resource('espData','EspController');


//Bereich Artikel Propeller
Route::resource('propeller','PropellerController');
Route::get('propeller/create/json-propellerForm/{id}',array('as'=>'propeller.propellerFormAjax','uses'=>'PropellerController@propellerFormAjax'));

Route::resource('shop','CartController');


//Bereich Propeller Tools, Matrix & CAD
Route::resource('propellerFormMatritzen','PropellerFormMatritzenController');
Route::get('/indexGF25_0L', 'PropellerFormMatritzenController@indexGF25_0L');
Route::get('/indexGF25_0R', 'PropellerFormMatritzenController@indexGF25_0R');

Route::get('/indexGF26_0L', 'PropellerFormMatritzenController@indexGF26_0L');
Route::get('/indexGF26_0R', 'PropellerFormMatritzenController@indexGF26_0R');

Route::get('/indexGF30_0L', 'PropellerFormMatritzenController@indexGF30_0L');
Route::get('/indexGF30_0R', 'PropellerFormMatritzenController@indexGF30_0R');
Route::get('/indexGK30_0L', 'PropellerFormMatritzenController@indexGK30_0L');
Route::get('/indexGK30_0R', 'PropellerFormMatritzenController@indexGK30_0R');

Route::get('/indexGF31_0L', 'PropellerFormMatritzenController@indexGF31_0L');
Route::get('/indexGF31_0R', 'PropellerFormMatritzenController@indexGF31_0R');

Route::get('/indexGF40_0L', 'PropellerFormMatritzenController@indexGF40_0L');
Route::get('/indexGF40_0R', 'PropellerFormMatritzenController@indexGF40_0R');

Route::get('/indexGF45_0L', 'PropellerFormMatritzenController@indexGF45_0L');
Route::get('/indexGF45_0R', 'PropellerFormMatritzenController@indexGF45_0R');

Route::get('/indexGF50_0L', 'PropellerFormMatritzenController@indexGF50_0L');
Route::get('/indexGF50_0R', 'PropellerFormMatritzenController@indexGF50_0R');

Route::resource('propellerFormen','PropellerFormenController');
Route::get('/propellerFormen/auftrag/fb018', 'PropellerFormenController@fb018')->name('propellerFormen.fb018');
Route::post('/propellerFormen/fb018speichern', 'PropellerFormenController@fb018speichern')->name('propellerFormen.fb018speichern');

Route::get('/formen_GF25_0_PDF', 'PropellerFormenController@formen_GF25_0_PDF');
Route::get('/formen_GF26_0_PDF', 'PropellerFormenController@formen_GF26_0_PDF');
Route::get('/formen_GF30_0_PDF', 'PropellerFormenController@formen_GF30_0_PDF');
Route::get('/formen_GF31_0_PDF', 'PropellerFormenController@formen_GF31_0_PDF');
Route::get('/formen_GV30_0_PDF', 'PropellerFormenController@formen_GV30_0_PDF');
Route::get('/formen_GK30_0_PDF', 'PropellerFormenController@formen_GK30_0_PDF');
Route::get('/formen_GF40_0_PDF', 'PropellerFormenController@formen_GF40_0_PDF');
Route::get('/formen_GF45_0_PDF', 'PropellerFormenController@formen_GF45_0_PDF');
Route::get('/formen_GF50_0_PDF', 'PropellerFormenController@formen_GF50_0_PDF');
Route::get('/formen_GV50_0_PDF', 'PropellerFormenController@formen_GV50_0_PDF');
Route::get('/formen_GAV40_0_PDF', 'PropellerFormenController@formen_GAV40_0_PDF');
Route::get('/formen_GAV40_1_PDF', 'PropellerFormenController@formen_GAV40_1_PDF');
Route::get('/formen_GAV60_0_PDF', 'PropellerFormenController@formen_GAV60_0_PDF');


Route::resource('propellerModellBlaetter','PropellerModellBlaetterController');

Route::resource('propellerModellBlattTypen','PropellerModellBlattTypenController');

Route::resource('propellerModellWurzeln','PropellerModellWurzelnController');

Route::resource('propellerModellKompatibilitaeten','PropellerModellKompatibilitaetenController');

Route::resource('propellerZuschnitte','PropellerZuschnitteController');
Route::resource('propellerZuschnittLagen','PropellerZuschnittLagenController');

Route::resource('airfoilData','AirfoilDataController');

/**Route::resource(
     'propellerModellKompatibilitaeten',
     'PropellerModellKompatibilitaetenController',
     ['parameters' => [
          'propellerModellKompatibilitaeten' => 'Kompatibilitaet'
     ]]);
==> Route für Route-Namen mit mehr als 32x Characters*/

//PDF´s
Route::get('/TypenPDF', 'PropellerModellBlattTypenController@typenPDF');
//Route::get('/BlattmodellePDF', 'PropellerModellBlaetterController@blattmodellePDF');
Route::get('/blattmodelle_D05_PDF', 'PropellerModellBlaetterController@blattmodelle_D05_PDF');
Route::get('/blattmodelle_D10_PDF', 'PropellerModellBlaetterController@blattmodelle_D10_PDF');
Route::get('/blattmodelle_D20_PDF', 'PropellerModellBlaetterController@blattmodelle_D20_PDF');
Route::get('/blattmodelle_D25_PDF', 'PropellerModellBlaetterController@blattmodelle_D25_PDF');
Route::get('/blattmodelle_D30_PDF', 'PropellerModellBlaetterController@blattmodelle_D30_PDF');
Route::get('/blattmodelle_D45_PDF', 'PropellerModellBlaetterController@blattmodelle_D45_PDF');
Route::get('/blattmodelle_D50_PDF', 'PropellerModellBlaetterController@blattmodelle_D50_PDF');
Route::get('/blattmodelle_D60_PDF', 'PropellerModellBlaetterController@blattmodelle_D60_PDF');


//Route::get('/WurzelmodellePDF', 'PropellerModellWurzelnController@wurzelmodellePDF');
Route::get('/wurzelmodelle_GF05_0_PDF', 'PropellerModellWurzelnController@wurzelmodelle_GF05_0_PDF');
Route::get('/wurzelmodelle_GF10_0_PDF', 'PropellerModellWurzelnController@wurzelmodelle_GF10_0_PDF');
Route::get('/wurzelmodelle_GF20_0_PDF', 'PropellerModellWurzelnController@wurzelmodelle_GF20_0_PDF');
Route::get('/wurzelmodelle_GF25_0_PDF', 'PropellerModellWurzelnController@wurzelmodelle_GF25_0_PDF');
Route::get('/wurzelmodelle_GF26_0_PDF', 'PropellerModellWurzelnController@wurzelmodelle_GF26_0_PDF');
Route::get('/wurzelmodelle_GF30_0_PDF', 'PropellerModellWurzelnController@wurzelmodelle_GF30_0_PDF');
Route::get('/wurzelmodelle_GF31_0_PDF', 'PropellerModellWurzelnController@wurzelmodelle_GF31_0_PDF');
Route::get('/wurzelmodelle_GF40_0_PDF', 'PropellerModellWurzelnController@wurzelmodelle_GF40_0_PDF');
Route::get('/wurzelmodelle_GF45_0_PDF', 'PropellerModellWurzelnController@wurzelmodelle_GF45_0_PDF');
Route::get('/wurzelmodelle_GF50_0_PDF', 'PropellerModellWurzelnController@wurzelmodelle_GF50_0_PDF');
Route::get('/wurzelmodelle_GF60_0_PDF', 'PropellerModellWurzelnController@wurzelmodelle_GF60_0_PDF');
Route::get('/wurzelmodelle_GK20_0_PDF', 'PropellerModellWurzelnController@wurzelmodelle_GK20_0_PDF');
Route::get('/wurzelmodelle_GK25_0_PDF', 'PropellerModellWurzelnController@wurzelmodelle_GK25_0_PDF');
Route::get('/wurzelmodelle_GK30_0_PDF', 'PropellerModellWurzelnController@wurzelmodelle_GK30_0_PDF');
Route::get('/wurzelmodelle_GK40_0_PDF', 'PropellerModellWurzelnController@wurzelmodelle_GK40_0_PDF');
Route::get('/wurzelmodelle_GK50_0_PDF', 'PropellerModellWurzelnController@wurzelmodelle_GK50_0_PDF');
Route::get('/wurzelmodelle_GS60_0_PDF', 'PropellerModellWurzelnController@wurzelmodelle_GS60_0_PDF');
Route::get('/wurzelmodelle_GV30_0_PDF', 'PropellerModellWurzelnController@wurzelmodelle_GV30_0_PDF');
Route::get('/wurzelmodelle_GV50_0_PDF', 'PropellerModellWurzelnController@wurzelmodelle_GV50_0_PDF');
Route::get('/wurzelmodelle_GAV60_0_PDF', 'PropellerModellWurzelnController@wurzelmodelle_GAV60_0_PDF');


Route::get('/KompatibilitaetenPDF', 'PropellerModellKompatibilitaetenController@kompatibilitaetenPDF');

Route::get('/formenMatrixPDF_GF25_0_L', 'PropellerFormMatritzenController@formenMatrixPDF_GF25_0_L');
Route::get('/formenMatrixPDF_GF25_0_R', 'PropellerFormMatritzenController@formenMatrixPDF_GF25_0_R');

Route::get('/formenMatrixPDF_GF26_0_L', 'PropellerFormMatritzenController@formenMatrixPDF_GF26_0_L');
Route::get('/formenMatrixPDF_GF26_0_R', 'PropellerFormMatritzenController@formenMatrixPDF_GF26_0_R');

Route::get('/formenMatrixPDF_GF30_0_L', 'PropellerFormMatritzenController@formenMatrixPDF_GF30_0_L');
Route::get('/formenMatrixPDF_GF30_0_R', 'PropellerFormMatritzenController@formenMatrixPDF_GF30_0_R');
Route::get('/formenMatrixPDF_GK30_0_L', 'PropellerFormMatritzenController@formenMatrixPDF_GK30_0_L');
Route::get('/formenMatrixPDF_GK30_0_R', 'PropellerFormMatritzenController@formenMatrixPDF_GK30_0_R');

Route::get('/formenMatrixPDF_GF31_0_L', 'PropellerFormMatritzenController@formenMatrixPDF_GF31_0_L');
Route::get('/formenMatrixPDF_GF31_0_R', 'PropellerFormMatritzenController@formenMatrixPDF_GF31_0_R');

Route::get('/formenMatrixPDF_GF40_0_L', 'PropellerFormMatritzenController@formenMatrixPDF_GF40_0_L');
Route::get('/formenMatrixPDF_GF40_0_R', 'PropellerFormMatritzenController@formenMatrixPDF_GF40_0_R');

Route::get('/formenMatrixPDF_GF45_0_L', 'PropellerFormMatritzenController@formenMatrixPDF_GF45_0_L');
Route::get('/formenMatrixPDF_GF45_0_R', 'PropellerFormMatritzenController@formenMatrixPDF_GF45_0_R');

Route::get('/formenMatrixPDF_GF50_0_L', 'PropellerFormMatritzenController@formenMatrixPDF_GF50_0_L');
Route::get('/formenMatrixPDF_GF50_0_R', 'PropellerFormMatritzenController@formenMatrixPDF_GF50_0_R');


//Bereich Motor
Route::resource('motoren','MotorenController');
Route::resource('motorGetriebe','MotorGetriebeController');
Route::resource('motorFlansche','MotorFlanscheController');


//Bereich Produktion
Route::resource('materialien','MaterialienController');
Route::resource('materialHersteller','MaterialHerstellerController');


Route::get('/herstellerPDF', 'MaterialHerstellerController@herstellerPDF');
Route::get('/materialienPDF', 'MaterialienController@materialienPDF');


//Bereich LFA
Route::resource('laermmessungDaten','LaermmessungDatenController');
Route::resource('laermmessungen','LaermmessungenController');


Route::get('/laermmessBerichtPDF/{laermmessBerichtPDF}', 'LaermmessungenController@laermmessBerichtPDF');


//Bereich StepCode
Route::resource('propellerStepCode','PropellerStepCodeController');
Route::post('/propellerStepCode/mainStepCode', 'PropellerStepCodeController@Main_Step_Code')->name('propellerStepCode.mainStepCode');

Route::resource('propellerStepCodeDateien','PropellerStepCodeDateienController');
Route::resource('propellerStepCodeProfile','PropellerStepCodeProfileController');
Route::resource('propellerStepCodeBlaetter','PropellerStepCodeBlaetterController');
Route::resource('propellerStepCodeBlattBloecke','PropellerStepCodeBlattBloeckeController');
Route::resource('propellerStepCodeWurzelnF','PropellerStepCodeWurzelnFController');
Route::resource('propellerStepCodeWurzelnAV','PropellerStepCodeWurzelnAVController');
Route::resource('propellerStepCodeWurzelBloecke','PropellerStepCodeWurzelBloeckeController');


Route::middleware(['auth'])->group( function(){

     Route::get('get/{filename}', 'PropellerStepCodeDateienController@getFile')->name('getfile');
     Route::resource('/users', UserController::class);

});


//Bereich Q13 Fräsprogramm
Route::resource('q13Nullpunkte','Q13NullpunkteController');

//Bereich Standard layout
Route::view('app','layouts.app');
Route::resource('dashboard', 'DashboardController');