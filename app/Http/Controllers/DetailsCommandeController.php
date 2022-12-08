<?php

namespace App\Http\Controllers;

use App\Models\Lot;
use App\Models\Commande;
use App\Models\Medicament;
use Illuminate\Http\Request;
use App\Models\DetailsCommande;
use App\Http\Resources\DetailsCommandeResource;

class DetailsCommandeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    //liste des details_commandes
    public function getAllDetailsCommandes()
    {
        return response()->json(DetailsCommandeResource::collection(DetailsCommande::all()), 200);
    }

    //Retourner un details_commande
    public function getDetailsCommandeById($id)
    {
        $details_commande = DetailsCommande::find($id);

        if (is_null($details_commande)) {
            return response()->json(['message' => 'Les détails de cette commande sont introuvables...'], 404);
        } else {
            return response()->json(new DetailsCommandeResource($details_commande),200);
        }
    }

    //ajouter un details_commande
    public function addDetailsCommande(Request $request)
    {
        $details_commande = DetailsCommande::create($request->all());
        return response($details_commande, 200);
    }

    //mise à jour d'un details_commande
    public function updateDetailsCommande(Request $request, $id)
    {
        $details_commande = DetailsCommande::find($id);

        if (is_null($details_commande)) {
            return response()->json(['message' => 'Les détails de cette commande sont introuvables...'], 404);
        } else {
            $details_commande->update($request->all());
            return response($details_commande, 200);
        }
    }

    //Supprimer un details_commande
    public function deleteDetailsCommande($id)
    {
        $details_commande = DetailsCommande::find($id);

        if (is_null($details_commande)) {
            return response()->json(['message' => 'Les détails de cette commande sont introuvables...'], 404);
        } else {
            $details_commande->delete();
            return response(200);
        }
    }

    public function getLastCommande(){
        $detcom = DetailsCommande::orderby('created_at', 'desc')->first();
        $detailsCommande = $this->getDetailsCommandeById($detcom->id);
        return $detailsCommande;
    }

}
