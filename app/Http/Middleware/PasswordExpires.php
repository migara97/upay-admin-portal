<?php

namespace App\Http\Middleware;

use App\Models\Backend\Parameter;
use Closure;
use Carbon\Carbon;

/**
 * Class PasswordExpired.
 */
class PasswordExpires
{
    /**
     * @param         $request
     * @param Closure $next
     *
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if (!$user->is_ldap_user) {
            $password_changed_at = new Carbon($user->password_changed_at ?: $user->created_at);
            $passwordExpiresDays = Parameter::where('name', 'PORTAL_PASSWORD_EXPIRES_DAYS')->first()->value;
            if (Carbon::now()->diffInDays($password_changed_at) >= $passwordExpiresDays) {
                return redirect()->route('password.expired');
            }
        }

        return $next($request);
    }
}
