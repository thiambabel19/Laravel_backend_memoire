<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaire extends Model
{
    use HasFactory;

    protected $fillable = array('numInventaire', 'dateInventaire','user_id');

    public static $rules = array(
        'numInventaire' => 'required|max:10',
        'dateInventaire' => 'required|date',
        'user_id' => 'required|bigInteger'
    );

    public function user(){
        return $this->belongsTo(User::class);
    }
}
