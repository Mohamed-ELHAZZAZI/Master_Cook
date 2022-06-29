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
        config::set('site_name', 'My Profile');
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

            if (!Helper::isEmpty([$_POST["first_name"], $_POST["last_name"], $_POST["username"], $_POST["email"]])) {

                if (!Helper::email_check($_POST["email"])) {
                    Session::setError("Invalid email format");
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


    public static function updateProfile()
    {


        if (isset($_POST["save_img"])) {
            $id = Session::get("user_id");
            $user = User::find($id);
            if ($user->id != Session::get("user_id")) {
                Session::setError("Ukonwn error, try again later");
                header("location: " . URL . "/users/profile");
                exit();
            }
            if (isset($_FILES['image'])) {
                $file_temp = $_FILES['image']['tmp_name'];
                if (!empty($file_temp)) {
                    $allowed_ext = array("jpeg", "jpg", "gif", "png", "jfif","JPEG", "JPG", "GIF", "PNG", "JFIF");
                    $exp = explode(".", $_FILES['image']['name']);
                    $ext = end($exp);
                    $file_name =  "profile_= " . $user->id . "." . $ext;
                    $path = ROOT . S . "webroot" . S . "upload" . S . "users_profile" . S . $file_name;
                    if (in_array($ext, $allowed_ext)) {
                        if (move_uploaded_file($file_temp, $path)) {
                            $user->profile_img =  "/webroot/upload/users_profile/" . $file_name;
                            $user->updateProfile();
                            Session::setFlash("Profile changed");
                            header("location: " . URL . "/users/profile");
                        }
                    } else {
                        Session::setError("invalid image extention");
                        header("location: " . URL . "/users/profile");
                    }
                }
            }
        } elseif (isset($_POST["delete_profile"])) {
            $id = Session::get("user_id");
            $user = User::find($id);
            if ($user->id != Session::get("user_id")) {
                Session::setError("Ukonwn error, try again later");
                header("location: " . URL . "/users/profile");
                exit();
            }

            $user->profile_img =  "/webroot/upload/users_profile/1.png";
            $user->updateProfile();
            Session::setFlash("Profile removed");
            header("location: " . URL . "/users/profile");
        }
        header("location: " . URL . "/users/profile");
        exit();
    }


    public function admin_index()
    {
        if (!Session::get("admin")) {
            echo "page not found";
            exit();
        }
        if (isset($_POST["search"])) {
            $search = $_POST["search"];
            $users = User::Where("id LIKE ? OR first_name LIKE ? OR last_name LIKE ? OR user_name LIKE ? OR email LIKE ? ", ['%' . $search . '%', '%' . $search . '%', '%' . $search . '%', '%' . $search . '%', '%' . $search . '%']);
        } else {
            $users = User::all([0, 10]);
        }
        config::set('site_name', 'Master cook-User\'s Admin Panel');
        $this->data["users"] = $users;
    }
    public function admin_delete()
    {
        if (!Session::get("admin")) {
            echo "page not found";
            exit();
        }
        $id = $this->parms[0];
        if (isset($_POST["delete"])) {
            User::delete($id);
            Session::setFlash("User deleted!");
            header("location: " . URL . "/admin/users");
        }
    }
    public function admin_admin()
    {
        if (!Session::get("admin")) {
            echo "page not found";
            exit();
        }
        $id = $this->parms[0];
        if (isset($_POST["SetAdmin"])) {
            $user = User::find($id);
            if ($user->is_admin) {
                $user->is_admin = false;
                $msg = "user degrade from admin";
            } else {
                $user->is_admin = true;
                $msg = "user upgraded to admin";
            }
            $user->updateAdmin();

            if ($user->id === Session::get("user_id")) {
                header("location: " . URL);
                $msg = "You are no more";
                exit();
            }
            Session::setWarning($msg);
            header("location: " . URL . "/admin/users");
            exit();
        }
        echo "Error";
        exit();
    }
    public function ajax_index()
    {
        if (isset($_POST["limit"])) {
            $users = User::all([$_POST["limit"], $_POST["limit"] + 10]);
            echo json_encode($users);
        } else {
            echo json_encode([]);
        }
    }
}
