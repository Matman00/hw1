<?php
  include 'dbconfig.php';
  session_start();
  if(isset($_POST["nome"]) && isset($_POST["cognome"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["verify_password"]) && isset($_POST["telefono"])){
    $error = array();
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error[] = "email non valida";
        echo "<h1> email</h1>";

    }else{
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
      $res=mysqli_query($conn, "SELECT email FROM utenti WHERE email = '$email'");
      if(mysqli_num_rows($res)>0){
        $error[]="email gia in uso";
        echo "<h1> email uso</h1>";
      }
    }
    //almeno un nuemro almeno una minuscola almeno una maiuscola almeno un carattere speciale
    if(!preg_match("/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%*?]{8,}$/", $_POST['password'])){
          $error[]="la password non soddisfa i requisiti minimi";
          echo "<h1> password non rispecchia i requisiti</h1>";
      }

      if (strcmp($_POST["password"], $_POST["verify_password"]) != 0) {
          $error[] = "Le password non coincidono";
          echo "<h1> pass non uguali</h1>";
      }
      if(!preg_match('/^[0-9]{10,}$/', $_POST['telefono'])){
        $error[]="numero di telefono non valido";
        echo "<h1> telefono ha caratteri</h1>";
      }
      $telefono=mysqli_real_escape_string($conn, $_POST['telefono']);
      $res=mysqli_query($conn, "SELECT telefono FROM utenti WHERE telefono = '$telefono'");
      if(mysqli_num_rows($res)>0){
        $error[]="telefono già in uso";
        echo "<h1>telefono</h1>";
      }

      if(count($error)==0){
        $nome=mysqli_real_escape_string($conn,$_POST['nome']);
        $cognome=mysqli_real_escape_string($conn,$_POST['cognome']);
        $password=mysqli_real_escape_string($conn,$_POST['password']);
        $password=password_hash($password, PASSWORD_BCRYPT);

        $query="INSERT INTO utenti(nome,cognome,email,telefono,pass) VALUES ('$nome', '$cognome','$email','$telefono','$password')";
        if(mysqli_query($conn,$query)){
          $_SESSION["_user_email"]=$_POST["email"];
          $_SESSION["_user_id"]=mysqli_insert_id($conn);

        header("Location: homepage.php");
    
        }
        else {
          $error[]="connessione fallita";
        }
      }
      mysqli_close($conn);
  }
  else {
    if(isset($_POST["username_login"]) && isset($_POST["password_login"])){
      $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
      $error= array();
      $email=mysqli_real_escape_string($conn, $_POST["username_login"]);
      $query="SELECT pass from utenti where email='$email'";
      $res=mysqli_query($conn,$query);
      if(mysqli_num_rows($res)<1){
        $error[]="email non trovata";
      }
      else
      {
        $entry = mysqli_fetch_assoc($res);

      }

      if(count($error)==0){
        if(password_verify($_POST['password_login'], $entry['pass'])){
          $_SESSION["_user_email"]=$_POST["username_login"];
          header("Location: homepage.php");
        }

      }
        mysqli_close($conn);
    }


  }


 ?>



<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>StewieLab Racing</title>
  <link rel="stylesheet" type="text/css" href="./css&img/homepage.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Acme&display=swap" rel="stylesheet">
  <script src="./script/login.js" defer="true"></script>
  <script src="./script/signup.js" defer="true"></script>
  <script src="./script/homepage.js" defer="true"></script>
  <script src="https://kit.fontawesome.com/b0280d700f.js" crossorigin="anonymous"></script>
</head>

<body>
<?php
if(!isset($_SESSION["_user_email"])){
  echo "<div class='login-text'>";
}
else {
  echo "<div class='hidden'>";
}
 ?>
    <button class="cta"><i class="fas fa-chevron-down fa-1x"></i></button>

    <div class="text">
      <div class="aas">
        <div>
          <a id="login">Login</a>
          <hr id="hr_login">
        </div>
        <div>
          <a id="signup">sign Up</a>
          <hr class="hidden" id="hr_signup">
        </div>
      </div>
      <br>
      <form class="" name="login_form" id="login_form" method="post">
        <input type="text" name="username_login" id="username_login"<?php if(isset($_POST["username_login"])){echo "value=".$_POST["username_login"];} ?>  placeholder="Username" >
        <br>
        <input type="password"  name="password_login" <?php if(isset($_POST["username_login"])) echo "class='error'"?> id="password_login" placeholder="Password" >
        <br>
        <button class="submit-btn" id="login_btn" name="login_btn" type="submit" disabled>Log In</button>
        <?php
          if(isset($_POST["username_login"])){
            echo "<p id='login_error_text' >Password errata</p>";
            //echo "value=".$_POST["username_login"];
          }else echo "<p id='login_error_text' class='hidden'></p>";

        ?>

      </form>

      <form class="hidden" id="signup_form" method="post">
        <div class="form_signin">
          <input type="text" name="nome" id="nome_signup" <?php if(isset($_POST["nome"])){echo "value=".$_POST["nome"];} ?> placeholder="Nome">
          <input type="text" name="cognome" id="cognome_signup" <?php if(isset($_POST["cognome"])){echo "value=".$_POST["cognome"];} ?> placeholder="Cognome">
          <input type="text" name="email" id="email_signup" <?php if(isset($_POST["email_signup"])){echo "value=".$_POST["email_signup"];} ?> placeholder="email">
          <input type="text" name="telefono" id="telefono_signup" <?php if(isset($_POST["telefono"])){echo "value=".$_POST["telefono"];} ?> placeholder="telefono">
          <input type="password" name="password" id="password_signup" class="" placeholder="Password">
          <input type="password" name="verify_password" id="verify_password" placeholder="conferma Password">
          <button type="submit" class="submit-btn" id="signup_btn" name="button" disabled>sign in</button>
          <p id="signup_error_text" class="hiddden"></p>
        </div>

      </form>

    </div>

  </div>

  <article class="hidden" id="modale">
    <div class="container_prev">
      <form method="POST" id="form">

        <input type="hidden" name="access_key" value="28b458c6-7d67-421d-9389-3516039b4281">
        <input type="hidden" name="from_name" value="Nuovo messaggio da un cliente">
        <input type="checkbox" name="botcheck" id="checkbox">

        <!-- Custom Form Data -->
        <?php
        if(!isset($_SESSION["_user_email"])){
          echo "<div class='form_input'>
          <label for='email'>E-mail</label>
          <input type='email' name='email' id='email' placeholder='mario.rossi@gmail.com' required>
        </div>";
      }else {
        echo "<div class='hidden'>
        <label for='email'>E-mail</label>
        <input type='email' name='email' id='email' placeholder='mario.rossi@gmail.com' value=".$_SESSION['_user_email']." required>
      </div>";
      }
        ?>
        <div class="form_input">
          <label for="subject">Oggetto</label>
          <select name="subject" id="subject" required>
            <option value="Preventivo">Preventivo</option>
            <option value="Collaborazione">Collaborazione</option>
          </select>
        </div>
        <div class="form_input">
          <label for="telefono">Telefono</label>
          <input type="text" name="telefono" id="telefono" placeholder="+39 3884578587" required>
        </div>
        <div class="form_input">
          <label for="nome">Nome</label>
          <input type="text" name="nome" id="nome" placeholder="Mario" required>
        </div>
        <div class="form_input">

          <label for="cognome">Cognome</label>
          <input type="text" name="Cognome" id="cognome" placeholder="Rossi" required />
        </div>
        <div class="form_input">
          <label for="messaggio">Richiesta</label>
          <textarea name="messaggio" id="messaggio" required></textarea>
        </div>

        <div class="form_input">
          <button type="submit" id="button">Invia email</button>
        </div>
        <div id="result"></div>
      </form>
    </div>
  </article>
  <header>
    <div id="overlay"></div>
    <nav>
      <div class="logo">
        <img src="./css&img/img/logo.png" id="logo">
      </div>
      <div class="option">
        <div class="linea"></div>
        <div class="linea"></div>
        <div class="linea"></div>
      </div>

      <div id="menu">
        <?php
          if(isset($_SESSION["_user_email"])){
            echo "<a href='logout.php'>Logout</a>";
            echo "<a href='account.php'> ".$_SESSION["_user_email"]."</a>";
          }
         ?>
        <a href="./shop.php">Shop</a>
        <a id="collab_prev1">Collab&Prev</a>
      </div>

      <div class="hidden" id="container_menu">
        <div id="menu_mobile">
          <?php
            if(isset($_SESSION["_user_email"])){
              echo "<a href='logout.php'>Logout</a>";
              echo "<a href='account.php'> ".$_SESSION["_user_email"]."</a>";
            }
           ?>
          <a href="./shop.php">Shop</a>
          <a id="collab_prev">Collab&Prev</a>
        </div>
      </div>
    </nav>
    <h1 id="testo_header">E' la passione che ci spinge a dare il massimo</h1>
  </header>
  <section class="argomento">
    <div class="titolo_argomento">
      <h1>I nostri servizi</h1>
    </div>
    <div class="box_argomento">
      <div class="servizi">

        <img src="./css&img/img/img_video.jpg" class="servizi_img">
        <h2>Riprese video in pista</h2><br>
        <p>Con le nostre videocamere, droni e con l'innata capacità del
          cameramen di riprendere mezzi ad alte prestazioni, siamo in grado
          di rendere uniche e indimendicabili le vostre uscite in pista.</p>

      </div>
      <div class="servizi">

        <img src="./css&img/img/preparazioni.jpg" class="servizi_img">
        <h2>Preparazioni & Lavorazioni</h2><br>
        <p>Perchè limitarsi a montare i componenti per come escono dalla
          fabbrica? Con le nostre competenze riusciamo a tirare fuori
          tutti i CV dai componenti acquistati affettuando anche lavorazioni
          meccaniche con il tornio.</p>

      </div>
      <div class="servizi">
        <img src="./css&img/img/banco_prova.jpg" class="servizi_img">
        <h2>Test su banco</h2><br>
        <p>Grazie al nuovissimo banco prova della EASYRUN diamo la possibilità
          di misurare la vera potenza del vostro scooter e di capire dove
          migliorare l'erogazione.</p>
      </div>
    </div>
  </section>

  <footer>
    <div class="footer_box">
      <h2 id="text_footer">Contatti</h2>
      <div class="footer_content">
        <i class="fa fa-phone" style='font-size:24px'></i>
        <p>3760010294</p>
      </div>

    </div>
    <div class="footer_box">


      <h2 id="text_footer">Social</h2>

      <div class="footer_content">
        <i class='fab fa-youtube' style='font-size:24px'></i>
        <a href="#">YouTube</a>
      </div>
      <div class="footer_content">
        <i class='fab fa-instagram' style='font-size:24px' ></i>
        <a href="#">Instagram</a>
      </div>

    </div>
    <div class="footer_box">


      <article class="insta_box">
        <div class="testo_feed">
          <h3>@Stewielab racing</h3>
        </div>
        <div class="feed">
        </div>
      </article>
    </div>
  </footer>

</body>

</html>
