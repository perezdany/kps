<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use App\Models\Depense;

class DepensesController extends Controller
{
    //Gère les dépense effectuées

    public function DisplayAll()
    {
        $get = DB::table('depenses')
            ->join('apparts', 'depenses.id_appart', '=', 'apparts.id' )
            ->get(['depenses.*', 'apparts.*']);

        return $get;
    }

    public function SaveDepense(Request $request)
    {
        $objet = $request->objet;
        $appart = $request->appart;
        $date = $request->date;
        $montant = $request->montant;

    
        $depenses = new Depense(['libele_depense' => $objet, 'id_appart' => $appart,  'date' => $date, 'montant_depenses' => $montant, ]);
        $depenses->save();

        return redirect('depenses')->with('success', 'Enregistrement effectué');
    }

    public function DeleteDepense(Request $request)
    {
        $deleted = DB::table('depenses')->where('id_depense', '=', $request->id_depense)->delete();

        //var_dump($deleted);
        return redirect('depenses')->with('success', 'Suppression effectuée');
    }

    public function edit_depense_form(Request $request)
    {
        return view('admin/edit_depense_form', [
            'id' => $request->id_depense,
            ]);
    }

    public function editDepense(Request $request)
    {
        $depense_update = DB::table('depenses')
            ->where('id_depense', $request->id_depense)
            ->update(['libele_depense' => $request->objet, 'id_appart' =>  $request->appart, 'date' => $request->date, 'montant_depenses' => $request->montant]);

        return redirect('depenses')->with('success', 'Modification effectuée avec succès');
    }

    public function GetDepenseById($id)
    {
       $get = DB::table('depenses')
            ->where('id_depense', $id)
            ->join('apparts', 'depenses.id_appart', '=', 'apparts.id' )
            ->get(['depenses.*', 'apparts.*']);

        return $get;
    }
}
