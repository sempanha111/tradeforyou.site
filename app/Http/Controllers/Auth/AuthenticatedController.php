<?php

namespace App\Http\Controllers\Auth;

use App\Events\AlertDepositSuccessCrypto;
use App\Http\Controllers\Controller;
use App\Mail\MailRequestConfirmation;
use App\Mail\MailResetSuccess;
use App\Mail\RegisterSuccess;
use App\Models\Deposit;
use App\Models\Earning;
use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail as MailFacades;
use Illuminate\Support\Str;

class AuthenticatedController extends Controller
{

    public function singup_get(Request $request)
    {

        $referralId = $request->query('rel');
        if ($referralId != null) {
            $request->session()->put('Rel', $referralId);
        }

        return view('Frontend.signup');
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->intended('/')->with('success', 'You are Logout Successfully');
    }


    public function login(Request $request)
    {


        $request->validate([
            'username' => 'required',
            'password' => 'required|min:6'
        ]);
        $users = User::Where("name", $request->username)->get();


        foreach ($users as $user) {
            if (Hash::check($request->password, $user->password)) {
                Auth::login($user);
                if ($request->user()->role === 'admin') {
                    return redirect()->intended('admin/dashboard')->with('success', 'LogIn Admin Successfully');
                } else {
                    return redirect()->intended('/dashboard')->with('success', 'Hello, dear ' . Auth::user()->name . '!');
                }
            }
        }
        return back()->withErrors([
            'username' => 'The Username do not match our records.',
            'password' => 'The Password do not match our records.',
        ]);
    }

    public function signup(Request $request)
    {
        try {
            $request->validate([
                'fullname' => 'required|min:4',
                'username' => 'required|min:4|unique:users,name',
                'password' => 'required|min:6',
                'retypepassword' => 'required|min:6|same:password',
                'email' => 'required|email|unique:users,email',
                'retypeemail' => 'required|email|unique:users,email|same:email',
            ]);

            $refferal = $request->session()->has('Rel') ? $request->session()->get('Rel') : null;

            $users = User::create([
                'fullname' => $request->fullname,
                'name' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'perfect_money' => ($request->perfectmoney != null ? $request->perfectmoney : null),
                'payeer' => ($request->payeer != null ? $request->payeer : null),
                'bitcoin' => ($request->bitcoin != null ? $request->bitcoin : null),
                'litecoin' => ($request->litecoin != null ? $request->litecoin : null),
                'ethereum' => ($request->ethereum != null ? $request->ethereum : null),
                'bitcoin_cash' => ($request->bitcoin_cash != null ? $request->bitcoin_cash : null),
                'usdt_bsc_bep20' => ($request->usdt_bsc_bep20 != null ? $request->usdt_bsc_bep20 : null),
                'sq' => ($request->sq != null ? $request->sq : null),
                'sa' => ($request->sa != null ? $request->sa : null),
                'link_from' => $refferal,
                'remember_token' => Str::random(20),
            ]);


            // Auth::login($users);
            $details = [
                'type' => 'Registration Info',
                'hello' => 'Hello '. $users->name. ',',
                'text1' => 'Thank you for registration on our site.',
                'text2' => 'Your login information:',
                'text3' => 'Login: '. $users->name,
                'text4' => 'Password: '. $request->password,
                'text5' => 'You can login here: '.url('/'),
                'text6' => 'Contact us immediately if you did not authorize this registration.',
                'text7' => 'Thank you.'

            ];

            MailFacades::to($users->email)->send(new RegisterSuccess($details));
            event(new AlertDepositSuccessCrypto("Register Successfully"));

            return redirect()->intended('/login')->with('success', 'You are Register Seccessfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Handle general exceptions
            return redirect()->back()->with('error', 'Something went wrong. Please try again.')->withInput();
        }
    }



    public function forgetpassword()
    {
        return view('Frontend.forget_password');
    }

    public function forgetpassword_send(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email'
            ]);
            $user = User::Where('email', $request->email)->first();
            if (!empty($user)) {
                $details = [
                    'type' => 'sent to confirm',
                    'hello' => 'Hello '. $user->name. ',',
                    'token' => $user->remember_token,
                    'text1' => 'Please confirm your request for password reset.',
                    'text2' => 'Copy and paste this link to your browser:',

                ];

                MailFacades::to($request->email)->send(new MailRequestConfirmation($details));

                return redirect()->route('forgetpassword')->with('success', 'Your account was found. Please check your e-mail address and follow confirm URL to reset your password.');

            } else {
                return redirect()->back()->with('error', 'No accounts found for provived info.');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Handle general exceptions
            return redirect()->back()->with('error', 'Something went wrong. Please try again.')->withInput();
        }
    }

    public function resetconfirm(Request $request)
    {

        $token = $request->query('action');

        if (!empty($token)) {

            $user = User::Where('remember_token', $token)->first();
            if (!empty($user)) {

                $generate_new_password = Str::random(7);


                $user->update([
                    'password' => Hash::make($generate_new_password),
                    'remember_token' => Str::random(20),
                ]);

                $ipAddress = $request->ip(); // Get the user's IP address

                $details = [
                    'type' => 'success reset',
                    'hello' => 'Hello '. $user->name. ',',
                    'text1' => 'Someone (most likely you) requested your username and password from the '. $ipAddress,
                    'text2' => 'Your password has been changed!!!',
                    'text3' => 'You can log into our account with:',
                    'text4' => 'Username: '. $user->name,
                    'text5' => 'Password: '. $generate_new_password,
                    'text6' => 'Hope that helps.',
                ];

                MailFacades::to($user->email)->send(new MailResetSuccess($details));


                return redirect()->route('forgetpassword')->with('success', 'Request was confirmed. Login and password was sent to your email address.');


            }
            else{
                return redirect()->route('forgetpassword')->with('error', 'Your link not found. Please check your e-mail address and follow confirm URL.');
            }
        }
        else{
            return redirect()->route('forgetpassword')->with('error', 'Your link not found. Please check your e-mail address and follow confirm URL.');
        }



    }
}
