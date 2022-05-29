<?php
require_once 'dbconfig.php';
if (!isset($_GET["email"])) {
        echo "Non dovresti essere qui";
        exit;
    }
header('Content-Type: application/json');


    // Connessione al DB
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
    $email=mysqli_real_escape_string($conn,$_GET["email"]);
    $ordini=array();
    $query="SELECT prodotti.pic, prodotti.sku, dettagli_ordini.totale, dettagli_ordini.id, dettagli_ordini.ordine_creato
            from prodotti join articoli_ordini on prodotti.id=articoli_ordini.prodotto join dettagli_ordini on articoli_ordini.ordine=dettagli_ordini.id join utenti on dettagli_ordini.utente=utenti.id
            where utenti.email='$email'
            order by dettagli_ordini.ordine_creato desc";
    $res=mysqli_query($conn,$query)or die(mysqli_error($error));
    while($row = mysqli_fetch_assoc($res))
      {
            $ordini[] = $row;
      }
    mysqli_free_result($res);
    mysqli_close($conn);
    echo json_encode($ordini);
?>
