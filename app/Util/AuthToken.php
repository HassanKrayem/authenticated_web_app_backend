<?php
namespace App\Util;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthToken {

    private $tokenKey = null;
    private $ttl = 60 * 60 * 24; // in seconds (24 hour)

    public function __construct () {
        $this->tokenKey = '*$*@3312DH'. date('m-y') .'SN%Ouch';
    }

    function create($data = [], $config = [])
    {
        $iat = $config['iat'] ?? time(); // time of token issued at
        $nbf = $config['nbf'] ?? $iat; // not before in seconds
        $exp = $config['exp'] ?? $iat + ($config['ttl'] ?? $this->ttl); // expire time of token in seconds

        return JWT::encode([
            "iss" => $config['iss'] ?? "",
            "aud" => $config['aud'] ?? "",
            "iat" => $iat,
            "nbf" => $nbf,
            "exp" => $exp,
            "data" => $data,
        ], $this->tokenKey, 'HS256');
    }

    function decode($jwt, $algo)
    {
        try {
            return JWT::decode($jwt, new Key($this->tokenKey, $algo));
        } catch (\Exception $e) {
            return strtolower($e->getMessage());
        }
    }
}
