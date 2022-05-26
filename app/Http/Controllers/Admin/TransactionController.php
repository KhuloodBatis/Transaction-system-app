<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Transaction\TransactionResource;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'payer'    => ['required', 'integer', 'exists:users,id'],
            'category' => ['required', 'integer', 'exists:categories,id'],
            'amount'   => ['required', 'integer'],
            'status'   => ['required', 'alpha'],
            'due_on'   => ['required', 'date:y-m-d'],
        ]);
        $transaction = Transaction::create([
            'payer'    => $request->payer,
            'category' => $request->category,
            'amount'   => $request->amount,
            'status'   => $request->status,
            'due_on'   => $request->due_on
        ]);

        $transaction->categories()->attach($request->category);

        return response()->json([
            'message' => 'sccessfull',
            'result' => new TransactionResource($transaction)
        ]);
    }

    public function show(Transaction $transaction)
    {
        //return  $transaction->load('categories');
        return  new TransactionResource($transaction);
    }
}
