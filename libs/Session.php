<?php

class Session {
    public static function init() {
        session_start();
    }

    public static function destory() {
        session_destroy();
    }

    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function remove($key) {
        if (isset($_SESSION[$key]))
            unset($_SESSION[$key]);
    }

    public static function get($key) {
        if (isset($_SESSION[$key]))
            return $_SESSION[$key];
    }

    public static function exists($key) {
        return isset($_SESSION[$key]);
    }
}
