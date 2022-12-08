<?php

namespace App\Models;

use App\Models\Lot;
use App\Models\User;
use App\Models\Vente;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailsVente extends Model
{
    use HasFactory;

    protected $fillable = array('ventes_id', 'lots_id', 'qteVendue', 'montant', 'user_id');

    public static $rules = array(
        'ventes_id' => 'required|integer',
        'lots_id' => 'required|integer',
        'qteVendue' => 'required|integer',
        'montant' => 'required|float',
        'user_id' => 'required|bigInteger'
    );

    public function ventes(){
        return $this->belongsTo(Vente::class);
    }

    public function lots(){
        return $this->belongsTo(Lot::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
