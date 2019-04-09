<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>La Știuca</title>
  <link rel="stylesheet" href="css/gestionarePersonal_style.css">
  <link rel="stylesheet" href="css/header_style.css">
  <link rel="stylesheet" href="css/footer_style.css">
  <link rel="shortcut icon" type="image/png" href="imagini/favicon-titlu.ico">
  <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:700" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

  <?php
    session_start();

    include_once 'includeri-php/header.php';
  ?>

  <div class="container gestionarePersonal-container">
    <h1> Gestionare Personal </h1>

    <div class="angajati">
      <h2>Angajați</h2>

      <table class="table table-hover table-striped tabel">
        <thead class="thead-dark thead-style">
          <tr>
            <th scope="col"> #         </th>
            <td scope="col"> Nume   </td>
            <td scope="col"> Prenume      </td>
            <td scope="col"> Telefon      </td>
            <td scope="col"> E-mail </td>
            <td scope="col"> Funcție     </td>
          </tr>
        </thead>
        <tbody>

          <?php

            require 'includeri-php/dbconnection.php';

            $sql      = "SELECT * FROM utilizatori WHERE tipUtilizator LIKE '2%';";
            $rezultat = mysqli_query($conn, $sql);

            if(mysqli_num_rows($rezultat) > 0)
            {
              $numarAngajat = 1;

              while($row = mysqli_fetch_assoc($rezultat))
              {
                if($row['tipUtilizator'] == 21)
                {
                  $profesie = "bucătar";
                }
                else
                {
                  $profesie = "ospătar";
                }

                echo '<tr>
                        <th scope="row" class="element">' . $numarAngajat  . ' </th>
                        <td class="element"> ' . $row['numeUtilizator']    . ' </td>
                        <td class="element"> ' . $row['prenumeUtilizator'] . ' </td>
                        <td class="element"> ' . $row['telefonUtilizator'] . ' </td>
                        <td class="element"> ' . $row['emailUtilizator']   . ' </td>
                        <td class="element"> ' . $profesie                 . ' </td>
                        <td class="td-elimina">
                          <form class="inline-form" action="includeri-php/concediereAngajat.php" method="post">
                            <input style="visibility: hidden; width: 0;" type="text" name="idAngajat'.$numarAngajat.'" value="'.$row['idUtilizator'].'">
                            <button type="submit" name="concediazaAngajat'.$numarAngajat.'" class="btn btn-default"> Concediază </button>
                          </form>
                        </td>
                      </tr>';

                  $numarAngajat++;
              }
            }



          ?>
        </tbody>
      </table>

      <div class="adaugareAngajat" id="adaugareAngajat">
        <button type"button" class="btn btn-default" onclick="afiseazaFormularAngajare()"> Adaugă Personal </button>
      </div>

      <div style="clear: both;"></div>

      <div class="col-md-8 col-md-offset-2 formularAngajare" id="formularAngajare">
        <h3>Formular Angajare</h3>
        <form class="" action="includeri-php/signup.php" method="post">
          <div class="col-md-6 nume">
            <label>Nume: </label>
            <input type="text" id="numeAngajat" name="numeAngajat"required></input>
          </div>
          <div class="col-md-6 prenume">
            <label>Prenume: </label>
            <input type="text" id="prenumeAngajat" name="prenumeAngajat" required></input>
          </div>
          <div class="col-md-6 nrTelefon">
            <label>Telefon: </label>
            <input type="text" id="telefonAngajat" name="telefonAngajat" required></input>
          </div>
          <div class="col-md-6 email">
            <label>E-mail: </label>
            <input type="email" id="emailAngajat" name="emailAngajat" required></input>
          </div>
          <div class="col-md-6 functie">
            <label>Functie: </label>
            <select id="functieAngajat" name="functieAngajat">
              <option value="" disabled selected></option>
              <option value="21">Bucătar</option>
              <option value="22">Ospătar</option>
            </select>
          </div>
          <div class="col-md-6 parola">
            <label>Parolă: </label>
            <input type="password" id="parolaAngajat" name="parolaAngajat" required></input>
          </div>
          <div class="col-md-6 repetareParola">
            <label>Repetare Parolă: </label>
            <input type="password" id="repetareParolaAngajat" name="repetareParolaAngajat" required></input>
          </div>
          <div style="clear: both;"></div>
          <div class="optiuni">
            <button type="button" class="btn btn-default btn-detalii" id="anuleaza"  name="anuleaza" onclick="anuleazaAngajare()">Anulează </button>
            <button type="submit" class="btn btn-default btn-detalii" id="angajeaza" name="angajeaza">Angajează </button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <?php
    include_once 'includeri-php/footer.php';
  ?>

  <script type="text/javascript" src="javascript/gestionare-personal.js"></script>
  <script type="text/javascript" src="javascript/burger-menu.js"></script>

</body>
</html>
