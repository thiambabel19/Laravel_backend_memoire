<?php

namespace App\Models;

use App\Models\Lot;
use App\Models\User;
use App\Models\Facture;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailsFacture extends Model
{
    use HasFactory;

    protected $fillable = array('factures_id', 'lots_id', 'qteAchetee', 'montant', 'user_id');

    public static $rules = array(
        'factures_id' => 'required|integer',
        'lots_id' => 'required|integer',
        'qteAchetee' => 'required|integer',
        'montant' => 'required|float',
        'user_id' => 'required|bigInteger'
    );

    public function lots(){
        return $this->hasMany(Lot::class);
    }

    public function fature(){
        return $this->belongsTo(Facture::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}