<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Client;
use App\Models\Contact;
use App\Models\Utilisateur;
use App\Models\Departement;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Mail\MailConfirmUser;
use App\Mail\Newsletter;
use App\Mail\ContactMessage;
use App\Mail\ResetPasswordMail;
use DB;

class UserController extends Controller
{
    //Controler qui se charge des connexion des utilisateur et autre

    public function loginclient()
    {
        if( session()->has('nom'))
        {
            return view('customer/my_space');
        }
        else
        {
            return view('customer/customer_login');
        }
    }

    public function my_space()
    {
        
        return view('customer/my_space');
        
    }

    public function loginAdminView()
    {
       

        return view('admin/login_admin');
        
    }

    public function myDash()
    {
        //CODE POUR LA CONCEPTION DU GRAPH DES DEPENSES MENSUELLES

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
            $number = cal_days_in_month(CAL_GREGORIAN, $i, $year);
           
            $first_date = $year."-".$i."-01";
            $last_date = $year."-".$i."-". $number;
            //dd($first_date);
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
             //dd($data);
            //var_dump(count($data));
        }          
       
        return view('admin/dashboard', compact('data'));
        
    }


    public function CustomerRegister()
    {
        //ici c'est le client qu s'inscrit. vici son script creatcustomer sera pur l'admin
        $name = request('name');
        $user_email = request('email');
        $user_tel = request('tel');
        $user_addres = request('adresse');
        $user_password = Hash::make(request('password'));
        $confirm_pass = Hash::make(request('confirm_pass'));
        $today =  date('Y-m-d');
        
        //NB: ECRIRE UN CODE JS POUR VERIFIER SI LA CONFIRMATION DU MOT DE PASSE ENTTRE CORRESPOND PAS(fait)
        
        //FAIRE AUSSi UN CODE DE SECUITE POUR NE PAS QUE L'UTILISATEUR S'ENREGISTRE PLUSEUR FOIS AVEC LE MEME MAIL c'est deja fait avec verify_exist
        $verify_exist = Client::where('email', $user_email)->first();
        if($verify_exist)
        {
            return redirect('customer_register')->with('error', 'Ce mail est déja utilisé');
        }
        else
        {
            //var_dump($user_email);
                $customer = new Client(['nom_prenoms' => $name, 'email' => $user_email,  'tel' => $user_tel, 'adress_geo' => $user_addres, 'password' => $user_password, 'confirmation_token' => str_replace("/", '', bcrypt(Str::random(10))), 'accepted_terms' => false, 'member_since' => $today]);
                $customer->save();
                $geter = Client::where('email', $user_email)->first();
                //dd($geter->id);
                //envoi du mail de confirmation ; appel de la classe en fait
                //event(new Registered $customer);
                $url = config('app.url')."/confirm/".$geter->id."/".$geter->confirmation_token;

                //echo $url; 
                
                $data = ['email' => $user_email, 'id_client' => $geter->id_client, 'token' => $geter->confirmation_token, 'url' => $url];
          
                Mail::to($user_email)->send(new MailConfirmUser($data));
                //echo $name."/".$user_email."/".$user_tel."/".$user_addres."/".$user_password."/";
                
                //customer->notify(new RegisterConfirmationNotif());
            
        
        }

        
        //('add_customer')
        //rediriger l'utisateur vers la case départ 
        //on va vérifier si c'est l'admin qui ajoute un utilisateurr dans ce cas on va rediriger vers sa pateforme
      
        return redirect('customer_register')->with('success', 'Enregistrement effectué avec succès! Un email a été envoyé à l\'adresse '.$user_email.' Consultez votre boîte mail afin de confirmer cet email');

    }

    public function GetByEmail($email)
    {
        $get = Client::where('email', '=', $email)->first();

        //dd($get->id_client);
        return $get;
    }


    public function confirm($id, $token)
    {
        //on va vérifier que l'id et le token qui est renvoyé exste bel et bien dans la base donc appartient a un utilisateur
        $user =  Client::where('id', $id)->where('confirmation_token', $token)->first();
        //var_dump($user);
        if($user)
        {
            //le champ confirmation_token des utilisateurs confirmé apres enregistrement doit être toujours  vide

            //$user->update(['confirmation_token' => null]);
            //$this->guard()->login($user);
            
            //var_dump($id);
            $affected = DB::table('clients')
              ->where('id', $id)
              ->update(['confirmation_token' => null]);
            //var_dump($affected);

            //rediriger vers la page de login avec un message de succes
            return redirect('customer_login')->with('success', 'Votre mail a bien été confirmé! Vous pouvez vous connecter');
        }
        else
        {
            //donc on le retourne encore  a la page de login
            return redirect('customer_login')->with('error', 'Ce lien ne semble plus valide');
            
        }
    }

    public function customerLogin()
    {
        if( $user = (DB::table('clients')->whereEmail(request('login'))->count() > 0) OR ($user = DB::table('clients')->whereTel(request('login'))->count() > 0))
        {
            //on veut vérifier la correspondance du mot de passe hashé 
            
            
            //vérifier c'est quel infos il a entré le numéro ou le mail
            $theuser = Client::where('email', request('login'))->first();
            if($theuser)
            {
                //dd(request('password'));
                if($theuser->confirmation_token == null) //vérifier que le token est null
                {
                    //c'est un compte qui est validé
                    //vérifier maintenant que c'est sa première connexion

                     
                    
                    $secret = Client::where('email', request('login'))->first()->mdp;
                    $t = Hash::make(request('password'));
                   

                    if(Hash::check(request('password'), $secret))//ca veut dire que le hashage match
                    {
                        if($theuser->login_counter == null AND $theuser->accepted_term == false)
                        {
                            session(['theuser' => $theuser]);
                            session(['nom' => $theuser->nom_prenoms]);
                           
                            $affected = DB::table('clients')->where('id_client', $theuser->id)
                            ->update(['count_login' => 1]);

                            //on va le faire valider les termes de contrats après
                            return view('customer/my_space');
                        }
                        else
                        {   
                            session(['theuser' => $theuser]);
                            session(['nom' => $theuser->nom_prenoms]);
                            return view('customer/my_space');
                        }

                        

                    }
                    else
                    {
                        //dd(strval($secret));
                        //dd(Hash::make(request('password')));
                        return redirect()->route('connexion')->with('error', 'Mot de passe incorrect');

                    }
                    
                }
                else
                {
                     return redirect()->route('connexion')->with('error', 'Utilisateur inexistant');
                }
            }
            else
            {
                //c'est so numéro tél il a pris
                
                $theuser = Client::where('tel', request('login'))->first();
                if($theuser->confirmation_token == null)
                {
                    $secret = Client::where('tel', request('login'))->first()->mdp; 
                    if(Hash::check(request('password'), $secret))//ca veut dire que le hashage match
                    {

                        if($theuser->login_counter == null AND $theuser->accepted_term == false)
                        {
                            session(['theuser' => $theuser]);
                            session(['nom' => $theuser->nom_prenoms]);
                           
                            $affected = DB::table('clients')->where('id_client', $theuser->id)
                            ->update(['count_login' => 1]);

                            //on va le faire valider les termes de contrats après
                            return view('customer/my_space');
                        }
                        else
                        {   
                            session(['theuser' => $theuser]);
                            session(['nom' => $theuser->nom_prenoms]);
                            return view('customer/my_space');
                        }

                    }
                    else
                    {
                        //dd(strval($secret));
                        //dd(Hash::make(request('password')));
                        return redirect()->route('connexion')->with('error', 'Mot de passe incorrect');

                    }

                    
                }
                else
                {
                     return redirect()->route('connexion')->with('error', 'Utilisateur inexistant');
                }
            }
            
           
           
        }
        else
        {
            
           return redirect()->route('connexion')->with('error', 'Email inexistant/utilisateur inexistant');
        }
       
    }

    public function Newsletter()
    {
        // permettre l'enregistrement des contacts qui souhaient avoir une newsletter

        $mail =  htmlspecialchars(request('contact'));
        $date = date("Y-m-d");

        //var_dump($mail);
        //enregistrement
        $customer = new Contact(['mail_contact' => $mail, 'date_ajout' => $date]);
        $customer->save();

        $geter = Contact::where('mail_contact', $mail)->first();

        //envoi de la notification
        $url = config('app.url')."/unsuscribe/".$geter->id."/".$mail;
        $data = ['email' => $mail, 'id' => $geter->id_contact, 'url' => $url];
  
        Mail::to($mail)->send(new Newsletter($data));

        return redirect('customer_login')->with('success', 'Email enregistré avec succès! vous recevrez une notification à l\'adresse '.$mail.'');


    }

    public function Unsuscribe($id)
    {
        //désabonnement $deleted = DB::table('users')->where('votes', '>', 100)->delete();

        $deleted = DB::table('contacts')->where('id_contact', '=', $id)->delete();

        return redirect('customer_login')->with('success', 'Vous vous êtes désabonné avec succès');
    }

    public function ContactUs()
    {
        //Code pour le formulaire conactez nous

        $name =  htmlspecialchars(request('name'));
        $subject =  htmlspecialchars(request('subject'));
        $message = htmlspecialchars(request('msg'));
        $email  =  htmlspecialchars(request('email'));

        //les valeur a passer pour le Mail
        $data = ['name' => $name, 'subject' => $subject, 'message' => $message, 'email' => $email];

        $mail = 'contact@example.com';

        //envoie du mail
        $email = new ContactMessage($data);

        Mail::to($mail)->send($email);
        //Mail::to('info@example.com')->send(new ContactMessage($data));

        return redirect('contact')->with('success', 'Votre message a bien été envoyé Nous vous répondrons dans les plus bref délais');

    }

    public function RegisterUser()
    {
        //Enregistrer un utilisateur de l'administration
         //ici c'est le client qu s'inscrit. vici son script creatcustomer sera pur l'admin
        $name = $request->name;
        $user_email = $request->email;
        $user_tel = $request->tel;
        $login = $request->login;
        $user_password = Hash::make($request->pass);
        $confirm_pass = Hash::make(request('confirm_pass'));
        $departement = $request->departement;
        $poste = $request->poste;
        
        //NB: ECRIRE UN CODE JS POUR VERIFIER SI LA CONFIRMATION DU MOT DE PASSE ENTTRE CORRESPOND PAS(fait)
        
        //FAIRE AUSSi UN CODE DE SECUITE POUR NE PAS QUE L'UTILISATEUR S'ENREGISTRE PLUSEUR FOIS AVEC LE MEME MAIL c'est deja fait avec verify_exist
        $verify_exist = Utilisateur::where('email_users', $user_email)->first();
        if($verify_exist)
        {
            return redirect('register_user')->with('error', 'Ce mail est déja utilisé');
        }
        else
        {
            //var_dump($user_email);
                $customer = new Utilisateur(['nom_prenoms_users' => $name, 'email_users' => $user_email,  'tel_users' => $user_tel, 'password' => $user_password, 'login' => $login, 'id_departement' => $departement, 'libele_poste' => $poste]);
                $customer->save();
                return redirect('register_user')->with('success', 'Enregistrement effectué avec succès! Voous povez dès à présent vous connecter');

        
        }
      
        
    }

    public function LoginUser()
    {
        $theuser = Utilisateur::where('login', request('login'))->first();
        if($theuser)
        {
            //on veut vérifier la correspondance du mot de passe hashé 
      
            $secret = Utilisateur::where('login', request('login'))->first()->passe;
            //$t = Hash::make(request('passe'));
           
            if(Hash::check(request('passe'), $secret))//ca veut dire que le hashage match
            {
               
                //On va vérifier mlaientenant si le département choisi est le bon
                $departement = Utilisateur::where('login', request('login'))->first()->id_departement;
                if($departement == request('departement'))
                {
                    session(['theadmin' => $theuser]);
                    session(['pseudo' => $theuser->nom_prenoms_users]);
                    return view('admin/dashboard');
                }
                else
                {
                    return redirect('login_admin')->with('error', 'Vous n\'êtes pas dans ce département. Essayez un autre SVP');
                }
            
            }
            else
            {
                //dd(strval($secret));
                //dd(Hash::make(request('password')));
                return redirect('login_admin')->with('error', 'Mot de passe incorrect');

            }
  
            
        }
        else
        {
             return redirect('login_admin')->with('error', 'Utilisateur inexistant');
        }
    }

    public function displayAllCustomers()
    {
        $get = Client::All();

        return $get;
    }

     public function displayAllUsers()
    {
        $get = DB::table('utilisateurs')->join('departements', 'departements.id_departement', '=', 'utilisateurs.id_departement')
        ->get(['utilisateurs.id', 'utilisateurs.nom_prenoms_users', 'utilisateurs.email_users', 'utilisateurs.tel_users', 'utilisateurs.libele_poste', 'utilisateurs.user_since', 'departements.desig_departement']);

        return $get;
    }

    public function AddCustomer(Request $request)
    {
        //ici c'est l'admin qui ajoute

        //ici c'est le client qu s'inscrit. vici son script creatcustomer sera pur l'admin
        $name = $request->thename;
        $user_email = $request->email;
        $user_tel = $request->tel;
        $user_addres = $request->adresse;
        $user_password = Hash::make($request->password);
        $confirm_pass = Hash::make($request->confirm_pass);
        $today = date('Y-m-d');

        //dd($name);
        
        //NB: ECRIRE UN CODE JS POUR VERIFIER SI LA CONFIRMATION DU MOT DE PASSE ENTTRE CORRESPOND PAS(fait)
        
        //FAIRE AUSSi UN CODE DE SECUITE POUR NE PAS QUE L'UTILISATEUR S'ENREGISTRE PLUSEUR FOIS AVEC LE MEME MAIL c'est deja fait avec verify_exist
        $verify_exist = Client::where('email', $user_email)->first();
        if($verify_exist)
        {
            return redirect('add_customer')->with('error', 'Ce mail est déja utilisé');
        }
        else
        {
            //var_dump($user_email);
                $customer = new Client(['nom_prenoms' => $name, 'email' => $user_email,  'tel' => $user_tel, 'adress_geo' => $user_addres, 'password' => $user_password, 'confirmation_token' => str_replace("/", '', bcrypt(Str::random(10))), 'accepted_terms' => false, 'member_since' => $today]);
                $customer->save();
                $geter = Client::where('email', $user_email)->first();
                //envoi du mail de confirmation ; appel de la classe en fait
                //event(new Registered $customer);
                $url = config('app.url')."/confirm/".$geter->id_client."/".$geter->confirmation_token;

                //echo $url; 
                
                $data = ['email' => $user_email, 'id_client' => $geter->id_client, 'token' => $geter->confirmation_token, 'url' => $url];
          
                Mail::to($user_email)->send(new MailConfirmUser($data));
                //echo $name."/".$user_email."/".$user_tel."/".$user_addres."/".$user_password."/";
                
                //customer->notify(new RegisterConfirmationNotif());
            
        
        }

        
        //('add_customer')
        //rediriger l'utisateur vers la case départ 
        //on va vérifier si c'est l'admin qui ajoute un utilisateurr dans ce cas on va rediriger vers sa pateforme
      
        return redirect('add_customer')->with('success', 'Enregistrement effectué avec succès! Un email a été envoyé à l\'adresse '.$user_email.' Consultez votre boîte mail afin de confirmer cet email');

    }

    public function DeleteCustomer()
    {
        $id_customer =  request('id_client');
        
        $deleted = DB::table('clients')->where('id_client', '=', $id_customer)->delete();

        //var_dump($deleted);
        return redirect('customers')->with('success', 'Cet utilisateur a été retiré de la base');
    }

    public function DeleteUser()
    {
        $id_customer =  request('id_client');
        
        $deleted = DB::table('clients')->where('id_client', '=', $id_customer)->delete();

        //var_dump($deleted);
        return redirect('customers')->with('success', 'Cet utilisateur a été retiré de la base');
    }

    public function EditCustomerForm(Request $request)
    {
        return view('admin/edit_customer_form', [
            'id' => $request->id_client,
            ]);
    }

    public function GetCustomerById($id)
    {
        $get = Client::where('id', $id)->get();

        return $get;
    }

    public function EditCustomerPass(Request $request)
    {
        $user_password = Hash::make($request->password);
        //dd( $user_password);
        $customer_update = DB::table('clients')
        ->where('id', $request->id_customer)
        ->update(['password' => $user_password,]);
        //dd($customer_update);

        return redirect('customers')->with('success', 'Modification effectuée avec succès');
    }

    public function EditCustomerAccount(Request $request)
    {
        //ici c'est le client qu s'inscrit. vici son script creatcustomer sera pur l'admin
        $name = $request->thename;
        $user_email = $request->email;
        $user_tel = $request->tel;
        $user_addres = $request->adresse;
       

        $customer_update = DB::table('clients')
            ->where('id', $request->id_customer)
            ->update(['nom_prenoms' => $name, 'email' =>  $user_email, 'tel' => $user_tel, 'adress_geo' => $user_addres]);

        return redirect('customers')->with('success', 'Modification effectuée avec succès');
    }

    public function EditAdminForm(Request $request)
    {
        return view('admin/edit_admin_form', [
            'id' => $request->id_user,
            ]);
    }

    public function EditAdmin(Request $request)
    {
        $name = $request->name;
        $user_email = $request->email;
        $user_tel = $request->tel;
        $login = $request->login;
        $departement = $request->departement;
        $poste = $request->poste;

        $customer_update = DB::table('utilisateurs')
        ->where('id', $request->id_user)
        ->update(['nom_prenoms_users' => $name, 'email_users' =>  $user_email, 'tel_users' => $user_tel, 'login' => $login, 'id_departement' => $departement, 'libele_poste' => $poste]);

        return redirect('users')->with('success', 'Modification effectuée avec succès');
    }

    public function EditAdminPassword(Request $request)
    {
        $user_password = Hash::make($request->pass);

        $customer_update = DB::table('utilisateurs')
        ->where('id', $request->id_user)
        ->update(['password' => $user_password ]);

        return redirect('users')->with('success', 'Mot de passe modifié avec succès');
    }

    public function GetAdminById($id)
    {
        $get = DB::table('utilisateurs')
                    ->where('id', $id)
                    ->join('departements', 'utilisateurs.id_departement', '=', 'departements.id_departement')
                    ->get(['utilisateurs.*', 'departements.*']);
        return $get;
    }

    public function GetLastestCusomer()
    {
        $get = DB::table('clients')
        ->orderByRaw('member_since  DESC')
        ->take(5)
        ->get();

        return $get;
    }

    public function GetLastestAdmin()
    {
        $get = DB::table('utilisateurs')
        ->orderByRaw('user_since  DESC')
        ->take(5)
        ->get();

        return $get;
    }

    public function displayMyProfile(Request $request)
    {
        //dd('ici');
        return view('customer/my_profile', [
            'id' => $request->id_user,
            ]);
    }

    public function EditMyAccountCustomer(Request $request)
    {
          //ici c'est le client qu s'inscrit. vici son script creatcustomer sera pur l'admin
          $name = $request->name;
          $user_email = $request->email;
          $user_tel = $request->tel;
          $user_addres = $request->adresse;
         
  
          $customer_update = DB::table('clients')
              ->where('id', $request->id_customer)
              ->update(['nom_prenoms' => $name, 'email' =>  $user_email, 'tel' => $user_tel, 'adress_geo' => $user_addres]);
  
          return redirect('my_space')->with('success', 'Modification effectuée avec succès');
    }

    public function EditMyCustommerPassword(Request $request)
    {
        $user_password = Hash::make($request->password);
        //dd( $user_password);
        $customer_update = DB::table('clients')
        ->where('id', $request->id_customer)
        ->update(['password' => $user_password,]);
        //dd($customer_update);

        return redirect('my_space')->with('success', 'Modification effectuée avec succès');
    }

    public function VerifResetCustomerPassword(Request $request)
    {
        $email = $request->email;

        $le_client = Client::where('email', $email)->first();

        if($le_client != null)
        {
            $url = config('app.url')."/reset_pass_form/".$le_client->id;

            //echo $url; 
            
            $data = ['id_client' => $le_client->id,  'url' => $url];
      
            Mail::to($email)->send(new ResetPasswordMail($data));

            return redirect('forget_pass_form')->with('success', 'Un mail a été envoyé à '. $email. 'consultez votre boîte mail');
           /* return view('reset_pass_form', [
                'id' => $le_client->id,
                ] );*/
        }
        return redirect('forget_pass_form')->with('error', 'L\'adresse mail renseignée n\'existe pas');
    }

    public function ResetPassCustomerForm($id)
    {
        return view('reset_pass_form', [
            'id' => $id,
            ] );
    }

    public function ResetMyPassword(Request $request)
    {

    }

}
