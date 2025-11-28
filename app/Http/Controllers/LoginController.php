<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Get authenticated user
            $user = Auth::user();
            
            // Debugging - Log role information
            Log::info('User logged in', [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'role_id' => $user->role_id,
                'role_name' => $user->role ? $user->role->name : 'No Role',
                'has_owner_role' => $user->hasRole('owner'),
                'has_koordinator_role' => $user->hasRole('koordinator'),
            ]);

            // Redirect based on user role
            if ($user->hasRole('koordinator')) {
                Log::info('Redirecting to koordinator dashboard');
                return redirect()->intended(route('koordinator.dashboard'));
            } elseif ($user->hasRole('owner')) {
                Log::info('Redirecting to owner dashboard');
                return redirect()->intended(route('owner.dashboard'));
            }

            // Fallback jika role tidak dikenali
            Log::warning('Role not recognized, redirecting to default dashboard');
            return redirect()->intended('/dashboard');
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}