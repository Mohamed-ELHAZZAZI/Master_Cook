<?php


class User extends Model
{

    public $id;
    public $user_name;
    public $email;
    public $password;
    public $last_name;
    public $profile_img;
    public $first_name;
    public $is_admin;

    /**
     * 
     * sign up
     */



    public static function insert($params = [])
    {
        $sql = "INSERT INTO users(first_name , last_name , user_name, email , password) value (?,?,?,?,?)";
        return App::$db->query($sql, $params);
    }




    /**
     * 
     * 
     * 
     */



    public static function find($id)
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        return App::$db->query($sql, [$id])->fetchAll(PDO::FETCH_CLASS, User::class)[0];
    }

    public static function all($limit = [-1 , -1])
    {
        $sql = "SELECT * FROM users ";
        if ($limit[0] >= 0 && $limit[1] > 0 && $limit[0] < $limit[1] + 1 ) {
            $sql .= " LIMIT " . $limit[0].",".$limit[1];
        }
        return App::$db->query($sql)->fetchAll(PDO::FETCH_CLASS, User::class);
    }

    public static function Where($where = "", $params = [])
    {
        $sql = "SELECT * FROM users ";
        if ($where != "") {
            $sql .= " WHERE " . $where;
        }
        $exists =  App::$db->query($sql, $params)->fetchAll(PDO::FETCH_CLASS, User::class);
        if (isset($exists)) {
            return $exists;
        }else {
            return null;
        }
    }

    
    public static function delete($id)
    {
        $sql = "DELETE FROM users WHERE id = ?";
        return App::$db->query($sql, [$id]);
    }

    public static function modify($first_name, $last_name, $username, $email, $image, $id)
    {
        $sql = "UPDATE users SET  first_name = ? , last_name = ? , user_name = ? , email = ? , profile_img = ? WHERE id = ?";
        return App::$db->query($sql, [$first_name, $last_name, $username, $email, $image, $id]);
    }


    


    public function update()
    {
        $sql = "UPDATE users SET user_name = ? , last_name = ? ,first_name = ? ,email = ? WHERE id = ?";
        return App::$db->query($sql, [$this->user_name, $this->last_name, $this->first_name, $this->email, $this->id]);
    }

    public function updateProfile() {
        $sql = "UPDATE users SET profile_img = ? WHERE id = ?";
        return App::$db->query($sql, [$this->profile_img, $this->id]);
    }

    public function updateAdmin() {
        $sql = "UPDATE users SET is_admin = ? WHERE id = ?";
        return App::$db->query($sql, [$this->is_admin, $this->id]);
    }
}
