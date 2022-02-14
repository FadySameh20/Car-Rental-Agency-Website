<?php
//session_start();
if(!isset($_SESSION['ssn'])){
    header('location: index.php');
}
?>