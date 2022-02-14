<?php
include 'backbone.php';
include 'redirectNotLoggedIn.php';

$conn = $_SESSION['conn'];
$ssn = $_SESSION['ssn'];

$result = mysqli_query($conn, "SELECT * FROM `user` WHERE ssn ='$ssn'");
$user = mysqli_fetch_assoc($result);

if ($user['is_admin'] == 'F') {
    header('location: index.php');
}
?>

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
    <div class="inner">
        <h2 class="h2">Search Customers Information</h2>
        <section>
            <form class="form-inline" method="post" name="myForm" action="">
                <div class="form-group mx-sm-3 mb-2">
                    <input type="text" name="fname" class="form-control" id="fname" placeholder="First Name">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <input type="text" name="lname" class="form-control" id="lname" placeholder="Last Name">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <input type="number" onkeypress="return event.charCode >= 48" min="1" name="phone"
                           class="form-control" id="phone" placeholder="Phone No.">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <select name="sex" id="sex">
                        <option value="" disabled selected hidden>Male/Female</option>
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                    </select>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="min_birthdate">Min Birth Date</label>
                    <input type="date" name="min_birthdate" class="form-control" id="min_birthdate"
                           placeholder="Min. Birth date">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="max_birthdate">Max Birth Date</label>
                    <input type="date" name="max_birthdate" class="form-control" id="max_birthdate"
                           placeholder="Max. Birth date">
                </div>
                <input type="submit" name="submit" class="btn btn-primary mb-2" value="Search"/>
            </form>
        </section>
        <h1>User</h1>
        <section>
            <div style="overflow-x:auto;width:100%;height:500px">
                <table>
                    <thead>
                    <th style="text-align: center;">SSN</th>
                    <th style="text-align: center;">First Name</th>
                    <th style="text-align: center;">Last Name</th>
                    <th style="text-align: center;">Phone</th>
                    <th style="text-align: center;">Emaill</th>
                    <th style="text-align: center;">Sex</th>
                    <th style="text-align: center;">Birth Date</th>
                    </thead>
                    <?php
                    if (isset($_POST['submit'])) {
                        $result = "SELECT * FROM `user` WHERE is_admin = 'F'";
                        if ($_POST["fname"] != "") {
                            $result = $result . " AND LOWER(fname) = LOWER(\"" . $_POST["fname"] . "\")";
                        }
                        if ($_POST["lname"] != "") {
                            $result = $result . " AND LOWER(lname) = LOWER(\"" . $_POST["lname"] . "\")";
                        }
                        if ($_POST["phone"] != "") {
                            $result = $result . " AND phone = \"" . $_POST["phone"] . "\"";
                        }
                        if ($_POST["email"] != "") {
                            $result = $result . " AND email = \"" . $_POST["email"] . "\"";
                        }
                        if (isset($_POST["sex"])) {
                            $result = $result . " AND sex = \"" . $_POST["sex"] . "\"";
                        }
                        if ($_POST["min_birthdate"] != "") {
                            $result = $result . " AND birthdate >= \"" . $_POST["min_birthdate"] . "\"";
                        }
                        if ($_POST["max_birthdate"] != "") {
                            $result = $result . " AND birthdate <= \"" . $_POST["max_birthdate"] . "\"";
                        }
                        $result = mysqli_query($conn, $result);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td style=\"text-align: center;\">" . $row["ssn"] . "</td>";
                            echo "<td style=\"text-align: center;\">" . $row["fname"] . "</td>";
                            echo "<td style=\"text-align: center;\">" . $row["lname"] . "</td>";
                            echo "<td style=\"text-align: center;\">" . $row["phone"] . "</td>";
                            echo "<td style=\"text-align: center;\">" . $row["email"] . "</td>";
                            echo "<td style=\"text-align: center;\">" . $row["sex"] . "</td>";
                            echo "<td style=\"text-align: center;\">" . $row["birthdate"] . "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </table>
            </div>
        </section>
    </div>

    <?php include 'scripts.php'; ?>

</body>
</html>