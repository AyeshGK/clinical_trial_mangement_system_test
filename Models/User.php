<?php

namespace app\Models;

use app\core\database\Database;

class User
{
    private Database $db;
    private string $user_name;
    private string $user_email;
    private string $user_uid;
    private string $user_pwd;
    private string $user_pwd_repeat;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->db = new Database();
    }

    public function setUserDetails($body)
    {
        $this->user_name = $body['user_name'];
        $this->user_email = $body['user_email'];
        $this->user_uid = $body['user_uid'];
        $this->user_pwd = password_hash($body['user_pwd'], PASSWORD_DEFAULT);
        $this->user_pwd_repeat = $body['user_pwd_repeat'];
    }

    public function userName(): string
    {
        return "user_name :" . $this->user_name;
    }

    public function register()
    {
        $sql = "INSERT INTO users (user_name,user_email,user_uid,user_pwd)
                VALUES (:user_name,:user_email,:user_uid,:user_pwd)";

        $this->db->query($sql);

        $user_data = [
            "user_name" => $this->user_name,
            "user_email" => $this->user_email,
            "user_uid" => $this->user_uid,
            "user_pwd" => $this->user_pwd,
        ];
        $this->db->bindMultipleValues($user_data);


        $this->db->execute();

        echo "successfully entered data" . '<br>';;


    }
}
