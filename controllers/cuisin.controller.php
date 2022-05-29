<?php

class CuisinController extends Controller {
    public function chef()
    {
        if (!isset($this->parms[0]) && !isset($_POST["search_btn"])) {
            header('location: '.URL);
            exit();
        }

        if (isset($_POST["search_btn"])) {
            // $list = FaveList::Where(" AND is_confirmed = ?", ['%' . $_POST["search"] . '%', '%' . $_POST["search"] . '%', 1]);
            $list = Post::Where("(title LIKE ? OR discription LIKE ? ) AND  owner_id = ? AND is_confirmed = ?" , [ '%' . $_POST["search"] . '%', '%' . $_POST["search"] . '%', Session::get("chef_id") , 1]);
        } else {
            $chef_id = $this->parms[0];
            Session::set("chef_id" ,$chef_id);
            $list = Post::Where("owner_id = ? AND is_confirmed = ?" , [$chef_id , 1]);
        }
        
        $this->data["chef"] =  User::find( Session::get("chef_id"));
        $this->data["postes"] = $list;
    }
}