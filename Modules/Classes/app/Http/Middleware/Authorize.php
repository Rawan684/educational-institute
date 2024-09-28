<?php

namespace Modules\Classes\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Authorize
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = User::find(1);
        if (!$user->hasRole('admin')) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        return $next($request);
    }
}
