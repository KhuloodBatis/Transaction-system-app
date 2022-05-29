<?php

namespace App\Http\Controllers\Customer;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Payment\PaymentResource;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();
        //   $num = 0.00;
        //   $am = $num /3;
        //   $data['amount'] = $am;

        Validator::make($data, [
            'transaction_id' => ['required','integer','exists:transactions,id'],
            'amount'         => ['required','numeric'],
            'payment_method' => ['required','string', 'required_with:PayPal,Visa'],
            'paud_at'        => ['required','date:y-m-d'],
            'details'        => ['required','string'],
            ])->validate();
        $payment = Payment::create([
            'transaction_id' => $data['transaction_id'],
            //I must divied the amount for 3 items payments for example
            'amount'         => $data['amount'],
            'payment_method' => $data['payment_method'],
            'paud_at'        => $data['paud_at'],
            'details'        => $data['details'],
        ]);

        return  response()->json([
            'message' => 'sccessfull',
            'result' => new PaymentResource($payment)
        ]);
    }
}
