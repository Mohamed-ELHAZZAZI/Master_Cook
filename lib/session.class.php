<?php

class Session
{



    public static function setFlash($message)
    {
        $_SESSION["flash_message"] = $message;
    }

    public static function hasFlash()
    {
        return isset($_SESSION["flash_message"]);
    }

    public static function flash()
    {
        echo $_SESSION["flash_message"];
        $_SESSION["flash_message"] = null;
    }

    public static function setError($message)
    {
        $_SESSION["error_message"] = $message;
    }

    public static function hasError()
    {
        return isset($_SESSION["error_message"]);
    }

    public static function error()
    {
        echo $_SESSION["error_message"];
        $_SESSION["error_message"] = null;
    }


    public static function setWarning($message)
    {
        $_SESSION["warning_message"] = $message;
    }

    public static function hasWarning()
    {
        return isset($_SESSION["warning_message"]);
    }


    public static function warning()
    {
        echo $_SESSION["warning_message"];
        $_SESSION["warning_message"] = null;
    }

    /**
     * SESSION
     * 
     */


    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return null;
    }

    public static function clear($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
    public static function destroy() {
        session_destroy();
    }
}
