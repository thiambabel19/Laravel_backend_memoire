<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profil extends Model
{
    use HasFactory;

    protected $fillable = array('nomProfil');

    public static $rules = array(
        'nomProfil' => 'required|max:30'
    );

    public function user(){
        return $this->belongsTo(Profil::class);
    }

}
