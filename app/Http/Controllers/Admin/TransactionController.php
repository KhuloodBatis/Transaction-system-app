<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Transaction\TransactionResource;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        $vat = ($data['amount'] / 100) * 21.5;
        $data['amount'] = $data['amount'] + $vat;

        Validator::make($data, [
            'payer_id'       => ['required', 'integer', 'exists:users,id'],
            'category_id'    => ['required', 'integer', 'exists:categories,id'],
            'subcategory_id' => ['required', 'integer', 'exists:categories,id'],
            'amount'         => ['required', 'numeric'],
            'status'         => ['required', 'string'],
            'due_on'         => ['required', 'date:y-m-d'],
        ])->validate();
        $transaction = Transaction::create([
            'payer_id'       => $data['payer_id'],
            'category_id'    => $data['category_id'],
            'subcategory_id' => $data['subcategory_id'],
            'amount'         => $data['amount'],
            'status'         => $data['status'],
            'due_on'         => $data['due_on'],
        ]);
        return response()->json([
            'message' => 'sccessfull',
            'result' => new TransactionResource($transaction)
        ]);
    }



    public function show(Transaction $transaction)
    {
        $status = DB::table('transactions as t')
            ->select(DB::raw("case
         when  (sum(p.amount) < t.amount) AND t.due_on < now() then 'Overdue'
         when  (sum(p.amount) < t.amount) AND t.due_on > now() then 'Outstanding'
             ELSE 'paid'
                END AS status"))
            ->join('payments as p', 't.id', '=', 'p.transaction_id')
            ->where('t.id', '=', $transaction->id)
            ->where('p.buyer_id', '=', Auth::id())
            ->groupBy('t.id')
            ->get();
        return $status;
    }

}
