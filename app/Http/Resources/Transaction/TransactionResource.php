<?php

namespace App\Http\Resources\Transaction;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Category\CategoryResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'               => $this->id,
            'payer_id'         => new UserResource($this->user),
            'category_id'      => new CategoryResource($this->category),
            'subcategory_id'   => new CategoryResource($this->subcategory),
            'amount'           => $this->amount,
            'status'           => $this->status,
            'due_on'           => $this->due_on
        ];
    }
}
