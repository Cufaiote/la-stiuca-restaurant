<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>La Știuca</title>
  <link rel="stylesheet" href="css/comenzi_style.css">
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
    include_once 'includeri-php/header.php';
    include_once 'includeri-php/dbconnection.php';
  ?>

  <div class="container comenzi-container">
    <h1>Comenzi </h1>

    <div class="comenzi">
      <h2>Comenzi nepreluate</h2>
      <table class="table table-hover table-striped tabel">
        <thead class="thead-dark thead-style">
          <tr>
            <th scope="col"> Nr. Bon     </th>
            <td scope="col"> Nume Client </td>
            <td scope="col"> Adresa      </td>
            <td scope="col"> Comanda     </td>
            <td scope="col"> Total       </td>
            <td scope="col"> Data        </td>
          </tr>
        </thead>
        <tbody>
          <?php
              $countComenzi = 0;

              $sql = "SELECT comenzi.idComanda, numeUtilizator, prenumeUtilizator, localitate, strada, numar, bloc,
                      scara, etaj, apartament, interfon, total, data FROM comenzi
                      INNER JOIN utilizatori ON comenzi.idClient = utilizatori.idUtilizator
                      INNER JOIN adrese ON comenzi.idAdresa = adrese.idAdresa
                      WHERE statusComanda = '1'
                      ORDER BY data";

              if(!mysqli_query($conn, $sql))
              {
                echo 'Eroare: ' . $sql;
                echo '<br>' . mysqli_error($conn);
                exit();
              }
              else
              {
                $rezultat = mysqli_query($conn, $sql);
                if(mysqli_num_rows($rezultat) > 0)
                {
                  while($rowComenzi = mysqli_fetch_assoc($rezultat))
                  {
                    $sql = "SELECT numePreparat FROM preparate
                            INNER JOIN comenzi_preparate ON comenzi_preparate.idPreparat = preparate.idPreparat
                            WHERE idComanda = '".$rowComenzi["idComanda"]."';";

                    $comanda = "";

                    if(!mysqli_query($conn, $sql))
                    {
                      echo 'Eroare: ' . $sql;
                      echo '<br>' . mysqli_error($conn);
                      exit();
                    }
                    else
                    {
                      $rezultatPreparate  = mysqli_query($conn, $sql);
                      if(mysqli_num_rows($rezultatPreparate) > 0)
                      {
                        while($rowPreparat = mysqli_fetch_assoc($rezultatPreparate))
                        {
                          $comanda .= $rowPreparat["numePreparat"] . "; ";
                        }
                      }
                    }

                    $countComenzi++;

                    echo '<tr>
                            <th scope="row" class="element">' . $rowComenzi["idComanda"] .'</th>
                            <td class="element">' . $rowComenzi["numeUtilizator"] . ' ' . $rowComenzi["prenumeUtilizator"] . '</td>
                            <td class="element"> ' . $rowComenzi["localitate"] . ' ' . $rowComenzi["strada"] . '
                             ' . $rowComenzi["numar"] . ' ' . $rowComenzi["bloc"] . '
                             ' . $rowComenzi["scara"] . ' ' . $rowComenzi["etaj"] . '
                             ' . $rowComenzi["apartament"] . ' ' . $rowComenzi["interfon"] . '     </td>
                            <td class="element"> ' . $comanda . ' </td>
                            <td class="element"> ' . $rowComenzi["total"]    . '  lei   </td>
                            <td class="element"> ' . $rowComenzi["data"] . ' </td>
                            <td class="td-elimina">
                              <form clas="form-inline" action="includeri-php/preluareComanda.php" method="post">
                                <input type="text" style="visibility: hidden; height: 0; width: 0;" name="nrBon" value="'.$rowComenzi["idComanda"].'"/>
                                <button type="submit" name="preluareComanda'.$countComenzi.'" class="btn btn-default"> Preia Comanda </button>
                              </form>
                            </td>
                          </tr>';
                  }
              }
            }

          ?>
        </tbody>
      </table>
    </div>

    <div class="comenzi">
      <h2>Comenzi preluate</h2>
      <table class="table table-hover table-striped tabel">
        <thead class="thead-dark thead-style">
          <tr>
            <th scope="col"> Nr. Bon     </th>
            <td scope="col"> Nume Client </td>
            <td scope="col"> Adresa      </td>
            <td scope="col"> Comanda     </td>
            <td scope="col"> Total       </td>
            <td scope="col"> Angajat     </td>
          </tr>
        </thead>
        <tbody>
          <?php
              $countComenzi = 0;

              $sql = "SELECT comenzi.idComanda, numeUtilizator, prenumeUtilizator, localitate, strada, numar, bloc,
                      scara, etaj, apartament, interfon, total, idAngajat FROM comenzi
                      INNER JOIN utilizatori ON comenzi.idClient = utilizatori.idUtilizator
                      INNER JOIN adrese ON comenzi.idAdresa = adrese.idAdresa
                      WHERE statusComanda = '2'";

              if(!mysqli_query($conn, $sql))
              {
                echo 'Eroare: ' . $sql;
                echo '<br>' . mysqli_error($conn);
                exit();
              }
              else
              {
                $rezultat = mysqli_query($conn, $sql);
                if(mysqli_num_rows($rezultat) > 0)
                {
                  while($rowComenzi = mysqli_fetch_assoc($rezultat))
                  {
                    $sql = "SELECT numePreparat FROM preparate
                            INNER JOIN comenzi_preparate ON comenzi_preparate.idPreparat = preparate.idPreparat
                            WHERE idComanda = '".$rowComenzi["idComanda"]."';";

                    $comanda = "";

                    if(!mysqli_query($conn, $sql))
                    {
                      echo 'Eroare: ' . $sql;
                      echo '<br>' . mysqli_error($conn);
                      exit();
                    }
                    else
                    {
                      $rezultatPreparate  = mysqli_query($conn, $sql);
                      if(mysqli_num_rows($rezultatPreparate) > 0)
                      {
                        while($rowPreparat = mysqli_fetch_assoc($rezultatPreparate))
                        {
                          $comanda .= $rowPreparat["numePreparat"] . "; ";
                        }
                      }
                    }

                    $sql = "SELECT numeUtilizator, prenumeUtilizator FROM utilizatori WHERE idUtilizator = '" . $rowComenzi["idAngajat"] ."';";

                    if(!mysqli_query($conn, $sql))
                    {
                      echo 'Eroare: ' . $sql;
                      echo '<br>' . mysqli_error($conn);
                      exit();
                    }
                    else
                    {
                      $rezultatAngajat = mysqli_query($conn, $sql);
                      $rowAngajat      = mysqli_fetch_assoc($rezultatAngajat);
                      $numeAngajat     = $rowAngajat["numeUtilizator"] . ' ' . $rowAngajat["prenumeUtilizator"];
                    }

                    $countComenzi++;

                    echo '<tr>
                            <th scope="row" class="element">' . $rowComenzi["idComanda"] .'</th>
                            <td class="element">' . $rowComenzi["numeUtilizator"] . ' ' . $rowComenzi["prenumeUtilizator"] . '</td>
                            <td class="element"> ' . $rowComenzi["localitate"] . ' ' . $rowComenzi["strada"] . '
                             ' . $rowComenzi["numar"] . ' ' . $rowComenzi["bloc"] . '
                             ' . $rowComenzi["scara"] . ' ' . $rowComenzi["etaj"] . '
                             ' . $rowComenzi["apartament"] . ' ' . $rowComenzi["interfon"] . '     </td>
                            <td class="element"> ' . $comanda . ' </td>
                            <td class="element"> ' . $rowComenzi["total"]    . '  lei   </td>
                            <td class="element"> ' . $numeAngajat . ' </td>
                            <td class="td-elimina">
                              <form clas="form-inline" action="includeri-php/finalizareComanda.php" method="post">
                                <input type="text" style="visibility: hidden; height: 0; width: 0;" name="nrBon" value="'.$rowComenzi["idComanda"].'"/>
                                <button type="submit" name="finalizareComanda'.$countComenzi.'" class="btn btn-default"> Finalizeaza </button>
                              </form>
                            </td>
                          </tr>';
                  }
              }
            }

          ?>
        </tbody>
      </table>
    </div>



</div>

  <?php
    include_once 'includeri-php/footer.php';
  ?>

  <script type="text/javascript" src="javascript/cosul-meu.js"></script>
  <script type="text/javascript" src="javascript/burger-menu.js"></script>

</body>
</html>
