<?php
  session_start();
 ?>
<html lang="en" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="./css&img/shop.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Acme&display=swap" rel="stylesheet">
    <script src="./script/shop.js" defer="true"></script>
    <script src="https://kit.fontawesome.com/b0280d700f.js" crossorigin="anonymous"></script>
  </head>
  <body>
    <header>
      <div class="navigation">
        <a href="./homepage.php"> <i class="fa fa-home"></i></a>

        <?php
          if(isset($_SESSION["_user_email"])){
            echo  "<a href='./carrello.php'><i class='fa fa-shopping-cart'></i></a>";
            echo "<a href='./account.php'><i class='fa fa-user'></i></a>";
          }
        ?>
      </div>
      <div>
        <input type="text" id="search_bar" name="" value="">
        <button type="button"><i class="fa fa-search"></i></button>
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
