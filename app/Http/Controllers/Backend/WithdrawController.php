<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawController extends Controller
{
    public function withdraw_admin()
    {


        $withdraws = Withdraw::Wherenull('on_delete')->orderBy('id', 'desc')->get();


        return view('Backend.withdraw', compact('withdraws'));
    }

    public function withdraw_admin_complete($id)
    {
        $withdraw = Withdraw::find($id);
        return view('Backend.completewithdraw', compact('id', 'withdraw'));
    }

    public function approved_withdraw(Request $request)
    {
        try {

            $request->validate([
                'batch' => 'required',
                'id' => 'required'
            ]);

            $batch = $request->batch;
            $id = $request->id;
            $withdraw = Withdraw::find($id);
            if($withdraw){
                $withdraw->update([
                'batch' => $batch,
                'status' => 'Approved'
                ]);
                return redirect()->back()->with('success', 'You Approved Withdraw Successfully')->withInput();
            }
            else{
                return redirect()->back()->with('error', 'You has been add Batch Already.')->withInput();
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Handle general exceptions
            return redirect()->back()->with('error', 'Something went wrong. Please try again.')->withInput();
        }
    }

    public function withdraw_admin_pending($id){
        try{
            $withdraw = Withdraw::find($id);
            if($withdraw){
                $withdraw->update([
                'status' => 'Pending'
                ]);
                return redirect()->back()->with('success', 'You Update Pending Successfully')->withInput();
            }
            else{
                return redirect()->back()->with('error', 'The withdraw does not match with the system.')->withInput();
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Handle general exceptions
            return redirect()->back()->with('error', 'Something went wrong. Please try again.')->withInput();
        }
    }

    public function delete_withdraw($id)
    {
        $withdraw = Withdraw::find($id);
        $withdraw->update([
            'on_delete' => 1
        ]);
        return redirect()->back()->with('success', 'You Delete Withdraw Successfully');
    }

    public function completewithdraw_edit($id){
        $withdraw = Withdraw::find($id);
        if($withdraw){
            return view('Backend.completewithdraw_edit', compact('id', 'withdraw'));
        }
        else{
            return redirect()->back()->with('error', 'The system No match id');
        }
    }

    
    public function approved_withdraw_update(Request $request){
        try {

            $request->validate([
                'batch' => 'required',
                'id' => 'required'
            ]);

            $batch = $request->batch;
            $id = $request->id;
            $withdraw = Withdraw::find($id);
            if($withdraw){
                $withdraw->update([
                'batch' => $batch,
                ]);
                return redirect()->back()->with('success', 'You Update Batch Withdraw Successfully')->withInput();
            }
            else{
                return redirect()->back()->with('error', 'You has been add Batch Already.')->withInput();
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Handle general exceptions
            return redirect()->back()->with('error', 'Something went wrong. Please try again.')->withInput();
        }
    }
}
