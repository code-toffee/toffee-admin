<?php
declare(strict_types=1);

namespace App\Utils;

class PasswordSafeUtils
{
    private static string $key = '';

    public static function generate(string $pwd): string
    {
        return hash_hmac('sha256', $pwd, self::$key);
    }

    public static function verifyPassword(string $data, string $hash): bool
    {
        return hash_hmac('sha256', $data, self::$key) === $hash;
    }
}
