<?php


class PostsController extends Controller
{
    public  function show()
    {
        $postId =  $this->parms[0];
        $post = Post::getPost($postId);
        if (empty($post)) {
            echo "post not found";
            exit();
        }
        if ($post->is_confirmed || (Session::get("admin") && isset($_POST["view"]))) {

            $this->data["chef"] = User::find($post->owner_id);
            $this->data["post"] = $post;
        } else {
            Session::setError("Post not confirmed");
            header("location: " . URL);
            exit();
        }
    }

    public function create()
    {
    }
    public function post()
    {


        if (isset($_POST["create_post"])) {
            $title = $_POST["title"];
            $estimated_time = $_POST["estimated_time"];
            $catigories = $_POST["catigories"];
            $discription = $_POST["discription"];

            $owner_id = Session::get("user_id");


            if (Helper::isEmpty([$title, $estimated_time, $catigories, $discription])) {
                Session::setError("Please fill all the blankc");
                header("location: " . URL . "/posts/create");
                exit();
            }

            // if (!Helper::title_check($title)) {
            //     Session::setError("Invalid title format");
            //     header("location: " . URL . "/posts/create");
            //     exit();
            // }

            // if (!Helper::time_check($estimated_time)) {
            //     Session::setError("Invalid estimated estimated_time format");
            //     header("location: " . URL . "/posts/create");
            //     exit();
            // }

            // if (!Helper::desc_check($discription)) {
            //     Session::setError("Invalid discription format");
            //     header("location: " . URL . "/posts/create");
            //     exit();
            // }

            if (isset($_FILES['image'])) {
                $file_temp = $_FILES['image']['tmp_name'];
                if (!empty($file_temp)) {
                    $allowed_ext = array("jpeg", "jpg", "gif", "png", "jfif");
                    $exp = explode(".", $_FILES['image']['name']);
                    $ext = end($exp);

                    $file_name =   $title . "_owner_id_" . $owner_id . "." . $ext;
                    $path = ROOT . S . "webroot" . S . "upload" . S . "media" . S . "posts_image" . S . $file_name;
                    if (in_array($ext, $allowed_ext)) {
                        if (move_uploaded_file($file_temp, $path)) {
                            $image =   "/webroot/upload/media/posts_image/" . $file_name;
                        }
                    } else {
                        Session::setError("invalid image extention");
                        header("location: " . URL . "/posts/create");
                    }
                }


                if (isset($_FILES['video'])) {
                    $file_temp = $_FILES['video']['tmp_name'];
                    $allowed_ext = array("mp4");
                    $exp = explode(".", $_FILES['video']['name']);
                    $ext = end($exp);
                    $file_name = "45" . "." . $ext;
                    $path = ROOT . S . "webroot" . S . "upload" . S . "media" . S . "posts_video" . S . $file_name;
                    if (in_array($ext, $allowed_ext)) {
                        if (move_uploaded_file($file_temp, $path)) {
                            $video = "/upload/media/posts_video/" . $file_name;
                            Post::setPost($owner_id, $title, $discription, $estimated_time, $catigories, $image, $video);
                            Session::setFlash("Post created, Please wait for the confirmation");
                            header("location: " . URL);
                        }
                    } else {
                        Session::setError("Only mp4 is accepted");
                        header("location: "  . URL . "/posts/create");
                    }
                } else {
                    Session::setError("Vedio is required");
                    header("location: "  . URL . "/posts/create");
                }
            } else {

                Session::setError("Image is required");
                header("location: " . URL . "/posts/create");
            }
        }
        exit();
    }

    public function delete()
    {
        $id = $this->parms[0];
        $post = Post::getPost($id);
        if (Session::get("user_id") != $post->owner_id && !Session::get("admin")) {
            header("location: " . URL . "/posts/show/" . $post->id);
            exit();
        }
        Post::delete($id);
        Session::setFlash("Post deleted");
        header("location: " . URL);
        exit();
    }



    public function modify()
    {
        $id = $this->parms[0];
        $post = Post::getPost($id);
        if (Session::get("user_id") != $post->owner_id) {
            header("location: " . URL . "/posts/show/" . $post->id);
            exit();
        }

        $this->data["post"] = $post;
    }


    public function update()
    {

        $id = $this->parms[0];
        if (isset($_POST["update"])) {


            $post = Post::getPost($id);
            if ($post->owner_id != Session::get("user_id")) {
                Session::setError("ERROR");
                header("location: " . URL);
                exit();
            }


            $post->owner_id = Session::get("user_id");


            if (!Helper::isEmpty([$_POST["title"], $_POST["estimated_time"], $_POST["discription"]])) {

                // if (!Helper::title_check($_POST["title"])) {
                //     Session::setError("Invalid title format");
                //     header("location: " . URL . "/posts/modify/" . $id);
                //     exit();
                // }

                // if (!Helper::time_check($_POST["estimated_time"])) {
                //     Session::setError("Invalid estimated estimated_time format");
                //     header("location: " . URL . "/posts/modify/" . $id);
                //     exit();
                // }

                // if (!Helper::desc_check($_POST["discription"])) {
                //     Session::setError("Invalid discription format");
                //     header("location: " . URL . "/posts/modify/" . $id);
                //     exit();
                // }

                $post->title =  $_POST["title"];
                $post->estimated_time =  $_POST["estimated_time"];
                $post->discription =  $_POST["discription"];
                $post->is_confirmed = 0;
            } else {
                Session::setError("Please fill all the blankc");
                header("location: " . URL . "/posts/modify/" . $id);
                exit();
            }

            if (!Helper::isEmpty([$_POST["catigories"]])) {
                $post->catigories =  $_POST["catigories"];
            } else {
                Session::setError("Please Choose a categorie");
                header("location: " . URL . "/posts/modify/" . $id);
                exit();
            }



            if (isset($_FILES['image'])) {
                $file_temp = $_FILES['image']['tmp_name'];
                if (!empty($file_temp)) {
                    $allowed_ext = array("jpeg", "jpg", "gif", "png", "jfif");
                    $exp = explode(".", $_FILES['image']['name']);
                    $ext = end($exp);
                    $file_name =  $post->title . "_owner_id_" . $post->owner_id . "." . $ext;
                    $path = ROOT . S . "webroot" . S . "upload" . S . "media" . S . "posts_image" . S . $file_name;
                    if (in_array($ext, $allowed_ext)) {
                        if (move_uploaded_file($file_temp, $path)) {
                            $post->image =  "/webroot/upload/media/posts_image/" . $file_name;
                        }
                    } else {
                        Session::setError("invalid image extention");
                        header("location: " . URL . "/posts/modify/" . $id);
                    }
                }
            }

            if (isset($_FILES['video'])) {
                $file_temp = $_FILES['video']['tmp_name'];
                if (!empty($file_temp)) {
                    $allowed_ext = array("mp4");
                    $exp = explode(".", $_FILES['video']['name']);
                    $ext = end($exp);
                    $file_name = $post->title . "_owner_id_" . $post->owner_id . "." . $ext;
                    $path = ROOT . S . "webroot" . S . "upload" . S . "media" . S . "posts_video" . S . $file_name;
                    if (in_array($ext, $allowed_ext)) {
                        if (move_uploaded_file($file_temp, $path)) {
                            $post->video = "/upload/media/posts_video/" . $file_name;
                        }
                    } else {
                        Session::setError("Only mp4 is accepted");
                        header("location: "  . URL . "/posts/modify/" . $id);
                    }
                }
            }

            $post->update();
            Session::setFlash("Post updated, please wait for the confirmation");
            header("location: " . URL);
        }
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
            $posts = Post::Where("(id LIKE ? OR title LIKE ? OR discription LIKE ?) AND  is_confirmed = ?", ['%' . $search . '%', '%' . $search . '%', '%' . $search . '%', 0]);
        } else {
            $posts = Post::Where("is_confirmed = ?", [0]);
        }

        $this->data["posts"] = $posts;
    }
    public function admin_delete()
    {
        if (!Session::get("admin")) {
            echo "page not found";
            exit();
        }
        $id = $this->parms[0];
        if (isset($_POST["delete"])) {
            Post::delete($id);
            Session::setFlash("Post Deleted");
            header("location: " . URL . "/admin/posts");
        }
        exit();
    }

    public function admin_accepte()
    {
        if (!Session::get("admin")) {
            echo "page not found";
            exit();
        }
        $id = $this->parms[0];
        if (isset($_POST["accepte"])) {
            Post::chng_statut([1, $id]);
            Session::setFlash("Post Accepted");
            header("location: " . URL . "/admin/posts");
        }
        exit();
    }
    public function unconfirm()
    {
        if (!Session::get("admin")) {
            echo "page not found";
            exit();
        }
        $id = $this->parms[0];
        if (isset($_POST["unconfirm"])) {
            Post::chng_statut([0, $id]);
            Session::setFlash("Post  Unconfirmd");
            header("location: " . URL);
        }
    }

    public function ajax_index()
    {
        if (isset($_POST["limit"]) && isset($_POST["category"])) {
            if ($_POST["category"] === "all") {
                $posts = Post::Where("", [], [$_POST["limit"], $_POST["limit"] + 9]);
            } else {
                $posts = Post::Where("catigories = ? AND is_confirmed = ?", [$_POST["category"] , 1], [$_POST["limit"], $_POST["limit"] + 9]);
            }
            echo json_encode($posts);
        } else {
            echo json_encode([]);
        }
    }
}
