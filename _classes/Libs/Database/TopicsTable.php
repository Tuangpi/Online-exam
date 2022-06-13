<?php

namespace Libs\Database;

use PDO;

class TopicsTable
{
    private $mydb = null;

    public function __construct(MySQL $mysql)
    {
        $this->mydb = $mysql->connect();
    }

    public function getAllTopic()
    {
        $statement = $this->mydb->query("SELECT * from topics");
        return $statement->fetchAll();
    }

    public function countTotalQuestions($id)
    {
        $statement = $this->mydb->prepare("SELECT COUNT(topic_id) AS total FROM questions WHERE questions.topic_id = :id");
        $statement->execute(["id" => $id]);

        return $statement->fetch();
    }

    public function getHistory($id)
    {
        $statement = $this->mydb->prepare("SELECT scores.*, topics.* FROM scores LEFT JOIN topics ON scores.topic_id = topics.id WHERE scores.user_id = :id ORDER BY scores.topic_id ASC;");
        $statement->execute(["id" => $id]);
        return $statement->fetchAll();
    }
}
