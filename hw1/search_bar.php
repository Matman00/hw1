<?php
  require_once 'dbconfig.php';
  if(!isset($_GET["element"])){
    echo "Non dovresti essere qui";
    exit;
  }

  $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
  $element=mysqli_real_escape_string($conn,$_GET['element']);

  $query="SELECT sconti.attivo, sconti.percentuale, prodotti.nome as titolo, prodotti.descrizione, prodotti.prezzo, prodotti.sku,
          prodotti.quantita, prodotti.pic, categorie_prodotti.nome
          from categorie_prodotti join prodotti on categorie_prodotti.id=prodotti.categoria join sconti on sconti.id=prodotti.sconto
          where prodotti.nome like '$element%'";
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
