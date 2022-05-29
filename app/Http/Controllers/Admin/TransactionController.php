<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Transaction\TransactionResource;

class TransactionController extends Controller
{
    public function store(Request $request)
    {     $data = $request->all();
        //   $num = 0.00;
        //   $am = $num /3;
        //   $data['amount'] = $am;

        // if ($data['amount'] > Payment::amunt() )
        //      $data['status'] = 'Overdue';
        // else if (2/$data['amount'] = Payment::amunt())
        //      $data['status'] = 'Outstanding';
        //      else
        //      $data['amount'] = 'Paid';

          Validator::make($data, [
            'payer'       => ['required','integer','exists:users,id'],
            'category'    => ['required','integer','exists:categories,id'],
            'subcategory' => ['required','integer','exists:categories,id'],
            'amount'      => ['required','numeric'],
            'status'      => ['exclude_with:Paid,Outstanding,Overdue', 'string'],
            'due_on'      => ['required','date:y-m-d'],
            ])->validate();
        $transaction = Transaction::create([
            'payer'       => $data['payer'],
            'category'    => $data['category'],
            //the subcategory must be solve based on the select category parent
            'subcategory' => $data['subcategory'],
            'amount'      => $data['amount'],
            'status'      => $data['status'],
            'due_on'      => $data['due_on'],
        ]);

        $transaction->categories()->attach($request->category);
        $transaction->subcategories()->attach($request->subcategory);

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
