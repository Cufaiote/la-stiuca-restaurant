<?php
  session_start();
  error_reporting(E_ERROR | E_PARSE);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>La Știuca</title>
  <link rel="stylesheet" href="css/cosulMeu_style.css">
  <link rel="stylesheet" href="css/contulMeu_style.css">
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

  ?>

  <div class="container cart-container">
    <h1>Coșul meu &nbsp;&nbsp;<i class="fas fa-cart-plus"></i> </h1>

    <div class="comanda">
      <div class="pasul1">
        <div class="nr1">1</div>
        <h2> Comanda </h2>
      </div>
      <table class="table table-hover table-striped tabel">
        <thead class="thead-dark thead-style">
          <tr>
            <th scope="col"> #         </th>
            <td scope="col"> Imagine   </td>
            <td scope="col"> Nume      </td>
            <td scope="col"> Preț      </td>
            <td scope="col"> Cantitate </td>
            <td scope="col"> Total     </td>
          </tr>
        </thead>
        <tbody>
          <?php
            $nrObiecte = count($_SESSION['comanda']);

            for($i = 1; $i <= $nrObiecte; $i++)
            {
              echo '<tr>
                      <th scope="row" class="element">' . $i .'</th>
                      <td class="element">
                        <div class="imgPrep" style="background-image: url(imagini/meniu/'.$_SESSION['comanda'][$i-1]['caleImagine'].');"></div>
                      </td>
                      <td class="element" style="text-align: left;"> ' . $_SESSION['comanda'][$i-1]['numePreparat'] . '     </td>
                      <td class="element"> ' . $_SESSION['comanda'][$i-1]['pretPreparat'] . ' lei </td>
                      <td class="element"> ' . $_SESSION['comanda'][$i-1]['cantitate']    . '     </td>
                      <td class="element"> ' . $_SESSION['comanda'][$i-1]['pretPreparat'] * $_SESSION['comanda'][$i-1]['cantitate'] . ' lei </td>
                      <td class="td-elimina">
                        <form action="includeri-php/eliminareElementDinComanda.php" method="post">
                          <button type="submit" name="eliminareElement'.$i.'" class="btn btn-default"> Elimină </button>
                        </form>
                      </td>
                    </tr>';
            }

            $total = 0;

            $timpDePreparare = 0;
            $contor = 0;

            for($i = 1; $i <= $nrObiecte; $i++)
            {
              $total += $_SESSION['comanda'][$i-1]['pretPreparat'] * $_SESSION['comanda'][$i-1]['cantitate'];
              $_SESSION["timpMediuDeAsteptare"] = $_SESSION['comanda'][$i-1]['timpDePreparare'];

              $timp = explode(":", $_SESSION["comanda"][$i-1]["timpDePreparare"]);
              $timpDePreparare += 60 * $timp[0] + $timp[1] + $timp[2]/60;
              $contor ++;
            }

            if($contor != 1)
            {
              $timpDePreparare /= ($contor - 1);
              $minut = $timpDePreparare % 60;
              $ora   = intval($timpDePreparare - $minut);

              $_SESSION["timpMediuDeAsteptare"] = $ora.":".$minut.":00";
            }

            echo '<tr>
                    <th scope="row">   </th>
                    <td>               </td>
                    <td>               </td>
                    <td>               </td>
                    <td> <b> Total </b></td>
                    <td><p id="totalDePlata" onchange="verificareTotalDePlata()"> ' . $total . ' lei </p></td>
                  </tr>';

          ?>
        </tbody>
      </table>

      <div class="continua" id="continua1">
        <button type"button" class="btn btn-default" data-toggle="collapse" data-target="#clientul" aria-expanded="false" aria-controls="collapseExample"> Continuă </button>
      </div>
    </div>

    <div class="collapse" id="clientul">
      <div class="pasul2">
        <div class="nr2">2</div>
        <h2> Datele Personale </h2>
      </div>
      <div class="informatii-client">
        <div class="col-md-6 detalii">
          <label>Nume: </label>
          <input type="text" id="numeClient" name="numeClient" value="<?php echo $_SESSION["numeClient"] ?>" form="trimiteComanda" required oninvalid="this.setCustomValidity('Va rugam sa introduceti numele!')" oninput="setCustomValidity('')" onchange="schimbareDetaliiClient()"></input>
        </div>
        <div class="col-md-6 detalii">
          <label>Prenume: </label>
          <input type="text" id="prenumeClient" name="prenumeClient" value="<?php echo $_SESSION["prenumeClient"] ?>"  form="trimiteComanda" required oninvalid="this.setCustomValidity('Va rugam sa introduceti prenumele!')" oninput="setCustomValidity('')" onchange="schimbareDetaliiClient()"></input>
        </div>
        <div class="col-md-6 detalii">
          <label>Telefon: </label>
          <input type="text" id="telefonClient" name="telefonClient" value="<?php echo $_SESSION["telefonClient"] ?>" form="trimiteComanda" required oninvalid="this.setCustomValidity('Va rugam sa introduceti numarul de telefon!')" oninput="setCustomValidity('')" onchange="schimbareDetaliiClient()"></input>
        </div>
        <div class="col-md-6 detalii">
          <label>E-mail: </label>
          <input type="email" id="emailClient" name="emailClient" value="<?php echo $_SESSION["emailClient"] ?>" form="trimiteComanda" required  oninvalid="this.setCustomValidity('Va rugam sa introduceti un e-mail valid!')" oninput="setCustomValidity('')" onchange="schimbareDetaliiClient()"></input>
        </div>

        <div class="salvareModificari col-md-7 col-md-offset-2" id="modificariClient">
          <h4> Doriți să salvați modificările informațiilor în baza noastră de date? </h4>
          <form id="form-modificariClient" name="form-modificariClient" action="includeri-php/salvareModificariInformatiiClient.php" method="post">
            <button type"submit" class="btn btn-default" id="daSalvareModificari" name="daSalvareModificari"> Da </button>
            <input class="hiddenForm" type="text" id="hiddenFormNumeClient"    name="hiddenFormNumeClient"></input>
            <input class="hiddenForm" type="text" id="hiddenFormPrenumeClient" name="hiddenFormPrenumeClient"></input>
            <input class="hiddenForm" type="text" id="hiddenFormTelefonClient" name="hiddenFormTelefonClient"></input>
            <input class="hiddenForm" type="text" id="hiddenFormEmailClient"   name="hiddenFormEmailClient"></input>
          </form>
          <button type"button" class="btn btn-default" id="nuSalvareModificari" name="nuSalvareModificari" onclick="anuleazaModificariClient()"> Nu </button>
        </div>
      </div>

      <div class="continua">
        <button type"button" class="btn btn-default" id="butonPas2" data-toggle="collapse" data-target="#adresaComanda" aria-expanded="false" aria-controls="collapseExample"> Continuă </button>
      </div>
    </div>

    <?php

      require 'includeri-php/dbconnection.php';

      $sql  = "SELECT localitate, strada, numar, bloc, scara, etaj, apartament, interfon FROM adrese
               INNER JOIN adrese_clienti ON (adrese_clienti.idAdresa = adrese.idAdresa)
               INNER JOIN utilizatori ON (utilizatori.idUtilizator = adrese_clienti.idClient)
               WHERE utilizatori.idUtilizator  = '$_SESSION[idClient]';";
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

        $adrese = array();

        while($row = mysqli_fetch_assoc($rezultat))
        {
          $detaliiAdresa = $row["localitate"] . ", " . $row["strada"] . ", " . $row["numar"] . ", " . $row["bloc"] . ", " .
                           $row["scara"] . ", " . $row["etaj"] . ", " . $row["apartament"] . ", " . $row["interfon"] . ";";

          array_push($adrese, $detaliiAdresa);

        }
      }

    ?>

    <div class="collapse" id="adresaComanda">
      <div class="pasul3">
        <div class="nr3">3</div>
        <h2> Adresa </h2>
      </div>

      <div class="col-md-10 col-md-offset-1 alegereAdresa">
        <h4>Alegeți o adresă: &nbsp;&nbsp;</h4>
        <select class="mdb-select md-form" id="alegereAdresaDropdown" name="alegereAdresaDropdown" onchange="afisareAdresa()">
          <option value="" disabled selected></option>
          <?php
            for($i = 0; $i < count($adrese); $i++)
            {
              echo '<option name="adresa'.$i.'">'.$adrese[$i].'</option>';
            }
          ?>
        </select>

        <h4>&nbsp;&nbsp;&nbsp;&nbsp; sau introduceți o adresă nouă: &nbsp;&nbsp;</h4>
        <i class="fas fa-plus plus" name="nou" onclick="adresaNoua()"></i>
      </div>

      <div class="informatii-adresa" id="informatii-adresa">
        <div class="col-md-4 adresa">
          <label>Localitate: </label>
          <input type="text" id="localitate" name="localitate"  form="trimiteComanda" required  oninvalid="this.setCustomValidity('Va rugam sa introduceti localitatea!')" oninput="setCustomValidity('')" onchange="schimbareDetaliiAdresa()"/>
        </div>
        <div class="col-md-4 adresa">
          <label>Stradă: </label>
          <input type="text" id="strada" name="strada" form="trimiteComanda" required  oninvalid="this.setCustomValidity('Va rugam sa introduceti strada!')" oninput="setCustomValidity('')" onchange="schimbareDetaliiAdresa()"/>
        </div>
        <div class="col-md-4 adresa">
          <label>Număr: </label>
          <input type="text" id="numar" name="numar" form="trimiteComanda" required  oninvalid="this.setCustomValidity('Va rugam sa introduceti numarul!')" oninput="setCustomValidity('')" onchange="schimbareDetaliiAdresa()"/>
        </div>
        <div class="col-md-4 adresa">
          <label>Bloc: </label>
          <input type="text" id="bloc" name="bloc" form="trimiteComanda" onchange="schimbareDetaliiAdresa()"/>
        </div>
        <div class="col-md-4 adresa">
          <label>Scară: </label>
          <input type="text" id="scara" name="scara"  form="trimiteComanda" onchange="schimbareDetaliiAdresa()"/>
        </div>
        <div class="col-md-4 adresa">
          <label>Etaj: </label>
          <input type="text" id="etaj" name="etaj"  form="trimiteComanda" onchange="schimbareDetaliiAdresa()"/>
        </div>
        <div class="col-md-4 adresa">
          <label>Apartament: </label>
          <input type="text" id="apartament" name="apartament"   form="trimiteComanda" onchange="schimbareDetaliiAdresa()"/>
        </div>
        <div class="col-md-4 adresa">
          <label>Interfon: </label>
          <input type="text" id="interfon" name="interfon"  form="trimiteComanda" onchange="schimbareDetaliiAdresa()"/>
        </div>

        <div class="col-md-7 col-md-offset-2 salvareModificari" id="modificariAdresa">
          <h4> Doriți să salvați noua adresă în baza noastră de date? </h4>
          <form id="form-modificariAdresa" name="form-modificariAdresa" action="includeri-php/adaugareAdresa.php" method="post">
            <button type"submit" class="btn btn-default" id="daSalvareModificari" name="daSalvareAdresa"> Da </button>
            <input class="hiddenForm" type="text" id="hiddenFormLocalitate" name="hiddenFormLocalitate"></input>
            <input class="hiddenForm" type="text" id="hiddenFormStrada"     name="hiddenFormStrada"></input>
            <input class="hiddenForm" type="text" id="hiddenFormNumar"      name="hiddenFormNumar"></input>
            <input class="hiddenForm" type="text" id="hiddenFormBloc"       name="hiddenFormBloc"></input>
            <input class="hiddenForm" type="text" id="hiddenFormScara"      name="hiddenFormScara"></input>
            <input class="hiddenForm" type="text" id="hiddenFormEtaj"       name="hiddenFormEtaj"></input>
            <input class="hiddenForm" type="text" id="hiddenFormApartament" name="hiddenFormApartament"></input>
            <input class="hiddenForm" type="text" id="hiddenFormInterfon"   name="hiddenFormInterfon"></input>
          </form>
          <button type"button" class="btn btn-default" id="nuSalvareModificari" name="nuSalvareModificari" onclick="anuleazaModificariAdresa()"> Nu </button>
        </div>

        <div class="continua">
          <button type"button" class="btn btn-default" id="buton-comanda" name="buton-comanda" onclick="afiseazaModal()"> Trimite Comanda </button>
        </div>

        <!-- Fereastra modal -->
        <div class="modal fade modal-box" id="myModal" role="dialog">
          <div class="modal-dialog-centered modal-dialog ">

            <!-- Continutul ferestrei -->
            <div class="modal-content fereastra-modal">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title titlu">Comandă trimisă</h4>
              </div>
              <div class="modal-body">
                <div class="item">
                  <p>Comanda a fost finalizată și trimisă!</p>
                  <p>Timpul estimat de livrare este: <?php echo $_SESSION["timpMediuDeAsteptare"]; ?>!</p>
                </div>
              </div>
              <div class="modal-footer">
              <form id="trimiteComanda" action="includeri-php/trimitereComanda.php" method="post">
                <button type"submit" class="btn btn-customize" id="buton-trimite-comanda" name="buton-trimite-comanda"> OK</button>
              </form>
            </div>
            </div>
          </div>
        </div>
    </div>

  </div>



</div>

  <?php
    include_once 'includeri-php/footer.php';
  ?>

  <script type="text/javascript" src="javascript/cosul-meu.js"></script>
  <script type="text/javascript" src="javascript/burger-menu.js"></script>

</body>
</html>
