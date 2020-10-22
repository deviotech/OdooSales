<?php  

session_start();

$databaseHost = 'localhost';
$databaseName = 'odoo_sales';
$databaseUsername = 'root';
$databasePassword = '';

$conn = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName); 
?>