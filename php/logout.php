<!-- Ends the current user session to log out the user
and redirects back to the page specified in the query parameter. -->
<?php 
session_start();
if(isset($_SESSION['email'])){
session_destroy();}
$ref= @$_GET['q'];
header("location:$ref");
?>