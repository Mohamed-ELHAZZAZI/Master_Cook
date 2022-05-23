<?php

class MylistsController extends Controller
{
    public function index()
    {
        if (Session::get("user_id") === null) {
            header("location: " . URL);
            exit();
        }
        $user_id = Session::get("user_id");
        if (isset($_POST["search_btn"])) {
            $list = FaveList::Where("(title LIKE ? OR discription LIKE ? ) AND is_confirmed = ?", ['%' . $_POST["search"] . '%', '%' . $_POST["search"] . '%', 1]);
        } else {
            $list = FaveList::get_my_lists($user_id);
        }

        $this->data["postes"] = $list;
    }
}
