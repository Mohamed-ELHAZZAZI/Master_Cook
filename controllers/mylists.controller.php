<?php

class MylistsController extends Controller
{
    public function index()
    {
        $user_id = Session::get("user_id");
        if (isset($_POST["search_btn"])) {
            $list = Post::Where("(title LIKE ? OR discription LIKE ? ) AND is_confirmed = ?", ['%' . $_POST["search"] . '%', '%' . $_POST["search"] . '%', 1]);
        } else {
            $list = FaveList::get_my_lists($user_id);
        }
        $this->data["postes"] = $list;
    }
}
