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
        <h2 class="h2">Search</h2>
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
                    <label for="cur_state">Current Status for date</label>
                    <input type="date" name="cur_state" class="form-control" id="cur_state"
                           placeholder="Current status">
                </div>
                <input type="submit" name="submit" class="btn btn-primary mb-2" value="Search"/>
            </form>
        </section>

        <br>
        <h1>Car</h1>
        <section>
            <div style="overflow-x:auto;width:100%;height:500px">
                <table>
                    <thead>
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
                    </thead>
                    <?php
                    if (isset($_POST['submit'])) {
                        $result = "SELECT * FROM `car` WHERE 1";
                        if ($_POST["plate_id"] != "") {
                            $result = $result . " AND plate_id = \"" . $_POST["plate_id"] . "\"";
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
                        if ($_POST["cur_state"] != "") {
                            $temp = $result . " AND plate_id not in (SELECT plate_id FROM car_status WHERE (\"" . $_POST["cur_state"] . "\" BETWEEN out_of_service_start_date and out_of_service_end_date) or (\"" . $_POST["cur_state"] . "\" >=out_of_service_start_date AND out_of_service_end_date is null))";
                            $result = $result . " AND plate_id in (SELECT plate_id FROM car_status WHERE (\"" . $_POST["cur_state"] . "\" BETWEEN out_of_service_start_date and out_of_service_end_date) or (\"" . $_POST["cur_state"] . "\" >=out_of_service_start_date AND out_of_service_end_date is null))";
                        }
                        $result = mysqli_query($conn, $result);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td style=\"text-align: center;\">" . $row["plate_id"] . "</td>";
                            echo "<td style=\"text-align: center;\">" . $row["model"] . "</td>";
                            echo "<td style=\"text-align: center;\">" . $row["year"] . "</td>";
                            $status = "Available";
                            if ($row["out_of_service"] == 'T' || $_POST["cur_state"] != "") {
                                $status = "Unavailable";
                            }
                            echo "<td style=\"text-align: center;\">" . $status . "</td>";
                            echo "<td style=\"text-align: center;\">" . $row["price"] . "</td>";
                            echo "<td style=\"text-align: center;\">" . $row["color"] . "</td>";
                            echo "<td style=\"text-align: center;\">" . $row["power"] . "</td>";
                            echo "<td style=\"text-align: center;\">" . $row["automatic"] . "</td>";
                            echo "<td style=\"text-align: center;\">" . $row["tank_capacity"] . "</td>";
                            echo "<td style=\"text-align: center;\">" . $row["loc"] . "</td>";
                            echo "</tr>";
                        }
                        if ($_POST["cur_state"] != "") {
                            $result = mysqli_query($conn, $temp);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td style=\"text-align: center;\">" . $row["plate_id"] . "</td>";
                                echo "<td style=\"text-align: center;\">" . $row["model"] . "</td>";
                                echo "<td style=\"text-align: center;\">" . $row["year"] . "</td>";
                                $status = "Available";
                                echo "<td style=\"text-align: center;\">" . $status . "</td>";
                                echo "<td style=\"text-align: center;\">" . $row["price"] . "</td>";
                                echo "<td style=\"text-align: center;\">" . $row["color"] . "</td>";
                                echo "<td style=\"text-align: center;\">" . $row["power"] . "</td>";
                                echo "<td style=\"text-align: center;\">" . $row["automatic"] . "</td>";
                                echo "<td style=\"text-align: center;\">" . $row["tank_capacity"] . "</td>";
                                echo "<td style=\"text-align: center;\">" . $row["loc"] . "</td>";
                                echo "</tr>";
                            }
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