<?php

namespace App\Helper;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
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

            return $token;
        } 
        
        catch (\Exception $e) {
            Log::critical($e->getMessage().''.$e->getFile().':'.$e->getLine());
            return [
                'error' => 'Failed to generate JWT token',
                'message' => $e->getMessage(),
            ];
        }
    }

    public static function verifyToken(string $token)
    {
        try {
            $key = config('jwt.jwt_secret_key');
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            return (array) $decoded;
        } 
        
        catch (\Exception $e) {
            Log::critical($e->getMessage().''.$e->getFile().':'.$e->getLine());
            return [
                'error' => 'Failed to decode JWT token',
                'message' => $e->getMessage(),
            ];
        }
    }
}
