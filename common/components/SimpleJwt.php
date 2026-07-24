<?php

namespace common\components;

/**
 * Minimal HS256 JWT encode/decode, used by common\models\User for the api/
 * app's token auth. Avoids an external dependency: firebase/php-jwt's
 * PHP-7.4-compatible release line (^5.5) is flagged by security advisories,
 * while the fixed release line (^6.x) requires PHP 8+ — incompatible with
 * this project's PHP 7.4 target. HS256 is just base64url(header).base64url(payload)
 * signed with hash_hmac('sha256', ...), so implementing the envelope directly
 * around that standard primitive avoids the dependency conflict entirely.
 */
class SimpleJwt
{
    /**
     * @param array $payload
     * @param string $secret
     * @return string
     */
    public static function encode(array $payload, $secret)
    {
        $header = ['alg' => 'HS256', 'typ' => 'JWT'];
        $segments = [
            self::base64UrlEncode(json_encode($header)),
            self::base64UrlEncode(json_encode($payload)),
        ];
        $signature = hash_hmac('sha256', implode('.', $segments), $secret, true);
        $segments[] = self::base64UrlEncode($signature);
        return implode('.', $segments);
    }

    /**
     * @param string $jwt
     * @param string $secret
     * @return array the decoded payload
     * @throws \RuntimeException if the token is malformed, mis-signed, or expired
     */
    public static function decode($jwt, $secret)
    {
        $parts = explode('.', $jwt);
        if (count($parts) !== 3) {
            throw new \RuntimeException('Malformed JWT.');
        }
        [$headerB64, $payloadB64, $signatureB64] = $parts;

        $header = json_decode(self::base64UrlDecode($headerB64), true);
        if (!is_array($header) || ($header['alg'] ?? null) !== 'HS256') {
            throw new \RuntimeException('Unsupported or missing JWT algorithm.');
        }

        $expectedSignature = hash_hmac('sha256', $headerB64 . '.' . $payloadB64, $secret, true);
        $actualSignature = self::base64UrlDecode($signatureB64);
        if (!hash_equals($expectedSignature, $actualSignature)) {
            throw new \RuntimeException('JWT signature verification failed.');
        }

        $payload = json_decode(self::base64UrlDecode($payloadB64), true);
        if (!is_array($payload)) {
            throw new \RuntimeException('Malformed JWT payload.');
        }
        if (isset($payload['exp']) && time() >= $payload['exp']) {
            throw new \RuntimeException('JWT has expired.');
        }
        return $payload;
    }

    private static function base64UrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private static function base64UrlDecode($data)
    {
        $padded = str_pad($data, strlen($data) % 4 === 0 ? strlen($data) : strlen($data) + (4 - strlen($data) % 4), '=');
        return base64_decode(strtr($padded, '-_', '+/'));
    }
}
