<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Earning;
use App\Models\User;
use App\Services\GeneralService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EarningController extends Controller
{
    protected $generalService;

    public function __construct(GeneralService $generalService)
    {
        $this->generalService = $generalService;
    }

    public function earning_history(Request $request)
    {

        $filter_data = [
            'type' => 'Earning',
            'crypto_type' => 'All Currencies',
            'month_from' => 1,
            'day_from' => 1,
            'month_to' => 12,
            'day_to' => 31,
        ];

        $request->session()->put('history_filter', $filter_data);

        $filtered_data = $this->generalService->Get_History_Filter('Earning', 'All Currencies', 'All', 'All');

        return view('Frontend.history', [
            'datas' => $filtered_data['datas'],
            'filter_data' => $filter_data
        ]);
    }
}
