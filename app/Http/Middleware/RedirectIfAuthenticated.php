<?php
/**
 * Hype Sri Lanka (https://hypesl.org).
 *
 * @link https://github.com/artslabcreatives/invoiceninja source repository
 *
 * @copyright Copyright (c) 2021. Hype Sri Lanka (https://hypesl.org)
 *
 * @license https://www.elastic.co/licensing/elastic-license
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        switch ($guard) {
        case 'contact':
          if (Auth::guard($guard)->check()) {
              return redirect()->route('client.dashboard');
          }
          break;
          case 'user':
          Auth::logout();
          // if (Auth::guard($guard)->check()) {
          //     return redirect()->route('dashboard.index');
          // }
          break;
        default:
        Auth::logout();
          // if (Auth::guard($guard)->check()) {
          //     return redirect('/');
          // }
          break;
      }

        return $next($request);
    }
}
