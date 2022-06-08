<?php

namespace App\Http\Controllers\Customer;

use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Payment\PaymentResource;

class PaymentController extends Controller
{

    public function index()
    {

        // $payments = Payment::all();
        // return PaymentResource::collection($payments);

    }

    public function store(Request $request)
    {

        $request->validate([
            'transaction_id' => ['required', 'integer', 'exists:transactions,id'],
            //'buyer_id'       => ['required', 'integer', 'exists:users,id'],
            'amount'         => ['required', 'numeric'],
            'payment_method' => ['required', 'string', 'required_with:PayPal,Visa'],
            'paid_at'        => ['required', 'date:y-m-d'],
            'details'        => ['required', 'string'],
        ]);
        $payment = Payment::create([
            'transaction_id' =>  $request->transaction_id,
            'buyer_id'       =>  $request->user()->id,
            'amount'         =>  $request->amount,
            'payment_method' =>  $request->payment_method,
            'paid_at'        =>  $request->paid_at,
            'details'        =>  $request->details,
        ]);

        return  response()->json([
            'message' => 'sccessfull',
            'result' => new PaymentResource($payment)
        ]);
    }
}
