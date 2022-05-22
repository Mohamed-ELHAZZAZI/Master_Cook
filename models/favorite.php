<?php

class Favorite extends Model
{

     /**
      * @return mixed;
      * 
      */

     public static function set_like($user_id, $post_id)
     {
          $sql = "INSERT INTO my_lists(user_id , post_id) value (?,?)";
          return App::$db->query($sql, [$user_id, $post_id]);
     }

     public static function delete_like($user_id, $post_id)
     {
          $sql = "DELETE FROM my_lists WHERE user_id = ? AND post_id =?";
          return App::$db->query($sql, [$user_id, $post_id]);
     }
}
