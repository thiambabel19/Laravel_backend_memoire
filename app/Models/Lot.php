<?php

namespace App\Models;

use App\Models\User;
use App\Models\Medicament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lot extends Model
{
    use HasFactory;

    protected $fillable = array('numero', 'dateFab', 'dateExp', 'prixUnitaire', 'qteStocker', 'medicaments_id', 'user_id');

    public static $rules = array(
        'numero' => 'required|max:50',
        'dateFab' => 'required|date',
        'dateExp' => 'required|date',
        'prixUnitaire' => 'required|float',
        'qteStocker' => 'required|float',
        'medicaments_id' => 'required|integer',
        'user_id' => 'required|bigInteger'
    );

    public function medicaments(){
        return $this->belongsTo(Medicament::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
