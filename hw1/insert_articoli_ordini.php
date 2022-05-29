<?php
  require_once 'dbconfig.php';
  if(!isset($_GET["prod"])){
    echo "Non dovresti essere qui";
    exit;
}
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
    $prod=mysqli_real_escape_string($conn,$_GET["prod"]);
    $query="INSERT INTO articoli_ordini(ordine, prodotto, quantita)
            select dettagli_ordini.id, carrello.prodotto, carrello.quantita
            from dettagli_ordini join utenti on utenti.id=dettagli_ordini.utente join shopping_session on shopping_session.utente=utenti.id join carrello on carrello.sessione=shopping_session.id join prodotti on prodotti.id=carrello.prodotto
            where prodotti.sku='$prod' and dettagli_ordini.chiuso=0";
    mysqli_query($conn,$query)or die(mysqli_error($error));
    mysqli_close($conn);
?>
