<?php

class PagesController extends Controller
{
    public function index()
    {
        if (isset($_POST["search_btn"])) {
            $postes = Post::Where("(title LIKE ? OR discription LIKE ? ) AND is_confirmed = ?", ['%' . $_POST["search"] . '%', '%' . $_POST["search"] . '%', 1]);
        } else {
            $postes = Post::getAllPosts();
        }

        $this->data["postes"] = $postes;
    }
    public function view()
    {
        $parms = App::getRouter()->getParms();

        if (isset($parms[0])) {
            $alias = strtolower($parms[0]);

            $this->data['content'] = "here will be a page with " .  $alias . " alias";
        }
    }
}
