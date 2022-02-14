<?php

session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car rental agency";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$_SESSION['conn'] = $conn;
?>
<!-- Header -->
<header id="header">
    <div class="inner">

        <!-- Logo -->
        <a href="index.php" class="logo">
            <span class="fa fa-car"></span> <span class="title">CAR RENTAL WEBSITE</span>
        </a>

        <!-- Nav -->
        <nav>
            <ul>
                <li><a href="#menu">Menu</a></li>
            </ul>
        </nav>

    </div>
</header>

<!-- Menu -->
<nav id="menu">
    <h2>Menu</h2>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
        <li class="nav-item"><a href="car_catalog.php" class="nav-link">Car catalog</a></li>
        <?php
        if (isset($_SESSION['ssn'])) {
            $ssn = $_SESSION['ssn'];
            $result = mysqli_query($conn, "SELECT * FROM `user` WHERE ssn ='$ssn'");
            $user = mysqli_fetch_assoc($result);
            $is_admin = $user['is_admin'];
        }else{
            $is_admin='F';
        };
        if (!isset($_SESSION['ssn'])) { ?>
            <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
            <li class="nav-item"><a href="register.php" class="nav-link">Register</a></li>
        <?php } else { ?>
            <li class="nav-item"><a href="destroy.php" class="nav-link">Sign Out</a></li>
        <?php } ?>
        <?php if ($is_admin == 'T') { ?>
            <li class="nav-item"><a href="register_car.php" class="nav-link">Register car</a></li>
            <li class="nav-item"><a href="admin_dashboard.php" class="nav-link">Admin Dashboard</a></li>
            <li class="nav-item"><a href="cars_info.php" class="nav-link">Cars Information</a></li>
            <li class="nav-item"><a href="customers_info.php" class="nav-link">Customers Information</a></li>
            <li class="nav-item"><a href="reservations_info.php" class="nav-link">Reservations</a></li>
        <?php } else { ?>
            <li class="nav-item"><a href="payment.php" class="nav-link">Payment</a></li>
            <li class="nav-item"><a href="user_reservations.php" class="nav-link">Reservations</a></li>
        <?php } ?>


    </ul>
</nav>

<!-- Main -->
<div id="main">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="images/slider-image-1-1920x700.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="images/slider-image-2-1920x700.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="images/slider-image-3-1920x700.jpg" alt="Third slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>