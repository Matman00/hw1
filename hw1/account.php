<?php
include "dbconfig.php";
session_start();

if(isset($_POST["via"]) && isset($_POST["cap"]) && isset($_POST["citta"]) && isset($_POST["paese"]) && isset($_POST["recapito"])){
  $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
  $error=array();
  $via=mysqli_real_escape_string($conn,$_POST["via"]);
  $cap=mysqli_real_escape_string($conn,$_POST['cap']);
  $citta=mysqli_real_escape_string($conn,$_POST["citta"]);
  $paese=mysqli_real_escape_string($conn,$_POST["paese"]);
  $email=$_SESSION['_user_email'];
  if(!preg_match('/^[0-9]{10,}$/', $_POST['recapito'])){
    $error[]="numero di telefono non valido";
    echo "<h1> telefono ha caratteri</h1>";
  }
  $recapito=mysqli_real_escape_string($conn,$_POST["recapito"]);
  if(count($error)==0){
    $query="SELECT id from utenti where email='$email'";
    $res=mysqli_query($conn,$query);
    $id_utente=mysqli_fetch_array($res);
    mysqli_free_result($res);
    $query="INSERT INTO indirizzi(via,cap,citta,paese, telefono, utente)
            VALUES ('$via','$cap','$citta','$paese','$recapito','$id_utente[0]')";
    mysqli_query($conn,$query) or die (mysqli_error($conn));
    header("Location : accoun.php");

  }
}


 ?>
<html lang="en" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="./css&img/account.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Acme&display=swap" rel="stylesheet">
    <script src="./script/account.js" defer="true"></script>
    <script src="https://kit.fontawesome.com/b0280d700f.js" crossorigin="anonymous"></script>
  </head>
  <body>
    <!---   form indirizzo    ----->
    <article class="hidden" id="modale">
      <div class="container_prev">
        <form method="POST" id="form">

          <div class="form_indirizzo">
            <input type="text" name="via" id="via" placeholder="Indirizzo" required>
            <input type="text" name="citta" id="citta" placeholder="Città" required>
            <input type="text" name="cap" id="cap" placeholder="CAP" required >
            <input type="text" name="paese" id="paese" placeholder="Paese" required></textarea>
            <input type="text" name="recapito" id="recapito" placeholder="Recapito" required></textarea>
            <button type="submit" id="button">Inserisci indirizzo</button>

          </div>
          <p class="" id="error"></p>
        </form>
      </div>
    </article>

    <!--- fine form indirizzo---->
  <section class="contenitore">
    <div class="zona_profilo">

        <div class="option">
          <a  id="account_settings">Account Settings</a>
          <a  id="ordini">riepilogo Ordini</a>
          <a href="logout.php">Logout</a>
        </div>

    </div>
    <div class="contenuto">
      <header>
        <a href="./carrello.php"><i class="fa fa-shopping-cart"></i></a>
        <a href="./homepage.php"><i class="fa fa-home"></i></a>
        <a href="./shop.php"><i class="fa fa-shopping-bag"></i></a>
      </header>
      <?php
      echo "<p class='hidden' id='email_get'>".
              $_SESSION['_user_email']."
            </p>";
       ?>
      <div class="box_contenuto">
        <div class="account_settings_box" id="account_settings_box">
          <div class="titolo">
            <h1>Account<br>Settings</h1>
          </div>
          <h3>Account</h3>
          <div class="box">
            <div class="inner_box_account">
              <p>Nome</p>
              <p  id="nome"></p>
            </div>
            <div class="inner_box_account">
              <p>Cognome</p>
              <p id="cognome"></p>
            </div>
            <div class="inner_box_account">
              <p>Email</p>
            <p id="email"></p>
            </div>
            <div class="inner_box_account">
              <p>Telefono</p>
              <p id="telefono"></p>
            </div>
          </div>
          <h3>Address</h3>
          <div class="box" id="address">
            <div id="add_address">
              <i class="fa fa-plus-circle"></i>
            </div>
          </div>
        </div>
        <div class="hidden" id="riepilogo">
          <div class="titolo">
            <h1>Riepilogo<br>Ordini</h1>
          </div>
          </div>
        </div>
      </div>

    </div>
  </section>
  </body>
</html>
