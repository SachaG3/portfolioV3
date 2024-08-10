<?php

namespace App\Http\Middleware;

use App\Models\SingleUser;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SingleUserAuth
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->get('authenticated') !== true) {
            $username = $request->input('username');
            $password = $request->input('password');

            $user = SingleUser::where('username', $username)->first();

            if ($user && Hash::check($password, $user->password)) {
                $request->session()->put('authenticated', true);
            } else {
                return redirect('login')->withErrors(['Invalid credentials']);
            }
        }

        return $next($request);
    }
}
