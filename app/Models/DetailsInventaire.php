<?php

namespace App\Models;

use App\Models\Lot;
use App\Models\User;
use App\Models\Inventaire;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailsInventaire extends Model
{
    use HasFactory;

    protected $fillable = array('inventaires_id', 'lots_id', 'periode', 'user_id');

    public static $rules = array(
        'inventaires_id' => 'required|integer',
        'lots_id' => 'required|integer',
        'periode' => 'required|max:100',
        'user_id' => 'required|bigInteger'
    );

    public function inventaire(){
        return $this->belongsTo(Inventaire::class);
    }

    public function lots(){
        return $this->hasMany(Lot::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}