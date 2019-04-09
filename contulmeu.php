<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>La Știuca</title>
  <link rel="stylesheet" href="css/contulMeu_style.css">
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

    <div class="topProduseComandate">
      <h3 id="titluProduse">Top 3 produse comandate</h3>
      <div class="produse">
        <?php

          $sql  = "SELECT SUM(cantitate) AS cantitate, idPreparat FROM comenzi_preparate GROUP BY idPreparat ORDER BY cantitate DESC;";
          $stmt = mysqli_stmt_init($conn);

          if(!mysqli_stmt_prepare($stmt, $sql))
          {
            echo "Eroare - SQL Statement - SELECT \n";
            echo mysqli_stmt_error($stmt);
            exit();
          }
          else
          {
            mysqli_stmt_execute($stmt);
            $rezultat = mysqli_stmt_get_result($stmt);

            for($i = 0; $i < 3; $i++)
            {
              $row = mysqli_fetch_assoc($rezultat);

              $sql = "SELECT * FROM preparate WHERE idPreparat = '".$row["idPreparat"]."';";

              if(!mysqli_query($conn, $sql))
              {
                echo "Eroare!  " .$sql;
                echo "<br>" . mysqli_error($conn);
                exit();
              }
              else
              {
                $informatiiPreparat = mysqli_fetch_assoc(mysqli_query($conn, $sql));

                echo '<div class="col-md-4 produs" id="produs-'.$i.'" onclick="afisareModal(this.id)">
                        <div class="responsive imgProdus" style="background-image: url(imagini/meniu/'.$informatiiPreparat["caleImagine"].'");">

                        </div>
                        <h4>'.$informatiiPreparat["numePreparat"].'</h4>
                        <h5>'. str_replace(",", ", ", $informatiiPreparat["ingredientePreparat"]).'</h5>
                        <h4>'.$informatiiPreparat["pretPreparat"].' lei</h4>
                      </div>

                      <!-- Fereastra modal -->
                      <div class="modal fade modal-box" id="myModal-'. $i .'" role="dialog">
                        <div class="modal-dialog modal-dialog-centered">

                          <!-- Continutul ferestrei -->
                          <div class="modal-content fereastra-modal">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h3 class="modal-title titlu">'. $informatiiPreparat["numePreparat"] .'</h3>
                            </div>
                            <div class="modal-body">
                              <div class="item">
                                <div class="po-modal poza-st" style="background-image: url(imagini/meniu/'.$informatiiPreparat["caleImagine"].');">
                                </div>
                                <div class="info-item-modal">
                                  <div class="cantitate">
                                    <h3>Cantitate</h3>
                                    <form class="value-form">
                                      <div class="value-button decrease" id="decrease-'.$informatiiPreparat["idPreparat"] .'" onclick="decreaseValue(this.id)"><i class="fas fa-minus fa-semn"></i></div>
                                      <div class="value"><input type="number" class="number" id="number-'. $informatiiPreparat["idPreparat"] .'" name="cantitate" value="1" /></div>
                                      <div class="value-button increase" id="increase-'. $informatiiPreparat["idPreparat"] .'" onclick="increaseValue(this.id)"><i class="fas fa-plus fa-semn"></i></div>
                                    </form>
                                  </div>
                                  <div class="info-pret">
                                    <h3>Pret:  <span id="schimbarePret-'. $informatiiPreparat["idPreparat"] .'">'. $informatiiPreparat["pretPreparat"] .'</span> lei</h3>
                                  </div>
                                  <div class="buton-adauga">
                                    <form class="form-adauga" action="includeri-php/adaugarePreparatLaComanda.php" method="post">
                                      <input type="number" id="nr-'. $informatiiPreparat["idPreparat"] .'" name="cantitate" value="1" style="visibility: hidden; width: 0px; height: 0px;">
                                      <input type="number" name="idPrep" value="'. $informatiiPreparat["idPreparat"] .'" style="visibility: hidden; width: 0px; height: 0px;">
                                      <button type="button" class="btn btn-default btn-modal" name="button-dismiss" data-dismiss="modal">Închide</button>
                                      <button type="submit" class="btn btn-default btn-modal" name="button-addToCart">Adaugă în coș</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>';
              }
            }
          }
        ?>
      </div>
      <h4> Cele mai comandate produse de către clienții noștrii. Vă invităm să le încercați si dumneavoastră! </h4>
    </div>

    <div class="detaliiCont">
      <h3>Detalii cont</h3>
      <div class="detalii">
        <div class="col-md-10 informatii-client">
          <div class="col-md-offset-1 col-md-5 nume">
            <label>Nume: </label>
            <input type="text" id="numeClient" name="numeClient" value="<?php echo $_SESSION["numeClient"]; ?>" readonly required  onchange="schimbareDetaliiClient()"></input>
          </div>
          <div class="col-md-offset-1 col-md-5 prenume">
            <label>Prenume: </label>
            <input type="text" id="prenumeClient" name="prenumeClient" value="<?php echo $_SESSION["prenumeClient"]; ?>" readonly required  onchange="schimbareDetaliiClient()"></input>
          </div>
          <div class="col-md-offset-1 col-md-5 nrTelefon">
            <label>Telefon: </label>
            <input type="text" id="telefonClient" name="telefonClient" value="<?php echo $_SESSION["telefonClient"]; ?>" readonly required  onchange="schimbareDetaliiClient()"></input>
          </div>
          <div class="col-md-offset-1 col-md-5 email">
            <label>E-mail: </label>
            <input type="email" id="emailClient" name="emailClient" value="<?php echo $_SESSION["emailClient"]; ?>" readonly required  onchange="schimbareDetaliiClient()"></input>
          </div>
          <div class="col-md-offset-1 col-md-5 parola">
            <label>Parolă: </label>
            <input type="password" id="parolaClient" name="parolaClient" value="" readonly onchange="schimbareDetaliiClient()"></input>
          </div>
          <div class="col-md-offset-1 col-md-5 repetareParola">
            <label>Repetare Parolă: </label>
            <input type="password" id="repetareParolaClient" name="repetareParolaClient" value="" readonly onchange="schimbareDetaliiClient()"></input>
          </div>
        </div>
        <div class="col-md-2 modificariDetalii">
          <form id="form-modificariDetalii" name="form-modificariDetalii" action="includeri-php/salvareModificariInformatiiClient.php" method="post">
            <button type"submit" class="btn btn-default btn-detalii" id="trimite" name="daSalvareModificari2"> Modifică </button>
            <input class="hiddenForm" type="text" id="hiddenFormNume"    name="hiddenFormNume"></input>
            <input class="hiddenForm" type="text" id="hiddenFormPrenume" name="hiddenFormPrenume"></input>
            <input class="hiddenForm" type="text" id="hiddenFormTelefon" name="hiddenFormTelefon"></input>
            <input class="hiddenForm" type="text" id="hiddenFormEmail"   name="hiddenFormEmail"></input>
            <input class="hiddenForm" type="text" id="hiddenFormParola" name="hiddenFormParola"></input>
            <input class="hiddenForm" type="text" id="hiddenFormRepetareParola"   name="hiddenFormRepetareParola"></input>
          </form>
          <button class="btn btn-default btn-detalii" type="submit" name="modifica" id="modifica" onclick="afisareOptiuni()"    >Modifică</button>
          <button class="btn btn-default btn-detalii" type="button" name="anuleaza" id="anuleaza" onclick="anuleazaModificari()">Anulează</button>

        </div>
      </div>
    </div>

    <div class="adrese">
      <h3>Adresele mele</h3>
      <div class="flex-adrese">
        <div class="col-md-4 adaugareAdresa">
          <p>Adaugați o nouă adresă: </p>
          <i class="fas fa-plus plus" onclick="afisareAdresa()"></i>
        </div>
        <div class="col-md-8 afisareAdrese">

          <?php

            $sql  = "SELECT adrese.idAdresa, localitate, strada, numar, bloc, scara, etaj, apartament, interfon FROM adrese
                     INNER JOIN adrese_clienti ON (adrese_clienti.idAdresa = adrese.idAdresa)
                     INNER JOIN utilizatori ON (utilizatori.idUtilizator = adrese_clienti.idClient)
                     WHERE utilizatori.idUtilizator = '$_SESSION[idClient]';";

            if(!mysqli_stmt_prepare($stmt, $sql))
            {
              echo "Eroare - SQL Statement - SELECT \n";
              echo mysqli_stmt_error($stmt);
              exit();
            }
            else
            {
              mysqli_stmt_execute($stmt);
              $rezultat = mysqli_stmt_get_result($stmt);

              $adrese = array();
              $adreseIndex = array();

              while($row = mysqli_fetch_assoc($rezultat))
              {
                $detaliiAdresa = $row["localitate"] . ", " . $row["strada"] . ", " . $row["numar"] . ", " . $row["bloc"] . ", " .
                                 $row["scara"] . ", " . $row["etaj"] . ", " . $row["apartament"] . ", " . $row["interfon"] . ";";

                array_push($adrese, $detaliiAdresa);
                array_push($adreseIndex, $row["idAdresa"]);
              }

              for($i = 1; $i <= count($adrese); $i++)
              {
                echo '<div class="domiciliu">
                        <h4>'.$i .'</h4>
                        <p class="col-md-7 p-domiciliu" id="'.$i.'domiciliu">'.$adrese[$i-1].'</p>
                        <button class="btn btn-detalii" type="button" name="modificaAdresa'.$i.'" id="'.$adreseIndex[$i-1].'-modificaAdresa-'.$i.'" onclick="afisareFormularModificare(this.id)">Modifică</button>
                        <form class="inline-form" action="includeri-php/eliminareAdresa.php" method="post">
                          <input style="visibility: hidden; width: 0;" type="text" name="idAdresa'.$i.'" value="'.$adreseIndex[$i-1].'">
                          <button class="btn btn-detalii" type="submit" name="stergereAdresa'.$i.'">Elimină</button>
                        </form>
                      </div>';
              }
            }
          ?>

        </div>
      </div>

      <div class="col-md-8 col-md-offset-2 formularAdrese" id="formularAdrese">
        <div class="formularModificare" id="formularModificare">
          <div class="col-md-6 adresa">
            <label>Localitate: </label>
            <input type="text" id="localitate" name="localitate" value="" required onchange="modificareDetaliiAdresa()" form="adaugareAdresa"/>
          </div>
          <div class="col-md-6 adresa">
            <label>Stradă: </label>
            <input type="text" id="strada" name="strada" value="" required onchange="modificareDetaliiAdresa()" form="adaugareAdresa"/>
          </div>
          <div class="col-md-6 adresa">
            <label>Număr: </label>
            <input type="text" id="numar" name="numar" value="" required onchange="modificareDetaliiAdresa()" form="adaugareAdresa"/>
          </div>
          <div class="col-md-6 adresa">
            <label>Bloc: </label>
            <input type="text" id="bloc" name="bloc" value="" onchange="modificareDetaliiAdresa()" form="adaugareAdresa"/>
          </div>
          <div class="col-md-6 adresa">
            <label>Scară: </label>
            <input type="text" id="scara" name="scara" value="" onchange="modificareDetaliiAdresa()" form="adaugareAdresa"/>
          </div>
          <div class="col-md-6 adresa">
            <label>Etaj: </label>
            <input type="text" id="etaj" name="etaj" value="" onchange="modificareDetaliiAdresa()" form="adaugareAdresa"/>
          </div>
          <div class="col-md-6 adresa">
            <label>Apartament: </label>
            <input type="text" id="apartament" name="apartament" value="" onchange="modificareDetaliiAdresa()" form="adaugareAdresa"/>
          </div>
          <div class="col-md-6 adresa">
            <label>Interfon: </label>
            <input type="text" id="interfon" name="interfon" value="" onchange="modificareDetaliiAdresa()" form="adaugareAdresa"/>
          </div>
        </div>

        <div class="col-md-offset-8 col-md-4" id="hiddenForm-modificari">
          <button class="btn btn-default btn-detalii" type="button" name="anuleazaModificari" id="anuleazaModificari" onclick="anuleazaModificariAdresa()">Anulează</button>
          <form action="includeri-php/modificareAdresa.php" method="post">
            <button class="btn btn-default btn-detalii" type="submit" name="trimiteModificari" id="trimiteModificari" onclick="a()">Modifică</button>
            <input class="inputModificare" type="text" id="modificareIdAdresa"   name="modificareIdAdresa" value="" style="visibility: hidden; width: 0; height: 0;"></input>
            <input class="inputModificare" type="text" id="modificareLocalitate" name="modificareLocalitate" required></input>
            <input class="inputModificare" type="text" id="modificareStrada"     name="modificareStrada" required></input>
            <input class="inputModificare" type="text" id="modificareNumar"      name="modificareNumar" required></input>
            <input class="inputModificare" type="text" id="modificareBloc"       name="modificareBloc"></input>
            <input class="inputModificare" type="text" id="modificareScara"      name="modificareScara"></input>
            <input class="inputModificare" type="text" id="modificareEtaj"       name="modificareEtaj"></input>
            <input class="inputModificare" type="text" id="modificareApartament" name="modificareApartament"></input>
            <input class="inputModificare" type="text" id="modificareInterfon"   name="modificareInterfon"></input>
          </form>
        </div>
        <div class="col-md-offset-8 col-md-4" id="hiddenForm-adaugareAdresa">
          <button class="btn btn-default btn-detalii" type="button" name="anuleazaAdresa" id="anuleazaAdresa" onclick="anuleazaModificariAdresa()">Anulează</button>
          <form id="adaugareAdresa" action="includeri-php/adaugareAdresa.php" method="post">
            <button class="btn btn-default btn-detalii" type="submit" name="trimiteAdresa" id="trimiteAdresa">Adaugă</button>
          </form>
        </div>

      </div>
    </div>
  </div>

  <?php
  include_once 'includeri-php/footer.php';
  ?>

  <script type="text/javascript" src="javascript/contul-meu.js"></script>
  <script type="text/javascript" src="javascript/menu-modal.js"></script>
  <script type="text/javascript" src="javascript/burger-menu.js"></script>

</body>
</html>
