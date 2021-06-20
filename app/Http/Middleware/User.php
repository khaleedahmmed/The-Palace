<?php

namespace App\Http\Middleware;

use App\Traits\ResponseTrait;
use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use JWTAuth;
class User extends BaseMiddleware
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
              $user = JWTAuth::parseToken()->authenticate();
          } catch (TokenExpiredException $e) {
            return  $this->error('unauthenticated user');
          } catch (JWTException $e) {

            return  $this->error('unauthenticated user');
          }

          return $next($request);

    }
}
