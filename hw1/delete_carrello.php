  <?php
  require_once 'dbconfig.php';
  if(!isset($_GET["email"])){
    echo "Non dovresti essere qui";
    exit;
  }
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
    $email=mysqli_real_escape_string($conn,$_GET["email"]);
    $query="DELETE FROM carrello
            where sessione=(select shopping_session.id
                            from shopping_session join utenti on shopping_session.utente=utenti.id
                            where utenti.email='$email')";

    mysqli_query($conn,$query)or die(mysqli_error($error));
    $query="UPDATE shopping_session
            set totale=0
            where utente=(select id
                            from utenti
                            where email='$email')";

    mysqli_query($conn,$query)or die(mysqli_error($error));
    $query="UPDATE dettagli_ordini
            set chiuso=1
            where utente=(select utenti.id
                            from utenti join dettagli_ordini on utenti.id=dettagli_ordini.utente
                            where utenti.email='$email' and dettagli_ordini.chiuso=0)";

    mysqli_query($conn,$query)or die(mysqli_error($error));
    mysqli_close($conn);
?>
