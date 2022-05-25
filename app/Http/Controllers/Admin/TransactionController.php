<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'payer' => ['required', 'integer', 'exists:users,id'],
            'amount' => ['required', 'integer'],
            'status' => ['required', 'alpha'],
            'due_on' => ['required', 'date:y-m-d'],
        ]);
        $transaction = Transaction::create([
            'payer' => $request->payer,
            'amount' => $request->amount,
            'status' => $request->status,
            'due_on' => $request->due_on
        ]);
        
        return $transaction;
    }

    public function show()
    {
    }
}
