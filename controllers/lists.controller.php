<?php

class ListsController extends Controller
{

    public function ajax_like()
    {
        if (isset($_POST["like"])) {
            $user_id = Session::get("user_id");
            $post_id = $this->parms[0];

            if ((bool)$_POST["like"] === true) {
                Favorite::delete_like($user_id, $post_id);
                $like = false;
            } else {
                Favorite::set_like($user_id, $post_id);
                $like = true;
            }

            echo json_encode([
                "like" =>  $like,
                "post_id" => $post_id
            ]);
        }
    }
}
