<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Helper\JWTToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class JwtTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try{
            $token = $request->cookie('Login_token');
            if (!$token) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            
            $decoded = JWTToken::verifyToken($token);

            if ($decoded['error']){
                return response()->json(['error' => $decoded['error']], 401);
            }

            $payload = $decoded['payload'];
        
            $user = User::where('id',$payload->id)->where('email', $payload->email)->first();
            
            Auth::setUser($user);

            return $next($request);
        }
        catch(\Exception $e){
            Log::error($e->getMessage().''.$e->getFile().':'.$e->getLine());
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
