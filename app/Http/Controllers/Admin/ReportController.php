<?php

namespace App\Http\Controllers\Admin;

use App\Models\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Report\ReportResource;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'starting_date'  => ['required', 'date:y-m-d'],
            'ending_date'    => ['required', 'date:y-m-d'],
            'transaction_id' => ['required','integer','exists:transactions,id'],
            'payment_id'     => ['required','integer','exists:payments,id'],
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
