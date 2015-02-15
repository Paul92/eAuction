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
        unset($_SESSION[$key]);
    }

    public static function get($key) {
        return $_SESSION[$key];
    }
}
