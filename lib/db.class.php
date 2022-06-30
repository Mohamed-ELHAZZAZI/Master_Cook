<?php

class DB
{
    protected $connection;

    public function __construct($host, $user, $password, $db_name)
    {


        try {
            $this->connection = new PDO('mysql:host=' . $host . ';dbname=' . $db_name .  $password, $user);
        } catch (\Throwable $th) {
            echo "Error : can not connect to data base";
            exit();
        }
    }
    public function query($sql , $params = [])
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        Session::set("last_id", $this->connection->lastInsertId());
        return $stmt;
    }
}
