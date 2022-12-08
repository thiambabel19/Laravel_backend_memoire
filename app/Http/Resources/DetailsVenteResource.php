<?php

namespace App\Http\Resources;

use App\Models\Medicament;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailsVenteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $vente = $this->ventes()->get()[0];
        $lot = $this->lots()->get()[0];
        $nomUser = $this->user()->get()[0];

        $medicament = Medicament::find($lot->medicaments_id);

        return [
            'id' => $this->id,
            'ventes_id' => $this->ventes_id,
            'lots_id' => $lot->id,
            'qteVendue' => $this->qteVendue,
            'montant' => $this->montant,
            'user_id' => $this->user_id,
            'numVente' => $vente->numVente,
            'dateVente' => $vente->dateVente,
            'typeVente' => $vente->typeVente,
            'prixUnitaire' => $lot->prixUnitaire,
            'numLot' => $lot->numero,
            'medicament' => $medicament->nomCommercial,
            'nomVendeur' => $nomUser->name
        ];
    }
}
