<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailsFacture;

class DetailsFactureController extends Controller
{
    public function __construct(){
       $this->middleware('auth');
    }

    //liste des details_factures
    public function getAllDetailsFactures()
    {
        return response()->json(DetailsFacture::all(), 200);
    }

    //Retourner un details_facture
    public function getDetailsFactureById($id)
    {
        $details_facture = DetailsFacture::find($id);

        if (is_null($details_facture)) {
            return response()->json(['message' => 'Les détails de cette facture sont introuvables...'], 404);
        } else {
            return response()->json(DetailsFacture::find($id), 200);
        }
    }

    //ajouter un details_facture
    public function addDetailsFacture(Request $request)
    {
        $details_facture = DetailsFacture::create($request->all());
        return response($details_facture, 200);
    }

    //mise à jour d'un details_facture
    public function updateDetailsFacture(Request $request, $id)
    {
        $details_facture = DetailsFacture::find($id);

        if (is_null($details_facture)) {
            return response()->json(['message' => 'Les détails de cette facture sont introuvables...'], 404);
        } else {
            $details_facture->update($request->all());
            return response($details_facture, 200);
        }
    }

    //Supprimer un details_facture
    public function deleteDetailsFacture($id)
    {
        $details_facture = DetailsFacture::find($id);

        if (is_null($details_facture)) {
            return response()->json(['message' => 'Les détails de cette facture sont introuvables...'], 404);
        } else {
            $details_facture->delete();
            return response(200);
        }
    }


}

