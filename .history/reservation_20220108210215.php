<?php include 'backbone.php'; ?>
<?php
$conn = $_SESSION['conn'];
$ssn = $_SESSION['ssn'];
$plate_id = $_GET['plate_id'];
if(!isset($_GET['plate_id'])){
    echo '<script>';
    echo 'window.location = "car_catalog.php"';
    echo '</script>';
}
$result = mysqli_query($conn, "SELECT * FROM `user` WHERE ssn ='$ssn' AND is_admin='F'");
$user = mysqli_fetch_assoc($result);
if (!$user) {
    echo '<script>';
    echo 'window.location = "register.php"';
    echo '</script>';
}


$result = mysqli_query($conn, "SELECT * FROM `car` WHERE plate_id ='$plate_id'");
$car = mysqli_fetch_assoc($result);
if(!$car) {
    echo '<script>';
    echo "alert(\"car $plate_id\")";
    echo '</script>';
}

if($car['out_of_service'] === "T") {
    echo '<script>';
    echo 'alert("Car is out of service")';
    echo 'window.location = "index.php"';
    echo '</script>';
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
    <script src="js/reservationValidate.js"></script>
</head>
<body class="is-preload">
<!-- Wrapper -->
<div id="wrapper">

    <!-- Header -->
    <br>
    <br>
</div>

<!-- Footer -->
<footer id="footer">
        <section>
            <h2>Details</h2>
            <div>
                <ul>
                    <?php
                        echo "<img src=\"images/" . $car['img'] . "\" class=\"nav-item\">";
                        echo "<li class=\"nav-item\">Model: " . $car['model'] . "</li>";
                        echo "<li class=\"nav-item\">Year: " . $car['year'] . "</li>";
                        echo "<li class=\"nav-item\">Color: " . $car['color'] . "</li>";
                        echo "<li class=\"nav-item\">Horse Power: " . $car['power'] . "</li>";
                        if($car['automatic'] === 'T') {
                            $type = "Automatic";
                        } else {
                            $type = "Manual";
                        }
                        echo "<li class=\"nav-item\">Type: " . $type . "</li>";
                        echo "<li class=\"nav-item\">Tank Capacity: " . $car['tank_capacity'] . "</li>";
                        echo "<li class=\"nav-item\">Location: " . $car['loc'] . "</li>";
                        echo "<li class=\"nav-item\">Price: " . $car['price'] . "</li>";
                    ?>
                </ul>
            </div>
        </section>
    <div class="inner">
        <section>
            <h2>Reserve</h2>
            <div class="card text-center" style="margin-top:10px;padding: 50px;background: transparent">
                <form class="form-inline" method="post" name="myForm" action="" onsubmit="return validateReservationForm();">
                    <?php 
                        $result = mysqli_query($conn, "SELECT branch_name FROM `car` NATURAL JOIN `location` NATURAL JOIN `branch` WHERE plate_id = \"$plate_id\"");
                        $branches = Array();
                        while($row = mysqli_fetch_assoc($result)){
                            $branches[] = $row['branch_name'];
                        }
                    ?>
                    <div class="form-group mx-sm-3 mb-2">
                        <select name="pickup_location" id="pickup_location" required>
                            <option value="" disabled selected hidden>Pickup Location</option>
                            <?php
                                foreach ($branches as &$branch) {
                                    echo "<option value=\"$branch\">$branch</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <select name="return_location" id="return_location" required>
                            <option value="" disabled selected hidden>Return Location</option>
                            <?php
                                foreach ($branches as &$branch) {
                                    echo "<option value=\"$branch\">$branch</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="pickup_time">Pickup Time </label>
                        <input type="date" name="pickup_time" class="form-control" id="pickup_time" required>
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="return_time">Return Time </label>
                        <input type="date" name="return_time" class="form-control" id="return_time" required>
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary mb-2" value="Reserve"/>
                </form>
            </div>
        </section>
    </div>
</footer>

</div>

<?php include 'scripts.php';?>

<?php
if (isset($_POST['submit'])) {

    $reservation_time = date("Y-m-d H:i:s");
    $pickup_location = $_POST['pickup_location'];
    $return_location = $_POST['return_location'];
    $pickup_time = $_POST['pickup_time'];
    $return_time = $_POST['return_time'];

    $result = mysqli_query($conn, "SELECT * FROM `reservation` WHERE plate_id = $plate_id AND ((pickup_time BETWEEN '$pickup_time' AND  '$return_time') OR (return_time BETWEEN '$pickup_time' AND '$return_time')  OR ('$pickup_time' BETWEEN pickup_time AND return_time) OR ('$return_time' BETWEEN pickup_time AND return_time))");
    $clash = mysqli_fetch_assoc($result);
    
    if ($clash) { // if there is a clash
        echo '<script>';
        echo 'alert("Reservation already exists!");';
        echo 'window.location = "car_catalog.php"';
        echo '</script>';
    } else {
        $query = "INSERT INTO `reservation` (plate_id,ssn,reservation_time,pickup_location,return_location,pickup_time,return_time,is_paid) VALUES('$plate_id','$ssn','$reservation_time','$pickup_location','$return_location','$pickup_time','$return_time','F')";
        $result = mysqli_query($conn, $query);

        echo '<script>';
        echo 'alert("Reservation made successfully");';
        echo '</script>'; 

        echo '<script>';
        echo 'window.location = "index.php"';
        echo '</script>';
    }
}

$conn->close();

?>
</body>
</html>