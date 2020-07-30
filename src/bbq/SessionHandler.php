<?php
declare(strict_types=1);

namespace src\bbq;

class SessionHandler
{
    /**
     * SessionHandler constructor.
     */
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * @param string $key
     * @param null $value
     */
    public function set(string $key, $value = null)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key
     */
    public function remove(string $key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }

        return null;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function exists(string $key): bool
    {
        return isset($_SESSION[$key]);
    }
}
