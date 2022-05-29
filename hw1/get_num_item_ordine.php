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
    $n_ordini=array();
    $query="SELECT count(articoli_ordini.ordine) as numero, dettagli_ordini.id
            from articoli_ordini join dettagli_ordini on dettagli_ordini.id=articoli_ordini.ordine join utenti on dettagli_ordini.utente=utenti.id
            where utenti.email='$email'
            GROUP by dettagli_ordini.id
            order by dettagli_ordini.id DESC";
    $res=mysqli_query($conn,$query)or die(mysqli_error($error));
    while($row = mysqli_fetch_assoc($res))
      {
            $n_ordini[] = $row;
      }
    mysqli_free_result($res);
    mysqli_close($conn);
    echo json_encode($n_ordini);
?>
