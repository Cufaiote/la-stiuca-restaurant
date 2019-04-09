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
  <link rel="stylesheet" href="css/menu_style.css">
  <link rel="stylesheet" href="css/header_style.css">
  <link rel="stylesheet" href="css/footer_style.css">
  <link rel="shortcut icon" type="image/png" href="imagini/favicon-titlu.ico">
  <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:700" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Rouge+Script" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

  <?php
    include_once 'includeri-php/header.php';
  ?>

    <div class="container">
      <h1> Meniu </h1>
      <div class="categorii-meniu">
        <form method="post">
          <button class="btn btn-link" name="1-aperitive"       type="submit">Aperitive         </button>
          <button class="btn btn-link" name="2-specialitati"    type="submit">Specialități      </button>
          <button class="btn btn-link" name="3-fructe-de-mare"  type="submit">Fructe de mare    </button>
          <button class="btn btn-link" name="4-ciorbe"          type="submit">Ciorbe si borșuri </button>
          <button class="btn btn-link" name="5-salate"          type="submit">Salate            </button>
          <button class="btn btn-link" name="6-garnituri"       type="submit">Garnituri         </button>
          <button class="btn btn-link" name="7-deserturi"       type="submit">Deserturi         </button>
          <button class="btn btn-link" name="8-bauturi"         type="submit">Băuturi           </button>
          <button class="btn btn-link" name="toate-produsele" type="submit">Toate produsele   </button>
        </form>
      </div>

    <div class="incadrare">
      <div class="meniu-container">

      <?php

        include_once 'includeri-php/dbconnection.php';

        $categorii = array("1-aperitive", "2-specialitati", "3-fructe-de-mare", "4-ciorbe", "5-salate", "6-garnituri", "7-deserturi", "8-bauturi");
        $isClicked = false;

        foreach ($categorii as $value)
        {
          if(isset($_POST[$value]))
          {
            $isClicked = true;
            $categorie = explode("-", $value);

            $sql  = "SELECT * FROM preparate WHERE categoriePreparat = '$categorie[0]' ORDER BY idPreparat ASC;";
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

              $arrayPreparate = array();

              echo '<div class="preparate">
                      <h2>' . $categorie[1] . '</h2>';

              while($row = mysqli_fetch_assoc($rezultat))
              {
                array_push($arrayPreparate, $row);
              }

              $nrPreparate = count($arrayPreparate);

              for($i = 0; $i < $nrPreparate; $i++)
              {
                if(isset($_SESSION['idClient']))
                {
                  echo ' <div class="col-md-6 left">
                            <div class="left-item">
                              <div class="po poza-st" style="background-image: url(imagini/meniu/'.$arrayPreparate[$i]["caleImagine"].');">
                              </div>
                              <div class="info-item">
                                <div class="numeSiPret">
                                  <h3>'. $arrayPreparate[$i]["numePreparat"] .'</h3>
                                  <h3>'. $arrayPreparate[$i]["pretPreparat"] .' lei</h3>
                                </div>
                                <div class="info-ing">
                                  <h4>'. str_replace(",", ", ", $arrayPreparate[$i]["ingredientePreparat"]) .'</h4>
                                </div>
                                <div class="buton-adauga">
                                  <input type="hidden" id="phpClient" value="'.$_SESSION["idClient"].'" style="width: 0; height: 0;"/>
                                  <button type="button" class="btn btn-customize" id="'. $arrayPreparate[$i]["idPreparat"] .'" onclick="deschideModal(this.id)">Adaugă în coș</button>
                                </div>
                              </div>
                            </div>
                          </div>


                         <!-- Fereastra modal -->
                          <div class="modal fade modal-box" id="myModal-'. $arrayPreparate[$i]["idPreparat"] .'" role="dialog">
                            <div class="modal-dialog modal-dialog-centered">

                              <!-- Continutul ferestrei -->
                              <div class="modal-content fereastra-modal">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title titlu">'. $arrayPreparate[$i]["numePreparat"] .'</h4>
                                </div>
                                <div class="modal-body">
                                  <div class="item">
                                    <div class="po-modal poza-st" style="background-image: url(imagini/meniu/'.$arrayPreparate[$i]["caleImagine"].');">
                                    </div>
                                    <div class="info-item-modal">
                                      <div class="cantitate">
                                        <h3>Cantitate</h3>
                                        <form class="value-form">
                                          <div class="value-button decrease" id="decrease-'. $arrayPreparate[$i]["idPreparat"] .'" onclick="decreaseValue(this.id)"><i class="fas fa-minus fa-semn"></i></div>
                                          <div class="value"><input type="number" class="number" id="number-'. $arrayPreparate[$i]["idPreparat"] .'" name="cantitate" value="1" /></div>
                                          <div class="value-button increase" id="increase-'. $arrayPreparate[$i]["idPreparat"] .'" onclick="increaseValue(this.id)"><i class="fas fa-plus fa-semn"></i></div>
                                        </form>
                                      </div>
                                      <div class="info-pret">
                                        <h3>Pret:  <span id="schimbarePret-'. $arrayPreparate[$i]["idPreparat"] .'">'. $arrayPreparate[$i]["pretPreparat"] .'</span> lei</h3>
                                      </div>
                                      <div class="buton-adauga">
                                        <form class="form-adauga" action="includeri-php/adaugarePreparatLaComanda.php" method="post">
                                          <input type="number" id="nr-'. $arrayPreparate[$i]["idPreparat"] .'" name="cantitate" value="1" style="visibility: hidden; width: 0px; height: 0px;">
                                          <input type="number" name="idPrep" value="'. $arrayPreparate[$i]["idPreparat"] .'" style="visibility: hidden; width: 0px; height: 0px;">
                                          <button type="button" class="btn btn-default btn-modal" name="button-dismiss" data-dismiss="modal">Inchide</button>
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
                        elseif (isset($_SESSION['idAdmin']))
                        {
                          echo ' <div class="col-md-6 left">
                                    <div class="left-item">
                                      <div class="po poza-st" style="background-image: url(imagini/meniu/'.$arrayPreparate[$i]["caleImagine"].');">
                                      </div>
                                      <div class="info-item">
                                        <div class="numeSiPret">
                                          <h3>'. $arrayPreparate[$i]["numePreparat"] .'</h3>
                                          <h3>'. $arrayPreparate[$i]["pretPreparat"] .' lei</h3>
                                        </div>
                                        <div class="info-ing">
                                          <h4>'. str_replace(",", ", ", $arrayPreparate[$i]["ingredientePreparat"]) .'</h4>
                                        </div>
                                        <div class="buton-adauga">
                                          <input type="hidden" id="phpAdmin" value="'.$_SESSION["idAdmin"].'" style="width: 0; height: 0;"/>
                                          <button type="button" class="btn btn-customize" id="'. $arrayPreparate[$i]["idPreparat"] .'" onclick="modificaModal(this.id)">Modifică</button>
                                          <button type="button" class="btn btn-customize" id="elimina-' . $arrayPreparate[$i]["idPreparat"] . '" onclick="stergeModal(this.id)"> Elimină </button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  <!-- Fereastra modal -->
                                   <div class="modal fade modal-box" id="modalAdmin-'. $arrayPreparate[$i]["idPreparat"] .'" role="dialog">
                                     <div class="modal-dialog modal-dialog-centered">

                                       <!-- Continutul ferestrei -->
                                       <div class="modal-content fereastra-modal" style="width: 950px!important;">
                                         <div class="modal-header">
                                           <button type="button" class="close" data-dismiss="modal">&times;</button>
                                           <h4 class="modal-title titlu">'. $arrayPreparate[$i]["numePreparat"] .'</h4>
                                         </div>
                                         <div class="modal-body">
                                         <form class="col-md-offset-1 col-md-10 upload" action="includeri-php/modificarePreparat.php" method="post" enctype="multipart/form-data">
                                           <input class="upload-form" style="visibility: hidden;" type="text" name="modificaidPreparat" value="'. $arrayPreparate[$i]["idPreparat"] .'">
                                           <div class="modifica-form">
                                             <label>Nume:</label>
                                             <input class="modifica-input" type="text" name="modificaNumePreparat" value="'. $arrayPreparate[$i]["numePreparat"] .'">
                                           </div>
                                           <div class="modifica-form">
                                             <label>Pret:</label>
                                             <input class="modifica-input" type="text" name="modificaPretPreparat" value="'. $arrayPreparate[$i]["pretPreparat"] .'">
                                           </div>
                                           <div class="modifica-form">
                                             <label>Ingrediente:</label>
                                             <input class="modifica-input" type="text" name="modificaIngredientePreparat" value="'. $arrayPreparate[$i]["ingredientePreparat"] .'">
                                           </div>
                                           <div class="modifica-form">
                                             <label>Categorie:</label>
                                             <select class="modifica-input" name="modificaCategoriePreparat">
                                               <option value="'. $arrayPreparate[$i]["categoriePreparat"] .'" disabled selected ></option>
                                               <option value="specialitati">Specialitati</option>
                                               <option value="aperitive">Aperitive</option>
                                               <option value="fructe-de-mare">Fructe de mare</option>
                                               <option value="ciorbe">Ciorbe si borsuri</option>
                                               <option value="salate">Salate</option>
                                               <option value="garnituri">Garnituri</option>
                                               <option value="deserturi">Deserturi</option>
                                               <option value="bauturi">Bauturi</option>
                                             </select>
                                           </div>
                                           <div class="modifica-form">
                                             <label style="font-size: 14px; padding-top: 5px;">Timp de preparare:</label>
                                             <input class="modifica-input" type="text" name="modificaTimpDePreparare" value="'. $arrayPreparate[$i]["timpDePreparare"] .'">
                                           </div>
                                           <div class="modifica-form">
                                             <input class="modifica-input" id="modificaFile" type="file" name="modificaFile">
                                           </div>
                                           <button id="modifica-button" type="submit" name="modifica">Modifică</button>
                                         </form>
                                         </div>
                                       </div>
                                     </div>
                                   </div>

                                   <!-- Fereastra modal -->
                                   <div class="modal fade modal-box" id="stergePreparat-'.$arrayPreparate[$i]["idPreparat"].'" role="dialog">
                                     <div class="modal-dialog modal-dialog-centered" role="document">
                                       <div class="modal-content fereastra-modal">
                                         <div class="modal-header">
                                            <h5 class="modal-title">'.$arrayPreparate[$i]["numePreparat"].'</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                         </div>
                                         <div class="modal-body">
                                            <p>&nbsp;&nbsp;&nbsp;Sunteți sigur(ă) ca vreți să eliminați preparatul:&nbsp;&nbsp; <span style="font-weight: bold;  font-style: italic;">'.$arrayPreparate[$i]["numePreparat"].'</span>?</p>
                                         </div>
                                         <div class="modal-footer">
                                            <button type="button" class="btn btn-customize" data-dismiss="modal">Nu</button>
                                            <form class="form-inline form-eliminare" action="includeri-php/eliminarePreparat.php" method="post">
                                              <button class="btn btn-customize" type="submit" name="butonEliminaPreparat">Elimină</button>
                                              <input type="text" name="stergeIdPreparat" id="stergeIdPreparat" style="visibility: hidden; height: 0; width: 0;" value="'.$arrayPreparate[$i]["idPreparat"].'"/>
                                              <input type="text" name="stergeCaleImagine" id="stergeCaleImagine" style="visibility: hidden; height: 0; width: 0;" value="'.$arrayPreparate[$i]["caleImagine"].'"/>
                                            </form>
                                         </div>
                                      </div>
                                    </div>
                                  </div>';
                        }
                        elseif(isset($_SESSION['idPersonal']))
                        {
                          echo ' <div class="col-md-6 left">
                                    <div class="left-item">
                                      <div class="po poza-st" style="background-image: url(imagini/meniu/'.$arrayPreparate[$i]["caleImagine"].');">
                                      </div>
                                      <div class="info-item">
                                        <div class="numeSiPret">
                                          <h3>'. $arrayPreparate[$i]["numePreparat"] .'</h3>
                                          <h3>'. $arrayPreparate[$i]["pretPreparat"] .' lei</h3>
                                        </div>
                                        <div class="info-ing">
                                          <h4>'. str_replace(",", ", ", $arrayPreparate[$i]["ingredientePreparat"]) .'</h4>
                                        </div>

                                      </div>
                                    </div>
                                  </div>';
                        }
                        else
                        {
                          echo '<div class="col-md-6 left">
                                    <div class="left-item">
                                      <div class="po poza-st" style="background-image: url(imagini/meniu/'.$arrayPreparate[$i]["caleImagine"].');">
                                      </div>
                                      <div class="info-item">
                                        <div class="numeSiPret">
                                          <h3>'. $arrayPreparate[$i]["numePreparat"] .'</h3>
                                          <h3>'. $arrayPreparate[$i]["pretPreparat"] .' lei</h3>
                                        </div>
                                        <div class="info-ing">
                                          <h4>'. str_replace(",", ", ", $arrayPreparate[$i]["ingredientePreparat"]) .'</h4>
                                        </div>
                                        <div class="buton-adauga">
                                          <input type="hidden" id="phpClient" value="'.$_SESSION["idClient"].'" style="width: 0; height: 0;"/>
                                          <button type="button" class="btn btn-customize" id="'. $arrayPreparate[$i]["idPreparat"] .'" onclick="deschideModal(this.id)">Adaugă în coș</button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>';
                        }

              }

              echo '</div>';
            }
          }
        }

        if(isset($_POST['toate-produsele']))
        {
          echo '<script> location.replace("menu.php"); </script>';
          exit();
        }

        if($isClicked == false)
        {
          $sql  = "SELECT * FROM preparate ORDER BY categoriePreparat ASC;";
          $stmt = mysqli_stmt_init($conn);

          if(!mysqli_stmt_prepare($stmt, $sql))
          {
            echo "Eroare - SQL Statement - SELECT";
            exit();
          }
          else
          {
            mysqli_stmt_execute($stmt);
            $rezultat = mysqli_stmt_get_result($stmt);
            $arrayPreparate = array();

            echo '<div class="preparate">
            <h2>Oferta noastra</h2>';

            while($row = mysqli_fetch_assoc($rezultat))
            {
              array_push($arrayPreparate, $row);
            }

            $nrPreparate = count($arrayPreparate);

            for($i = 0; $i < $nrPreparate; $i++)
            {
              if(isset($_SESSION['idClient']))
              {
                echo ' <div class="col-md-6 left">
                          <div class="left-item">
                            <div class="po poza-st" style="background-image: url(imagini/meniu/'.$arrayPreparate[$i]["caleImagine"].');">
                            </div>
                            <div class="info-item">
                              <div class="numeSiPret">
                                <h3>'. $arrayPreparate[$i]["numePreparat"] .'</h3>
                                <h3>'. $arrayPreparate[$i]["pretPreparat"] .' lei</h3>
                              </div>
                              <div class="info-ing">
                                <h4>'. str_replace(",", ", ", $arrayPreparate[$i]["ingredientePreparat"]) .'</h4>
                              </div>
                              <div class="buton-adauga">
                                <input type="hidden" id="phpClient" value="'.$_SESSION["idClient"].'" style="width: 0; height: 0;"/>
                                <button type="button" class="btn btn-customize" id="'. $arrayPreparate[$i]["idPreparat"] .'" onclick="deschideModal(this.id)">Adaugă în coș</button>
                              </div>
                            </div>
                          </div>
                        </div>


                       <!-- Fereastra modal -->
                        <div class="modal fade modal-box" id="myModal-'. $arrayPreparate[$i]["idPreparat"] .'" role="dialog">
                          <div class="modal-dialog modal-dialog-centered">

                            <!-- Continutul ferestrei -->
                            <div class="modal-content fereastra-modal">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title titlu">'. $arrayPreparate[$i]["numePreparat"] .'</h4>
                              </div>
                              <div class="modal-body">
                                <div class="item">
                                  <div class="po-modal poza-st" style="background-image: url(imagini/meniu/'.$arrayPreparate[$i]["caleImagine"].');">
                                  </div>
                                  <div class="info-item-modal">
                                    <div class="cantitate">
                                      <h3>Cantitate</h3>
                                      <form class="value-form">
                                        <div class="value-button decrease" id="decrease-'. $arrayPreparate[$i]["idPreparat"] .'" onclick="decreaseValue(this.id)"><i class="fas fa-minus fa-semn"></i></div>
                                        <div class="value"><input type="number" class="number" id="number-'. $arrayPreparate[$i]["idPreparat"] .'" name="cantitate" value="1" /></div>
                                        <div class="value-button increase" id="increase-'. $arrayPreparate[$i]["idPreparat"] .'" onclick="increaseValue(this.id)"><i class="fas fa-plus fa-semn"></i></div>
                                      </form>
                                    </div>
                                    <div class="info-pret">
                                      <h3>Pret:  <span id="schimbarePret-'. $arrayPreparate[$i]["idPreparat"] .'">'. $arrayPreparate[$i]["pretPreparat"] .'</span> lei</h3>
                                    </div>
                                    <div class="buton-adauga">
                                      <form class="form-adauga" action="includeri-php/adaugarePreparatLaComanda.php" method="post">
                                        <input type="number" id="nr-'. $arrayPreparate[$i]["idPreparat"] .'" name="cantitate" value="1" style="visibility: hidden; width: 0px; height: 0px;">
                                        <input type="number" name="idPrep" value="'. $arrayPreparate[$i]["idPreparat"] .'" style="visibility: hidden; width: 0px; height: 0px;">
                                        <button type="button" class="btn btn-default btn-modal" name="button-dismiss" data-dismiss="modal">Inchide</button>
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
                      elseif (isset($_SESSION['idAdmin']))
                      {
                        echo ' <div class="col-md-6 left">
                                  <div class="left-item">
                                    <div class="po poza-st" style="background-image: url(imagini/meniu/'.$arrayPreparate[$i]["caleImagine"].');">
                                    </div>
                                    <div class="info-item">
                                      <div class="numeSiPret">
                                        <h3>'. $arrayPreparate[$i]["numePreparat"] .'</h3>
                                        <h3>'. $arrayPreparate[$i]["pretPreparat"] .' lei</h3>
                                      </div>
                                      <div class="info-ing">
                                        <h4>'. str_replace(",", ", ", $arrayPreparate[$i]["ingredientePreparat"]) .'</h4>
                                      </div>
                                      <div class="buton-adauga">
                                        <input type="hidden" id="phpAdmin" value="'.$_SESSION["idAdmin"].'" style="width: 0; height: 0;"/>
                                        <button type="button" class="btn btn-customize" id="'. $arrayPreparate[$i]["idPreparat"] .'" onclick="modificaModal(this.id)">Modifică</button>
                                        <button type="button" class="btn btn-customize" id="elimina-' . $arrayPreparate[$i]["idPreparat"] . '" onclick="stergeModal(this.id)"> Elimină </button>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <!-- Fereastra modal -->
                                 <div class="modal fade modal-box" id="modalAdmin-'. $arrayPreparate[$i]["idPreparat"] .'" role="dialog">
                                   <div class="modal-dialog modal-dialog-centered">

                                     <!-- Continutul ferestrei -->
                                     <div class="modal-content fereastra-modal" style="width: 950px!important;">
                                       <div class="modal-header">
                                         <button type="button" class="close" data-dismiss="modal">&times;</button>
                                         <h4 class="modal-title titlu">'. $arrayPreparate[$i]["numePreparat"] .'</h4>
                                       </div>
                                       <div class="modal-body">
                                       <form class="col-md-offset-1 col-md-10 upload" action="includeri-php/modificarePreparat.php" method="post" enctype="multipart/form-data">
                                         <input class="upload-form" style="visibility: hidden;" type="text" name="modificaidPreparat" value="'. $arrayPreparate[$i]["idPreparat"] .'">
                                         <div class="modifica-form">
                                           <label>Nume:</label>
                                           <input class="modifica-input" type="text" name="modificaNumePreparat" value="'. $arrayPreparate[$i]["numePreparat"] .'">
                                         </div>
                                         <div class="modifica-form">
                                           <label>Pret:</label>
                                           <input class="modifica-input" type="text" name="modificaPretPreparat" value="'. $arrayPreparate[$i]["pretPreparat"] .'">
                                         </div>
                                         <div class="modifica-form">
                                           <label>Ingrediente:</label>
                                           <input class="modifica-input" type="text" name="modificaIngredientePreparat" value="'. $arrayPreparate[$i]["ingredientePreparat"] .'">
                                         </div>
                                         <div class="modifica-form">
                                           <label>Categorie:</label>
                                           <select class="modifica-input" name="modificaCategoriePreparat">
                                             <option value="'. $arrayPreparate[$i]["categoriePreparat"] .'" disabled selected ></option>
                                             <option value="1">Aperitive</option>
                                             <option value="2">Specialitati</option>
                                             <option value="3">Fructe de mare</option>
                                             <option value="4">Ciorbe si borsuri</option>
                                             <option value="5">Salate</option>
                                             <option value="6">Garnituri</option>
                                             <option value="7">Deserturi</option>
                                             <option value="8">Bauturi</option>
                                           </select>
                                         </div>
                                         <div class="modifica-form">
                                           <label style="font-size: 14px; padding-top: 5px;">Timp de preparare:</label>
                                           <input class="modifica-input" type="text" name="modificaTimpDePreparare" value="'. $arrayPreparate[$i]["timpDePreparare"] .'">
                                         </div>
                                         <div class="modifica-form">
                                           <input class="modifica-input" id="modificaFile" type="file" name="modificaFile">
                                         </div>
                                         <button id="modifica-button" type="submit" name="modifica">Modifică</button>
                                       </form>
                                       </div>
                                     </div>
                                   </div>
                                 </div>

                                 <!-- Fereastra modal -->
                                 <div class="modal fade modal-box" id="stergePreparat-'.$arrayPreparate[$i]["idPreparat"].'" role="dialog">
                                   <div class="modal-dialog modal-dialog-centered" role="document">
                                     <div class="modal-content fereastra-modal">
                                       <div class="modal-header">
                                          <h5 class="modal-title">'.$arrayPreparate[$i]["numePreparat"].'</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                       </div>
                                       <div class="modal-body">
                                          <p>&nbsp;&nbsp;&nbsp;Sunteți sigur(ă) ca vreți să eliminați preparatul:&nbsp;&nbsp; <span style="font-weight: bold;  font-style: italic;">'.$arrayPreparate[$i]["numePreparat"].'</span>?</p>
                                       </div>
                                       <div class="modal-footer">
                                          <button type="button" class="btn btn-customize" data-dismiss="modal">Nu</button>
                                          <form class="form-inline form-eliminare" action="includeri-php/eliminarePreparat.php" method="post">
                                            <button class="btn btn-customize" type="submit" name="butonEliminaPreparat">Elimină</button>
                                            <input type="text" name="stergeIdPreparat" id="stergeIdPreparat" style="visibility: hidden; height: 0; width: 0;" value="'.$arrayPreparate[$i]["idPreparat"].'"/>
                                            <input type="text" name="stergeCaleImagine" id="stergeCaleImagine" style="visibility: hidden; height: 0; width: 0;" value="'.$arrayPreparate[$i]["caleImagine"].'"/>
                                          </form>
                                       </div>
                                    </div>
                                  </div>
                                </div>';
                      }
                      elseif(isset($_SESSION['idPersonal']))
                      {
                        echo ' <div class="col-md-6 left">
                                  <div class="left-item">
                                    <div class="po poza-st" style="background-image: url(imagini/meniu/'.$arrayPreparate[$i]["caleImagine"].');">
                                    </div>
                                    <div class="info-item">
                                      <div class="numeSiPret">
                                        <h3>'. $arrayPreparate[$i]["numePreparat"] .'</h3>
                                        <h3>'. $arrayPreparate[$i]["pretPreparat"] .' lei</h3>
                                      </div>
                                      <div class="info-ing">
                                        <h4>'. str_replace(",", ", ", $arrayPreparate[$i]["ingredientePreparat"]) .'</h4>
                                      </div>

                                    </div>
                                  </div>
                                </div>';
                      }
                      else
                      {
                        echo '<div class="col-md-6 left">
                                  <div class="left-item">
                                    <div class="po poza-st" style="background-image: url(imagini/meniu/'.$arrayPreparate[$i]["caleImagine"].');">
                                    </div>
                                    <div class="info-item">
                                      <div class="numeSiPret">
                                        <h3>'. $arrayPreparate[$i]["numePreparat"] .'</h3>
                                        <h3>'. $arrayPreparate[$i]["pretPreparat"] .' lei</h3>
                                      </div>
                                      <div class="info-ing">
                                        <h4>'. str_replace(",", ", ", $arrayPreparate[$i]["ingredientePreparat"]) .'</h4>
                                      </div>
                                      <div class="buton-adauga">
                                        <input type="hidden" id="phpClient" value="'.$_SESSION["idClient"].'" style="width: 0; height: 0;"/>
                                        <button type="button" class="btn btn-customize" id="'. $arrayPreparate[$i]["idPreparat"] .'" onclick="deschideModal(this.id)">Adaugă în coș</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>';
                      }

            }

            echo '</div>';
          }
        }

          echo '<!-- Fereastra modal client neautentificat-->
            <div class="modal fade modal-box" id="modalClientNeautentificat" role="dialog">
              <div class="modal-dialog modal-dialog-centered">

                <!-- Continutul ferestrei -->
                <div class="modal-content fereastra-modal">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title titlu">Se pare ca nu v-ati autentificat!</h3>
                  </div>
                  <div class="modal-body">
                    <div class="item-cn">
                      <h4> Pentru a putea comanda on-line de la restaurantul nostru trebuie să vă autentificați!</h4>

                      <div class="mod-autentificare">
                        <h4> Pentru a vă autentifica, apăsați următorul buton: </h4>
                        <button type="button" class="btn btn-customize" id="btn-autentificare">
                          <a href="autentificare.php">Autentificare</a>
                        </button>
                      </div>

                      <div class="mod-inregistrare">
                        <h4> Nu aveți cont? Creati-vă unul acum:</h4>
                        <button type="button" class="btn btn-customize" id="btn-inregistrare">
                          <a href="inregistrare.php">Înregistrare</a>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-customize " name="button-dismiss" data-dismiss="modal">Inchide</button>
                  </div>
                </div>
              </div>
            </div>';
        ?>
      </div>
    </div>
    </div>

    <div style="clear:both;"></div>

    <?php

      if(isset($_SESSION['idAdmin']))
      {
        echo '<div class="menu-upload-container">
                <div class="col-md-6 col-md-offset-3 menu-upload">
                  <h2>Adăugați un preparat</h2>
                  <form class="upload" action="includeri-php/menu-upload.php" method="post" enctype="multipart/form-data">
                    <input class="upload-form" type="text" name="numePreparat" placeholder="Nume preparat...">

                    <input class="upload-form" type="text" name="pretPreparat" placeholder="Pret preparat...">
                    <input class="upload-form" type="text" name="ingredientePreparat" placeholder="Ingrediente...">
                    <span id="span-dropdown">Alegeți o categorie:<select id="upload-form-dropdown" name="categoriePreparat">
                      <option value="" disabled selected></option>
                      <option value="1">Aperitive</option>
                      <option value="2">Specialitati</option>
                      <option value="3">Fructe de mare</option>
                      <option value="4">Ciorbe si borsuri</option>
                      <option value="5">Salate</option>
                      <option value="6">Garnituri</option>
                      <option value="7">Deserturi</option>
                      <option value="8">Bauturi</option>
                    </select></span>
                    <input class="upload-form" type="text" name="timpDePreparare" placeholder="Timp de preparare: (hh:mm:ss)...">
                    <input class="upload-form" type="file" name="file">
                    <button id="upload-button" type="submit" name="submit">Adaugă</button>
                  </form>
                </div>
              </div>';
      }

      ?>

  <?php
    include_once 'includeri-php/footer.php';
  ?>

  <script type="text/javascript" src="javascript/menu-modal.js"></script>
  <script type="text/javascript" src="javascript/popover-autentificare.js"></script>
  <script type="text/javascript" src="javascript/burger-menu.js"></script>

</body>
</html>
