<?php

namespace App\Http\Controllers;

use App\Http\Resources\LotResource;
use App\Models\Lot;
use App\Models\Medicament;
use App\Models\Parametrage;
use Illuminate\Http\Request;
use App\Http\Resources\MedicamentResource;

class MedicamentController extends Controller
{
    public function __construct(){
       $this->middleware('auth');
    }

    //liste des medicaments
    public function getAllMedicaments(){
        return response()->json(Medicament::all(), 200);
    }

    //Retourner un medicament
    public function getMedicamentById($id){

        $medicament = Medicament::find($id);

        if(is_null($medicament)){
            return response()->json(['message' => 'Medicament introuvable'], 404);
        }else{
            return response()->json($medicament, 200);
        }
    }

    //ajouter un medicament
    public function addMedicament(Request $request){
        $medicament = Medicament::create($request->all());
        $req = Parametrage::find(1);
        $req->numMedicament += 1;
        $req->update();
        return response($medicament, 200);
    }

    //mise à jour d'un medicament
    public function updateMedicament(Request $request, $id){

        $medicament = Medicament::find($id);

        if(is_null($medicament)){
            return response()->json(['message' => 'Medicament introuvable'], 404);
        }
        else
        {
            $medicament->update($request->all());
            return response($medicament, 200);
        }

    }

    //Supprimer un medicament
    public function deleteMedicament($id){

        $medicament = Medicament::find($id);

        if(is_null($medicament)){
            return response()->json(['message' => 'Medicament introuvable'], 404);
        }
        else
        {
            $medicament->delete();
            return response(200);
        }

    }

    //rechercher un médicament par sa forme
    public function searchMedicamentForme($forme){

        $m = Medicament::where('forme', 'like', '%'.$forme.'%')->get();

        if(is_null($m)){
            return response()->json(['message' => 'Médicament introuvable'], 404);
        }else{
            return $m;
        }
    }

    //rechercher un médicament par sa famille
    public function searchMedicamentFamille($famille){

        $m = Medicament::where('famille', 'like', '%'.$famille.'%')->get();

        if(is_null($m)){
            return response()->json(['message' => 'Médicament introuvable'], 404);
        }else{
            return $m;
        }
    }

    public function verifierExistence($nomMedi){
        $result = Medicament::where('nomCommercial',strtolower($nomMedi))->get();

        if(is_null($result)){
            return response()->json(['message' => 'Ce médicament n\'existe pas encore dans notre système ...'], 404);
        }else{
            return response()->json($result);
        }
    }

    public function getCountMedicament(){
        $medi = Medicament::all()->count();

        if(is_null($medi)){
            return response()->json(['message' => 'Aucune ligne trouvée ...'], 404);
        }else{
            return response()->json($medi);
        }
    }


}