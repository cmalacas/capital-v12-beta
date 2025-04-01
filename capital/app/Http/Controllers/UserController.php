<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function forgotPassword(Request $request) {

        $email = $request->get('email');

        $user = User::where('email', '=', $email)->first();

        print_r($user->toArray());

        return $email;

    }
}
