<?php

namespace App\Http\Controllers;

use App\Http\Resources\DetailsVenteResource;
use App\Models\DetailsVente;
use Illuminate\Http\Request;

class DetailsVenteController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    //liste des details_ventes
    public function getAllDetailsVentes()
    {
        return response()->json(DetailsVenteResource::collection(DetailsVente::all()), 200);
    }

    //Retourner un details_vente
    public function getDetailsVenteById($id)
    {
        $details_vente = DetailsVente::find($id);

        if (is_null($details_vente)) {
            return response()->json(['message' => 'Les détails de cette vente sont introuvables...'], 404);
        } else {
            return response()->json(new DetailsVenteResource(DetailsVente::find($id)), 200);
        }
    }

    //ajouter un details_vente
    public function addDetailsVente(Request $request)
    {
        $details_vente = DetailsVente::create($request->all());
        return response($details_vente, 200);
    }

    //mise à jour d'un details_vente
    public function updateDetailsVente(Request $request, $id)
    {
        $details_vente = DetailsVente::find($id);

        if (is_null($details_vente)) {
            return response()->json(['message' => 'Les détails de cette vente sont introuvables...'], 404);
        } else {
            $details_vente->update($request->all());
            return response($details_vente, 200);
        }
    }

    //Supprimer un details_vente
    public function deleteDetailsVente($id)
    {
        $details_vente = DetailsVente::find($id);

        if (is_null($details_vente)) {
            return response()->json(['message' => 'Les détails de cette vente sont introuvables...'], 404);
        } else {
            $details_vente->delete();
            return response(200);
        }
    }

    public function getLastVente(){
        $detVente = DetailsVente::orderby('created_at', 'desc')->first();
        $detailsVente = $this->getDetailsVenteById($detVente->id);
        return $detailsVente;
    }


}
