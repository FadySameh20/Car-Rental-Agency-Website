<?php include 'backbone.php'; ?>
<?php include 'redirectLoggedIn.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Car rental Agency</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="assets/css/main.css"/>
    <noscript>
        <link rel="stylesheet" href="assets/css/noscript.css"/>
    </noscript>
</head>
<body>

<body class="is-preload">
<!-- Wrapper -->
<div id="wrapper">

    <!-- Header -->
    <br>
    <br>
</div>
<div class="overlay"></div>
<div class="container">
    <div class="row no-gutters slider-text justify-content-start align-items-center justify-content-center">
        <div class="col-lg-8 ftco-animate">
            <div class="text w-100 text-center mb-md-5 pb-md-5 px-2">
                <h1 class="mb-4">Login to join the Fastest &amp; Easiest Way To Rent A Car</h1>
                <div class="card text-center" style="margin:10px;padding: 50px;background: transparent">
                    <form class="form-inline" method="post" name="myForm" action=""
                          onsubmit="return validateLoginForm()">

                        <div class="form-group mx-sm-3 mb-2">
                            <label for="Email" class="sr-only">Email</label>
                            <input type="email" name="Email" class="form-control" id="Email" placeholder="Email">
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="Password" class="sr-only">Password</label>
                            <input type="password" name="Password" class="form-control" id="Password"
                                   placeholder="Password">
                        </div>
                        <input type="submit" name="submit" class="btn btn-primary mb-2 cent" value="Login">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


</div>

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/jquery.scrolly.min.js"></script>
<script src="assets/js/jquery.scrollex.min.js"></script>
<script src="assets/js/main.js"></script>
<script src="js/registerValidate.js"></script>
<script src="js/loginValidate.js"></script>

<?php
$conn = $_SESSION['conn'];

if (isset($_POST['submit'])) {
    // receive all input values from the form

    $email = $_POST['Email'];
    $password = $_POST['Password'];

    $result = mysqli_query($conn, "SELECT * FROM `user` WHERE email = '$email'");
    $user = mysqli_fetch_assoc($result);

    if ((md5($password) == $user['password']) && $user) {
        $_SESSION['ssn'] = $user['ssn'];

        echo '<script>';
        echo 'window.location = "index.php"';
        echo '</script>';
        exit();
    } else {
        echo '<script>';
        echo 'alert("Check email or password");';
        echo 'window.location = "login.php"';
        echo '</script>';
    }
}
mysqli_close($conn);
?>


</body>
</html>