<?php
namespace App\Helpers;

class CSRF
{
    /**
     * Generate a CSRF token and store it in the session
     * @return string
     */
    public static function generate()
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Verify the provided CSRF token matches the session
     * @param string $token
     * @return bool
     */
    public static function verify($token)
    {
        if (empty($_SESSION['csrf_token']) || empty($token)) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }

    /**
     * Generate HTML hidden input field for CSRF
     * @return string
     */
    public static function field()
    {
        $token = self::generate();
        return '<input type="hidden" name="csrf_token" value="' . $token . '">';
    }
}
