<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>La Știuca</title>
  <link rel="stylesheet" href="css/contAngajat_style.css">
  <link rel="stylesheet" href="css/header_style.css">
  <link rel="stylesheet" href="css/footer_style.css">
  <link rel="stylesheet" href="css/menu_style.css">
  <link rel="shortcut icon" type="image/png" href="imagini/favicon-titlu.ico">
  <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:700" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

    <?php
      include_once 'includeri-php/header.php';
      require 'includeri-php/dbconnection.php';
    ?>

  <div class="container cont-container">
    <h1>Contul meu</h1>

    <div class="detaliiCont">
      <h3>Detalii cont</h3>
      <div class="detalii">

        <?php

          $id = "";

          if(isset($_SESSION['idAdmin']))
          {
            $id = $_SESSION['idAdmin'];
          }
          elseif(isset($_SESSION['idPersonal']))
          {
            $id = $_SESSION['idPersonal'];
          }
          else
          {
            header("Location: index.php?accesinterzis");
            exit();
          }

          $sql  = "SELECT * FROM utilizatori WHERE idUtilizator = ?;";
          $stmt = mysqli_stmt_init($conn);

          if(!mysqli_stmt_prepare($stmt, $sql))
          {
            header("Location: contAngajat.php?error=sqlerror");
            exit();
          }
          else
          {
            mysqli_stmt_bind_param($stmt, "s", $id);
            mysqli_stmt_execute($stmt);

            $rezultat = mysqli_stmt_get_result($stmt);
            $row      = mysqli_fetch_assoc($rezultat);
          }

        ?>

        <form id="form-modificariDetalii" name="form-modificariDetalii" action="includeri-php/salvareModificariInformatiiClient.php" method="post">

          <div class="col-md-10 col-md-offset-1 informatii-client">
            <div class="col-md-6 col-md-offset-3 idAngajat">
              <label>Nume: </label>
              <input type="text" id="idAngajat" name="idAngajat" value="<?php echo $row['idUtilizator']; ?>" readonly required></input>
            </div>
            <div class="col-md-6 col-md-offset-3 nume">
              <label>Nume: </label>
              <input type="text" id="numeAngajat" name="numeAngajat" value="<?php echo $row['numeUtilizator']; ?>" readonly required onchange="schimbareInformatiiAngajat()"></input>
            </div>
            <div class="col-md-6 col-md-offset-3 prenume">
              <label>Prenume: </label>
              <input type="text" id="prenumeAngajat" name="prenumeAngajat" value="<?php echo $row['prenumeUtilizator']; ?>" readonly required  onchange="schimbareInformatiiAngajat()"></input>
            </div>
            <div class="col-md-6 col-md-offset-3 nrTelefon">
              <label>Telefon: </label>
              <input type="text" id="telefonAngajat" name="telefonAngajat" value="<?php echo $row['telefonUtilizator']; ?>" readonly required  onchange="schimbareInformatiiAngajat()"></input>
            </div>
            <div class="col-md-6 col-md-offset-3 email">
              <label>E-mail: </label>
              <input type="email" id="emailAngajat" name="emailAngajat" value="<?php echo $row['emailUtilizator']; ?>" readonly required  onchange="schimbareInformatiiAngajat()"></input>
            </div>
            <div class="col-md-6 col-md-offset-3 parola">
              <label>Parola: </label>
              <input type="password" id="parolaAngajat" name="parolaAngajat" value="" readonly  onchange="schimbareInformatiiAngajat()"></input>
            </div>
            <div class="col-md-6 col-md-offset-3 parola">
              <label>Repetare Parola: </label>
              <input type="password" id="repetareParolaAngajat" name="repetareParolaAngajat" value="" readonly  onchange="schimbareInformatiiAngajat()"></input>
            </div>
          </div>
          <div class="col-md-6 col-md-offset-3 modificariDetalii">
            <button class="btn btn-default btn-detalii" type="button" name="anuleaza" id="anuleaza" onclick="anuleazaModificari()" >Anuleaza</button>
            <button class="btn btn-default btn-detalii" type="submit" name="trimiteModificariAngajat"  id="trimite">  Modifica </button>
            <button class="btn btn-default btn-detalii" type="button" name="modifica" id="modifica" onclick="afiseazaOptiuni()"    >Modifica</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php
    include_once 'includeri-php/footer.php';
  ?>

  <script type="text/javascript" src="javascript/cont-angajat.js"></script>
  <script type="text/javascript" src="javascript/burger-menu.js"></script>

</body>
</html>
