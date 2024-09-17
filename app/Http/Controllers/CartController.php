<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Gloudemans\Shoppingcart\Contracts\Buyable;

use Gloudemans\Shoppingcart\Facades\Cart;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\Appart;
use App\Models\Shoppingcart;

use DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //afficher la vue du panier
        return view('customer/cart/index');
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Ajouter l'élément au panier

        //On veut pas avoir deux fois la même entité de ce produit
        $duplicata = Cart::search(function ($cartItem, $rowId) use($request) {
            //dd($cartItem->id);
                return $cartItem->id == $request->id_appart;
            });

        //dd($duplicata);

        //Rechercher l'id du produit qui a cet élément
        $appart = Appart::where('id', $request->id_appart)->first();

        //dd($appart);
        //on va voir si il y a une entrée de cet appart avec cet email(l'instance en question)
        $get_cart = Shoppingcart::where('instance', $request->user_email)->where('content',  $appart->designation_appart)->first();
        //dd($duplicata->isNotEmpty())
        if($duplicata == false AND $get_cart)
        {
            return redirect()->route('myspace')->with('error', 'Le produit a déja été ajouté!');
            //dd('ici');
        }
        else
        {
            //dd('laba');
            //Rechercher l'id du produit qui a cet élément
            $appart = Appart::where('id', $request->id_appart)->first();
            
            Cart::add($appart->id, $appart->designation_appart, 1, $appart->prix_jour)->associate('App\Models\Appart');
             //dd($appart);
           
            foreach(Cart::content() as $get)
            {
                $to_the_db = Shoppingcart::where('instance',  $request->user_email)->where('identifier',  $get->rowId)->first();
                if($to_the_db)//on n'a pas de ligne correspondate a cet rowId
                {

                }
                else
                {
                    //dd('cc');
                    //on va stocker certaines infos du panier en fonction du client dans la base
                    $cart = new Shoppingcart(['identifier' => $get->rowId, 'instance' => $request->user_email,  'content' => $get->model->designation_appart]);
                    $cart->save();
                }
                

                //dd($get->rowId);
            }


            /*$key = bcrypt(Str::random(10));

            Cart::store('ruyiroizruozufizeoufizoufizo');
            //Cart::instance('wishlist')->store(strval($request->user_email));*/

           return redirect()->route('myspace')->with('success', 'Elément ajouté à votre pannier avec succès!');

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
    public function destroy($rowid, $email)
    {
        //Supprimer un article qui est dans le panier
        //dd('cc');
        Cart::remove($rowid);

        //supprimer aussi dans la base de données
        DB::table('shoppingcarts')->where('identifier', '=', $rowid)->where('instance', $email)->delete();

        return back()->with('success', 'Element retiré du panier');
    }

    public function empty($instance)
    {
        Cart::destroy();

        DB::table('shoppingcarts')->where('instance', '=', $instance)->delete();

        return redirect('my_space');//rediriger sur son panier 
    }
}
