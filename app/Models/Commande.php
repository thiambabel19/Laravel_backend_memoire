<?php

namespace App\Models;

use App\Models\User;
use App\Models\Fournisseur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = array('fournisseurs_id','numCommande', 'dateCommande', 'user_id');

    public static $rules = array(
        'fournisseurs_id' => 'required|integer',
        'numCommande' => 'required|max:10',
        'dateCommande' => 'required|date',
        'user_id' => 'required|bigInteger',
    );

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function fournisseurs(){
        return $this->belongsTo(Fournisseur::class);
    }

}
