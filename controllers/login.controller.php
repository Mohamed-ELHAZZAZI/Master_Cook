<?php

class LoginController extends Controller
{
    public function index()
    {
        if (Session::get("user_id") != null) {
            header('location: '.URL);
            exit();
        }
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

            $user = User::Where("email = ?", [$email]);

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
