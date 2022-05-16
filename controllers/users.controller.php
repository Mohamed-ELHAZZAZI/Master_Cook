<?php

class UsersController extends Controller
{

    public function register()
    {
    }



    public function profile()
    {
        $user = User::find(Session::get("user_id"));
        $this->data["user"] = $user;
    }


    public function login()
    {
    }

    public function index()
    {
        // if (isset($_POST["search"])) {
        //     $search = $_POST["search_value"];
        //     $users = User::Where($where = "id = ? OR first_name = ? OR last_name = ? OR user_name = ? OR email = ? ", [$search, $search, $search, $search, $search]);
        // } else {
        //     $users = User::all();
        // }

        // $this->data["users"] = $users;
    }

    public function delete()
    {
        if (isset($_POST["delete"])) {
            $id =  $_POST["id"];
            User::delete($id);
            Session::setError('user deleted');
            header("location: " . URL . "/users/show");
        }
        exit();
    }
    public function modify()
    {
        $id =  $this->parms[0];

        $user = User::find($id);
        $this->data["user"] = $user;
    }


    public function chat()
    {
        // $id =  $this->parms[0];

        // $user = User::find($id);
        // $this->data["user"] = $user;
    }
    public function logout()
    {
        Session::destroy();
        header("location: " . URL);
        exit();
    }



    public function update()
    {

        if (isset($_POST["update"])) {
            
            $id = Session::get("user_id");
            $user = User::find($id);
            if ($user->id != Session::get("user_id")) {
                Session::setError("Ukonwn error, try again later");
                header("location: " . URL);
                exit();
            }

            if (!Helper::isEmpty([$_POST["first_name"], $_POST["last_name"], $_POST["username"] , $_POST["email"] ])) {

                if (!Helper::email_check($_POST["email"])) {
                    Session::setError("Invalid username format");
                    header("location: " . URL . "/users/profile");
                    exit();
                }

                $user->first_name =  $_POST["first_name"];
                $user->last_name =  $_POST["last_name"];
                $user->email =  $_POST["email"];
                $user->user_name = $_POST["username"];
            } else {
                Session::setError("Please fill all the blankc");
                header("location: " . URL . "/users/profile");
                exit();
            }

            $user->update();
            Session::setFlash("Profile updated!");
            header("location: " . URL . "/users/profile");
        }
        exit();
    }



}
