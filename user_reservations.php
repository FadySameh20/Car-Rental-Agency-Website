<?php 
    include 'backbone.php';
    include 'redirectNotLoggedIn.php';
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

<section>
    <?php 
        $ssn = $_SESSION['ssn']; 
        $query = "SELECT plate_id, pickup_time, return_time, pickup_location, return_location, img, model, year, color, automatic, price FROM `car` NATURAL JOIN `reservation` WHERE ssn = '$ssn'";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result)>0) {
            echo "<h2>Reservations</h2>";
        } else {
            echo "<h2>No reservations yet !</h2>";
        }
    ?>
    <div>
        <ul>
            <?php
                $reserv_num = 1;             
                while($car = mysqli_fetch_assoc($result)) {
                    echo "<br>";
                    echo "<h3>Reservation #" . $reserv_num . "</h3>";
                    $reserv_num = $reserv_num + 1;

                    echo "<img src=\"images/" . $car['img'] . "\" class=\"nav-item\" style=\"width: 500px; height: 300px;\">";
                    echo "<li class=\"nav-item\">Model: " . $car['model'] . "</li>";
                    echo "<li class=\"nav-item\">Year: " . $car['year'] . "</li>";
                    echo "<li class=\"nav-item\">Color: " . $car['color'] . "</li>";
                    if($car['automatic'] === 'T') {
                        $type = "Automatic";
                    } else {
                        $type = "Manual";
                    }
                    echo "<li class=\"nav-item\">Type: " . $type . "</li>";
                    
                    echo "<li class=\"nav-item\">Plate ID: " . $car['plate_id'] . "</li>";
                    echo "<li class=\"nav-item\">Pickup Location: " . $car['pickup_location'] . "</li>";
                    echo "<li class=\"nav-item\">Pickup Time " . $car['pickup_time'] . "</li>";
                    echo "<li class=\"nav-item\">Return Location: " . $car['return_location'] . "</li>";
                    echo "<li class=\"nav-item\">Return Time: " . $car['return_time'] . "</li>";
                    echo "<li class=\"nav-item\">Price per day: " . $car['price'] . "</li>";
                    
                    $start_date = strtotime($car['pickup_time']);  
                    $end_date = strtotime($car['return_time']);
                    $days = (($end_date - $start_date)/60/60/24) + 1;  //calculate number of reservation days
                    $cost_per_day = $car['price'];  //price of the car per day
                    $amount_per_reservation = $cost_per_day * $days;  //total amount to be paid
                    echo "<li class=\"nav-item\">Total payment: $" . $amount_per_reservation . "</li>";
                }
            ?>
        </ul>
    </div>
</section>

<?php include 'scripts.php';?>

</body>
</html>