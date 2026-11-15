<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function create(): View
    {
        return view('admin.auth.login');
    }

    /**
     * Attempt to authenticate an administrator.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $throttleKey = $this->throttleKey($request);

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'email' => "Too many login attempts. Please try again in {$seconds} seconds.",
            ]);
        }

        $credentials = $request->safe()->only(['email', 'password']);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::hit($throttleKey);

            throw ValidationException::withMessages([
                'email' => 'These credentials do not match our records.',
            ]);
        }

        RateLimiter::clear($throttleKey);

        $request->session()->regenerate();

        if (! $request->user()->is_admin) {
            Auth::logout();

            throw ValidationException::withMessages([
                'email' => 'This account does not have administrator access.',
            ]);
        }

        return redirect()->intended(route('admin.dashboard'));
    }

    /**
     * Log the administrator out.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    /**
     * Build a unique rate limiting key for the login attempt.
     */
    private function throttleKey(LoginRequest $request): string
    {
        return 'admin-login|'.strtolower((string) $request->input('email')).'|'.$request->ip();
    }
}
