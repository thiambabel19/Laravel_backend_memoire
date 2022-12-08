<?php

namespace App\Http\Controllers;

use App\Models\DetailsInventaire;
use App\Models\Inventaire;
use Illuminate\Http\Request;

class DetailsInventaireController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    //liste des details_inventaires
    public function getAllDetailsInventaires()
    {
        return response()->json(DetailsInventaire::all(), 200);
    }

    //Retourner un details_inventaire
    public function getDetailsInventaireById($id)
    {
        $details_inventaire = DetailsInventaire::find($id);

        if (is_null($details_inventaire)) {
            return response()->json(['message' => 'Les détails de cet inventaire sont introuvables...'], 404);
        } else {
            return response()->json(DetailsInventaire::find($id), 200);
        }
    }

    //ajouter un details_inventaire
    public function addDetailsInventaire(Request $request)
    {
        //$details_inventaire = DetailsInventaire::create($request->all());
        $last_inv = Inventaire::all()->last()['id'];
        $detInv = new DetailsInventaire();
        $detInv->inventaires_id = $last_inv;
        $detInv->lots_id = $request->lots_id;
        $detInv->periode = $request->periode;
        $detInv->user_id = $request->user_id;
        $detInv->save();

        return response($detInv, 200);
    }

    //mise à jour d'un details_inventaire
    public function updateDetailsInventaire(Request $request, $id)
    {
        $details_inventaire = DetailsInventaire::find($id);

        if (is_null($details_inventaire)) {
            return response()->json(['message' => 'Les détails de cet inventaire sont introuvables...'], 404);
        } else {
            $details_inventaire->update($request->all());
            return response($details_inventaire, 200);
        }
    }

    //Supprimer un details_inventaire
    public function deleteDetailsInventaire($id)
    {
        $details_inventaire = DetailsInventaire::find($id);

        if (is_null($details_inventaire)) {
            return response()->json(['message' => 'Les détails de cet inventaires sont introuvables...'], 404);
        } else {
            $details_inventaire->delete();
            return response(200);
        }
    }

}