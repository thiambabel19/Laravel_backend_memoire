<?php

namespace App\Models;

use App\Models\Lot;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medicament extends Model
{
    use HasFactory;

    protected $fillable = array('numMedicament', 'DCI', 'nomCommercial', 'qteSeuil', 'forme', 'famille', 'dosage', 'user_id');

    public static $rules = array(
        'numMedicament' => 'required|max:10',
        'DCI' => 'required|max:30',
        'nomCommercial' => 'required|integer',
        'qteSeuil' => 'required|integer',
        'forme' => 'required|max:50',
        'famille' => 'required|50',
        'dosage' => 'required|float',
        'user_id' => 'required|bigInteger'
    );

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function lots(){
        return $this->hasMany(Lot::class);
    }
}
