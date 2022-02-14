<?php 
include 'backbone.php';
include 'redirectNotLoggedIn.php';

$conn = $_SESSION['conn'];
$ssn = $_SESSION['ssn'];

$result = mysqli_query($conn, "SELECT * FROM `user` WHERE ssn ='$ssn'");
$user = mysqli_fetch_assoc($result);
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
        <h2 class="h2">Cars</h2>
        <?php
            $result = mysqli_query($conn, "SELECT * FROM `car`");
            $colors = Array();
            $locations = Array();
            while($row = mysqli_fetch_assoc($result)){
                $colors[] = $row['color'];
                $locations[] = $row['loc'];
            }
        ?>

        <section>
            <form class="form-inline" method="post" name="myForm" action="">
                <div class="form-group mx-sm-3 mb-2">
                    <input type="text" name="model" class="form-control" id="model" placeholder="Model">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <input type="text" name="year" class="form-control" id="year" placeholder="Year">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <input type="number" name="min_price" class="form-control" id="min_price" placeholder="Min. Price">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <input type="number" name="max_price" class="form-control" id="max_price" placeholder="Max. Price">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <select name="color" id="color">
                        <option value="" disabled selected hidden>Color</option>
                        <?php
                            foreach (array_unique($colors) as &$color) {
                                echo "<option value=\"$color\">$color</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <input type="number" name="min_power" class="form-control" id="min_power" placeholder="Min. Horse Power">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <input type="number" name="min_capacity" class="form-control" id="min_capacity" placeholder="Min. Tank Capacity">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <select name="location" id="location">
                        <option value="" disabled selected hidden>Location</option>
                        <?php
                            foreach (array_unique($locations) as &$location) {
                                echo "<option value=\"$location\">$location</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <select name="automatic" id="automatic">
                        <option value="" disabled selected hidden>Automatic/Manual</option>
                        <option value="T">Automatic</option>
                        <option value="F">Manual</option>
                    </select>
                </div>
                <input type="submit" name="submit" class="btn btn-primary mb-2" value="Search"/>
            </form>
        </section>
        <section class="tiles">
            <?php
                if (isset($_POST['submit'])) {
                    $m = strtolower($_POST["model"]);
                    $result = "SELECT * FROM `car` WHERE out_of_service = \"F\"";
                    if ($_POST["model"] != "") {
                        $result = $result . " AND LOWER(model) LIKE \"%$m%\"";
                    }
                    if ($_POST["year"] != "") {
                        $result = $result . " AND year = " . $_POST["year"];
                    }
                    if ($_POST["min_price"] != "") {
                        $result = $result . " AND price >= " . $_POST["min_price"];
                    }
                    if ($_POST["max_price"] != "") {
                        $result = $result . " AND price <= " . $_POST["max_price"];
                    }
                    if (isset($_POST["color"])) {
                        $result = $result . " AND color = \"" . $_POST["color"] . "\"";
                    }
                    if ($_POST["min_power"] != "") {
                        $result = $result . " AND power >= " . $_POST["min_power"];
                    }
                    if ($_POST["min_capacity"] != "") {
                        $result = $result . " AND tank_capacity >= " . $_POST["min_capacity"];
                    }
                    if (isset($_POST["location"])) {
                        $result = $result . " AND loc = \"" . $_POST["location"] . "\"";
                    }
                    if (isset($_POST["automatic"])) {
                        $result = $result . " AND automatic = \"" . $_POST["automatic"] . "\"";
                    }
    
                    $result = mysqli_query($conn, $result);
                } else {
                    $result = mysqli_query($conn, "SELECT * FROM `car` WHERE out_of_service = 'F'");
                };
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<article class=\"style1\">";
                    echo "<span class=\"image\">";
                    echo "<img src=\"images/" . $row["img"] . "\" alt=\"\"/>";
                    echo "</span>";

                    if($user['is_admin'] === 'F') {
                        echo "<a href=\"reservation.php?plate_id=" . $row["plate_id"] . "\">";    
                    } else {
                        echo "<a href=\"edit_car.php?plate_id=" . $row["plate_id"] . "\">";
                    }
            
                    echo "<h2>" . $row["model"] . " " . $row["year"] . "</h2>";
                    echo "<p>Price: <strong>". $row["price"] . "</strong> per day</p>";
                    echo "<div class=\"content\">";
                    echo "<p>Tank capcity: <strong>". $row["tank_capacity"] . "</strong> per day</p>";
                    echo "</div>";
                    echo "</a>";
                    echo "</article>";
                }
            ?>
        </section>

        <br>

    </div>

    <?php include 'scripts.php';?>

</body>
</html>