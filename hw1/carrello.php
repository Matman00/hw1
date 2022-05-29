<?php
  session_start();
 ?>
<html lang="en" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="./css&img/carrello.css">
    <script src="./script/carrello.js" defer="true"></script>
    <script src="https://kit.fontawesome.com/b0280d700f.js" crossorigin="anonymous"></script>
  </head>
  <body>
    <header>
      <div class="navigation">
        <a href="./homepage.php"> <i class="fa fa-home"></i></a>
        <a href="./account.php"><i class="fa fa-user"></i></a>
        <a href="./shop.php"><i class="fa fa-shopping-bag"></i></a>
      </div>

    </header>
    <section>
      <h1 class='hidden' id='email'><?php
          if(isset($_SESSION["_user_email"])){
            echo $_SESSION['_user_email'];
          }
        ?></h1>

    </section>
  </body>
</html>
