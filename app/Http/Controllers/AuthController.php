<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //ajout user
    public function register(Request $request){

        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
            'telephone' => 'required|string',
            'adresse' => 'required|string',
            'profils_id' => 'required|integer',
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'telephone' => $fields['telephone'],
            'adresse' => $fields['adresse'],
            'profils_id' => $fields['profils_id'],
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    // user login
    public function login(Request $request){

        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        //verifiction adresse email
        $user = User::where('email', $fields['email'])->first();

        //verifiction password
        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response([
                'message' => 'Mot de passe incorrect ... '
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    //deconnexion
    public function logout(Request $request){
        //auth()->user()->acces_tokens()->delete();
        $request->user()->currentAccessToken()->delete();
        return [
            'message' => 'Vous êtes déconnectés ...'
        ];
    }

     //mise à jour d'un profil
    public function updateUser(Request $request, $id){

        $user = User::find($id);

        if(is_null($user)){
            return response()->json(['message' => 'Utilisateur introuvable'], 404);
        }
        else
        {
            $user->update($request->all());
            return response($user, 200);
        }

    }

    public function getUser(Request $request){
        return $request->user();
    }


    protected function redirectTo($request){

        if(! $request->expectsJson()){
            return route('user/login');
        }

    }

    public function crypterPassword($password){
        return bcrypt($password);
    }

}
