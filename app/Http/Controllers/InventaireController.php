<?php

namespace App\Http\Controllers;

use App\Models\Lot;
use App\Models\Vente;
use App\Models\Commande;
use App\Models\DetailsInventaire;
use App\Models\Inventaire;
use App\Models\Medicament;
use App\Models\Parametrage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class InventaireController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    //liste des inventaires
    public function getAllInventaires(){
        return response()->json(Inventaire::all(), 200);
    }

    //Retourner un inventaire
    public function getInventaireById($id){

        $inventaire = Inventaire::find($id);

        if(is_null($inventaire)){
            return response()->json(['message' => 'Inventaire introuvable'], 404);
        }else{
            return response()->json(Inventaire::find($id), 200);
        }
    }

    //ajouter un inventaire
    public function addInventaire(Request $request){
        //$inventaire = Inventaire::create($request->all());
        $inventaire = new Inventaire();
        $inventaire->numInventaire = $request->numInventaire;
        $inventaire->dateInventaire = $request->dateInventaire;
        $inventaire->user_id = $request->user_id;
        $inventaire->save();

        $parametrage = Parametrage::find(1);
        $parametrage->numInventaire += 1;
        $parametrage->update();

        //$this->addDetailsInventaire();

        return response($inventaire, 200);
    }

    //mise à jour d'un inventaire
    public function updateInventaire(Request $request, $id){

        $inventaire = Inventaire::find($id);

        if(is_null($inventaire)){
            return response()->json(['message' => 'Inventaire introuvable'], 404);
        }
        else
        {
            $inventaire->update($request->all());
            return response($inventaire, 200);
        }

    }

    //Supprimer un inventaire
    public function deleteInventaire($id){

        $inventaire = Inventaire::find($id);

        if(is_null($inventaire)){
            return response()->json(['message' => 'Inventaire introuvable'], 404);
        }
        else
        {
            $inventaire->delete();
            return response(200);
        }

    }

    //rechercher un inventaire
    public function searchInventaire($numInventaire){

        $i = Inventaire::where('numInventaire', 'like', '%'.$numInventaire.'%')->get();

        if(is_null($i)){
            return response()->json(['message' => 'Inventaire introuvable'], 404);
        }else{
            return $i;
        }
    }

    public function getDataInventaire(Request $request){
        $today =  date('Y-m-d');

        $inventaire = Lot::select('numCommande', 'qteCommander', 'qteSeuil','prixUnitaire', 'prix', 'numVente', 'numero as numLot',
        'qteStocker', 'qteVendue', 'montant', 'nomCommercial as medicament', 'dateVente', 'dateCommande', 'lots.id as lots_id')
        ->where('ventes.dateVente','>=', $request->periode)->where('ventes.dateVente','<=', $today)
        ->where('commandes.dateCommande','>=', $request->periode)->where('commandes.dateCommande','<=', $today)
        ->whereNotNull('details_ventes.lots_id')
        ->whereNotNull('details_commandes.lots_id')
        ->join('details_ventes', 'details_ventes.lots_id', 'lots.id')
        ->join('details_commandes', 'details_commandes.lots_id', 'lots.id')
        ->join('ventes', 'ventes.id', 'details_ventes.ventes_id')
        ->join('commandes', 'commandes.id', 'details_commandes.commandes_id')
        ->join('medicaments', 'medicaments.id', 'lots.medicaments_id')
        ->get();

        if(is_null($inventaire)){
            return response()->json(['Message' => 'Aucune ligne n\'est recuperée ...']);
        }else{
            return response()->json($inventaire);
        }
    }

}
