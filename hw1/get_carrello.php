<?php
  require_once 'dbconfig.php';
  if (!isset($_GET["q"])) {
          echo "Non dovresti essere qui";
          exit;
      }
  header('Content-Type: application/json');

  $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
  $email=mysqli_real_escape_string($conn,$_GET["q"]);
  $query="SELECT	sconti.percentuale,sconti.attivo, prodotti.sku,prodotti.nome,prodotti.prezzo,prodotti.pic, carrello.quantita , shopping_session.totale
          FROM sconti join prodotti on sconti.id=prodotti.sconto join carrello on prodotti.id=carrello.prodotto join shopping_session on carrello.sessione=shopping_session.id join utenti on shopping_session.utente=utenti.id
          WHERE utenti.email='$email'";
  $res=mysqli_query($conn,$query)or die(mysqli_error($error));
  $elementi=array();
  while($row = mysqli_fetch_assoc($res))
    {
          $elementi[] = $row;
    }
  mysqli_free_result($res);
  mysqli_close($conn);
  // Ritorna
  echo json_encode($elementi);

 ?>
