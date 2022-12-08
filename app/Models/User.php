<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Lot;
use App\Models\Vente;
use App\Models\Profil;
use App\Models\Facture;
use App\Models\Patient;
use App\Models\Commande;
use App\Models\Inventaire;
use App\Models\Medicament;
use App\Models\DetailsVente;
use App\Models\DetailsFacture;
use App\Models\DetailsCommande;
use App\Models\DetailsInventaire;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'telephone',
        'adresse',
        'profils_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profils(){
        return $this->belongsTo(Profil::class);
    }

    public function fatures(){
        return $this->hasMany(Facture::class);
    }

    public function commandes(){
        return $this->hasMany(Commande::class);
    }

    public function inventaires(){
        return $this->hasMany(Inventaire::class);
    }

    public function patients(){
        return $this->hasMany(Patient::class);
    }

    public function ventes(){
        return $this->hasMany(Vente::class);
    }

    public function medicaments(){
        return $this->hasMany(Medicament::class);
    }

    public function details_commandes(){
        return $this->hasMany(DetailsCommande::class);
    }

    public function lots(){
        return $this->hasMany(Lot::class);
    }

    public function details_factures(){
        return $this->hasMany(DetailsFacture::class);
    }

    public function details_inventaires(){
        return $this->hasMany(DetailsInventaire::class);
    }

    public function details_ventes(){
        return $this->hasMany(DetailsVente::class);
    }

}
