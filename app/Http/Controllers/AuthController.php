<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

use App\Models\Utilisateur;

class AuthController extends Controller
{
    //Gère les connexion et les déconnexion

    public function logoutAdmin(Request $request)
    {
        Auth::logout();
     
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();

        //dd(session('pseudo'));
        return  redirect()->route('loginAdmin');
    }

    public function logoutUser(Request $request)
    {
        Auth::logout();
     
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();

        //dd(session('pseudo'));
        return  redirect()->route('login');
    }

    public function AdminLogin(Request $request)
    {
        //dd('ici');
        //Vérifier son département d'abord
        //On va vérifier mlaientenant si le département choisi est le bon
        $departement = Utilisateur::where('login', $request->login)->first()->id_departement;
        //$f = Hash::make($request->password);
        //dd($f);
        if($departement == $request->departement)
        { 
            //dd(Auth::guard('admin')->attempt(['login' => $request->login, 'password' => $request->password]));
            //dd(Auth::guard('admin')->attempt(['login' => $request->login, 'passe' => $request->passe, ]));
            if (Auth::guard('admin')->attempt(['login' => $request->login, 'password' => $request->password, ])) 
            {
                // Authentication was successful...
                //dd(Auth::guard('admin')->attempt(['pseudo' => $request->login, 'password' => $request->pass, ]));
    
                $request->session()->regenerate();//regeneger la session
    
                return redirect()->route('mydash'); //si l'utilisateur était sur une ancienne page après la connexion ca le renvoi la bas dans le cas contraire sur la page d'accueil welcome
    
            }
            return back()->with('error', 'Utilisateur inexistant, mot de passe ou login incorrect');
        }
        else
        {
            return redirect('login_admin')->with('error', 'Vous n\'êtes pas dans ce département. Essayez un autre SVP');
        }
    

        
    }

    public function UserLogin(Request $request)
    {
        //dd('coiucou');
        //dd($request->password);
        //Vérifier si c'est un utilisateur qui se connecte
        //$user_password = Hash::make($request->password);
        //dd($user_password);
        //dd(Auth::guard('web')->attempt(['email' => $request->login, 'password' => $request->password]));
        //dd(Auth::guard('web')->attempt(['tel' => $request->login, 'password' => $request->password ]));
        //dd($request->password);
        if (Auth::guard('web')->attempt(['email' => $request->login, 'password' => $request->password])) 
        {
            // Authentication was successful...

            $request->session()->regenerate();//regeneger la session

            //dd(Auth::guard('admin')->user());

            return redirect()->intended(route('myspace')); //si l'utilisateur était sur une ancienne page après la connexion ca le renvoi la bas dans le cas contraire sur la page d'accueil welcome

        }
        else
        {
            if (Auth::guard('web')->attempt(['tel' => $request->login, 'password' => $request->password ])) 
            {
                // Authentication was successful...

                $request->session()->regenerate();//regeneger la session

                //dd(Auth::guard('admin')->user());

                return redirect()->intended(route('myspace')); //si l'utilisateur était sur une ancienne page après la connexion ca le renvoi la bas dans le cas contraire sur la page d'accueil welcome

            }
            else{
                return back()->with('error', 'Utilisateur inexistant, mot de passe ou login incorrect');
            }
            
        }  
       

    }
}
