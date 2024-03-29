<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminHandler
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->session()->missing('sessionkey')){
            return redirect()->route('loginScreen', ['err' => 5]);
            die();
        }

        $value = $request->session()->get('sessionkey');
        $decryptedvalue = decrypt($value);

        $userinfo = explode(',', $decryptedvalue);

        if($userinfo[1] != 'admin'){
            return redirect()->route('loginScreen', ['err' => 5]);
            die();
        }

        $request->attributes->add(['userinfo' => $userinfo]);
        return $next($request);
    }
}
