<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Session;
use Auth;
use DB;

use App\Models\Artikel01Propeller;
use App\Models\Artikel03Ausfuehrung;
use App\Models\Artikel03Farbe;
use App\Models\Artikel05Distanzscheibe;
use App\Models\Artikel06ASGP;
use App\Models\Artikel06SPGP;
use App\Models\Artikel06SPKP;
use App\Models\Artikel07AP;
use App\Models\Artikel07Buchsen;
use App\Models\Artikel07Adapterscheiben;
use App\Models\Artikel08Zubehoer;
use App\Models\Propeller;
use App\Models\Kunde;


class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userId = auth()->user()->id; 
        \Cart::session($userId);

        $kundeID = session('customerID');

        $artikel05DistanzscheibeObj = Artikel05Distanzscheibe::orderBy('name')->where('inaktiv',0)->get();
        $artikel06ASGPObj = Artikel06ASGP::orderBy('name')->where('inaktiv',0)->get();
        $artikel06SPGPObj = Artikel06SPGP::orderBy('name')->where('inaktiv',0)->get();
        $artikel06SPKPObj = Artikel06SPKP::orderBy('name')->where('inaktiv',0)->get();
        $artikel07APObj = Artikel07AP::orderBy('name')->where('inaktiv',0)->get();
        $artikel07BuchsenObj = Artikel07Buchsen::orderBy('name')->where('inaktiv',0)->get();
        $artikel07ASObj = Artikel07Adapterscheiben::orderBy('name')->where('inaktiv',0)->get();
        $artikel08ZubehoerObj = Artikel08Zubehoer::orderBy('name')->where('inaktiv',0)->get();


        //dd($artikel07ASObj);
        return view('shop.shop',
                            compact(
                                'artikel05DistanzscheibeObj',
                                'artikel06ASGPObj',
                                'artikel06SPGPObj',
                                'artikel06SPKPObj',
                                'artikel07APObj',
                                'artikel07ASObj',
                                'artikel07BuchsenObj',
                                'artikel08ZubehoerObj',
                                'kundeID'
                            ));
    }

    public function cart(Request $request){

        $userId = auth()->user()->id; 
        \Cart::session($userId);

        $cartCollection = \Cart::getContent();

        $kundeID = session('customerID');
        $kunde = Kunde::find($kundeID);

        //dd($cartCollection);

        return view('shop.cart',
                            compact(
                                'cartCollection',
                                'kundeID',
                                'kunde'
                            ));
    }



    public function add(Request $request){

        //dd($request->input());
        $this->validate($request,[
            'type' => 'required',
        ]);
        //vaildation muss hier ggf noch eingefügt werden

        session(['customerID' => $request->customerID]);

        $userId = auth()->user()->id;

        if(Str::of($request->name)->contains('H50')
        || Str::of($request->name)->contains('H60')
        ){
            if(Str::of($request->name)->contains('NC')){
                $protectionTape = null;
            }else{
                $protectionTape = $request->protectionTape;
            }
        }else{
            $protectionTape = null;
        }

        \Cart::session($userId)->add(
            array(
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'numOfBlades' => $request->numOfBlades,
            'propellerFormID' => $request->propellerFormID,
            'quantity' => $request->quantity,
            'projectID' => $request->projectID,
            'projectname' => $request->projectname,
            'projectclass' => $request->projectclass,
            'customerID' => $request->customerID,
            'option' => $request->option,
            'priceOption' => $request->priceOption,
            'assembly' => $request->assembly,
            'drilling' => $request->drilling,
            'sticker' => $request->sticker,
            'typesticker' => $request->typesticker,
            'protectionTape' => $protectionTape,
            'color' => $request->color,
            'testpropeller' => $request->testpropeller,
            'comment' => $request->comment,
            'urgency' => $request->urgency,
            'ets' => $request->ets,
            'certification' => $request->certification,
            'ds' => $request->ds,
            'asgp' => $request->asgp,
            'spgp' => $request->spgp,
            'spkp' => $request->spkp,
            'ap' => $request->ap,
            'as' => $request->as,
            'buHX' => $request->buHX,
            'btSet' => $request->btSet,
            'btSet2' => $request->btSet2,
            'type' => $request->type,
            'addParts' => $request->addParts
            )
        );
        return redirect("/shop/cart")->with('success_msg', 'Artikel zum Auftrag hinzugefügt');
        //return redirect("/auftraege/create/?kundenId=$request->customerID")->with('success_msg', 'Artikel zum Auftrag hinzugefügt');
    }



    public function update(Request $request){

        $artikel= explode(',', $request->input('artikel'));
        $id = $artikel[0];
        $name = $artikel[1]; 
        $testpropeller = $artikel[2]; 
        $qty = $request->input('quantity');

        //dd($request->input());
        //dd($testpropeller);

        /**
         * removes an item on cart by item ID
         *
         * @param $id
         */

        // removing cart item for a specific user's cart
        $userId = auth()->user()->id; // or any string represents user identifier


        \Cart::session($userId)->update($id, array(
            'quantity' => $qty, // so if the current product has a quantity of 4, another 2 will be added so this will result to 6
            'testpropeller' => $testpropeller,
          ));

        return redirect()->route('cart.index')->with('success_msg', "Artikel $name geändert" );
    }



    public function remove(Request $request){

        $id = $request->id;
        //dd($id);
        /**
         * removes an item on cart by item ID
         *
         * @param $id
         */

        \Cart::remove($id);

        // removing cart item for a specific user's cart
        $userId = auth()->user()->id; // or any string represents user identifier
        \Cart::session($userId)->remove($id);
        return redirect()->route('cart.index')->with('success_msg', 'Artikel vom Auftrag entfernt');
    }



    public function clear(){

        /**
        * clear cart
        *
        * @return void
        */
        $userId = auth()->user()->id;

        \Cart::clear();
        \Cart::session($userId)->clear();

        $kundeID = session('customerID');

        return redirect("/kunden/$kundeID")->with('success_msg', 'Alle Artikel vom Auftrag entfernt');
    }

}
