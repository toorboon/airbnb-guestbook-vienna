<?php

namespace App\Http\Middleware;

use App\Guest;
use App\Role;
use Closure;

class CheckRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $currentUserRole = auth()->user()->role_id;

        // If you are Admin, you can see all guests
        $roleId = Role::select('id')->where('name', 'Admin')->first()->id;
        if ($currentUserRole == $roleId) {
            return $next($request);
        }

        // Otherwise, the user_id on guest is checked
        $currentUser = auth()->user()->id;
        $currentGuest = $request->route('guest');
        $guestIsOwnedBy = Guest::findOrFail($currentGuest)->user_id;
        if ($currentUser == $guestIsOwnedBy){
            return $next($request);
        } else {
            return abort(403);
        }
    }
}
