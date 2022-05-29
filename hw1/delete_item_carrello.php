
<?php
require_once 'dbconfig.php';
if(!isset($_GET["email"]) && !isset($_GET["sku"])){
  echo "Non dovresti essere qui";
  exit;
}
  $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
  $email=mysqli_real_escape_string($conn,$_GET["email"]);
  $sku=mysqli_real_escape_string($conn,$_GET["sku"]);
  $query="UPDATE shopping_session
          set totale=totale-(SELECT prezzo
                              FROM prodotti
                              where sku='$sku')*(select carrello.quantita
                                            from  prodotti join carrello on carrello.prodotto=prodotti.id join shopping_session on shopping_session.id=carrello.sessione join utenti on utenti.id=shopping_session.utente
                                            WHERE prodotti.sku='$sku' and utenti.email='$email')
          where utente=(select id
                        from utenti
                        where email='$email')";

  mysqli_query($conn,$query)or die(mysqli_error($error));
  
  $query="DELETE from carrello
          where prodotto=(select p.id
                          FROM prodotti as p join carrello as c on p.id=c.prodotto join shopping_session as s on c.sessione=s.id join utenti as u on u.id=s.utente
                          where p.sku='$sku' and u.email='$email' )";

  mysqli_query($conn,$query)or die(mysqli_error($error));

  mysqli_close($conn);
?>
