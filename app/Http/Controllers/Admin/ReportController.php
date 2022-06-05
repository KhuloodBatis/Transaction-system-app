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

        $reports = Transaction::select(
            DB::raw('month(due_on) as month'),
            DB::raw('year(due_on) as year'),
            DB::raw('sum(case when STATUS = "paid" then amount ELSE 0 end )AS paid'),
            DB::raw('sum(case when STATUS = "outstanding" then amount ELSE 0 end )AS outstanding'),
            DB::raw('sum(case when STATUS = "overdue" then amount ELSE 0 end )AS overdue'),)
        ->groupBy(['month','year'])
        ->get()
        ->toArray();

         return $reports;
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
