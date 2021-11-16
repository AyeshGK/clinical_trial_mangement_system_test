<?php

namespace app\Models;

use app\core\database\Database;
use app\core\DBModel;

class User extends DBModel
{
    private string $primary_user_id;
    private string $user_name;
    private string $user_email;
    private string $user_uid;
    private string $user_pwd;
    private string $user_pwd_repeat;


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

//    public function register()
//    {
//        $sql = "INSERT INTO users (user_name,user_email,user_uid,user_pwd)
//                VALUES (:user_name,:user_email,:user_uid,:user_pwd)";
//
//        $user_data = [
//            "user_name" => $this->user_name,
//            "user_email" => $this->user_email,
//            "user_uid" => $this->user_uid,
//            "user_pwd" => $this->user_pwd,
//        ];
//
//        /*enter the data to database*/
//        try {
//            $this->db->query($sql);
//            $this->db->bindMultipleValues($user_data);
//            $this->db->execute();
//
//            return true;
//
//        } catch (\PDOException $error) {
//            echo "ERROR " . $error->getMessage();
//
//            return false;
//        }
//
////        echo "successfully entered data" . '<br>';;
//
//    }

    public function validate(): bool
    {
        return $this->user_name && $this->user_email && $this->user_pwd &&
            $this->user_pwd_repeat && $this->user_uid;
    }

    protected function getTableName(): string
    {
        return "users";
    }

    protected function getAttributes(): array
    {
        return ["user_name", "user_email", "user_uid", "user_pwd",];
    }

    protected function getPrimaryKey(): string
    {
        return "user_id";
    }

    protected function getData(): array
    {
        return [
            "user_name" => $this->user_name,
            "user_email" => $this->user_email,
            "user_uid" => $this->user_uid,
            "user_pwd" => $this->user_pwd,
        ];
    }

    protected function getPrimaryValue(): string
    {
        return $this->primary_user_id;
    }
}
