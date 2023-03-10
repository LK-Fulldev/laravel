<?php

namespace App\Http\Middleware;

use Closure;
use App\Exceptions\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EmailCallRestApiMiddleware
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
        $rules = [
            'email' => ['email', 'required'],
            'subject' => ['string', 'required'],
            'description' => ['string', 'required']
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) throw new ValidationException($validator);

        return $next($request);
    }
}
