<?php
require_once '../config/config.php';

class JwtHandler {
    public function jwtEncode($payload) {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode($payload);
        
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, JWT_SECRET, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        
        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }

    public function jwtDecode($jwt) {
        $tokenParts = explode('.', $jwt);
        if(count($tokenParts) !== 3) {
            throw new Exception("Invalid token format");
        }
        
        $header = base64_decode(str_replace(['-', '_'], ['+', '/'], $tokenParts[0]));
        $payload = base64_decode(str_replace(['-', '_'], ['+', '/'], $tokenParts[1]));
        $signatureProvided = $tokenParts[2];
        
        // Verify signature
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, JWT_SECRET, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        
        if($base64UrlSignature !== $signatureProvided) {
            throw new Exception("Invalid signature");
        }
        
        $payload = json_decode($payload);
        
        // Verify issuer and audience if needed
        if(isset($payload->iss) && $payload->iss !== JWT_ISSUER) {
            throw new Exception("Invalid issuer");
        }
        
        if(isset($payload->aud) && $payload->aud !== JWT_AUD) {
            throw new Exception("Invalid audience");
        }
        
        // Verify expiration
        if(isset($payload->exp) && $payload->exp < time()) {
            throw new Exception("Token expired");
        }
        
        return (object) [
            'header' => json_decode($header),
            'data' => $payload
        ];
    }
}
?>