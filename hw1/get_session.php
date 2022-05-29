<?php
  require_once 'dbconfig.php';
  header('Content-Type: application/json');
  if (!isset($_GET["email"])) {
          echo "Non dovresti essere qui";
          exit;
      }
  header('Content-Type: application/json');

    // Connessione al DB
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
    $email=mysqli_real_escape_string($conn,$_GET["email"]);

    $query="SELECT id from utenti where email='$email'";
    $res=mysqli_query($conn,$query)or die(mysqli_error($error));
    $id_utente=mysqli_fetch_array($res);
    mysqli_free_result($res);

    $query="SELECT * from shopping_session where utente='$id_utente[0]'";
    $res=mysqli_query($conn,$query) or die(mysqli_error($conn));
    $session=array();
    while($row = mysqli_fetch_assoc($res))
      {
            $session[] = $row;
      }
      mysqli_free_result($res);
      mysqli_close($conn);
      // Ritorna
      echo json_encode($session);
?>
