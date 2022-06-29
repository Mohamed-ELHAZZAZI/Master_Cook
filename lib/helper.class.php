<?php

class Helper
{

    public static function isEmpty($array)
    {
        foreach ($array as $element) {
            if (empty($element)) {
                return true;
            }
        }
        return false;
    }

    public static function email_check($email)
    {
        $result = true;
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    public static function invalidUser_name($username)
    {
        $result = true;
        if (preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    public static function user_exists($username, $email)
    {
        $result = true;
        $check = "SELECT user_name AND email FROM users WHERE user_name = ? or email = ?";
        $stmt = App::$db->query($check, [$username, $email]);
        $exists = $stmt->rowCount();
        if ($exists == 0) {
            $result =  false;
        } else {
            $result =  true;
        }
        return $result;
    }

    public static function pass_match($password, $repass)
    {
        $result = true;
        if ($password == $repass) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    public static function pass_check($password)
    {
        $result = true;
        /**
         * 
         * if (preg_match("/[a-zA-Z0-9]/", $password) && preg_match("/^.{8,50}$/", $password) && preg_match("/[\[^\'£$%^&*()}{@:\'#~?><>,;@\|\\\-=\-_+\-¬\`\]]/", $password)) {
        *$result = true;
        *} else {
        *    $result = false;
        *}
         * 
         */
        
        return $result;
    }
    /**
     * post
     * 
     */

    public static function title_check($title)
    {
        $result = true;
        if (preg_match("/[a-zA-Z0-9]/", $title)) {
            if (preg_match("/^.{1,30}$/", $title)) {
                $result = true;
            } else {
                $result = false;
            }
        } else {
            $result = false;
        }
        return $result;
    }

    public static function time_check($estimated_time)
    {
        $result = true;
        if (preg_match("/^[0-9]/", $estimated_time)) {
            if (preg_match("/^.{1,3}$/", $estimated_time)) {
                $result = true;
            } else {
                $result = false;
            }
        } else {
            $result = false;
        }
        return $result;
    }

    public static function desc_check($discription)
    {
        $result = true;
        if (preg_match("/^[a-zA-Z0-9]/", $discription)) {
            if (preg_match("/^.{20,2500}$/", $discription)) {
                $result = true;
            } else {
                $result = false;
            }
        } else {
            $result = false;
        }
        return $result;
    }
}
