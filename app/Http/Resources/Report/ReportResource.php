<?php

namespace App\Http\Resources\Report;

use App\Http\Resources\Payment\PaymentResource;
use App\Http\Resources\Transaction\TransactionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
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
            'id'             => $this->id,
            'starting_date'  => $this->starting_date,
            'ending_date'    => $this->ending_date,
            'transaction_id' => new TransactionResource($this->transaction),
            'payment_id'     => new PaymentResource($this->Payment),
        ];
    }
}
