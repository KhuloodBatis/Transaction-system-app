<?php

namespace App\Http\Resources\Payment;

use App\Http\Resources\Transaction\TransactionResource;
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
            'amount'         => $this->amount,
            'payment_method' => $this->payment_method,
            'paud_at'        => $this->paud_at,
            'details'        => $this->details,
        ];
    }
}
