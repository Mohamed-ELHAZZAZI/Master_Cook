<?php

class RegisterController extends Controller{
    public function index() {

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
                Session::setError("Username od Email already exists!");
                header("location: ". URL ."/register");

                exit();
            }
            if (Helper::pass_match($password, $repass) !== true) {
                Session::setError("Passwods don't much, try again!");
                header("location: ". URL ."/register");

                exit();
            }
            if (Helper::pass_check($password) !== true) {
                Session::setError("Weak password, Try again!");
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