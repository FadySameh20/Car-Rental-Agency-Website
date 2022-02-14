<?php include 'redirectLoggedIn.php'; ?>
<!DOCTYPE HTML>
<html>
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
<body class="is-preload">
<!-- Wrapper -->
<div id="wrapper">

    <!-- Header -->
    <?php include 'backbone.php'; ?>

    <br>
    <br>
</div>

<!-- Footer -->
<footer id="footer">
    <div class="inner">
        <section>
            <h2>Register</h2>
            <div class="card text-center" style="margin-top:10px;padding: 50px;background: transparent">
                <form class="form-inline" method="post" name="myForm" action=""
                      onsubmit="return validateRegisterForm()">
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="Email" class="sr-only">Email</label>
                        <input type="email" name="Email" class="form-control" id="Email" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="fName" class="sr-only">First Name</label>
                        <input type="text" name="fName" class="form-control" id="fName"
                               placeholder="First Name">
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="lName" class="sr-only">Last Name</label>
                        <input type="text" name="lName" class="form-control" id="lName" placeholder="Last Name">
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="Password" class="sr-only">Password</label>
                        <input type="password" name="Password" class="form-control" id="Password"
                               placeholder="Password">
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="Confirm" class="sr-only">Confirm Password</label>
                        <input type="password" name="Confirm" class="form-control" id="Confirm"
                               placeholder="Confirm Password">
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="mobile" class="sr-only">Mobile Phone</label>
                        <input type="number" onkeypress="return event.charCode >= 48" min="1" name="mobile" class="form-control" id="mobile"
                               placeholder="Phone number: 11-digit">
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="ssn" class="sr-only">National ID</label>
                        <input type="number" onkeypress="return event.charCode >= 48" min="1" name="ssn" class="form-control" id="ssn"
                               placeholder="SSN: 14-digit">
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="birthDate" class="sr-only">Birth Date: </label>
                        <input type="date" name="birthDate" class="form-control" id="birthDate">
                    </div>
                    <div>
                        <label for="sex" class="sr-only">Sex</label>
                        <select name="sex" id="sex">
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select>
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary mb-2" value="Register"/>
                </form>
            </div>
        </section>
    </div>
</footer>

</div>

<?php include 'scripts.php';?>

<?php
$conn=$_SESSION['conn'];
if (isset($_POST['submit'])) {
    $fname = $_POST['fName'];
    $lname = $_POST['lName'];
    $ssn = $_POST['ssn'];
    $email = $_POST['Email'];
    $mobile = $_POST['mobile'];
    $password = $_POST['Password'];
    $birthdate = $_POST['birthDate'];
    $sex = $_POST['sex'];
    $is_admin = 'F';


    $result = mysqli_query($conn, "SELECT * FROM `user` WHERE ssn = '$ssn' OR email = '$email' OR phone = '$mobile'");
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
        echo '<script>';
        echo 'alert("User already exists!");';
        echo 'window.location = "register.php"';
        echo '</script>';
    } else {
        $password = md5($password);
        $query = "INSERT INTO `user` (ssn,fname,lname,phone,email,password,sex,birthdate,is_admin) VALUES
                                                                                         ('$ssn','$fname','$lname','$mobile','$email','$password','$sex','$birthdate','$is_admin')";
        $result = mysqli_query($conn, $query);

        $_SESSION['ssn'] = $_POST['ssn'];

        echo '<script>';
        echo 'alert("User registered successfully")';
        echo '</script>';

        echo '<script>';
        echo 'window.location = "index.php"';
        echo '</script>';
        exit();
    }
}

$conn->close();
?>
</body>
</html>
