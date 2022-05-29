<?php
  require_once 'dbconfig.php';
  if(!isset($_GET["email"])){
    echo "Non dovresti essere qui";
    exit;
}
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
    $email=mysqli_real_escape_string($conn,$_GET["email"]);
    echo $email;
    $query="INSERT INTO dettagli_ordini(utente, totale)
            select utenti.id,  shopping_session.totale
            from utenti JOIN shopping_session on utenti.id=shopping_session.utente
            where utenti.email='$email'";
    mysqli_query($conn,$query)or die(mysqli_error($error));
    mysqli_close($conn);

?>
