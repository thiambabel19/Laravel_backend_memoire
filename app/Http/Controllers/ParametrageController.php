<?php

namespace App\Http\Controllers;

use App\Models\Parametrage;
use Illuminate\Http\Request;
use NumberFormatter;

class ParametrageController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function getNumLot(){
        $lastNumLot = Parametrage::all()->last()['numLot'];
        return response()->json($lastNumLot);
    }

    public function getNumMedicament(){
        $lastNumMedicament = Parametrage::all()->last()['numMedicament'];
        return response()->json($lastNumMedicament);
    }

    public function getNumCommande(){
        $lastNumCommande = Parametrage::all()->last()['numCommande'];
        return response()->json($lastNumCommande);
    }

    public function getNumfacture(){
        $lastNumFacture = Parametrage::all()->last()['numFacture'];
        return response()->json($lastNumFacture);
    }

    public function getNumVente(){
        $lastNumVente = Parametrage::all()->last()['numVente'];
        return response()->json($lastNumVente);
    }

    public function getNumInventaire(){
        $lastNumInventaire = Parametrage::all()->last()['numInventaire'];
        return response()->json($lastNumInventaire);
    }

}
