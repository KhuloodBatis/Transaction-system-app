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

        $payments = Payment::all();
        return PaymentResource::collection($payments);
    }

    public function store(Request $request, Transaction $transaction)
    {
        $data = $request->all();

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

        $payment->transaction()->save([$transaction->status = DB::table('transactions as t')
            ->select(DB::raw("case
                               when  (sum(p.amount) < t.amount) AND t.due_on < now() then 'Overdue'
                               when  (sum(p.amount) < t.amount) AND t.due_on > now() then 'Outstanding'
                             ELSE 'paid'
                            END AS status"))
            ->join('payments as p', 't.id', '=', 'p.transaction_id')
            ->where('t.id', '=', $transaction->id)
            ->where('p.buyer_id', '=', Auth::id())
            ->groupBy('t.id')
            ->get()]);
        return  response()->json([
            'message' => 'sccessfull',
            'result' => new PaymentResource($payment)
        ]);
    }
}
