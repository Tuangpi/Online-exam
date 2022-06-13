<?php
namespace Libs\Database;

class Questions
{
    private $db = null;
    public function __construct(MySQL $db) {
        $this->db = $db->connect();
    }

    public function insert($data)
    {
        $statement = $this->db->prepare("INSERT INTO questions(content, topic_id, option1, option2, option3, option4, right_answer) VALUES (:content, :topic_id, :option1, :option2, :option3, :option4, :right_answer)");
        $statement->execute($data);
        return $this->db->lastInsertId();
    }

    public function showQuestions($id)
    {
        $statement = $this->db->prepare("SELECT * FROM questions WHERE topic_id = :id");
        $statement->execute(["id" => $id]);

        return $statement->fetchAll();
    }

    public function countQuestions($topicId)
    {
        $statement = $this->db->prepare("SELECT count(content) as question_number FROM questions WHERE topic_id = :topicId;");
        $statement->execute(["topicId" => $topicId]);
        return $statement->fetch();
    }
}