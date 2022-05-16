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
        $this->data["chef"] = User::find($post->owner_id);
        $this->data["post"] = $post;
    }

    public function create()
    {
    }
    public function post()
    {


        if (isset($_POST["create_post"])) {
            $title = $_POST["title"];
            $time = $_POST["time"];
            $categories = $_POST["categories"];
            $desc = $_POST["desc"];

            $owner_id = Session::get("user_id");


            if (Helper::isEmpty([$title, $time, $categories, $desc])) {
                Session::setError("Please fill all the blankc");
                header("location: " . URL . "/posts/create");
                exit();
            }

            // if (!Helper::title_check($title)) {
            //     Session::setError("Invalid title format");
            //     header("location: " . URL . "/posts/create");
            //     exit();
            // }

            // if (!Helper::time_check($time)) {
            //     Session::setError("Invalid estimated time format");
            //     header("location: " . URL . "/posts/create");
            //     exit();
            // }

            // if (!Helper::desc_check($desc)) {
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
                            Post::setPost($owner_id, $title, $desc, $time, $categories, $image, $video);
                            Session::setFlash("Post created");
                            header("location: " . URL . "/posts/show/" . Session::get("last_id"));
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

    public function modify()
    {
        if (isset($_POST["delete"])) {
            $id = $this->parms[0];
            Post::delete($id);
            Session::setFlash("Post deleted");

            header("location: " . URL);

            exit();
        } else {
            $id = $this->parms[0];
            $post = Post::getPost($id);
            $this->data["post"] = $post;
            
        }
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


            if (!Helper::isEmpty([$_POST["title"], $_POST["time"], $_POST["disc"]])) {

                // if (!Helper::title_check($_POST["title"])) {
                //     Session::setError("Invalid title format");
                //     header("location: " . URL . "/posts/modify/" . $id);
                //     exit();
                // }

                // if (!Helper::time_check($_POST["time"])) {
                //     Session::setError("Invalid estimated time format");
                //     header("location: " . URL . "/posts/modify/" . $id);
                //     exit();
                // }

                // if (!Helper::desc_check($_POST["disc"])) {
                //     Session::setError("Invalid discription format");
                //     header("location: " . URL . "/posts/modify/" . $id);
                //     exit();
                // }

                $post->title =  $_POST["title"];
                $post->estimated_time =  $_POST["time"];
                $post->discription =  $_POST["disc"];
            } else {
                Session::setError("Please fill all the blankc");
                header("location: " . URL . "/posts/modify/" . $id);
                exit();
            }

            if (!Helper::isEmpty([$_POST["categories"]])) {
                $post->catigories =  $_POST["categories"];
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
            Session::setFlash("Post updated");
            header("location: " . URL . "/posts/show/" . $post->id);
        }
        exit();
    }
}
