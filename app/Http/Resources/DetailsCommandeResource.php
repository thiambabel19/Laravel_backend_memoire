<?php

namespace App\Http\Resources;

use App\Models\Fournisseur;
use App\Models\Medicament;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailsCommandeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $commande = $this->commandes()->get()[0];
        $lot = $this->lots()->get()[0];

        $fournisseur = Fournisseur::find($commande->fournisseurs_id);
        $medi = Medicament::find($lot->medicaments_id);
        $user = $this->user()->get()[0];

        return [
            'id' => $this->id,
            'commandes_id' => $this->commandes_id,
            'lots_id' => $lot->id,
            'qteCommander' => $this->qteCommander,
            'prix' => $this->prix,
            'user_id' => $this->user_id,
            'numCommande' => $commande->numCommande,
            'dateCommande' => $commande->dateCommande,
            'fournisseurs_id' => $commande->fournisseurs_id,
            'prixUnitaire' => $lot->prixUnitaire,
            'numLot' => $lot->numero,
            'nomFournisseur' => $fournisseur->nom,
            'medicament' => $medi->nomCommercial,
            'utilisateur' => $user->name
        ];


    }

}