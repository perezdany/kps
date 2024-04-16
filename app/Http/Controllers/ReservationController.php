<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Calculator;
use App\Http\Controllers\CartController;

use Gloudemans\Shoppingcart\Facades\Cart;

use App\Models\Reservation;
use App\Models\Shoppingcart;
use App\Models\Appart;
//use App\Models\Cart;
use DB;

class ReservationController extends Controller
{
    //Controller qui se charge des resevratons ajout suppression etc

    public function AddReservation(Request $request)
    {
        //on vérifie d'abord si c'est un client connecté ou si c'est un admini qui fait la réservaton

        $appart = htmlspecialchars($request->appart);
        $date_debut = htmlspecialchars($request->date_debut);
        $jours = htmlspecialchars($request->jours);
        $mois = htmlspecialchars($request->mois);
        $user_email = htmlspecialchars($request->email);
        $mode_paiement = htmlspecialchars($request->modepaiement);
        $type_paiement = htmlspecialchars($request->paiement);

        $calculator = new Calculator();

        //echo $date_debut;

        //calcul du montant
        $montant  = $calculator->AmountReservation($appart, $jours, $mois, $date_debut);
        
        //la date de départ de l'appartement
        $depart_date = $calculator->DepartDate($jours, $date_debut, $mois);

        //Récuperer le client concercé
        $id_client = auth()->user()->id;

        $id_reservation = "RESER".date("Ymdhisa");

        $validate = 0;

        //echo $depart_date;

        //l'horodateure
        $today =  date('Y-m-d');
        $heure = date('h:i:s');

        //on passe à la sauvegarde maintenant
        $reservation = new Reservation(['id_reservation' => $id_reservation, 'id_client' => $id_client,  'id' => $appart, 'id_mode_paie' => $mode_paiement, 'id_paiement' => $type_paiement, 'validate' => $validate, 'date_debut' => $date_debut, 'date_fin' =>  $depart_date, 'jours' => $jours, 'mois' => $mois, 'montant' => $montant, 'solder' => 0, 'date' => $today, 'heure' => $heure]);
        $reservation->save();

        //on va voir si l'appartement etait dans son panier et donc le vider après reservation

        //Rechercher l'id du produit qui a cet élément
        $appart = Appart::where('id', request('appart'))->first();

        //on va voir si il y a une entrée de cet appart avec cet email(l'instance en question)
        $get_cart = Shoppingcart::where('instance', auth()->user()->email)->where('content',  $appart->designation_appart)->first();

        if($get_cart != null)
        {
                Cart::remove($get_cart->identifier);

            //supprimer aussi dans la base de données
            DB::table('shoppingcarts')->where('identifier', '=', $get_cart->identifier)->where('instance', auth()->user()->email)->delete();
            //l'appartement est dans la table shoppingcart va falloir le supprimer
            // $delete = (new CartController())->destroy($get_cart->identifier);
        }

        return redirect()->route('myspace')->with('success', 'Votre Réservation a été effectué. Vous recevrez une notification de validation d\'ici peu');

    }

    public function SaveReservation()
    {
        //on vérifie d'abord si c'est un client connecté ou si c'est un admini qui fait la réservaton

        if(session()->has('theadmin'))
        {
            $appart = htmlspecialchars($request->appart);
            $date_debut = htmlspecialchars($request->date_debut);
            $jours = htmlspecialchars($request->jours);
            $mois = htmlspecialchars($request->mois);
            $user_email = htmlspecialchars($request->email);
            $mode_paiement = htmlspecialchars($request->modepaiement);
            $type_paiement = htmlspecialchars($request->paiement);

            $calculator = new Calculator();

            //echo $date_debut;

            //calcul du montant
            $montant  = $calculator->AmountReservation($appart, $jours, $mois, $date_debut);
            
            //la date de départ de l'appartement
            $depart_date = $calculator->DepartDate($jours, $date_debut, $mois);

            //Récuperer le client concercé
            $id_client = (new UserController())->GetByEmail($user_email); //session('theuser')->id_client;
            //dd(gettype($id_client));

            if($id_client == null)
            {
                return redirect('save_reservation')->with('error', 'Cette adresse email (adresse du client) n\'existe pas essayez une autre adresse svp');
               
            }
            else
            {
                $id_reservation = "RESER".date("Ymdhisa");

                $validate = 1;

                //echo $depart_date;

                //l'horodateure
                $today =  date('Y-m-d');
                $heure = date('h:i:s');

                //on passe à la sauvegarde maintenant
                $reservation = new Reservation(['id_reservation' => $id_reservation, 'id_client' => $id_client->id_client,  'id' => $appart, 'id_mode_paie' => $mode_paiement, 'id_paiement' => $type_paiement, 'validate' => $validate, 'date_debut' => $date_debut, 'date_fin' =>  $depart_date, 'jours' => $jours, 'mois' => $mois, 'montant' => $montant, 'solder' => 0, 'date' => $today, 'heure' => $heure]);
                $reservation->save();

                //on va voir si l'appartement etait dans son panier et donc le vider après reservation

                //Rechercher l'id du produit qui a cet élément
               /* $appart = Appart::where('id', request('appart'))->first();

                //on va voir si il y a une entrée de cet appart avec cet email(l'instance en question)
                $get_cart = Shoppingcart::where('instance', session('theuser')->email)->where('content',  $appart->designation_appart)->first();

                if($get_cart != null)
                {
                     Cart::remove($get_cart->identifier);

                    //supprimer aussi dans la base de données
                    DB::table('shoppingcarts')->where('identifier', '=', $get_cart->identifier)->where('instance', session('theuser')->email)->delete();
                    //l'appartement est dans la table shoppingcart va falloir le supprimer
                   // $delete = (new CartController())->destroy($get_cart->identifier);
                }*/

                return redirect('save_reservation')->with('success', 'Votre Réservation a été effectué. Vous recevrez une notification de validation d\'ici peu');

            }

           
        }
        else
        {
            return redirect('save_reservation')->with('error', 'Vous devez d\'abord vous connecter avant de faire une réservation! Connectez-vous via l\'espace client');
        }

    }


    public function ReservationInProgess($id_client)
    {
        $get = DB::table('reservations')->join('clients', 'clients.id', '=', 'reservations.id_client')->join('apparts', 'apparts.id', '=', 'reservations.id')->join('paiements', 'paiements.id_paiement', '=', 'reservations.id_paiement')->join('modepaiements', 'modepaiements.id_mode_paie', '=', 'reservations.id_mode_paie')->where('reservations.validate', 0)->where('clients.id', $id_client)
        ->get(['apparts.id', 'apparts.designation_appart', 'apparts.prix', 'apparts.nb_lit', 'apparts.nb_douche', 'apparts.path', 'apparts.path_descript1', 'apparts.path_descript2', 'apparts.path_descript3', 'apparts.note', 'apparts.internet_wifi', 'apparts.description', 'clients.nom_prenoms', 'clients.tel', 'clients.email', 'paiements.libele_paiement', 'modepaiements.libele_mode_paie', 'reservations.id_reservation', 'reservations.validate', 'reservations.montant', 'reservations.date_debut', 'reservations.date_fin']);
        
        //$get = DB::table('apparts')->where('id', '>=', $id)->get();

        return $get;
    }

    public function SelectAReservation($id_reservation)
    {
        //récupérer une réservation précise ici,
         $get = DB::table('reservations')->join('clients', 'clients.id', '=', 'reservations.id_client')->join('apparts', 'apparts.id', '=', 'reservations.id')->join('paiements', 'paiements.id_paiement', '=', 'reservations.id_paiement')->join('modepaiements', 'modepaiements.id_mode_paie', '=', 'reservations.id_mode_paie')->where('reservations.id_reservation', '=', $id_reservation)
        ->get(['apparts.id', 'apparts.designation_appart', 'apparts.prix', 'apparts.nb_lit', 'apparts.nb_douche', 'apparts.path', 'apparts.path_descript1', 'apparts.path_descript2', 'apparts.path_descript3', 'apparts.note', 'apparts.internet_wifi', 'apparts.description', 'clients.nom_prenoms', 'clients.tel', 'clients.email', 'paiements.libele_paiement', 'modepaiements.libele_mode_paie', 'modepaiements.id_mode_paie', 'reservations.id_paiement', 'reservations.id_reservation', 'reservations.validate', 'reservations.montant', 'reservations.date_debut', 'reservations.date_fin', 'reservations.jours', 'reservations.mois']);
        
        //$get = DB::table('apparts')->where('id', '>=', $id)->get();

       return $get;
    }

    public function DeleteMyReservation($id_reservation)
    {
        $deleted = DB::table('reservations')->where('id_reservation', '=', $id_reservation)->delete();

        return redirect('my_space')->with('success', 'Réservation supprimée avec succès');
    }


    public function editMyReservation(Request $request)
    {
        $appart = htmlspecialchars($request->appart);
        $date_debut = htmlspecialchars($request->date_debut);
        $jours = htmlspecialchars($request->jours);
        $mois = htmlspecialchars($request->mois);
        $user_email = htmlspecialchars($request->email);
        $mode_paiement = htmlspecialchars($request->modepaiement);
        $type_paiement = htmlspecialchars($request->paiement);
        $id_reservation = htmlspecialchars($request->id_reservation);

        $calculator = new Calculator();

        //dd($id_reservation);
            
        //echo $date_debut;

        //calcul du montant
        $montant  = $calculator->AmountReservation($appart, $jours, $mois, $date_debut);
        
        //la date de départ de l'appartement
        $depart_date = $calculator->DepartDate($jours, $date_debut, $mois);

        //Récuperer le client concercé
        $id_client = session('theuser')->id_client;

        //$id_reservation = "RESER".date("Ymdhisa");

        $validate = 0;

        //echo $depart_date;

        //on passe à la modification maintenant

        

        $affected = DB::table('reservations')
            ->where('id_reservation', $id_reservation)
            ->update(['id' => $appart, 'id_mode_paie' => $mode_paiement, 'id_paiement' => $type_paiement, 'validate' => $validate, 'date_debut' => $date_debut, 'date_fin' =>  $depart_date, 'jours' => $jours, 'mois' => $mois, 'montant' => $montant, 'solder' => 0]);
        
        return redirect('my_space')->with('success', 'Modificaiton effectuée avec succès!');
    }

    public function ReservationDisplayAll()
    {
        $today =  date('Y-m-d');

        $get = DB::table('reservations')
        ->join('clients', 'clients.id', '=', 'reservations.id_client')
        ->join('apparts', 'apparts.id', '=', 'reservations.id')
        ->join('paiements', 'paiements.id_paiement', '=', 'reservations.id_paiement')
        ->join('modepaiements', 'modepaiements.id_mode_paie', '=', 'reservations.id_mode_paie')
        ->where('reservations.date_fin', '>', $today)
        ->get(['apparts.id', 'apparts.designation_appart', 'apparts.prix', 'apparts.nb_lit', 'apparts.nb_douche', 'apparts.path', 'apparts.path_descript1', 'apparts.path_descript2', 'apparts.path_descript3', 'apparts.note', 'apparts.internet_wifi', 'apparts.description', 'clients.nom_prenoms', 'clients.tel', 'clients.email', 'paiements.libele_paiement', 'modepaiements.libele_mode_paie', 'modepaiements.id_mode_paie', 'reservations.id_paiement', 'reservations.id_reservation', 'reservations.validate', 'reservations.montant', 'reservations.date_debut', 'reservations.date_fin', 'reservations.jours', 'reservations.mois', 'reservations.date', 'reservations.heure', 'reservations.solder']);
        
        return $get;
    }

    public function AllPoolReservation()//Toutes les réservation en attente
    {
        $today =  date('Y-m-d');

        $get = DB::table('reservations')->join('clients', 'clients.id', '=', 'reservations.id_client')->join('apparts', 'apparts.id', '=', 'reservations.id')->join('paiements', 'paiements.id_paiement', '=', 'reservations.id_paiement')->join('modepaiements', 'modepaiements.id_mode_paie', '=', 'reservations.id_mode_paie')
        ->where('reservations.date_fin', '>', $today)
        ->where('reservations.validate', 0)
        ->get(['apparts.id', 'apparts.designation_appart', 'apparts.prix', 'apparts.nb_lit', 'apparts.nb_douche', 'apparts.path', 'apparts.path_descript1', 'apparts.path_descript2', 'apparts.path_descript3', 'apparts.note', 'apparts.internet_wifi', 'apparts.description', 'clients.nom_prenoms', 'clients.tel', 'clients.email', 'paiements.libele_paiement', 'modepaiements.libele_mode_paie', 'modepaiements.id_mode_paie', 'reservations.id_paiement', 'reservations.id_reservation', 'reservations.validate', 'reservations.montant', 'reservations.date_debut', 'reservations.date_fin', 'reservations.jours', 'reservations.mois', 'reservations.date', 'reservations.heure']);
        
        //$get = DB::table('apparts')->where('id', '>=', $id)->get();

        return $get;
    }


    public function ValidateReservation(Request $request)//Valider la réservation
    {
       
            $lareservation = htmlspecialchars($request->id_reservation);
            
            $affected = DB::table('reservations')
              ->where('id_reservation', $lareservation)
              ->update(['validate' => 1]);
           
            return redirect('reservations')->with('success', 'La réservation a été validée');

       
    }

    public function ReservationCancel()
    {
        $id_reservation =  request('id_reservation');
        
        $deleted = DB::table('reservations')->where('id_reservation', '=', $id_reservation)->delete();

        return redirect('reservations')->with('success', 'Réservation Annulée avec succès');
    }

    public function EditReservationForm(Request $request)
    {
        //dd($request->id_reservation);
        return view('admin/edit_reservation_form', [
            'id' => $request->id_reservation,
            ]);
    }

    public function GetReservationById($id)
    {
        $get = DB::table('reservations')->join('clients', 'clients.id', '=', 'reservations.id_client')
        ->where('id_reservation', $id)
        ->join('apparts', 'apparts.id', '=', 'reservations.id')->join('paiements', 'paiements.id_paiement', '=', 'reservations.id_paiement')
        ->join('modepaiements', 'modepaiements.id_mode_paie', '=', 'reservations.id_mode_paie')
        ->get(['apparts.id', 'apparts.designation_appart', 'apparts.prix', 'apparts.nb_lit', 'apparts.nb_douche', 'apparts.path', 'apparts.path_descript1', 'apparts.path_descript2', 'apparts.path_descript3', 'apparts.note', 'apparts.internet_wifi', 'apparts.description', 'clients.nom_prenoms', 'clients.tel', 'clients.email', 'paiements.libele_paiement', 'modepaiements.libele_mode_paie', 'modepaiements.id_mode_paie', 'reservations.id_paiement', 'reservations.id_reservation', 'reservations.validate', 'reservations.montant', 'reservations.date_debut', 'reservations.date_fin', 'reservations.jours', 'reservations.mois', 'reservations.date', 'reservations.heure', 'reservations.solder']);
        
        return $get;
    }

    public function AdminEditReservation(Request $request)
    {
        $appart = htmlspecialchars($request->appart);
        $date_debut = htmlspecialchars($request->date_debut);
        $jours = htmlspecialchars($request->jours);
        $mois = htmlspecialchars($request->mois);
        $user_email = htmlspecialchars($request->email);
        $mode_paiement = htmlspecialchars($request->modepaiement);
        $type_paiement = htmlspecialchars($request->paiement);
        $id_reservation = htmlspecialchars($request->id_reservation);

        $calculator = new Calculator();

        //dd($id_reservation);
            
        //echo $date_debut;

        //calcul du montant
        $montant  = $calculator->AmountReservation($appart, $jours, $mois, $date_debut);
        
        //la date de départ de l'appartement
        $depart_date = $calculator->DepartDate($jours, $date_debut, $mois);

        //Récuperer le client concercé
        $id_client = auth()->user()->id_client;

        //$id_reservation = "RESER".date("Ymdhisa");

        $validate = 0;

        //echo $depart_date;

        //on passe à la modification maintenant

        

        $affected = DB::table('reservations')
            ->where('id_reservation', $id_reservation)
            ->update(['id' => $appart, 'id_mode_paie' => $mode_paiement, 'id_paiement' => $type_paiement, 'validate' => $validate, 'date_debut' => $date_debut, 'date_fin' =>  $depart_date, 'jours' => $jours, 'mois' => $mois, 'montant' => $montant, 'solder' => 0]);
        
        return redirect('reservations')->with('success', 'Modificaiton effectuée avec succès!');
    }
}
