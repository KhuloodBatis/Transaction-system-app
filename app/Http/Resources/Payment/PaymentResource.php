<?php

namespace App\Http\Resources\Payment;

use App\Http\Resources\Transaction\TransactionResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'transaction'    => new TransactionResource($this->transaction),
            'buyer_id'       => new UserResource($this->user),
            'amount'         => $this->amount,
            'payment_method' => $this->payment_method,
            'paid_at'        => $this->paid_at,
            'details'        => $this->details,
        ];
    }
}
