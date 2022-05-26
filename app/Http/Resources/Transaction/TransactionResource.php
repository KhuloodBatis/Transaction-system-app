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
            'id'       => $this->id,
            'payer'    => new UserResource($this->user),
            'categories' => CategoryResource::collection($this->categories),
            'amount'   => $this->amount,
            'status'   => $this->status,
            'due_on'   => $this->due_on
        ];
    }
}
