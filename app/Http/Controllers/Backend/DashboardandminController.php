<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Earning;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardandminController extends Controller
{
    public function dashboard(){
        $deposits = Deposit::Where('status', 'Approved')->get();
        $earnings = Earning::all();
        $users = User::Where('role', 'customer')->count();

        $total_deposit = 0;
        foreach($deposits as $deposit){
           $total_deposit += $deposit->amount;
        }
        $total_profit = 0;
        foreach($earnings as $earning){
           $total_profit += $earning->profit;
        }

        return view('Backend.index', compact('total_deposit', 'users', 'total_profit'));
    }
}
