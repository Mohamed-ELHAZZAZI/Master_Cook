<?php

class RegisterController extends Controller{
    public function index() {
        if (Session::get("user_id") != null) {
            header('location: '.URL);
            exit();
        }
        config::set('site_name', 'Register');
    }

    public function store()
    {
        if (isset($_POST["register"])) {
            $first_name =  $_POST["first_name"];
            $last_name =  $_POST["last_name"];
            $username = $_POST["user_name"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $repass = $_POST["repassword"];



            if (Helper::isEmpty([$first_name, $last_name, $username, $email, $password, $repass])) {
                Session::setError("Please fill all the blanks!");
                header("location: ". URL ."/register");
                exit();
            }
            if (Helper::email_check($email) !== true) {
                Session::setError("Invalid email!");
                header("location: ". URL ."/register");
                exit();
            }
            if (Helper::invalidUser_name($username) !== true) {
                Session::setError("Invalid Username");
                header("location: ". URL ."/register");
                exit();
            }

            if (Helper::user_exists($username, $email, $repass) !== false) {
                Session::setError("Username or Email already exists!");
                header("location: ". URL ."/register");

                exit();
            }
            if (Helper::pass_match($password, $repass) !== true) {
                Session::setError("Passwords don't much, try again!");
                header("location: ". URL ."/register");

                exit();
            }
            if (Helper::pass_check($password) !== true) {
                Session::setError("Make sure your password has:<br>- Between 6 and 40 characters.<br>- One capital lettere, one lower letter, one number.<br>- Special symbole (£$%^&*()}{@:\'#~?><>,;@....)");
                header("location: ". URL ."/register");
                exit();
            }

            
            $password =  password_hash($password, PASSWORD_DEFAULT);
            User::insert([$first_name, $last_name, $username, $email, $password]);
            Session::set("user_id", Session::get("last_id"));
            Session::setFlash('user created');
            header("location: ". URL ."/users/profile");
        }else {
            header("location: ". URL ."/register");
        }
     
    }
}