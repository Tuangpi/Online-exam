<?php
namespace Libs\Database;

class FeedBack
{
    private $db = null;

    public function __construct(MySQL $mysql) {
        $this->db = $mysql->connect();
    }

    public function getAll()
    {
        $statement = $this->db->query("SELECT * FROM feedbacks");
        return $statement->fetchAll();
    }
}