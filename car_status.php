<?php include 'backbone.php'; ?>
<?php
$conn = $_SESSION['conn'];
if(isset($_GET['plate_id']))
$plate_id = $_GET['plate_id'];

$result = mysqli_query($conn, "SELECT * FROM `car` WHERE plate_id = '$plate_id'");
$car = mysqli_fetch_assoc($result);
if (!$car) {
    echo '<script>';
    echo 'window.location = "index.php"';
    echo '</script>';
}
if($car['out_of_service'] === 'T') {
    $status = "Out of Service";
} else {
    $status = "Active";
}
$_SESSION['plate_id'] = $plate_id;
$_SESSION['status'] = $status;
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
                        echo "<img src=\"images/" . $car['img'] . "\" class=\"nav-item\" style=\"width: 500px; height: 300px;\">";
                        echo "<li class=\"nav-item\">Model: " . $car['model'] . "</li>";
                        echo "<li class=\"nav-item\">Year: " . $car['year'] . "</li>";
                        echo "<li class=\"nav-item\">Status: " . $status . "</li>";
                    ?>
                </ul>
            </div>
        </section>
        <form action="change_car_status.php" method="post">
            <label for="changeStatus">Do you want to change the car status to be
                <?php
                    if($status === 'Active') {
                        echo "Out of Service ?";
                    } else {
                        echo "Active ?";
                    }
                ?>
            </label>
            <input type="submit" name="changeStatus" value="Yes">
        </form>
</footer>
</div>

<?php include 'scripts.php';?>

</body>
</html>
