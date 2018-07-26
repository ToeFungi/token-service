<?php namespace ToeFungi\Token\Laravel\Middleware;

use Closure;
use Illuminate\Http\Response;
use ToeFungi\Token\TokenService;

class TokenAuthentication
{
    /**
     * @var TokenService
     */
    private $tokenService;

    /**
     * Authenticate constructor.
     * @param TokenService $tokenService
     */
    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$this->tokenService->validateToken($request->bearerToken())) {
            return response(null, Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
