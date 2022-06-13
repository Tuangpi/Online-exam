<?php

namespace Libs\Database;

class Score
{
    private $db = null;
    public function __construct(MySQL $mysql)
    {
        $this->db = $mysql->connect();
    }

    public function insert($userId, $topicId)
    {
        $statement = $this->db->prepare("INSERT INTO scores(user_id, pass, topic_id) VALUES(:userId, 1, :topicId)");
        $statement->execute(["userId" => $userId, "topicId" => $topicId]);

        return $this->db->lastInsertId();
    }

    public function update($pass, $userId, $topicId)
    {
        $statement = $this->db->prepare("UPDATE scores SET pass = :pass WHERE user_id = :user_id AND topic_id = :topicId");
        $statement->execute(["pass" => $pass, "user_id" => $userId, "topicId" => $topicId]);

        return $statement->rowCount();
    }

    public function getScore($userId, $topicId)
    {
        $statement = $this->db->prepare("SELECT * FROM scores WHERE user_id = :userId AND topic_id = :topicId");
        $statement->execute(["userId" => $userId, "topicId" => $topicId]);
        return $statement->fetch();
    }

    public function getAll()
    {
        $statement = $this->db->query("SELECT DISTINCT user_id, users.name, users.email, users.gender,users.college, SUM(pass*2) OVER (PARTITION BY user_id) total_pass  FROM scores LEFT JOIN users ON scores.user_id = users.id ORDER BY total_pass DESC");
        return $statement->fetchAll();
    }

    public function deleteScore($userId, $topicId)
    {
        $statement = $this->db->prepare("DELETE FROM scores WHERE user_id = :userId AND topic_id = :topicId");
        $statement->execute(["userId" => $userId, "topicId" => $topicId]);
        return $statement->rowCount();
    }
}
