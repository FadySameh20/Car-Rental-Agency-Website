<?php 
include 'backbone.php';
include 'redirectNotLoggedIn.php';

if ($user['is_admin']=='F') {
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
            <h2>Register</h2>
            <div class="card text-center" style="margin-top:10px;padding: 50px;background: transparent">
                <form enctype='multipart/form-data' class="form-inline" method="post" name="myForm" action="">
                    <div class="form-group mx-sm-3 mb-2">
                        <input type="text" name="plateId" class="form-control" id="plateId" placeholder="Plate Id" required>
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <input type="text" name="model" class="form-control" id="model" placeholder="Model" required>
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <input type="number" onkeypress="return event.charCode >= 48" min="1" name="year" class="form-control" id="year" placeholder="Year" required>
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <input type="text" name="color" class="form-control" id="color" placeholder="Color" required>
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <select name="automatic" id="automatic" required>
                            <option value="" disabled selected hidden>Automatic/Manual</option>
                            <option value="T">Automatic</option>
                            <option value="F">Manual</option>
                        </select>
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <input type="number" onkeypress="return event.charCode >= 48" min="1" name="tank_capacity" class="form-control" id="tank_capacity" placeholder="Tank Capacity" required>
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <input type="number" onkeypress="return event.charCode >= 48" min="1" name="power" class="form-control" id="power" placeholder="Horse Power" required>
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <input type="number" onkeypress="return event.charCode >= 48" min="1" name="price" class="form-control" id="price" placeholder="Price" required>
                    </div>
                    <div class="form-group mx-sm-3 mb-2">                        
                        <select name="location" id="location" required>
                            <option value="" disabled selected hidden>Location</option>
                            <?php 
                                $result = mysqli_query($conn, "SELECT * FROM `location`");
                                $locations = Array();
                                while($row = mysqli_fetch_assoc($result)){
                                    $locations[] = $row['loc'];
                                }
                                foreach ($locations as &$location) {
                                    echo "<option value=\"$location\">$location</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="img">Image: </label>
                        <input type="file" accept="image/*" name="img" id = "img" required>
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary mb-2" value="Register"/>
                </form>
            </div>
        </section>
    </div>
</footer>

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
$ssn = $_SESSION['ssn'];

$result = mysqli_query($conn, "SELECT * FROM `user` WHERE ssn ='$ssn'");
$user = mysqli_fetch_assoc($result);

if (isset($_POST['submit'])) {

    $plate_id = $_POST['plateId'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $price = $_POST['price'];
    $color = $_POST['color'];
    $tank_capacity = $_POST['tank_capacity'];
    $power = $_POST['power'];
    $isAutomatic = $_POST['automatic'];
    $location = $_POST['location'];
    $out_of_service = 'F';

    $result = mysqli_query($conn, "SELECT * FROM `car` WHERE plate_id = '$plate_id'");
    $car = mysqli_fetch_assoc($result);

    if ($car) { // if car exists
        echo '<script>';
        echo 'alert("Car already exists!");';
        echo 'window.location = "register_car.php"';
        echo '</script>';
    } else {
        $filename = $_FILES["img"]["name"];
        $tempname = $_FILES["img"]["tmp_name"];    
        $folder = "images/". $filename;
        if (move_uploaded_file($tempname, $folder))  {
            $query = "INSERT INTO `car` (plate_id, model, year, out_of_service, price, color, power, `automatic`, tank_capacity, loc, img) VALUES('$plate_id','$model','$year','$out_of_service','$price','$color','$power','$isAutomatic','$tank_capacity','$location','$filename')";
            $result = mysqli_query($conn, $query);

            echo '<script>';
            echo 'alert("Car registered successfully");';
            echo '</script>';

            echo '<script>';
            echo 'window.location = "index.php"';
            echo '</script>';
            exit();
        } else {
            echo "<script>";
            echo "alert('Failed to upload the image !')";
            echo "</script>";

            echo '<script>';
            echo 'window.location = "register_car.php"';
            echo '</script>';
        }
    }
}

$conn->close();

?>
</body>
</html>
