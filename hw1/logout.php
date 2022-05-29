<?php
include "dbconfig.php";
    session_start();
    $email=$_SESSION['_user_email'];
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
    $query="DELETE FROM carrello
            where sessione=(select shopping_session.id
                            from shopping_session join utenti on shopping_session.utente=utenti.id
                            where utenti.email='$email')";
    mysqli_query($conn,$query);

    $query="DELETE FROM shopping_session
            where utente=(select id
                            from  utenti
                            where email='$email')";
    mysqli_query($conn,$query);
    session_destroy();
    header("location: homepage.php");
 ?>
