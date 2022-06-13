<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .wrap {
            margin: auto;
            margin-top: 1rem;
            max-width: 30rem;
        }
    </style>
</head>

<body>
    <div class="wrap">
        <?php if(isset($_GET['registered'])): ?>
            <div class="alert alert-warning">Email and Password already exist!</div>
            <?php endif ?>
        <form action="_actions/create.php" method="POST" class="mb-3">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Name</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="name">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="phone">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Address</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="address"></textarea>
            </div>
            <div class="d-flex mb-3 gap-4">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="flexRadioDefault1" value="M" checked>
                    <label class="form-check-label" for="flexRadioDefault1">
                        Male
                    </label>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="gender" id="flexRadioDefault2" value="F">
                    <label class="form-check-label" for="flexRadioDefault2">
                        Female
                    </label>
                </div>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">College</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="college">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="password">
            </div>
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>
        <a href="index.php" class="d-block text-center mb-5">Login</a>
    </div>
</body>

</html>