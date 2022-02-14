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
$plate_id = $_SESSION['plate_id'];
$status = $_SESSION['status'];
$current_date = date("Y-m-d");

$query = "SELECT * FROM `reservation` WHERE plate_id = '$plate_id' AND ('$current_date' < return_time)";
$result = mysqli_query($conn, $query);
$output = mysqli_fetch_assoc($result);
if (mysqli_num_rows($result) != 0) {
    echo '<script>';
    echo 'alert("Cant change status of the car as it is reserved")';
    echo '</script>';
    echo '<script>';
    echo 'window.location = "car_status.php"';
    echo '</script>';
} else {

    if ($status === 'Active') {
        $status = 'T';  //becomes out of service
        $query = "INSERT INTO `car_status` (plate_id,out_of_service_start_date) VALUES('$plate_id','$current_date')";
        $result = mysqli_query($conn, $query);
    } else {
        $status = 'F';  //becomes active
        $query = "UPDATE `car_status` SET out_of_service_end_date= '$current_date' WHERE plate_id='$plate_id' and out_of_service_end_date is null";
        $result = mysqli_query($conn, $query);
    }
    $query = "UPDATE `car` SET out_of_service = '$status' WHERE plate_id = '$plate_id'";
    $result = mysqli_query($conn, $query);
    header('location: admin_dashboard.php');
}

$conn->close();
?>