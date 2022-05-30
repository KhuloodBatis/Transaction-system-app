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
            'transaction_id' => ['required', 'integer', 'exists:transactions,id'],
            'buyer_id'       => ['required', 'integer', 'exists:users,id'],
            'amount'         => ['required', 'numeric'],
            'payment_method' => ['required', 'string', 'required_with:PayPal,Visa'],
            'paid_at'        => ['required', 'date:y-m-d'],
            'details'        => ['required', 'string'],
        ])->validate();
        $payment = Payment::create([
            'transaction_id' => $data['transaction_id'],
            'buyer_id'       => $data['buyer_id'],
            'amount'         => $data['amount'],
            'payment_method' => $data['payment_method'],
            'paid_at'        => $data['paid_at'],
            'details'        => $data['details'],
        ]);

        return  response()->json([
            'message' => 'sccessfull',
            'result' => new PaymentResource($payment)
        ]);
    }
}
