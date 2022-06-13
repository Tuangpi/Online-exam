<?php

use Helpers\Auth;
use Libs\Database\FeedBack;
use Libs\Database\MySQL;
use Libs\Database\Questions;
use Libs\Database\Score;
use Libs\Database\TopicsTable;
use Libs\Database\UsersTable;

include("vendor/autoload.php");
$auth = Auth::check();

$topic_table = new TopicsTable(new MySQL());

$user_table = new UsersTable(new MySQL());

$feedback_table = new FeedBack(new MySQL());

$questionNo = new Questions(new MySQL());

$feedbacks = $feedback_table->getAll();
$users = $user_table->getAll();
$topics = $topic_table->getAllTopic();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DashBoard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .wrap {
            max-width: 60rem;
            margin: auto;
            margin-top: 4rem;
            padding: 1rem;
        }

        .question-wrap {
            max-width: 45rem;
            margin: auto;
        }

        .white-30 {
            background-color: #fbfbfb;
        }

        .my-column-l {
            width: 20rem;
        }

        a {
            text-decoration: none;
        }

        td,
        th {
            text-align: center;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container-fluid ms-1">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <a class="navbar-brand text-warning" href="#">Test Your Skill</a>
                <div class="d-flex ms-auto me-5" role="search">
                    <a href="dashboard.php" class="me-5 text-warning">
                        <i class="fas fa-user"></i><span>Hello, <?php if ($auth === "admin") echo "$auth";
                                                                else echo "$auth->name" ?></span>
                    </a>
                    <a href="/_actions/logout.php" class="text-warning">Signout</a>
                    </form>
                </div>
            </div>
    </nav>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link disabled">DashBoard</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link <?php if (isset($_GET['insertQ'])) {
                                        echo "";
                                    } else {
                                        echo "active";
                                    } ?>" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Home</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="user-tab" data-bs-toggle="tab" data-bs-target="#user-tab-pane" type="button" role="tab" aria-controls="user-tab-pane" aria-selected="false">User</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history-tab-pane" type="button" role="tab" aria-controls="history-tab-pane" aria-selected="false">History</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="ranking-tab" data-bs-toggle="tab" data-bs-target="#ranking-tab-pane" type="button" role="tab" aria-controls="ranking-tab-pane" aria-selected="false">Ranking</button>
        </li>
        <?php if ($auth !== "admin") : ?>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php if (isset($_GET['insertQ'])) {
                                            echo "active";
                                        } else {
                                            echo "";
                                        } ?>" id="add-tab" data-bs-toggle="tab" data-bs-target="#add-tab-pane" type="button" role="tab" aria-controls="add-tab-pane" aria-selected="false">Add questions</button>
            </li>
        <?php endif ?>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="feedback-tab" data-bs-toggle="tab" data-bs-target="#feedback-tab-pane" type="button" role="tab" aria-controls="feedback-tab-pane" aria-selected="false">Feedback</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade <?php if (isset($_GET['insertQ'])) {
                                        echo "";
                                    } else {
                                        echo "show active";
                                    } ?>" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
            <div class="wrap white-30">
                <?php if ($topics) : ?>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">S.N</th>
                                <th scope="col">Topic</th>
                                <th scope="col">Total Question</th>
                                <th scope="col">Marks</th>
                                <th scope="col">Time Limit</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($topics as $topic) : ?>
                                <?php $total = $topic_table->countTotalQuestions($topic->id); ?>
                                <tr>
                                    <th scope="row"><?= $topic->id ?></th>
                                    <td><?= $topic->name ?></td>
                                    <td><?= $total->total ?></td>
                                    <td><?= $topic->marks ?> </td>
                                    <td><?= $topic->time_limit ?> minutes</td>
                                    <?php $score = new Score(new MySQL());
                                    $getScores = $score->getScore($auth->id, $topic->id);
                                    if ($getScores) :
                                    ?>
                                        <td><a href="account.php?id=<?= $auth->id ?>&re= true &n=0&t_id=<?= $topic->id ?>" class="btn btn-warning btn-sm">Restart</a></td>
                                    <?php else : ?>
                                        <td><a href="account.php?id=<?= $auth->id ?>&n=0&t_id=<?= $topic->id ?>" class="btn btn-success btn-sm">Start</a></td>
                                    <?php endif ?>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <div class="text-center text-danger">There's no Data!</div>
                <?php endif ?>
            </div>
        </div>
        <div class="tab-pane fade" id="user-tab-pane" role="tabpanel" aria-labelledby="user-tab" tabindex="0">
            <div class="wrap white-30">
                <?php if ($users) : ?>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">S.N</th>
                                <th scope="col">Name</th>
                                <th scope="col">Gender</th>
                                <th scope="col">College</th>
                                <th scope="col">Email</th>
                                <th scope="col">Mobile</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user) : ?>
                                <tr>
                                    <th scope="row"><?= $user->id ?></th>
                                    <td><?= $user->name ?></td>
                                    <td><?= $user->gender ?></td>
                                    <td><?= $user->college ?></td>
                                    <td><?= $user->email ?></td>
                                    <td><?= $user->phone_number ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <div class="text-center text-danger">No Users</div>
                <?php endif ?>
            </div>
        </div>

        <?php $histories = $topic_table->getHistory($auth->id); ?>
        <div class="tab-pane fade" id="history-tab-pane" role="tabpanel" aria-labelledby="history-tab" tabindex="0">
            <div class="wrap white-30">
                <?php if ($histories) : ?>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">S.N</th>
                                <th scope="col">Quiz</th>
                                <th scope="col">Question Solved</th>
                                <th scope="col">Right</th>
                                <th scope="col">Wrong</th>
                                <th scope="col">Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $scoresTable = new Score(new MySQL());
                            foreach ($histories as $history) :
                                $questionCount = $questionNo->countQuestions($history->topic_id); ?>
                                <tr>
                                    <th scope="row"><?= $history->id ?></th>
                                    <td><?= $history->name ?></td>
                                    <td><?= $questionCount->question_number ?></td>
                                    <td><?= $history->pass ?></td>
                                    <td><?= $questionCount->question_number - $history->pass ?></td>
                                    <td><?= $history->pass * 2 ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <div class="text-center text-danger">No History</div>
                <?php endif ?>
            </div>
        </div>


        <div class="tab-pane fade" id="ranking-tab-pane" role="tabpanel" aria-labelledby="ranking-tab" tabindex="0">
            <div class="wrap white-30">
                <?php $scores = $scoresTable->getAll();
                if ($scores) : ?>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Rank</th>
                                <th scope="col">Name</th>
                                <th scope="col">Gender</th>
                                <th scope="col">College</th>
                                <th scope="col">Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $scores = $scoresTable->getAll();
                            for ($i = 0; $i < count($scores); $i++) : ?>
                                <tr class="<?php if ($auth->email === $scores[$i]->email) {
                                                echo "text-success";
                                            } else {
                                                echo "";
                                            } ?>">
                                    <th scope="row"><?= $i + 1 ?></th>
                                    <td><?= $scores[$i]->name ?></td>
                                    <td><?= $scores[$i]->gender ?></td>
                                    <td><?= $scores[$i]->college ?></td>
                                    <td><?= $scores[$i]->total_pass ?></td>
                                </tr>
                            <?php endfor ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <div class="text-center text-danger">No Data!</div>
                <?php endif ?>
            </div>
        </div>


        <div class="tab-pane fade <?php if (isset($_GET['insertQ'])) {
                                        echo "show active";
                                    } else {
                                        echo "";
                                    } ?>" id="add-tab-pane" role="tabpanel" aria-labelledby="add-tab" tabindex="0">
            <div class="question-wrap white-30 mt-4">
                <?php if (isset($_GET['error'])) : ?>
                    <p class="alert alert-warning">Something's went wrong!</p>
                <?php endif ?>
                <form action="_actions/AddQuestion.php" method="POST" class="mb-3">
                    <select class="form-select mb-3" aria-label="Default select example" name="topicId">
                        <option selected>Select Topic</option>
                        <?php foreach ($topics as $topic) : ?>
                            <option value="<?= $topic->id ?>"><?= $topic->name ?></option>
                        <?php endforeach ?>
                    </select>
                    <!-- <div class="mb-3">
                        <label for="time-limit" class="form-label">Time Limit</label>
                        <input type="text" class="form-control" id="time-limit" aria-describedby="emailHelp" name="timeLimit">
                    </div>
                    <div class="mb-3">
                        <label for="mark" class="form-label">Mark</label>
                        <input type="text" class="form-control" id="marks" aria-describedby="emailHelp" name="mark">
                    </div> -->
                    <div class="mb-3">
                        <label for="question" class="form-label">Question</label>
                        <textarea class="form-control" id="question" rows="3" name="content"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="option1" class="form-label">Option1</label>
                        <input type="text" class="form-control" id="option1" aria-describedby="emailHelp" name="option1">
                    </div>
                    <div class="mb-3">
                        <label for="option2" class="form-label">Option2</label>
                        <input type="text" class="form-control" id="option2" aria-describedby="emailHelp" name="option2">
                    </div>
                    <div class="mb-3">
                        <label for="option3" class="form-label">Option3</label>
                        <input type="text" class="form-control" id="option3" aria-describedby="emailHelp" name="option3">
                    </div>
                    <div class="mb-3">
                        <label for="option4" class="form-label">Option4</label>
                        <input type="text" class="form-control" id="option4" aria-describedby="emailHelp" name="option4">
                    </div>
                    <div class="mb-3">
                        <label for="right-answer" class="form-label">Right Answer</label>
                        <input type="text" class="form-control" id="right-answer" aria-describedby="emailHelp" name="answer">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                </form>
            </div>
        </div>


        <div class="tab-pane fade" id="feedback-tab-pane" role="tabpanel" aria-labelledby="feedback-tab" tabindex="0">
            <div class="container white-30 mt-5">
                <?php if ($feedbacks) : ?>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">S.N</th>
                                <th scope="col" class="my-column-l">Subject</th>
                                <th scope="col">Email</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time</th>
                                <th scope="col">By</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($feedbacks as $feedback) : ?>
                                <tr>
                                    <th scope="row"><?= $feedback->id ?></th>
                                    <td style="text-align: left;"><?= $feedback->subject ?></td>
                                    <td><?= $feedback->email ?></td>
                                    <td><?= $feedback->created_date ?></td>
                                    <td><?= $feedback->created_time ?></td>
                                    <td><?= $feedback->name ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <p class="text-center text-danger">There is no FeedBack.</p>
                <?php endif ?>
            </div>
        </div>
    </div>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>