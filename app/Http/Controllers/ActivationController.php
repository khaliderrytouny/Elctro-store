<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\ActivateYourAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ActivationController extends Controller
{
    /**
     * Activate the user's account with the given code.
     *
     * @param string $code
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activationUserAccount($code)
    {
        $user = User::where('code', $code)->first();

        if (!$user) {
            return redirect('/')->with('error', 'Invalid activation code.');
        }

        $user->code = null;
        $user->active = 1;
        $user->save();

        Auth::login($user);

        return redirect('/')->with('success', 'You are now logged in.');
    }

    /**
     * Resend activation code to the user's email.
     *
     * @param string $email
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resendActivationCode($email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect('/login')->with('error', 'Email not found.');
        }

        if ($user->active) {
            return redirect('/')->with('info', 'Your account is already active.');
        }

        Mail::to($user->email)->send(new ActivateYourAccount($user->code));

        return redirect('/login')->with('success', 'Activation link has been sent to your email.');
    }
}
