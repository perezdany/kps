<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Appart;
use App\Models\Client;
use App\Models\Utilisateur;
use App\Models\Reservation;

class Calculator extends Controller
{
    //Celui qui fait toute sorte de calcul

    public function AmountReservation($id_appart, $jours, $nuits, $mois, $date_entree)
    {
        //L'appart en question
        $appart = Appart::where('id', $id_appart)->first();
        //dd($mois);
        //Voir qu'est ce qui a été rempli parmi le jour et le mois et la nuit
        if($mois != 0)//il a rempli le mois
        {   
            //dd('ici');
            //chaque mois n'as pas le meme nombre de jour, il faut donc déterminer le mois en question
            //pour déterminier le ou les mois en question il faut avoir la date de sortie du client
            //on a la date d'arrivée
            if($jours == 0)//il n'a pas voulu remplir les jours mais plutot le mois
            {
                //dd('ll');
                $departtime =strtotime($date_entree.'+'.$mois.' months');
                $depart = date("Y-m-d", $departtime);

                //on doit utiliser les timestamps pour la différence des dates
                $timestamp1 = strtotime($depart);
                $timestamp2 = strtotime($date_entree);

                $diff = $timestamp1 - $timestamp2;

                $tmp = $diff;
                $retour['second'] = $tmp % 60;
             
                $tmp = floor( ($tmp - $retour['second']) /60 );
                $retour['minute'] = $tmp % 60;
             
                $tmp = floor( ($tmp - $retour['minute'])/60 );
                $retour['hour'] = $tmp % 24;
             
                $tmp = floor( ($tmp - $retour['hour'])  /24 );
                $retour['day'] = $tmp;

                $amount = $appart->prix_jour * $retour['day'] ;
            }
            else //y a des jours dessus encore
            {
                //dd('mm');
                $departtime =strtotime($date_entree.'+'.$mois.' months');
                $depart = date("Y-m-d", $departtime);

                //on doit utiliser les timestamps pour la différence des dates
                $timestamp1 = strtotime($depart);
                $timestamp2 = strtotime($date_entree);

                $diff = $timestamp1 - $timestamp2;

                $tmp = $diff;
                $retour['second'] = $tmp % 60;
             
                $tmp = floor( ($tmp - $retour['second']) /60 );
                $retour['minute'] = $tmp % 60;
             
                $tmp = floor( ($tmp - $retour['minute'])/60 );
                $retour['hour'] = $tmp % 24;
             
                $tmp = floor( ($tmp - $retour['hour'])  /24 );
                $retour['day'] = $tmp;

                $le_nombre_jours = $retour['day'] + $jours;

                $amount = $appart->prix_jour * $le_nombre_jours;
            }

            if($nuits != 0)// il a rempli le nombre de nuit et pas le jours
            {
                //dd('aa');
                $departtime =strtotime($date_entree.'+'.$mois.' months');
                $depart = date("Y-m-d", $departtime);

                //on doit utiliser les timestamps pour la différence des dates
                $timestamp1 = strtotime($depart);
                $timestamp2 = strtotime($date_entree);

                $diff = $timestamp1 - $timestamp2;

                $tmp = $diff;
                $retour['second'] = $tmp % 60;
             
                $tmp = floor( ($tmp - $retour['second']) /60 );
                $retour['minute'] = $tmp % 60;
             
                $tmp = floor( ($tmp - $retour['minute'])/60 );
                $retour['hour'] = $tmp % 24;
             
                $tmp = floor( ($tmp - $retour['hour'])  /24 );
                $retour['day'] = $tmp;

                $le_nombre_jours = $retour['day'];

                $amount = ($appart->prix_jour * $le_nombre_jours) + ($appart->prix_nuit * $nuits);
            }

        }
        else//il a rempli uniquement les jours ou les nuits
        {
            //dd($nuits);
            $amount = intval(($nuits * $appart->prix_nuit)) + intval(($jours * $appart->prix_jour)) ; 
            //($jours * $appart->prix_jour); //+ ($nuits * $appart->prix_nuit);

            //dd($amount);
        }

        return $amount ;
        

    }


    public function DepartDate($jours, $date_entree, $mois, $nuits)
    {
        $timestamp = strtotime($date_entree);
        if($jours == 0)//il a rempli uniquement le mois
        {
            //dd('y');
            if($mois != 0) //si le mois est rempli donc et différent de zéro
            {
                //strtotime(‘+’.$duree.’ month’, $dateDepartTimestamp )
                $departtime = strtotime('+'.$mois.' month', $timestamp);
                $depart = date("Y-m-d", $departtime);

                return $depart;
            }
            else
            {
                if($nuits != 0)// il a rempli le nombre de nuit le jours
                {
                    $departtime = $timestamp + ($nuits * 86400);
                    $depart = date("Y-m-d", $departtime); 
                }
                else
                {
                    return redirect('reservation_form')->with('error', 'Vous devez mettre au moins un nombre de jours ou de mois.');  
                }
                
            }
           
            //return $depart;
        }
        else // le jour est rempli et différent de zéro
        {
            //dd('cc');
            if($mois != 0)// le jours est différent de 0 et le mois aussi
            {
                //dd('tt');
                if($jours == 30 OR $jours == 31) // c'est copmme ci ca fait un mois 
                {
                    //dd('ll');
                    $departtime =strtotime('+1 month', $timestamp);
                    $add_month = strtotime('+'.$mois.' month', $departtime);
                    
                    $depart = date("Y-m-d", $add_month);
                    return $depart;
                    //echo $depart;
                }
                else 
                {
                    if($nuits != 0)// il a rempli le nombre de nuit le jours
                    {
                        $departtime = strtotime('+'.$mois.' month', $timestamp);
                        $the_final = strtotime('+'.($jours+$nuits).' days', $departtime);
                        $depart = date("Y-m-d", $the_final); 

                        return $depart;
                    }
                    else
                    {
                        $departtime = strtotime('+'.$mois.' month', $timestamp);
                        $the_final = strtotime('+'.$jours.' days', $departtime);
                        $depart = date("Y-m-d", $the_final);
                        return $depart;
                    }
                  
                }
            }
            else //le mois est 0 c'est le jours seul qui est différent de zéro
            {
                if($nuits != 0)// il a rempli le nombre de nuit le jours
                {
                    $departtime = $timestamp + (($jours+$nuits) * 86400);

                    $depart = date("Y-m-d", $departtime); 
                    //dd($depart);
                    return $depart;
                }
                else
                {
                    $departtime = $timestamp + ($jours * 86400);
                    $depart = date("Y-m-d", $departtime); 
                    return $depart;   
                }

               
            }


           
        }

        

    }


    public function SommeCustomers()
    {
        //Calculer le nombre total de clients enregistrés

        $get = Client::all()->count();

        //dd($get);

        return $get;
    }

    public function SommeUsers()
    {
        //Calculer le nombre total de clients enregistrés

        $get = Utilisateur::all()->count();

        //dd($get);

        return $get;
    }

    public function SommeApparts()
    {
        //Calculer le nombre total de clients enregistrés

        $get = Appart::all()->count();

        //dd($get);

        return $get;
    }

    public function SommeReservations()
    {
        //Calculer le nombre total de clients enregistrés

        $get = Reservation::where('validate', 1)->count();

        //dd($get);

        return $get;
    }

    public function MonthlyEarn()
    {
        //FAIRE UNE BOUCLE POUR TOUS LES MOIS DE L'ANNEE
        
        //LE TABLEAU QUI VA RECCUEILLIR LES DONNES 
        $data = [];

        //l'année en cours
        $year = date('Y');

        //LA BOUCLE DES 12 MOIS
        for($i = 1; $i <= 12; $i++)
        {
            $somme = 0;
            //nombre de jours dans le mois
            $number = cal_days_in_month(CAL_GREGORIAN, $î, $year);

            $first_date = $year."-".$i."01";
            $last_date = $year."-".$i."-". $number;
            //LA REQUETE MAINTENANT
            $get = Reservation::whereBetween("date_debut", [ $first_date, $last_date ])
                    ->where('validate', 1)
                    ->where('solder', 1)
                    ->get(['montant']);
            
            //FAIRE UN FOREACH POUR FAIRE LA SOMME
            foreach($get as $montant)
            {
                $somme = $somme + $montant->montant;
            }

            //METTRE DANS LE TABLEAU data
            array_push($data, $somme);
        }          
       return $data;

       
    }
}
