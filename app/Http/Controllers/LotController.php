<?php

namespace App\Http\Controllers;

use App\Http\Resources\LotResource;
use App\Models\Lot;
use App\Models\Medicament;
use App\Models\Parametrage;
use Illuminate\Http\Request;

class LotController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    //liste des lots
    public function getAllLots()
    {
        return response()->json(LotResource::collection(Lot::all()), 200);
    }

    //Retourner un lot
    public function getLotById($id)
    {
        $lot = Lot::find($id);

        if (is_null($lot)) {
            return response()->json(['message' => 'Lot introuvable...'], 404);
        } else {
            return response()->json(new LotResource($lot), 200);
        }
    }

    //ajouter un lot
    public function addLot(Request $request)
    {
        $lot = Lot::create($request->all());
        $req = Parametrage::find(1);
        $req->numLot += 1;
        $req->update();
        return response($lot, 200);
    }

    //mise à jour d'un lot
    public function updateLot(Request $request, $id)
    {
        $lot = Lot::find($id);

        if (is_null($lot)) {
            return response()->json(['message' => 'Lot introuvable...'], 404);
        } else {
            $lot->update($request->all());
            return response($lot, 200);
        }
    }

    //Supprimer un lot
    public function deleteLot($id)
    {
        $lot = Lot::find($id);
        Medicament::where('lots_id', $id)->delete();
        if (is_null($lot)) {
            return response()->json(['message' => 'Lot introuvable...'], 404);
        } else {
            $lot->delete();
            return response(200);
        }
    }

    //rechercher un lot
    public function searchLot($prixUnitaire){

        $l = Lot::where('nomProfil', 'like', '%'.$prixUnitaire.'%')->get();

        if(is_null($l)){
            return response()->json(['message' => 'Lot introuvable'], 404);
        }else{
            return $l;
        }
    }

    public function getLotNonPeremption(){
        $today = date('Y-m-d');
        $lot = LotResource::collection(Lot::where('dateExp', '>', $today)->get());
        return response()->json($lot);
    }

    public function getLotPeremption(){
        $today = date('Y-m-d');
        $lot = LotResource::collection(Lot::where('dateExp', '<=', $today)->get());
        return response()->json($lot);
    }

    public function getCountLot(){
        $lot = Lot::all()->count();

        if(is_null($lot)){
            return response()->json(['message' => 'Aucune ligne trouvée ...'], 404);
        }else{
            return response()->json($lot);
        }
    }

}