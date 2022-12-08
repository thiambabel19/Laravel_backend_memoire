<?php

namespace App\Http\Controllers;

use App\Http\Resources\DetailsVenteResource;
use App\Http\Resources\LotResource;
use App\Models\DetailsVente;
use App\Models\Lot;
use App\Models\Parametrage;
use App\Models\Vente;
use Illuminate\Http\Request;

class VenteController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    //liste des ventes
    public function getAllVentes(){
        return response()->json(Vente::all(), 200);
    }

    //Retourner une vente
    public function getVenteById($id){

        $vente = Vente::find($id);

        if(is_null($vente)){
            return response()->json(['message' => 'Vente introuvable'], 404);
        }else{
            return response()->json(Vente::find($id), 200);
        }
    }

    //ajouter une vente
    public function addVente(Request $request){
        $today = date('Y-m-d');
        $req = Parametrage::find(1);

        if($request->qteVendue > $request->qteStocker){
            return response()->json(['message' => 'Le stock disponible pour ce médicament est de : '.$request->qteStocker]);
        }

        $vente = new Vente();
        $vente->numVente = $req->numVente;
        $vente->dateVente = $request->dateVente;
        $vente->typeVente = $request->typeVente;
        $vente->user_id = $request->user_id;
        $vente->save();

        if($vente){
            $req->numVente += 1;
            $req->update();

            $lot = Lot::find($request->lots_id);
            $lot->qteStocker = $lot->qteStocker - $request->qteVendue;
            $lot->update();

            $detVente = new DetailsVente();
            $detVente->ventes_id = $vente->id;
            $detVente->lots_id = $request->lots_id;
            $detVente->qteVendue = $request->qteVendue;
            $detVente->montant = $request->montant;
            $detVente->user_id = $request->user_id;
            $detVente->save();

        }

        return response()->json($detVente);
    }

    //mise à jour d'une vente
    public function updateVente(Request $request, $id){

        $vente = Vente::find($id);

        if(is_null($vente)){
            return response()->json(['message' => 'Vente introuvable'], 404);
        }
        else
        {
            $vente->update($request->all());
            return response($vente, 200);
        }

    }

    //Supprimer une vente
    public function deleteVente($id){

        $vente = Vente::find($id);

        if(is_null($vente)){
            return response()->json(['message' => 'vente introuvable'], 404);
        }
        else
        {
            $vente->delete();
            return response(200);
        }

    }

    //rechercher une vente
    public function searchVente($numVente){

        $v = Vente::where('numVente', 'like', '%'.$numVente.'%')->get();

        if(is_null($v)){
            return response()->json(['message' => 'Vente introuvable'], 404);
        }else{
            return $v;
        }
    }

    public function getFilterDateVente(Request $request){
        $vente = DetailsVente::select('numVente', 'nomCommercial as medicament', 'dateVente', 'qteVendue',
            'prixUnitaire', 'typeVente', 'numero as numLot', 'name as nomVendeur', 'montant', 'name as utilisateur')
            ->where('dateVente','>=', $request->dateDebut)->where('dateVente','<=', $request->dateFin)
            ->join('ventes', 'ventes.id', '=', 'details_ventes.ventes_id')
            ->join('lots', 'lots.id', '=', 'details_ventes.lots_id')
            ->join('medicaments', 'medicaments.id', '=', 'lots.medicaments_id')
            ->join('users', 'users.id', '=', 'details_ventes.user_id')
            //->join('users', 'users.id', '=', 'ventes.user_id')
            ->get();

        if($vente){
            return response()->json($vente);
        }
        else{
            return response()->json(['Message' => 'Pas de vente sur cette période ...']);
        }
    }

    public function getVenteToDate(){
        $today = date('Y-m-d');
        $vente = DetailsVente::select('nomCommercial as medicament', 'qteVendue', 'montant')
        ->where('dateVente', $today)
        ->join('ventes', 'ventes.id', '=', 'details_ventes.ventes_id')
        ->join('lots', 'lots.id', '=', 'details_ventes.lots_id')
        ->join('medicaments', 'medicaments.id', '=', 'lots.medicaments_id')
        ->join('users', 'users.id', '=', 'details_ventes.user_id')
        ->get();

        if($vente){
            return response()->json($vente);
        }
        else{
            return response()->json(['Message' => 'Pas encore de vente pour aujourd\'hui ...']);
        }

    }



}