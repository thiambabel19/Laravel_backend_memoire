<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fournisseur extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'telephone',
        'adresse',
        'email',
        'user_id'
    ];

    public static $rules = array(
        'nom' => 'required|max:30',
        'adresse' => 'required|max:50',
        'telephone' => 'required|max:13',
        'email' => 'required|max:80',
        'user_id' => 'required|bigInteger'
    );

    public function user(){
        return $this->belongsTo(User::class);
    }
}