<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Facture extends Model
{
    use HasFactory;

    protected $fillable = array('numFacture', 'dateFacture', 'commmandes_id', 'user_id');

    public static $rules = array(
        'numFacture' => 'required|max:10',
        'dateFacture' => 'required|date',
        'commandes_id' => 'required|integer',
        'user_id' => 'required|bigInteger'
    );

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function commandes(){
        return $this->belongsTo(Facture::class);
    }

}
