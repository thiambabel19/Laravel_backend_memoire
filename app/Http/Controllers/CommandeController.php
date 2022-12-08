<?php

namespace App\Http\Controllers;

use App\Http\Resources\LotResource;
use App\Models\Lot;
use App\Models\Facture;
use App\Models\Commande;
use App\Models\Medicament;
use App\Models\Parametrage;
use Illuminate\Http\Request;
use App\Models\DetailsCommande;
use App\Models\DetailsFacture;

class CommandeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    //liste des commandes
    public function getAllCommandes(){
        return response()->json(Commande::all(), 200);
    }

    //Retourner une commande
    public function getCommandeById($id){

        $commande = Commande::find($id);

        if(is_null($commande)){
            return response()->json(['message' => 'Commande introuvable'], 404);
        }else{
            return response()->json(Commande::find($id), 200);
        }
    }

    //ajouter une commande
    public function addCommande(Request $request){
        $today = date('Y-m-d');
        $lot = Lot::find($request->lots_id);
        $medicament = Medicament::find($request->medicaments_id);
        $stockTotal = $lot->qteStocker + $request->qteCommander;

        if($stockTotal > $medicament->qteSeuil){
            return response()->json(['message' => 'La quantité seuille de ce médicament est de : '.$medicament->qteSeuil.'. Le stock actuel est de '.$lot->qteStocker.'.']);
        }

        if($request->dateCommande < $today || $request->dateCommande > $today){
            return response()->json(['message' => 'Impossible d\'effectuer une commande pour une date inférieure ou supérieure à la date du jour !!!']);
        }

        $lot->qteStocker += $request->qteCommander;
        $lot->update();

        $req = Parametrage::find(1);

        $commande = new Commande();
        $commande->numCommande = $req->numCommande;
        $commande->dateCommande = $request->dateCommande;
        $commande->fournisseurs_id = $request->fournisseurs_id;
        $commande->user_id = $request->user_id;
        $commande->save();

        $req->numCommande +=1;
        $req->update();

        $detCommande = new DetailsCommande();
        $detCommande->commandes_id = $commande->id;
        $detCommande->lots_id = $request->lots_id;
        $detCommande->qteCommander = $request->qteCommander;
        $detCommande->prix = $request->prix;
        $detCommande->user_id = $request->user_id;
        $detCommande->save();

        $facture = new Facture();
        $facture->numFacture = $req->numFacture;
        $facture->dateFacture = $request->dateCommande;
        $facture->commandes_id = $commande->id;
        $facture->user_id = $request->user_id;
        $facture->save();

        $req->numFacture +=1;
        $req->update();

        $detFacture = new DetailsFacture();
        $detFacture->factures_id = $facture->id;
        $detFacture->lots_id = $request->lots_id;
        $detFacture->qteAchetee = $request->qteCommander;
        $detFacture->montant = $request->prix;
        $detFacture->user_id = $request->user_id;
        $detFacture->save();

        return response()->json($detCommande);
    }

    //mise à jour d'une commande
    public function updateCommande(Request $request, $id){

        $commande = Commande::find($id);

        if(is_null($commande)){
            return response()->json(['message' => 'Commande introuvable'], 404);
        }
        else
        {
            $commande->update($request->all());
            return response($commande, 200);
        }

    }

    //Supprimer une commande
    public function deleteCommande($id){

        $commande = Commande::find($id);

        if(is_null($commande)){
            return response()->json(['message' => 'Commande introuvable'], 404);
        }
        else
        {
            $commande->delete();
            return response(200);
        }

    }

    //rechercher une commande
    public function searchCommande($numCommande){

        $c = Commande::where('numCommande', 'like', '%'.$numCommande.'%')->get();

        if(is_null($c)){
            return response()->json(['message' => 'Commande introuvable'], 404);
        }else{
            return $c;
        }
    }

    public function getFilterCommande(Request $request){

        $commande = DetailsCommande::select('numCommande','numero as numLot', 'nomCommercial as medicament', 'dateCommande',
            'qteCommander', 'prixUnitaire', 'prix', 'nom as nomFournisseur', 'name as utilisateur')
            ->where('dateCommande','>=', $request->dateDebut)->where('dateCommande','<=', $request->dateFin)
            ->join('commandes', 'commandes.id', '=', 'details_commandes.commandes_id')
            ->join('fournisseurs', 'fournisseurs.id', '=', 'commandes.fournisseurs_id')
            ->join('lots', 'lots.id', '=', 'details_commandes.lots_id')
            ->join('medicaments', 'medicaments.id', '=', 'lots.medicaments_id')
            //->join('details_commandes', 'commandes.id', '=', 'details_commandes.id')
            ->join('users', 'users.id', '=', 'details_commandes.user_id')
            ->get();

        if($commande){
            return response()->json($commande);
        }
        else{
            return response()->json(['Message' => 'Pas de vente sur cette période ...']);
        }
    }

}