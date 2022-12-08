<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MedicamentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $lot = $this->lots()->get()[0];

        return [
            'id' => $this->id,
            'numMedicament' => $this->numMedicament,
            'DCI' => $this->DCI,
            'nomCommercial' => $this->nomCommercial,
            'forme' => $this->forme,
            'famille' => $this->famille,
            'lots_id' => $this->lots_id,
            'dosage' => $this->dosage,
            'numLot' => $lot->numero,
            'nomProduitLot' => $lot->nomProduit,
            'dateFab' => $lot->dateFab,
            'dateExp' => $lot->dateExp,
            'pu' => $lot->prixUnitaire,
            'qte' => $lot->qteStocker
        ];

    }
}
