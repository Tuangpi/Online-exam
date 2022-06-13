<?php

namespace Libs\Database;

use PDOException;

class UsersTable
{
    private $db = null;

    public function __construct(MySQL $mysql)
    {
        $this->db = $mysql->connect();
    }

    public function insert($data)
    {
        try {
            $statement = $this->db->prepare("INSERT INTO users(name, email, phone_number, password, created_at, address, gender, college) VALUES(:name, :email, :phone_number, :password, NOW(), :address, :gender, :college)");

            $statement->execute($data);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function findByEmailAndPassword($email, $password)
    {
        $statement = $this->db->prepare("SELECT id, name, email, password FROM users WHERE :email = email AND :password = password");
        $statement->execute(["email" => $email, "password" => $password]);

        $row = $statement->fetch();
        return $row ?? false;
    }

    public function getAll()
    {
        $statement = $this->db->query("SELECT * FROM users");
        return $statement->fetchAll();
    }
}
