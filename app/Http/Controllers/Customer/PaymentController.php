<?php

namespace App\Http\Controllers\Customer;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Payment\PaymentResource;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'transaction_id' => ['required','integer','exists:transactions,id'],
            'amount'         => ['required','numeric'],
            'payment_method' => ['required','string', 'required_with:PayPal,Visa'],
            'paud_at'        => ['required','date:y-m-d'],
            'details'        => ['required','string'],
        ]);
        $payment = Payment::create([
            'transaction_id' => $request->transaction_id,
            //I must divied the amount for 3 items payments for example
            'amount'         => $request->amount,
            'payment_method' => $request->payment_method,
            'paud_at'        => $request->paud_at,
            'details'        => $request->details,
        ]);

        return  response()->json([
            'message' => 'sccessfull',
            'result' => new PaymentResource($payment)
        ]);
    }
}
