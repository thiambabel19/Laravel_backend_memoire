<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parametrage extends Model
{
    use HasFactory;


    protected $fillable = array('numLot', 'numCommande', 'numFacture', 'numVente', 'numInventaire', 'numMedicament' );

    public static $rules = array(
        'numLot' => 'required|max:15',
        'numCommande' => 'required|max:15',
        'numFacture' => 'required|max:15',
        'numVente' => 'required|max:15',
        'numInventaire' => 'required|max:15',
        'numMedicament' => 'required|max:15'
    );
}
