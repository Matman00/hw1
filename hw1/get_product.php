<?php
  require_once 'dbconfig.php';
  header('Content-Type: application/json');


    // Connessione al DB
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
    $query="SELECT sconti.attivo, sconti.percentuale, prodotti.nome as titolo, prodotti.descrizione, prodotti.prezzo, prodotti.sku,
            prodotti.quantita, prodotti.pic, categorie_prodotti.nome
            from categorie_prodotti join prodotti on categorie_prodotti.id=prodotti.categoria join sconti on sconti.id=prodotti.sconto";
    $res=mysqli_query($conn,$query) or die(mysqli_error($conn));
    $prodotti=array();
    while($row = mysqli_fetch_assoc($res))
      {
            $prodotti[] = $row;
      }
      mysqli_free_result($res);
      mysqli_close($conn);
      // Ritorna
      echo json_encode($prodotti);
 ?>
