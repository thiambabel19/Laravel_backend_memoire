<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //liste des profils
    public function getAllProfils()
    {
        return response()->json(Profil::all(), 200);
    }

    //Retourner un profil
    public function getProfilById($id)
    {

        $profil = Profil::find($id);

        if (is_null($profil)) {
            return response()->json(['message' => 'Profil introuvable'], 404);
        } else {
            return response()->json(Profil::find($id), 200);
        }
    }

    //ajouter un profil
    public function addProfil(Request $request)
    {
        $profil = Profil::create($request->all());
        return response($profil, 200);
    }

    //mise à jour d'un profil
    public function updateProfil(Request $request, $id)
    {

        $profil = Profil::find($id);

        if (is_null($profil)) {
            return response()->json(['message' => 'Profil introuvable'], 404);
        } else {
            $profil->update($request->all());
            return response($profil, 200);
        }
    }

    //Supprimer un profil
    public function deleteProfil($id)
    {

        $profil = Profil::find($id);

        if (is_null($profil)) {
            return response()->json(['message' => 'Profil introuvable'], 404);
        } else {
            $profil->delete();
            return response(200);
        }
    }

    //rechercher un profil
    public function searchProfil($nomProfil)
    {

        $p = Profil::where('nomProfil', 'like', '%' . $nomProfil . '%')->get();

        if (is_null($p)) {
            return response()->json(['message' => 'Profil introuvable'], 404);
        } else {
            return $p;
        }
    }
}