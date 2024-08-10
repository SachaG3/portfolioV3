<?php
// Dans app/Http/Controllers/AuthController.php


namespace App\Http\Controllers;

use App\Models\SingleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = SingleUser::where('username', $request->username)->first();

        if ($user && $user->is_active) {
            if (Hash::check($request->password, $user->password)) {
                $request->session()->put('authenticated', true);
                return redirect()->intended('/');
            } else {
                // Désactiver l'utilisateur après une erreur de mot de passe
                $user->is_active = false;
                $user->save();
            }
        }

        return back()->withErrors(['Invalid credentials.']);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('authenticated');
        return redirect()->route('login');
    }
}
