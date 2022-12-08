<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    //liste des fournisseurs
    public function getAllFournisseurs(){
        return response()->json(Fournisseur::all(), 200);
    }

    //Retourner un fournisseur
    public function getFournisseurById($id){

        $fournisseur = Fournisseur::find($id);

        if(is_null($fournisseur)){
            return response()->json(['message' => 'Fournisseur introuvable'], 404);
        }else{
            return response()->json(Fournisseur::find($id), 200);
        }
    }

    //ajouter un fournisseur
    public function addFournisseur(Request $request){
        $fournisseur = Fournisseur::create($request->all());
        return response($fournisseur, 200);
    }

    //mise à jour d'un fournisseur
    public function updateFournisseur(Request $request, $id){

        $fournisseur = Fournisseur::find($id);

        if(is_null($fournisseur)){
            return response()->json(['message' => 'Fournisseur introuvable'], 404);
        }
        else
        {
            $fournisseur->update($request->all());
            return response($fournisseur, 200);
        }

    }

    //Supprimer un fournisseur
    public function deleteFournisseur($id){

        $fournisseur = Fournisseur::find($id);

        if(is_null($fournisseur)){
            return response()->json(['message' => 'Fournisseur introuvable'], 404);
        }
        else
        {
            $fournisseur->delete();
            return response(200);
        }

    }

    //rechercher un fournisseur
    public function searchFournisseur($nomfournisseur){

        $p = Fournisseur::where('prenom', 'like', '%'.$nomfournisseur.'%')->get();

        if(is_null($p)){
            return response()->json(['message' => 'Fournisseur introuvable'], 404);
        }else{
            return $p;
        }
    }

    public function verifierExistence($nom){
        $result = Fournisseur::where('nom',strtolower($nom))->get();

        if(is_null($result)){
            return response()->json(['message' => 'Ce fournisseur existe déjà ...'], 404);
        }else{
            return response()->json($result);
        }
    }

    public function getCountFournisseur(){
        $fournisseurs = Fournisseur::all()->count();

        if(is_null($fournisseurs)){
            return response()->json(['message' => 'Aucune ligne trouvée ...'], 404);
        }else{
            return response()->json($fournisseurs);
        }
    }

}