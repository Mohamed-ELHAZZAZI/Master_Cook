<?php

class CategoriesController extends Controller {
    public function ajax_filter()
    {
        if (isset($_POST["category"])) {
            $posts = Post::Where("catigories = ?", [$_POST["category"]]);
            echo json_encode($posts);
            
        }
    }
}