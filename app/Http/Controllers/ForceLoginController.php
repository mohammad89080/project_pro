<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForceLoginController extends Controller
{
    public function login(User $user)
    {
        Auth::login($user);

        // Redirect to the user's dashboard or any other desired page
        return redirect()->route('dashboard');
    }
}
