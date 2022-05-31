<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Transaction\TransactionResource;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        // if ($data['amount'] > Payment::amunt() )
        //      $data['status'] = 'Overdue';
        // else if (2/$data['amount'] = Payment::amunt())
        //      $data['status'] = 'Outstanding';
        //      else
        //      $data['amount'] = 'Paid';

        // $today = today();
        // switch (connection_status() ) {
        //     case $data['due_on'] < $today:
        //         $txt = 'Paid';
        //         break;
        //     case $data['due_on']:
        //         $txt = 'Outstanding' <= $today;
        //         break;
        //     case $data['due_on'] > $today:
        //         $txt = 'Overdue';
        //         break;
        //     default:
        //         $txt = 'Unknown';
        //         break;
        // }
        // $data['status'] = $txt;
        //////////////////
        // SELECT
        //    case
        //          when  (sum(p.amount) < t.amount) AND t.due_on < now() then 'Overdue'
        //          when  (sum(p.amount) <= t.amount) AND t.due_on > now() then 'Outstanding'
        //        ELSE 'paid'
        //     END AS status
        // FROM
        //       transactions t
        //         JOIN
        //       payments p ON t.id = p.transaction_id
        // WHERE t.id = 2 AND p.buyer_id = 1;

        // $newStatus = DB::table('transactions as t')
        //     ->selectRaw(" case
        //                  when  (sum(p.amount) < t.amount) AND t.due_on < now() then 'Overdue'
        //                  when  (sum(p.amount) <= t.amount) AND t.due_on > now() then 'Outstanding'
        //                ELSE 'paid'
	    //                END AS status")
        //     ->join('payments p', 't.id', '=', 'p.transaction_id')
        //     ->where('t.id ,' . 'Transaction::id()' . ',p.buyer_id, ' . 'Payment::buyer_id())')
        //     ->get();
        // $data['status'] = $newStatus;



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
        //return  $transaction->load('categories');
        return  new TransactionResource($transaction);
    }
}
