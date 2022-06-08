<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Transaction\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function show(Transaction $transaction)
    {  
        $transaction = Transaction::where('payer_id',Auth::id())->get();
       if(!$transaction ) {
          return  response()->json([
            'status' => 'successful',
            'result' =>TransactionResource::collection($transaction),
              ]);
       };

       return  response()->json([
        'status' => 'unsuccessful',
        'message' => 'you don`t have any transactions',
    ]);
         
    }
}
