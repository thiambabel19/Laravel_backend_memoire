<?php

namespace App\Models;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vente extends Model
{
    use HasFactory;

    protected $fillable = array('numVente', 'dateVente', 'typeVente', 'user_id');

    public static $rules = array(
        'numVente' => 'required|max:10',
        'dateVente' => 'required|date',
        'typeVente' => 'required|max:25',
        'user_id' => 'required|bigInteger'
    );

    public function user(){
        return $this->belongsTo(User::class);
    }

}