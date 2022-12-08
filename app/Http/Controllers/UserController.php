<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    //liste des users
    public function getAllUsers(){
        return response()->json(UserResource::collection(User::all()), 200);
    }

    //Retourner un user
    public function getUserById($id){

        $user = User::find($id);

        if(is_null($user)){
            return response()->json(['message' => 'Utilisateur introuvable'], 404);
        }else{
            return response()->json(new UserResource(User::find($id)), 200);
        }
    }

    //ajouter un user
    public function addUser(Request $request){
        $user = User::create($request->all());
        return response($user, 200);
    }

    //mise à jour d'un user
    public function updateUser(Request $request, $id){

        $user = User::find($id);

        if(is_null($user)){
            return response()->json(['message' => 'Utilisateur introuvable'], 404);
        }
        else
        {
            //user->password =
            $user->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
                'telephone' => $request['telephone'],
                'adresse' => $request['adresse'],
                'profils_id' => $request['profils_id'],
            ]);

            return response($user, 200);
        }

    }

    //Supprimer un user
    public function deleteUser($id){

        $user = User::find($id);

        if(is_null($user)){
            return response()->json(['message' => 'Utilisateur introuvable'], 404);
        }
        else
        {
            $user->delete();
            return response(200);
        }

    }

    //rechercher un utiilisateur
    public function searchUser($name){

        $user = User::where('name', 'like', '%'.$name.'%')->get();

        if(is_null($user)){
            return response()->json(['message' => 'Utilisateur introuvable'], 404);
        }else{
            return $user;
        }
    }

    //liste des utilisateurs étant vendeur
    public function getUserVendeur(){
        $vendeurs = User::select('*')->where('nomProfil','=', 'Vendeur')->join('profils', 'users.profils_id', 'profils.id')
        ->orderBy('name')
        ->get();
        if(is_null($vendeurs)){
            return response()->json(['Message' => 'Aucun vendeur n\'est trouvé ...']);
        }else{
            return response()->json($vendeurs);
        }
        //return User::where('profils_id', 3)->get();
    }

    public function verifierExistenceEmail($email){
        $result = User::where('email',strtolower($email))->get();

        if(is_null($result)){
            return response()->json(['message' => 'Il existe un utilisateur possédant cette adresse email ...'], 404);
        }else{
            return response()->json($result);
        }
    }


    public function getCountUser(){
        $users = User::all()->count();

        if(is_null($users)){
            return response()->json(['message' => 'Aucune ligne trouvée ...'], 404);
        }else{
            return response()->json($users);
        }
    }

}
