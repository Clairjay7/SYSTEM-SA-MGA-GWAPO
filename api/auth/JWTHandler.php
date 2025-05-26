<?php
class JWTHandler {
    private $secret_key;
    private $token_expire;

    public function __construct() {
        $this->secret_key = JWT_SECRET_KEY;
        $this->token_expire = JWT_TOKEN_EXPIRE;
    }

    public function generateToken($user_data) {
        $issued_at = time();
        $expire = $issued_at + $this->token_expire;

        $payload = [
            'iat' => $issued_at,
            'exp' => $expire,
            'user' => $user_data
        ];

        return $this->encode($payload);
    }

    public function validateToken($token) {
        try {
            $decoded = $this->decode($token);
            
            if ($decoded === false) {
                return false;
            }

            // Check if token is expired
            if (isset($decoded['exp']) && $decoded['exp'] < time()) {
                return false;
            }

            return $decoded;
        } catch (Exception $e) {
            return false;
        }
    }

    private function encode($payload) {
        $header = $this->base64UrlEncode(json_encode(['typ' => 'JWT', 'alg' => 'HS256']));
        $payload = $this->base64UrlEncode(json_encode($payload));
        $signature = $this->generateSignature($header, $payload);

        return "$header.$payload.$signature";
    }

    private function decode($token) {
        $parts = explode('.', $token);
        
        if (count($parts) !== 3) {
            return false;
        }

        list($header, $payload, $signature) = $parts;

        $valid_signature = $this->generateSignature($header, $payload);
        
        if ($signature !== $valid_signature) {
            return false;
        }

        return json_decode($this->base64UrlDecode($payload), true);
    }

    private function generateSignature($header, $payload) {
        return $this->base64UrlEncode(
            hash_hmac('sha256', "$header.$payload", $this->secret_key, true)
        );
    }

    private function base64UrlEncode($data) {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }

    private function base64UrlDecode($data) {
        $pad = strlen($data) % 4;
        if ($pad) {
            $data .= str_repeat('=', 4 - $pad);
        }
        return base64_decode(str_replace(['-', '_'], ['+', '/'], $data));
    }
} 