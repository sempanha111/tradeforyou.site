<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function support()
    {
        return view('Frontend.contact');
    }
    public function contact_send(Request $request)
    {

        try {

            $request->validate([
                'name' => 'required|min:4',
                'email' => 'required|email',
                'message' => 'required|min:10'
            ]);

            $user = User::Where('email', $request->email)->get();

            if($user->isNotEmpty()){
                Contact::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'message' => $request->message,
                ]);
                return redirect()->back()->with('success', 'Message has been successfully sent. We will back to you shortly. Thank you.');
            }
            else{
                return redirect()->back()->with('warning', 'The Email do not match our records.');
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
