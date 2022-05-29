<?php
  require_once 'dbconfig.php';
  header('Content-Type: application/json');
  if (!isset($_GET["email"])) {
          echo "Non dovresti essere qui";
          exit;
      }


    // Connessione al DB
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
    $email=mysqli_real_escape_string($conn,$_GET['email']);
    $query="SELECT indirizzi.*
            from indirizzi join utenti on utenti.id=indirizzi.utente
            where utenti.email='$email'";
    $res=mysqli_query($conn,$query) or die(mysqli_error($conn));
    $indirizzi=array();
    while($row = mysqli_fetch_assoc($res))
      {
            $indirizzi[] = $row;
      }
      mysqli_free_result($res);
      mysqli_close($conn);
      // Ritorna
      echo json_encode($indirizzi);
 ?>
