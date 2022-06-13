<?php
include("../vendor/autoload.php");

use Helpers\HTTP;
use Libs\Database\MySQL;
use Libs\Database\Questions;
use Libs\Database\Score;
use Libs\Database\TopicsTable;

$questionId = $_GET['n'];
$answer = $_POST['answer'];
$topicId = $_GET['t_id'];
$userId = $_GET['ui'];

$questionTable = new Questions(new MySQL());
$questions = $questionTable->showQuestions($topicId);
$topicTable = new TopicsTable(new MySQL());

$score = new Score(new MySQL());

$getScores = $score->getScore($userId, $topicId);

if ($answer === $questions[$questionId]->right_answer) {
    if ($getScores) {
        $pass = $getScores->pass + 1;
        $score->update($pass, $userId, $topicId);
    } else {
        $score->insert($userId, $topicId);
    }
}

$n = $questionId + 1;
$totalQuestion = $topicTable->countTotalQuestions($topicId);
if ($n >= $totalQuestion->total) {
    $getScores = $score->getScore($userId, $topicId);
    HTTP::redirect("account.php", "result=show&q=$totalQuestion->total&r=$getScores->pass");
} else {
    HTTP::redirect("account.php", "t_id=$topicId&n=$n");
}
