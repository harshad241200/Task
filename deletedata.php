<?php
require 'database.php';
$conn = new mysqli("localhost", "root", "", "product");

$id = $_GET['id']; // get id through query string

$del = mysqli_query($conn,"DELETE FROM prolist WHERE id = '$id'"); // delete query

if($del)
{
    mysqli_close($conn); // Close connection
    header("location:home.php"); // redirects to all records page
    exit;	
}
else
{
    echo "Error deleting record"; // display error message if not delete
}
?>

?>