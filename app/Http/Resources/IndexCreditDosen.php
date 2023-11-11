<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexCreditDosen extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        // if($request->id){
            return [
                'id' => $this->id,
                'kelas_id' => $this->kelas_id,
                'matkul_id' => $this->matkul_id,
                'dosen_id' => $this->dosen_id,
            ];
        // }
        // return ['data' => $this->collection];

        
    }
}
