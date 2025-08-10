<?php

namespace App\Helper;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class JWTToken
{
    public static function generateToken(array $userData, int $expirationTime = 3600)
    {
        try {
            $key = config('jwt.jwt_secret_key');
            $payload = $userData + [
                'iss' => 'Laravel App', // Issuer
                'iat' => time(), // Issued at
                'exp' => time() + $expirationTime, // Expiration time   
            ];

            $token =  JWT::encode($payload, $key, 'HS256');

            return [
                'error'=>false,
                'token'=>$token
            ];
        } 
        
        catch (\Exception $e) {
            Log::critical($e->getMessage().''.$e->getFile().':'.$e->getLine());
            return [
                'error' => true,
                'message' => 'Failed to generate JWT token',
            ];
        }
    }

    public static function verifyToken(string $token)
    {
        try {
            $key = config('jwt.jwt_secret_key');
            $payload = JWT::decode($token, new Key($key, 'HS256'));
            
            return [
                'error'=>false,
                'payload'=>$payload
            ];
        } 
        
        catch (\Exception $e) {
            Log::critical($e->getMessage().''.$e->getFile().':'.$e->getLine());
            return response()->json([
                'error' => 'Failed to verify JWT token',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
