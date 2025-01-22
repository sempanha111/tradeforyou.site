<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Models\User;
use App\Services\GeneralService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{

    protected $generalService;

    public function __construct(GeneralService $generalService)
    {
        $this->generalService = $generalService;
    }

    public function filter(Request $request)
    {
        $type = $request->input('type', 'Deposit');
        $crypto_type = $request->input('crypto_type', 'All Currencies');
        $month_from = $request->input('month_from', 1);
        $day_from = $request->input('day_from', 1);
        $month_to = $request->input('month_to', 12);
        $day_to = $request->input('day_to', 31);

        // Format dates
        $from = sprintf('%04d-%02d-%02d', date('Y'), $month_from, $day_from);
        $to = sprintf('%04d-%02d-%02d', date('Y'), $month_to, $day_to);


        $filtered_data = $this->generalService->Get_History_Filter($type, $crypto_type, $from, $to);

        $data = [
            'type' => $type,
            'crypto_type' => $crypto_type,
            'month_from' => $month_from,
            'day_from' => $day_from,
            'month_to' => $month_to,
            'day_to' => $day_to,
            'datas' => $filtered_data['datas'], // Store filtered results here
        ];

        // Store the filter data in session
        $request->session()->put('history_filter', $data);
        return redirect()->route('historys');
    }


    public function historys(Request $request)
    {

        $filter_data = session('history_filter', [
            'type' => 'Deposit',
            'crypto_type' => 'All Currencies',
            'month_from' => 1,
            'day_from' => 1,
            'month_to' => 12,
            'day_to' => 31,
            'datas' => collect(),
        ]);


        $datas = collect($filter_data['datas']);

        // Return the view with the filtered data
        return view('Frontend.history', compact('datas', 'filter_data'));
    }
}
