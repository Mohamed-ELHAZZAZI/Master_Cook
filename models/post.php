<?php

class Post extends Model
{
    public $owner_id, $title, $discription, $estimated_time, $catigories, $image, $video, $is_confirmed;


    /**
     * @return mixed;
     * 
     */

    public static function getAllPosts()
    {
        $sql = "SELECT *,( SELECT COUNT(*) FROM `my_lists` m WHERE m.`user_id` = ? AND m.`post_id` = p.id ) AS 'isliked' FROM postes p WHERE is_confirmed = ? ORDER BY id DESC";
        return App::$db->query($sql, [Session::get("user_id"), 1])->fetchAll(PDO::FETCH_CLASS, Post::class);
    }

    /**
     * @return mixed;
     * 
     */

    public static function getPost($post_id)
    {
        $sql = "SELECT * FROM postes Where id = ?";
        $post = App::$db->query($sql, [$post_id])->fetchAll(PDO::FETCH_CLASS, Post::class);
        if (isset($post[0]))
            return  $post[0];
        else
            return null;
    }


    public static function Where($where = "", $params = [])
    {
        $sql = "SELECT *,( SELECT COUNT(*) FROM `my_lists` m WHERE m.`user_id` = ? AND m.`post_id` = p.id ) AS 'isliked'  FROM postes p";
        if ($where != "") {
            $sql .= " WHERE " . $where;
        }
        array_unshift($params, Session::get("user_id"));
        $exists =  App::$db->query($sql, $params)->fetchAll(PDO::FETCH_CLASS, Post::class);
        if (isset($exists)) {
            return $exists;
        } else {
            return null;
        }
    }


    public static function setPost($owner_id, $title, $discription, $estimated_time, $catigories, $image, $video)
    {
        $sql = "INSERT INTO postes(owner_id, title,discription,estimated_time,catigories,image,video) value (?,?,?,?,?,?,?)";
        return App::$db->query($sql, [$owner_id, $title, $discription, $estimated_time, $catigories, $image, $video]);
    }

    public function update()
    {
        $sql = "UPDATE   postes SET owner_id = ? , title = ? ,discription = ? ,estimated_time = ? ,catigories = ? ,image = ? ,video = ? , is_confirmed = ? WHERE id = ?";
        return App::$db->query($sql, [$this->owner_id, $this->title, $this->discription, $this->estimated_time, $this->catigories, $this->image, $this->video, $this->is_confirmed, $this->id]);
    }

    public static function delete($id)
    {
        $sql = "DELETE FROM postes WHERE id = ?";
        return App::$db->query($sql, [$id]);
    }


    /**
     * @return mixed;
     * 
     */

    public static function chng_statut($param = [])
    {
        $sql = "UPDATE postes SET is_confirmed = ? Where id = ?";
        $post = App::$db->query($sql, $param)->fetchAll(PDO::FETCH_CLASS, Post::class);
        if (isset($post[0]))
            return  $post[0];
        else
            return null;
    }
}
