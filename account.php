<?php
include("vendor/autoload.php");

use Helpers\Auth;
use Libs\Database\MySQL;
use Libs\Database\Questions;
use Libs\Database\Score;
use Libs\Database\TopicsTable;
use Libs\Database\UsersTable;

$auth = Auth::check();

$topic_table = new TopicsTable(new MySQL());

$user_table = new UsersTable(new MySQL());

$question_table = new Questions(new MySQL());

$users = $user_table->getAll();
$topics = $topic_table->getAllTopic();

$score = new Score(new MySQL());

if (isset($_GET['re'])) {
    $score->deleteScore($_GET['id'], $_GET['t_id']);
}
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

        .quiz-wrap,
        .result-wrap {
            padding: 2rem 2rem 1rem 2.8rem;
            border-radius: 5px;
            margin-top: 4rem;
            background-color: #c5c5c5;
            box-shadow: 5px 2px 5px rgba(0, 0, 0, 0.5);
        }

        .result-wrap {
            background: linear-gradient(28deg, #4e493a, #b7b7b7);
            padding: 1.6rem;
            max-width: 40rem;
        }

        .result-wrap td {
            text-align: right;
        }

        .result-wrap th {
            text-align: left;
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
                        <i class="fas fa-user"></i><span>Hello, <?php if ($auth === "admin") echo "$user";
                                                                else echo "$auth->name" ?></span>
                    </a>
                    <a href="/_actions/logout.php" class="text-warning">Signout</a>
                    </form>
                </div>
            </div>
    </nav>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link disabled">Netcamp</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="false" <?php if(isset($_GET['n']) or isset($_GET['result'])) echo "disabled" ?>>Home</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history-tab-pane" type="button" role="tab" aria-controls="history-tab-pane" aria-selected="false" <?php if(isset($_GET['n']) or isset($_GET['result'])) echo "disabled" ?>>History</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="ranking-tab" data-bs-toggle="tab" data-bs-target="#ranking-tab-pane" type="button" role="tab" aria-controls="ranking-tab-pane" aria-selected="false"<?php if(isset($_GET['n']) or isset($_GET['result'])) echo "disabled" ?>>Ranking</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
            <div class="wrap white-30">
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
                                <?php $getScores = $score->getScore($auth->id, $topic->id);
                                if ($getScores) :
                                ?>
                                    <td><a href="account.php?id=<?= $auth->id ?>&re= true &t_id=<?= $topic->id ?>&h= true &n=0" class="btn btn-warning btn-sm">Restart</a></td>
                                <?php else : ?>
                                    <td><a href="account.php?id=<?= $auth->id ?>&h= true &n=0" class="btn btn-success btn-sm">Start</a></td>
                                <?php endif ?>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="history-tab-pane" role="tabpanel" aria-labelledby="history-tab" tabindex="0">
            <div class="wrap white-30">
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
            </div>
        </div>

        <!-- // history end -->

        <div class="tab-pane fade" id="ranking-tab-pane" role="tabpanel" aria-labelledby="ranking-tab" tabindex="0">
            <div class="wrap white-30">
                <table class="table table-striped table-hover">
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
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>M</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <?php if (isset($_GET['n'])) {
            $queryN_AsQuestionNumber = $_GET['n'];
            $questions = $question_table->showQuestions($_GET['t_id']); ?>
            <div class="tab-pane fade show active" id="quiz-tab-pane" role="tabpanel" aria-labelledby="quiz-tab" tabindex="0">
                <div class="quiz-wrap container">
                    <h2>Question <?= $queryN_AsQuestionNumber + 1 ?>::</h2>
                    <p><?= $questions[$queryN_AsQuestionNumber]->content ?></p>
                    <form action="/_actions/quiz.php?n=<?= $queryN_AsQuestionNumber ?>&t_id=<?= $_GET['t_id'] ?>&ui=<?= $auth->id ?>" method="POST">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answer" id="option1" value="<?= $questions[$queryN_AsQuestionNumber]->option1 ?>">
                            <label class="form-check-label" for="option1">
                                <?= $questions[$queryN_AsQuestionNumber]->option1 ?>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answer" id="option2" value="<?= $questions[$queryN_AsQuestionNumber]->option2 ?>">
                            <label class="form-check-label" for="option2">
                                <?= $questions[$queryN_AsQuestionNumber]->option2 ?>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answer" id="option3" value="<?= $questions[$queryN_AsQuestionNumber]->option3 ?>">
                            <label class="form-check-label" for="option3">
                                <?= $questions[$queryN_AsQuestionNumber]->option3 ?>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answer" id="option4" value="<?= $questions[$queryN_AsQuestionNumber]->option4 ?>">
                            <label class="form-check-label" for="option4">
                                <?= $questions[$queryN_AsQuestionNumber]->option4 ?>
                            </label>
                        </div>
                        <button class="btn btn-primary mt-4">Submit</button>
                    </form>
                </div>
            </div>
        <?php } elseif (isset($_GET['result'])) { ?>
            <div class="result-wrap container">
                <div class="h2 text-center text-success mb-4">Result</div>
                <table class="table">
                    <tbody>
                        <tr>
                            <th scope="row">Total Questions</th>
                            <td><?= $_GET['q'] ?></td>
                        </tr>
                        <tr class="text-success">
                            <th scope="row">Right Answer</th>
                            <?php if ($_GET['r']) : ?>
                                <td><?= $_GET['r'] ?></td>
                            <?php else : $_GET['r'] = 0; ?>
                                <td>0</td>
                            <?php endif ?>
                        </tr>
                        <tr class="text-danger">
                            <th scope="row">Wrong Answer</td>
                            <td><?= $_GET['q'] - $_GET['r'] ?></td>
                        </tr>
                        <tr class="text-info">
                            <th scope="row">Score</td>
                            <td><?= $_GET['r'] * 2 ?></td>
                        </tr>
                    </tbody>
                </table>
                <a href="dashboard.php" class="btn btn-success">Done</a>
            </div>
        <?php } ?>


    </div>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>