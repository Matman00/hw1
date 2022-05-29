<?php
require_once 'dbconfig.php';
if (!isset($_GET["q"])) {
        echo "Non dovresti essere qui";
        exit;
    }
header('Content-Type: application/json');


    // Connessione al DB
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
    $email=mysqli_real_escape_string($conn,$_GET["q"]);

    $query="SELECT nome ,cognome,email,telefono from utenti where email='$email'";
    $res=mysqli_query($conn,$query)or die(mysqli_error($error));
    $userinfo=mysqli_fetch_assoc($res);
    mysqli_free_result($res);
    mysqli_close($conn);
    echo json_encode($userinfo);
?>
