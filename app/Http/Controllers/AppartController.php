<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Client;
use App\Models\Appart;
use DB;

use Illuminate\Support\Facades\File;

class AppartController extends Controller
{
   //Il gère les appartements
    //NB: en fonction de la vue et de l'afficahe, on extraira les données par 3

    public function getWithId($id)
    {
        $get = DB::table('apparts')->join('typeapparts', 'typeapparts.id_type_appart', '=', 'apparts.id_type_appart')->where('apparts.id', '>', $id)->orderByRaw('apparts.id', 'asc')->get(['apparts.id', 'apparts.designation_appart', 'apparts.prix', 'apparts.nb_lit', 'apparts.nb_douche', 'apparts.path', 'apparts.path_descript1', 'apparts.path_descript2', 'apparts.path_descript3', 'apparts.note', 'apparts.internet_wifi', 'apparts.description', 'typeapparts.id_type_appart', 'typeapparts.libele_type_appart'])->take(3);
        
        //$get = DB::table('apparts')->where('id', '>=', $id)->get();

        return $get;
    }

    /*ublic function getAppartWithId($id)
    {
        $get = DB::table('apparts')->join('typeapparts', 'typeapparts.id_type_appart', '=', 'apparts.id_type_appart')->where('apparts.id', '!=', $id)->orderByRaw('apparts.id', 'asc')->get(['apparts.id', 'apparts.designation_appart', 'apparts.prix', 'apparts.nb_lit', 'apparts.nb_douche', 'apparts.path', 'apparts.path_descript1', 'apparts.path_descript2', 'apparts.path_descript3', 'apparts.note', 'apparts.internet_wifi', 'apparts.description', 'typeapparts.id_type_appart', 'typeapparts.libele_type_appart']);
        
        //$get = DB::table('apparts')->where('id', '>=', $id)->get();

        return $get;
    }*/

    /*$req = Customer::join('requestings', 'requestings.id', '=', 'customers.id')->where('requestings.id_status', '<>', '4')->orderByRaw('requestings.requesting_date DESC')->get(['customers.firstname', 'customers.lastname', 'customers.user_tel', 'requestings.device', 'requestings.object', 'requestings.requesting_date', 'requestings.id_requesting', 'requestings.duration', 'requestings.id_requesting']);*/

    public function CountAppart()
    {
        $nb = DB::table('apparts')->count();

        return $nb;
    }

    public function getFirstThree()
    {
        $get = DB::table('apparts')->join('typeapparts', 'typeapparts.id_type_appart', '=', 'apparts.id_type_appart')->orderByRaw('apparts.id', 'asc')->take(3)->get(['apparts.id', 'apparts.designation_appart', 'apparts.prix', 'apparts.nb_lit', 'apparts.nb_douche', 'apparts.path', 'apparts.path_descript1', 'apparts.path_descript2', 'apparts.path_descript3', 'apparts.note', 'apparts.internet_wifi', 'apparts.description', 'typeapparts.id_type_appart', 'typeapparts.libele_type_appart']);

        return $get;
    }

    public function GetLast($id)
    {
        $get = DB::table('apparts')->join('typeapparts', 'typeapparts.id_type_appart', '=', 'apparts.id_type_appart')->orderByRaw('apparts.id', 'asc')->where('apparts.id', '>', $id)->get(['apparts.id', 'apparts.designation_appart', 'apparts.prix', 'apparts.nb_lit', 'apparts.nb_douche', 'apparts.path', 'apparts.path_descript1', 'apparts.path_descript2', 'apparts.path_descript3', 'apparts.note', 'apparts.internet_wifi', 'apparts.description', 'typeapparts.id_type_appart', 'typeapparts.libele_type_appart'])->take(2);

        return $get;
    }

    public function GetMostAccurate()
    {
        $get = DB::table('apparts')->join('typeapparts', 'typeapparts.id_type_appart', '=', 'apparts.id_type_appart')->orderByRaw('apparts.id', 'asc')->where('apparts.note', '>=', 4)->get(['apparts.id', 'apparts.designation_appart', 'apparts.prix', 'apparts.nb_lit', 'apparts.nb_douche', 'apparts.path', 'apparts.path_descript1', 'apparts.path_descript2', 'apparts.path_descript3', 'apparts.note', 'apparts.internet_wifi', 'apparts.description', 'typeapparts.id_type_appart', 'typeapparts.libele_type_appart']);

        return $get;
    }

    public function AppartBusy($id)
    {
        //Recupérer les appartements qui sont libre actuellement

        $today = date('Y-m-d');

        $get =  DB::table('reservations')->join('apparts', 'apparts.id', '=', 'reservations.id')->where('date_fin', '<',$today)->where('validate', 1)->where('reservations.id', '=', $id)->get(['apparts.id', 'apparts.designation_appart', 'apparts.prix', 'apparts.path', 'reservations.date_debut', 'reservations.date_fin']);

        return $get;
    }

    public function AllAppart()
    {
        $get = DB::table('apparts')->join('typeapparts', 'typeapparts.id_type_appart', '=', 'apparts.id_type_appart')->orderByRaw('apparts.id', 'asc')->get(['apparts.id', 'apparts.designation_appart', 'apparts.prix', 'apparts.nb_lit', 'apparts.nb_douche', 'apparts.path', 'apparts.path_descript1', 'apparts.path_descript2', 'apparts.path_descript3', 'apparts.note', 'apparts.internet_wifi', 'apparts.description', 'typeapparts.id_type_appart', 'typeapparts.libele_type_appart']);

        return $get;
    }


    public function AddAppart(Request $request)
    {
        $le_nom = $request->thename;
        $type = $request->type;
        $prix = $request->prix;
        $lits = $request->lits;
        $douches = $request->douches;
        $wifi = $request->wifi;
        $description = $request->description;
        $image = $request->photo;

        //dd($image);

        //stocker l'image
        //Storage::disk('public')->put('articles', $image);

        //enregistrement de fichier dans la base
        $file_name = $image->getClientOriginalName();
    
                
        $path = $request->file('photo')->storeAs(
            'articles/apparts', $file_name, 'public'
        );

        //dd($path);
        //on passe à la sauvegarde maintenant
        $appart = new Appart(['designation_appart' => $le_nom, 'id_type_appart' => $type,  'prix' => $prix, 'nb_lit' => $lits, 'nb_douche' => $douches, 'path' => $path, 'internet_wifi' => $wifi, 'description' =>  $description]);
        $appart->save();

        return redirect('add_appart')->with('success', 'enregistrement effectué avec succès!');

        
    }

    public function DeleteAppart()
    {
        $id_appart =  request('id_appart');

        //recupérer le chemain d'accès de l'appart On veut supprimer le fichier dans le dossier de stockage
        $path_appart = Appart::where('id', $id_appart)->first();

        $fichier = storage_path().'/app/public/'.$path_appart->path;
        //dd($fichier);
       
        $var = File::delete($fichier);

        //dd($var);
        
        $deleted = DB::table('apparts')->where('id', '=', $id_appart)->delete();

        return redirect('appartements_gest')->with('success', 'Appartement supprimé');  
    }

    public function EditAppartForm(Request $request)
    {
        return view('admin/edit_appart_form', [
            'id' => $request->id_appart,
            ]);
    }

    public function DetailsAppartView(Request $request)
    {
        return view('admin/appart_about', [
            'id' => $request->id_appart,
            ]);
    }

    public function GetAppartById($id)
    {
        $get = DB::table('apparts')
        ->where('id', $id)
        ->join('typeapparts', 'typeapparts.id_type_appart', '=', 'apparts.id_type_appart')
        ->get(['apparts.id', 'apparts.designation_appart', 'apparts.prix', 'apparts.nb_lit', 'apparts.nb_douche', 'apparts.path', 'apparts.path_descript1', 'apparts.path_descript2', 'apparts.path_descript3', 'apparts.note', 'apparts.internet_wifi', 'apparts.description', 'typeapparts.id_type_appart', 'typeapparts.libele_type_appart']);

        //dd($get);
        return $get;
    }

    public function EditAppart(Request $request)
    {
        $le_nom = $request->thename;
        $type = $request->type;
        $prix = $request->prix;
        $lits = $request->lits;
        $douches = $request->douches;
        $wifi = $request->wifi;
        $description = $request->description;
        $image = $request->photo;

        //dd($image);

        //stocker l'image
        //Storage::disk('public')->put('articles', $image);

        //enregistrement de fichier dans la base
        if($image)
        {
            $file_name = $image->getClientOriginalName();

            $path = $request->file('photo')->storeAs(
                'articles/apparts', $file_name, 'public'
            );

            $update_file = DB::table('apparts')
                ->where('id', $request->id_appart)
                ->update(['path' => $path]);
                //dd($update_sans_en);
        }
        

        //dd($path);
        //on passe à la sauvegarde maintenant
        $appart_update = DB::table('apparts')
            ->where('id', $request->id_appart)
            ->update(['designation_appart' => $le_nom, 'id_type_appart' => $type,  'prix' => $prix, 'nb_lit' => $lits, 'nb_douche' => $douches, 'internet_wifi' => $wifi, 'description' =>  $description]);
        //$appart->save();

        return redirect('appartements_gest')->with('success', 'Modification effectué avec succès!');
    }


}
