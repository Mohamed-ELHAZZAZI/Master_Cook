<?php

class PagesController extends Controller
{
    public function index()
    {
        // $this->data['test_content'] =  "Here will be a pages lists";
        $postes = Post::getAllPosts();
        $this->data["postes"] = $postes;
    }
    public function view()
    {
        $parms = App::getRouter()->getParms();

        if (isset($parms[0])) {
            $alias = strtolower($parms[0]);

            $this->data['content'] = "here will be a page with ".  $alias." alias";
        }
    }



}
