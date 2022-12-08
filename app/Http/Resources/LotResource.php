<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LotResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $medicament = $this->medicaments()->get()[0];

        return [
            'id' => $this->id,
            'numLot' => $this->numero,
            'dateFab' => $this->dateFab,
            'dateExp' => $this->dateExp,
            'prixUnitaire' => $this->prixUnitaire,
            'qteStocker' => $this->qteStocker,
            'medicament' => $medicament->nomCommercial,
            'user_id' => $this->user_id,
            'medicaments_id' => $medicament->id,
            'qteSeuil' => $medicament->qteSeuil,
        ];
    }
}
