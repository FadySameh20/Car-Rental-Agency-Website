<?php 
include 'backbone.php';
include 'redirectNotLoggedIn.php';

$conn = $_SESSION['conn'];
$ssn = $_SESSION['ssn'];

$result = mysqli_query($conn, "SELECT * FROM `user` WHERE ssn ='$ssn'");
$user = mysqli_fetch_assoc($result);

if ($user['is_admin']=='F') {
    header('location: index.php');
}


if(isset($_GET['plate_id'])) {
    $plate_id = $_GET['plate_id'];
    $result = mysqli_query($conn, "SELECT * FROM `car` WHERE out_of_service = \"F\" AND plate_id=\"$plate_id\"");
    $car = mysqli_fetch_assoc($result);

    if (!isset($car)) {
        echo '<script>';
        echo 'alert("Car with this plate id doesn\'t exist!");';
        echo 'window.location = "index.php"';
        echo '</script>';
    }
} else {
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

    <!-- Header -->
    <br>
    <br>
</div>

<!-- Footer -->
<footer id="footer">
    <div class="inner">
        <section>
            <h2>Edit car</h2>
            <div class="card text-center" style="margin-top:10px;padding: 50px;background: transparent">
                <form class="form-inline" method="post" name="myForm" action="">
                    <div class="form-group mx-sm-3 mb-2">
                        <?php
                            echo '<input type="text" name="model" class="form-control" id="model" value="'.$car["model"].'">';
                        ?>
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <?php
                            echo '<input type="number" onkeypress="return event.charCode >= 48" min="1" name="year" class="form-control" id="year" value="'.$car["year"].'">';
                        ?>
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <?php
                            echo '<input type="text" name="color" class="form-control" id="color" value="'.$car["color"].'">';
                        ?>     
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <select name="automatic" id="automatic">
                            <?php
                                if ($car["automatic"] == "T") {
                                    echo '<option value="T" selected>Automatic</option>';
                                    echo '<option value="F">Manual</option>';
                                } else {
                                    echo '<option value="T">Automatic</option>';
                                    echo '<option value="F" selected>Manual</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="tank_capacity" style="padding-right: 10;">Tank Capcity</label>
                        <?php
                            echo '<input type="number" onkeypress="return event.charCode >= 48" min="1" name="tank_capacity" class="form-control" id="tank_capacity" value="'.$car["tank_capacity"].'">';
                        ?>     
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="power" style="padding-right: 10;">Power</label>
                        <?php
                            echo '<input type="number" onkeypress="return event.charCode >= 48" min="1" name="power" class="form-control" id="power" value="'.$car["power"].'">';
                        ?>     
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="price" style="padding-right: 10;">Price</label>
                        <?php
                            echo '<input type="number" onkeypress="return event.charCode >= 48" min="1" name="price" class="form-control" id="price" value="'.$car["price"].'">';
                        ?>     
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <select name="location" id="location">
                            <?php 
                                $result = mysqli_query($conn, "SELECT * FROM `location`");
                                $locations = Array();
                                while($row = mysqli_fetch_assoc($result)){
                                    $locations[] = $row['loc'];
                                }
                                foreach ($locations as &$location) {
                                    if ($location == $car["loc"]) {
                                        echo "<option value=\"$location\" selected>$location</option>";
                                    } else {
                                        echo "<option value=\"$location\">$location</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary mb-2" value="Edit"/>
                </form>
            </div>
            <?php
			    echo '<img src="images/'.$car["img"].'" class="img-fluid" alt="" />';
            ?>
        </section>
    </div>
</footer>

</div>

<?php include 'scripts.php';?>
<?php
if (isset($_POST['submit'])) {

    $current_date = date("Y-m-d");

    $query = "SELECT * FROM `reservation` WHERE plate_id = '$plate_id' AND ('$current_date' < return_time)";
    $result = mysqli_query($conn, $query);
    $output = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) != 0) {
        echo '<script>';
        echo 'alert("Can\'t change car specifications as it is reserved")';
        echo '</script>';
        echo '<script>';
        echo 'window.location = "car_catalog.php"';
        echo '</script>';
    }
    else {
        $model = $_POST['model'];
        $year = $_POST['year'];
        $price = $_POST['price'];
        $color = $_POST['color'];
        $tank_capacity = $_POST['tank_capacity'];
        $power = $_POST['power'];
        $isAutomatic = $_POST['automatic'];
        $location = $_POST['location'];
        $img = $_POST['img'];
        $out_of_service = 'F';
        
        $query = "UPDATE `car` SET model='$model', year='$year', price='$price', color='$color', power='$power', automatic='$isAutomatic', tank_capacity='$tank_capacity', loc='$location' WHERE plate_id='$plate_id'";
        $result = mysqli_query($conn, $query);


        echo '<script>';
        if (mysqli_affected_rows($conn) > 0) {
            echo 'alert("Car updated successfully!");';
            echo 'window.location = "index.php"';
        } else {
            echo 'alert("Error: Car didn\'t update!\n'.mysqli_error($con).'");';
        }
        echo '</script>';
    }
}

$conn->close();

?>
</body>
</html>
