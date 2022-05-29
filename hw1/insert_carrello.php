<?php

  require_once 'dbconfig.php';

  if(!isset($_GET["email"]) && !isset($_GET["sku"]) && !isset($_GET["quantita"])){
    echo "Non dovresti essere qui";
    exit;
  }
  $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
  $email=mysqli_real_escape_string($conn,$_GET['email']);

  $query= "SELECT id from utenti where email='$email'";
  $res=mysqli_query($conn,$query) or die (mysqli_error($conn));
  $id_utente=mysqli_fetch_array($res);

  mysqli_free_result($res);

  $query="SELECT id from shopping_session where utente='$id_utente[0]'";
  $res=mysqli_query($conn,$query) or die(mysqli_error($conn));
  $id_session=mysqli_fetch_array($res);
  mysqli_free_result($res);

  $quantita=mysqli_real_escape_string($conn,$_GET['quantita']);



  $sku=mysqli_real_escape_string($conn,$_GET['sku']);
  $query1="SELECT id from prodotti where sku='$sku'";
  $res=mysqli_query($conn,$query1) or die (mysqli_error($conn));
  $id_prodotto=mysqli_fetch_array($res);

  mysqli_free_result($res);


  $query2="INSERT INTO carrello(prodotto,sessione,quantita) VALUES ('$id_prodotto[0]', '$id_session[0]','$quantita')";

  $res=mysqli_query($conn, $query2) or die(mysqli_error($conn));
  
  mysqli_close($conn);
 ?>
