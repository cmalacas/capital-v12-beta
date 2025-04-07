<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login page.
     */
    public function create(Request $request)
    {
        /* return Inertia::render('auth/login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => $request->session()->get('status'),
        ]); */ 

        return view('Auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        /* $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false)); */

        $location = '/home';

        $loginData = ['email' => $request->get('email'), 'password' => $request->get('password'), 'active' => 1, 'deleted' => 0];

        if ($request->session()->has('redirect_url')) {

            $location = $request->session()->get('redirect_url');

        }
    
        if (Auth::attempt($loginData)) {

            $accessToken = Auth::user()->createToken('authToken')->accessToken;

            $user = Auth::user();            

            $user->two_factor_expiry = "1970-01-01 00:00:00";

            $user->remember_token = $accessToken;

            // $user->gns;

            $user->login_form = $request->has('form') ? $request->get('form') : '';

            // $user->save(); 

            return response(['user' => Auth::user(), 'token' => $accessToken, 'location' => $location, 'current_time' => time()]);


        } else {


            if (false) {




            } else {

                if (Auth::guard('client')->attempt($loginData)) {

                    $client = Auth::guard('client')->user();

                    if ($client->deleted === 0 && $client->active === 1) {

                        /* $accessToken = Auth::guard('client')->user()->createToken('authToken')->accessToken;  */

                        $client->phone_verified = 0;

                        $client->save();

                        //return response(['client' => $client, 'token' => $accessToken]);

                        return response(['client' => $client]);

                    } else {

                        return response(['message' => 'Invalid credentials']);

                    }

                } else {

                    return response(['message' => 'Invalid credentials']);

                }

            }
        }

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
