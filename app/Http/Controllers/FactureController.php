<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use Illuminate\Http\Request;

class FactureController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    //liste des factures
    public function getAllFactures(){
        return response()->json(Facture::all(), 200);
    }

    //Retourner une facture
    public function getFactureById($id){

        $facture = Facture::find($id);

        if(is_null($facture)){
            return response()->json(['message' => 'Facture introuvable'], 404);
        }else{
            return response()->json(Facture::find($id), 200);
        }
    }

    //ajouter une facture
    public function addFacture(Request $request){
        $facture = Facture::create($request->all());
        return response($facture, 200);
    }

    //mise à jour d'une facture
    public function updateFacture(Request $request, $id){

        $facture = Facture::find($id);

        if(is_null($facture)){
            return response()->json(['message' => 'Facture introuvable'], 404);
        }
        else
        {
            $facture->update($request->all());
            return response($facture, 200);
        }

    }

    //Supprimer une facture
    public function deleteFacture($id){

        $facture = Facture::find($id);

        if(is_null($facture)){
            return response()->json(['message' => 'Facture introuvable'], 404);
        }
        else
        {
            $facture->delete();
            return response(200);
        }

    }

    //rechercher une facture
    public function searchFacture($numFacture){

        $f = Facture::where('numFacture', 'like', '%'.$numFacture.'%')->get();

        if(is_null($f)){
            return response()->json(['message' => 'Facture introuvable'], 404);
        }else{
            return $f;
        }
    }

    //get num facture
    public function getNumFacture(){
        $last_facture = Facture::latest('id')->first();
        return $last_facture;
    }

}