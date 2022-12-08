<?php

namespace App\Models;

use App\Models\User;
use App\Models\Commande;
use App\Models\Medicament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailsCommande extends Model
{
    use HasFactory;

    protected $fillable = array('commandes_id', 'lots_id', 'qteCommander', 'prix', 'user_id');

    public static $rules = array(
        'commandes_id' => 'required|integer',
        'lots_id' => 'required|integer',
        'qteCommander' => 'required|integer',
        'prix' => 'required|float',
        'user_id' => 'required|bigInteger'
    );

    public function commandes(){
        return $this->belongsTo(Commande::class);
    }

    public function lots(){
        return $this->belongsTo(Lot::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
