<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function edit_account(){
        return view('Frontend.profile');
    }
    public function edit_account_send(Request $request){

        try{

            $user = $request->user();

            // Base validation rules
            $rules = [
                'fullname' => 'required|min:4',
                'username' => 'required|min:4',
                'email' => 'required|email',
            ];

            // Check if email is being changed
            if ($user->email != $request->email) {
                $rules['email'] = 'required|email|unique:users,email';
            }


            // Check if email is being changed
            if ($user->name != $request->username) {
                $rules['username'] = 'required|min:4|unique:users,name';
            }

            // Check if password is being updated
            if ($request->password != null) {
                $rules['password'] = 'required|min:6';
                $rules['retypepassword'] = 'required|min:6|same:password';
            }

            // Run the validation
            $request->validate($rules);

            // Prepare the data to update
            $updateData = [
                'fullname' => $request->fullname,
                'name' => $request->username,
                'email' => $request->email,
                'perfect_money' => $request->perfectmoney ?? null,
                'payeer' => $request->payeer ?? null,
                'bitcoin' => $request->bitcoin ?? null,
                'litecoin' => $request->litecoin ?? null,
                'ethereum' => $request->ethereum ?? null,
                'bitcoin_cash' => $request->bitcoin_cash ?? null,
                'usdt_bsc_bep20' => $request->usdt_bsc_bep20 ?? null,
            ];


            // If password is being updated, hash it
            if ($request->password != null) {
                $updateData['password'] = Hash::make($request->password);
            }

            // Update the user
            $user->update($updateData);


        return redirect()->back()->with('success', "Update Successfully");

        }catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Handle general exceptions
            return redirect()->back()->with('error', 'Something went wrong. Please try again.')->withInput();
        }
    }
}
