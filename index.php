<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Examination</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .wrap {
            margin: auto;
            margin-top: 5rem;
            max-width: 30rem;
        }
    </style>
</head>

<body>
    <div class="wrap">
        <form action="_actions/login.php" method="POST">
            <?php if (isset($_GET['incorrect'])) : ?>
                <div class="alert alert-warning">
                    Can't Login! Check Your Email & Password
                </div>
            <?php endif ?>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="password">
            </div>
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>

        <a href="register.php" class="d-block text-center mt-4">Register</a>
    </div>
</body>

</html>