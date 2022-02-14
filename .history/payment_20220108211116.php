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
        $query = "SELECT plate_id, pickup_time, return_time, pickup_location, return_location, img, model, year, color, automatic, price FROM `car` NATURAL JOIN `reservation` WHERE ssn = '$ssn' AND is_paid = 'F'";
        $result = mysqli_query($conn, $query);
        // echo "<script>";
        // echo $result;
        // echo "</script>";
        if(mysqli_num_rows($result)>0) {
            echo "<h2>Reservations</h2>";
        } else {
            echo "<h2>No reservations yet !</h2>";
        }
    ?>
    <div>
        <ul>
            <?php
                $total_amount = 0;               
                while($car = mysqli_fetch_assoc($result)) {
                    echo "<img src=\"images/" . $car['img'] . "\" class=\"nav-item\">";
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
                    
                    $start_date = strtotime($car['pickup_time']);  
                    $end_date = strtotime($car['return_time']);
                    $days = (($end_date - $start_date)/60/60/24) + 1;  //calculate number of reservation days
                    $cost_per_day = $car['price'];  //price of the car per day
                    $amount_per_reservation = $cost_per_day * $days;  //total amount to be paid
                    $total_amount = $total_amount + $amount_per_reservation;
                    echo "<li class=\"nav-item\">Price: $" . $amount_per_reservation . "</li>";
                }
            ?>
        </ul>
    </div>
    <div>
        <?php 
            if(mysqli_num_rows($result)>0) {
                echo "<h2>Total amount to be paid: $" . $total_amount . "</h2>";
                echo "<form action=\"\" method=\"post\">
                    <input type=\"submit\" name=\"submit\" class=\"btn btn-primary mb-2\" value=\"Pay\"/>
                </form>";
            }
        ?>
    </div>
</section>



<?php include 'scripts.php';?>

</body>
</html>

<?php 
    if (isset($_POST['submit'])) {
        if($total_amount > 0) {
            $query = "UPDATE `reservation` SET is_paid = 'T' WHERE ssn = '$ssn'";
            $result = mysqli_query($conn, $query);

            echo "<script>";
            echo "alert('Payment made successfully')";
            echo "</script>";

            echo "<script>";
            echo 'window.location = "index.php"';
            echo "</script>";
        } else {
            echo "<script>";
            echo 'window.location = "car_catalog.php"';
            echo "</script>";
        }
    }
?>