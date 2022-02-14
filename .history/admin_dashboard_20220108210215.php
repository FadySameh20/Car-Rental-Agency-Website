<?php include 'backbone.php' ?>
<?php
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
    <title>PHPJabbers.com | Free Car Rental Website Template</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="assets/css/main.css"/>
    <noscript>
        <link rel="stylesheet" href="assets/css/noscript.css"/>
    </noscript>
</head>
<body class="is-preload">
<br>
<br>
<form class="form-inline" method="post" name="myForm0" action="" onsubmit="return validateLocationBranchForm();">
    <div class="form-group mx-sm-3 mb-2">
        <input type="text" name="location0" class="form-control" id="location0" placeholder="Location" required>
    </div>
    <div class="form-group mx-sm-3 mb-2">
        <input type="text" name="branch0" class="form-control" id="branch0" placeholder="Branch" required>
    </div>
    <input type="submit" name="submit0" class="btn btn-primary mb-2" value="Add a new location and Branch"/>
</form>
<br>
<br>
<form class="form-inline" method="post" name="myForm1" action="" onsubmit="return validateBranchForm();">
    <div class="form-group mx-sm-3 mb-2">
        <select name="location1" id="location1" required>
            <option value="" disabled selected hidden>Location</option>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM `location`");
            $locations = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $locations[] = $row['loc'];
            }
            foreach ($locations as &$location) {
                echo "<option value=\"$location\">$location</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group mx-sm-3 mb-2">
        <input type="text" name="branch1" class="form-control" id="branch1" placeholder="Branch" required>
    </div>
    <input type="submit" name="submit1" class="btn btn-primary mb-2" value="Add New Branch for existing branch"/>
</form>

<div class="inner">
    <br><br>
    <div>
        <h2>Active Cars</h2>
        <section class="tiles">
            <?php
            $result = mysqli_query($conn, "SELECT * FROM `car` WHERE out_of_service = 'F'");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<article class=\"style1\">";
                echo "<span class=\"image\">";
                echo "<img src=\"images/" . $row["img"] . "\" alt=\"\"/>";
                echo "</span>";
                echo "<a href=\"car_status.php?plate_id=" . $row["plate_id"] . "\">";
                echo "<h2>" . $row["model"] . " " . $row["year"] . "</h2>";
                echo "<p>Price: <strong>" . $row["price"] . "</strong> per day</p>";
                echo "<div class=\"content\">";
                echo "<p>Tank capcity: <strong>" . $row["tank_capacity"] . "</strong> per day</p>";
                echo "</div>";
                echo "</a>";
                echo "</article>";
            }
            ?>
        </section>
    </div>
    <br>
    <div>
        <h2>Out of Service Cars</h2>
        <section class="tiles">
            <?php
            $result = mysqli_query($conn, "SELECT * FROM `car` WHERE out_of_service = 'T'");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<article class=\"style1\">";
                echo "<span class=\"image\">";
                echo "<img src=\"images/" . $row["img"] . "\" alt=\"\"/>";
                echo "</span>";
                echo "<a href=\"car_status.php?plate_id=" . $row["plate_id"] . "\">";
                echo "<h2>" . $row["model"] . " " . $row["year"] . "</h2>";
                echo "<p>Price: <strong>" . $row["price"] . "</strong> per day</p>";
                echo "<div class=\"content\">";
                echo "<p>Tank capcity: <strong>" . $row["tank_capacity"] . "</strong> per day</p>";
                echo "</div>";
                echo "</a>";
                echo "</article>";
            }
            ?>
        </section>
    </div>
</div>

<?php include 'scripts.php'; ?>
<?php

if (isset($_POST['submit0'])) {
    $loc = $_POST['location0'];
    $branch = $_POST['branch0'];
    $result = mysqli_query($conn, "SELECT * FROM `location` where loc='$loc'");
    $locResult = mysqli_fetch_assoc($result);
    if ($locResult) { // if user exists
        echo '<script>';
        echo 'alert("Location already exists!");';
        echo 'window.location = "register.php"';
        echo '</script>';
    } else {
        $query = "INSERT INTO `location` (loc) VALUES('$loc')";
        $result = mysqli_query($conn, $query);
        $query = "INSERT INTO `branch` (loc,branch_name) VALUES('$loc','$branch')";
        $result = mysqli_query($conn, $query);

        echo '<script>';
        echo 'window.location = "index.php"';
        echo '</script>';
        exit();
    }
}

if (isset($_POST['submit1'])) {
    $loc = $_POST['location1'];
    $branch = $_POST['branch1'];
    $query = "INSERT INTO `location` (loc) VALUES('$loc')";
    $result = mysqli_query($conn, $query);
    $query = "INSERT INTO `branch` (loc,branch_name) VALUES('$loc','$branch')";
    $result = mysqli_query($conn, $query);

    echo '<script>';
    echo 'window.location = "index.php"';
    echo '</script>';
    exit();
}
?>
</body>
</html>