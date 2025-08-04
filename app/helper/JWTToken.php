<?php

namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken
{
    public static function createToken($userEmail, $userId, $time = 60)
    {
        $key = env('JWTkey');
        $payload = [
            'iss' => 'laravel-token',
            'iat' => time(),
            'exp' => time() + 60 * $time,
            'userEmail' => $userEmail,
            'userId' => $userId
        ];
        $token = JWT::encode($payload, $key, 'HS256');
        return $token;
    }

    public static function tokenVerify($token)
    {
        try {
            if ($token != null) {
                $key = env('JWTkey');
                $decode = JWT::decode($token, new Key($key, 'HS256'));
                return $decode;
            } else {
                return 'Unauthorize';
            }
        } catch (Exception $e) {
            return 'Unauthorize';
        }
    }
}
