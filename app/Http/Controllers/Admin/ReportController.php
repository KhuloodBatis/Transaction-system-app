<?php

namespace App\Http\Controllers\Admin;

use App\Models\Report;
use App\Models\Payment;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Report\ReportResource;

class ReportController extends Controller
{
    public function index(Transaction $transaction)
    {
        // 11 [
        //     { " month " : " 1 " ,
        //       " year " : " 2021 " ,
        //       " paid " : " 20000 " ,
        //       " outstanding " : " 1000 " ,
        //       " overdue " : " 10.5 "
        //    } ,
        //    {
        //     " month " : " 2 " ,
        //     " year " : " 2021 " ,
        //     " paid " : " 0 " ,
        //     " outstanding " : " 1000 " ,
        //     " overdue " : " 5.5 "
        //    }]

        //    $categories = Category::where('parent_id',null)
        //    ->with(['subcategories'=> function($query){
        //        $query->withSum(['payments'=> function($query){
        //            $query->where('paid_at','>', now()->subMonth(value:3));
        //        }], 'amount');
        //    }])
        //    ->get();
        //    return $categories;

        //    $transactions = Transaction::where('id',Auth::id())
        //    ->withSum(['payments'=> function($query){
        //            $query->where('paid_at','>', now()->subMonth(value:3));
        //        }], 'amount')
        //    ->get();
        //    return $transactions;

        //     SELECT
        // 	EXTRACT(MONTH FROM p.paid_at) AS month,
        //    EXTRACT(YEAR FROM p.paid_at) AS year,
        //    t.amount AS paid,
        //    max(p.amount) AS outstanding,
        //   round(MIN(p.amount)/95,1) AS overdue
        // FROM
        //   payments p
        //    JOIN
        //   transactions t ON t.id = p.transaction_id
        // WHERE t.id = 2 AND p.buyer_id =1;

        $payments = DB::table('payments as p')
            ->select(DB::raw("p.id,
                     EXTRACT(MONTH FROM p.paid_at) AS month,
                     EXTRACT(YEAR FROM p.paid_at) AS year,
                     t.amount AS paid,
                     max(p.amount) AS outstanding,
                     round(MIN(p.amount)/95,1) AS overdue"))
            ->join('transactions as t', 't.id', '=', 'p.transaction_id')
            ->where('t.id', '=', $transaction->id)
            ->where('p.buyer_id', '=', Auth::id())
            ->groupBy('p.id')
            ->get();

        return $payments;
    }

    public function store(Request $request)
    {
        $request->validate([
            'starting_date'  => ['required', 'date:y-m-d'],
            'ending_date'    => ['required', 'date:y-m-d'],
            'transaction_id' => ['required', 'integer', 'exists:transactions,id'],
            'payment_id'     => ['required', 'integer', 'exists:payments,id'],
        ]);
        $report = Report::create([
            'starting_date'  => $request->starting_date,
            'ending_date'    => $request->ending_date,
            'transaction_id' => $request->transaction_id,
            'payment_id'     => $request->payment_id,
        ]);
        return new ReportResource($report);
    }
}
