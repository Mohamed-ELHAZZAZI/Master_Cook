<?php

class CuisinController extends Controller {
    public function chef()
    {
        if (!isset($this->parms[0]) && !isset($_POST["search_btn"])) {
            header('location: '.URL);
            exit();
        }

        if (isset($_POST["search_btn"])) {
            $list = Post::Where("(title LIKE ? OR discription LIKE ? ) AND  owner_id = ? AND is_confirmed = ?" , [ '%' . $_POST["search"] . '%', '%' . $_POST["search"] . '%', Session::get("chef_id") , 1]);
        } else {
            $chef_id = $this->parms[0];
            Session::set("chef_id" ,$chef_id);
            $list = Post::Where("owner_id = ? AND is_confirmed = ?" , [$chef_id , 1]);
        }
        $chef_info = User::find($chef_id);
        $this->data["chef"] =  User::find( Session::get("chef_id"));
        $this->data["postes"] = $list;
        
        config::set('site_name', $chef_info->user_name."'s Cuisine!");
        if (Session::get("user_id") === $chef_info->id) {
            config::set('site_name', "My Cuisine");
        }
    }
}