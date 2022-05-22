<?php

class FaveList extends Model
{
    /**
     * @return mixed;
     * 
     */

    public static function get_my_lists()
    {
        $sql = "SELECT * FROM my_lists m INNER JOIN postes p on  m.post_id = p.id";
        $post = App::$db->query($sql)->fetchAll(PDO::FETCH_CLASS, FaveList::class);
        if (isset($post))
            return  $post;
        else
            return null;
    }


    /**
     * @return mixed;
     * 
     */

    public static function Where($where = "", $params = [])
    {
        $sql = "SELECT * FROM my_lists m INNER JOIN postes p on  m.post_id = p.id ";
        if ($where != "") {
            $sql .= " WHERE " . $where;
        }
        $exists =  App::$db->query($sql, $params)->fetchAll(PDO::FETCH_CLASS, FaveList::class);
        if (isset($exists)) {
            return $exists;
        } else {
            return null;
        }
    }


}