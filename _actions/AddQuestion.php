<?php
include("../vendor/autoload.php");

use Helpers\HTTP;
use Libs\Database\MySQL;
use Libs\Database\Questions;

$data = [
    "content" => $_POST["content"],
    "topic_id" => $_POST["topicId"],
    "option1" => $_POST["option1"],
    "option2" => $_POST["option2"],
    "option3" => $_POST["option3"],
    "option4" => $_POST["option4"],
    "right_answer" => $_POST["answer"],
];

$addQuestion = new Questions(new MySQL());
$addedQuestion = $addQuestion->insert($data);

if ($addedQuestion) {
    HTTP::redirect("dashboard.php", "insertQ=true");
} else {
    HTTP::redirect("dashboard.php", "insertQ=true&error=true");
}
