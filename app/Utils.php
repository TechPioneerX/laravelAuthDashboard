<?php

namespace App;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Utils
{
    public static function generateJWT($email, $role, $createdAt): string
    {
        $payload = [
            'email' => $email,
            'role' => $role,
            'createdAt' => $createdAt->toDateTimeString(),
            'updatedAT' => now()->toDateTimeString(),
            'version' => env('VERSION')
        ];

        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }

    public static function parseJWT($jwt)
    {
        try {
            $decoded = JWT::decode($jwt, new Key(env('JWT_SECRET'), 'HS256'));
            return (array) $decoded;
        } catch (\Exception $e) {
            // Handle the exception (e.g., log the error, return a default value, etc.)
            return [];
        }
    }
}
