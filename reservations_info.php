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
        <br>
        <h2 class="h2">Search in Reservations</h2>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM `car`");
        $models = array();
        $colors = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $models[] = strtolower($row['model']);
            $colors[] = strtolower($row['color']);
        }

        $result = mysqli_query($conn, "SELECT * FROM `location`");
        $locations = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $locations[] = $row['loc'];
        }
        ?>

        <section>
            <form class="form-inline" method="post" name="myForm" action="">
                <div class="form-group mx-sm-3 mb-2">
                    <input type="text" name="plate_id" class="form-control" id="plate_id" placeholder="Plate ID">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <select name="model" id="model">
                        <option value="" disabled selected hidden>Model</option>
                        <?php
                        foreach (array_unique($models) as &$model) {
                            echo "<option value=\"$model\">$model</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <input type="number" onkeypress="return event.charCode >= 48" min="1" name="year"
                           class="form-control" id="year" placeholder="Year">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <input type="number" onkeypress="return event.charCode >= 48" min="1" name="min_price"
                           class="form-control" id="min_price" placeholder="Min. Price">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <input type="number" onkeypress="return event.charCode >= 48" min="1" name="max_price"
                           class="form-control" id="max_price" placeholder="Max. Price">
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
                    <input type="number" onkeypress="return event.charCode >= 48" min="1" name="min_power"
                           class="form-control" id="min_power" placeholder="Min. Horse Power">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <input type="number" onkeypress="return event.charCode >= 48" min="1" name="min_capacity"
                           class="form-control" id="min_capacity" placeholder="Min. Tank Capacity">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <select name="location" id="location">
                        <option value="" disabled selected hidden>Location</option>
                        <?php
                        foreach ($locations as &$location) {
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
                <div class="form-group mx-sm-3 mb-2">
                    <label for="min_reservation_date">Min Reservation date</label>
                    <input type="date" name="min_reservation_date" class="form-control" id="min_reservation_date"
                           placeholder="Min. Reservation date">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="max_reservation_date">Max Reservation Date</label>
                    <input type="date" name="max_reservation_date" class="form-control" id="max_reservation_date"
                           placeholder="Max. Reservation date">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="payment_start_date">Payment Start date</label>
                    <input type="date" name="payment_start_date" class="form-control" id="payment_start_date"
                           placeholder="Payment Start date">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="payment_end_date">Payment End Date</label>
                    <input type="date" name="payment_end_date" class="form-control" id="payment_end_date"
                           placeholder="Payment End date">
                </div>
                <input type="submit" name="submit" class="btn btn-primary mb-2" value="Search"/>
            </form>
        </section>
        <h1>Reservation</h1>
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
                    <th style="text-align: center;">Plate id</th>
                    <th style="text-align: center;">Model</th>
                    <th style="text-align: center;">Year</th>
                    <th style="text-align: center;">Status</th>
                    <th style="text-align: center;">Price</th>
                    <th style="text-align: center;">Color</th>
                    <th style="text-align: center;">Power</th>
                    <th style="text-align: center;">Automatic/Manual</th>
                    <th style="text-align: center;">Tank Capacity</th>
                    <th style="text-align: center;">Location</th>
                    <th style="text-align: center;">Reservation number</th>
                    <th style="text-align: center;">Reservation time</th>
                    <th style="text-align: center;">Pickup Location</th>
                    <th style="text-align: center;">Return Location</th>
                    <th style="text-align: center;">Pickup Time</th>
                    <th style="text-align: center;">Return Time</th>
                    <th style="text-align: center;">Is Paid</th>
                    <th style="text-align: center;">Paid At</th>
                    </thead>
                    <?php
                    if (isset($_POST['submit'])) {
                        $result = "SELECT * FROM `reservation` NATURAL JOIN `car` NATURAL JOIN `user` WHERE 1";
                        if ($_POST["plate_id"] != "") {
                            $result = $result . " AND plate_id = " . $_POST["plate_id"];
                        }
                        if (isset($_POST["model"])) {
                            $result = $result . " AND model = \"" . $_POST["model"] . "\"";
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
                        if ($_POST["min_reservation_date"] != "") {
                            $result = $result . " AND pickup_time >= \"" . $_POST["min_reservation_date"] . "\"";
                        }
                        if ($_POST["min_birthdate"] != "") {
                            $result = $result . " AND birthdate >= \"" . $_POST["min_birthdate"] . "\"";
                        }
                        if ($_POST["max_reservation_date"] != "") {
                            $result = $result . " AND return_time <= \"" . $_POST["max_reservation_date"] . "\"";
                        }
                        if ($_POST["max_birthdate"] != "") {
                            $result = $result . " AND birthdate <= \"" . $_POST["max_birthdate"] . "\"";
                        }
                        if ($_POST["payment_start_date"] != "") {
                            $result = $result . " AND paid_at >= \"" . $_POST["payment_start_date"] . "\"";
                        }
                        if ($_POST["payment_end_date"] != "") {
                            $result = $result . " AND paid_at <= \"" . $_POST["payment_end_date"] . "\"";
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
                            echo "<td style=\"text-align: center;\">" . $row["plate_id"] . "</td>";
                            echo "<td style=\"text-align: center;\">" . $row["model"] . "</td>";
                            echo "<td style=\"text-align: center;\">" . $row["year"] . "</td>";
                            $status = "Available";
                            if ($row["out_of_service"] == 'T') {
                                $status = "Unavailable";
                            }
                            echo "<td style=\"text-align: center;\">" . $status . "</td>";
                            echo "<td style=\"text-align: center;\">" . $row["price"] . "</td>";
                            echo "<td style=\"text-align: center;\">" . $row["color"] . "</td>";
                            echo "<td style=\"text-align: center;\">" . $row["power"] . "</td>";
                            echo "<td style=\"text-align: center;\">" . $row["automatic"] . "</td>";
                            echo "<td style=\"text-align: center;\">" . $row["tank_capacity"] . "</td>";
                            echo "<td style=\"text-align: center;\">" . $row["loc"] . "</td>";
                            echo "<td style=\"text-align: center;\">" . $row["reservation_number"] . "</td>";
                            echo "<td style=\"text-align: center;\">" . $row["reservation_time"] . "</td>";
                            echo "<td style=\"text-align: center;\">" . $row["pickup_location"] . "</td>";
                            echo "<td style=\"text-align: center;\">" . $row["return_location"] . "</td>";
                            echo "<td style=\"text-align: center;\">" . $row["pickup_time"] . "</td>";
                            echo "<td style=\"text-align: center;\">" . $row["return_time"] . "</td>";
                            echo "<td style=\"text-align: center;\">" . $row["is_paid"] . "</td>";
                            echo "<td style=\"text-align: center;\">" . $row["paid_at"] . "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </table>
            </div>
        </section>
        <br>
        <h1>Payment Table</h1>
        <section>
            <div style="overflow-x:auto;width:100%;height:500px">
                <table>
                    <thead>
                    <th style="text-align: center;">Day</th>
                    <th style="text-align: center;">Total Daily Payment</th>
                    </thead>
                    <?php
                    if (isset($_POST['submit'])) {
                        $res = "SELECT paid_at,SUM(price* (DATEDIFF(return_time, pickup_time) + 1)) AS totaldailypayment FROM car as C inner join reservation as R on C.plate_id=R.plate_id WHERE 1";
                        if ($_POST["payment_start_date"] != "") {
                            $res = $res . " AND paid_at >= \"" . $_POST["payment_start_date"] . "\"";
                        }
                        if ($_POST["payment_end_date"] != "") {
                            $res = $res . " AND paid_at <= \"" . $_POST["payment_end_date"] . "\"";
                        }
                        if ($_POST["payment_start_date"] != "" or $_POST["payment_end_date"] != "") {
                            $res = $res . " AND paid_at is not null GROUP BY paid_at ";
                            $result = mysqli_query($conn, $res);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td style=\"text-align: center;\">" . $row["paid_at"] . "</td>";
                                echo "<td style=\"text-align: center;\">" . $row["totaldailypayment"] . "</td>";
                                echo "</tr>";

                            }
                        }
                    }
                    ?>
                </table>
            </div>
        </section>
        <?php include 'scripts.php'; ?>

</body>
</html>