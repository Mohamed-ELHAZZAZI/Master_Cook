<?php

class LoginController extends Controller
{
    public function index()
    {
        if (Session::get("user_id") != null) {
            header('location: '.URL);
            exit();
        }
        config::set('site_name', 'Login');
    }

    public function getUser()
    {

        if (isset($_POST["submit"])) {
            $password = $_POST["password"];
            $email = $_POST["email"];

            if (Helper::isEmpty([$password, $email])) {
                Session::setError("Please fill all the blanks!");
                header("location: " . URL . "/login");
                exit();
            }

            if (isset($_POST["remember"])) {
                echo "remember <br>";
                setcookie("email", $email,time() + 36000,"http://localhost/");
                setcookie("password", $password,time() + 36000,"http://localhost/");
               }else {
                setcookie("email", "");
                setcookie("password", "");
               }

            $user = User::Where("email = ?", [$email])[0];

            if ($user != null) {
                if (password_verify($password, $user->password)) {
                   Session::set("user_id", $user->id);
                   header("location: " . URL);
                }else {
                    Session::setError("Email or password is incorrect!");
                    header("location: " . URL . "/login");
                }
            } else {
                Session::setError("Email or password is incorrect!");
                header("location: " . URL . "/login");
            }
            exit();
        } else {
            header("location: " . URL . "/login");
        }
    }
}
