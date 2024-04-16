<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Departement;

use DB;

class DepartementController extends Controller
{
    //Il gère tout ce qui concerne les département

    public function DisplayAllDepartments()
    {
        $get = Departement::all();

        return $get;
    }

    public function AddDepartement()
    {
        $departement = request('departement');

        $query = new Departement(['desig_departement' => $departement]);
        $query->save();

        
        return redirect('add_departement')->with('success', 'Enregistrement effectué');
    }

    public function getADepartment($id)
    {
        $get = Departement::where('id_departement', $id)->first();

        //dd($get);
        return $get;

    }

    public function DeleteDepartement()
    {
        $id_departement =  request('id_dep');
        
        $deleted = DB::table('departements')->where('id_departement', '=', $id_departement)->delete();

        //var_dump($deleted);
        return redirect('departements')->with('success', 'Département supprimé');
    }

    public function UpdateDepartement()
    {
         $dep = htmlspecialchars(request('id_departement'));
        
        $affected = DB::table('departements')
          ->where('id_departement', $dep)
          ->update(['desig_departement' => request('departement')]);
       
        return redirect('departements')->with('success', 'Département modifié');
    }
}
