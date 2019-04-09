<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>La Știuca</title>
  <link rel="stylesheet" href="css/footer_style.css">
  <link rel="stylesheet" href="css/header_style.css">
  <link rel="stylesheet" href="css/gallery_style.css">
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
  ?>

    <div class="container gallery-links">
      <div class="wrapper">
        <h1>Galerie</h1>
        <div class="gallery-container">
          <?php

            include_once 'includeri-php/dbconnection.php';

            $sql = "SELECT * FROM galerie WHERE categorieImagine = 'preparate' ORDER BY id DESC;";
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt, $sql))
            {
              echo "Eroare - SQL statement - SELECT";
              exit();
            }
            else
            {
              mysqli_stmt_execute($stmt);
              $rezultat = mysqli_stmt_get_result($stmt);
              $arrayImagini = array();
              echo '<div class="imagini">
                      <h2>Preparate</h2>';

              while($row = mysqli_fetch_assoc($rezultat))
              {
                array_push($arrayImagini, $row);
              }

              $nrImagini = count($arrayImagini);

              for($i = 0; $i < $nrImagini; $i++)
              {
                if(isset($_SESSION['idAdmin']))
                {
                  $numeImagine = explode(".", $arrayImagini[$i]["numeImagine"]);

                  echo '<div class="col-md-4">
                          <div class="polaroid"  id="polaroid-'.$i.'">
                              <div class="image-div" style="background-image: url(imagini/galerie/'.$arrayImagini[$i]["numeImagine"].');"></div>
                              <h3>'.$arrayImagini[$i]["titlu"].'</h3>
                              <p>'.$arrayImagini[$i]["descriere"].'</p>
                              <div class="col-md-offset-5 col-md-7 optiuniGalerie">
                                <button type="button" class="btn btn-customize" name="modificaImagine" id="modificaImagine-'.$i.'" onclick="modificaImagineModal(this.id)"> Modifică </button>
                                <button type="button" class="btn btn-customize" name="stergeImagine" id="stergeImagine-'.$arrayImagini[$i]["id"].'" onclick="stergeImagineModal(this.id)"> Elimină </button>
                              </div>
                          </div>
                        </div>

                        <div class="modal fade" id="modificaImaginePreparat'.$i.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content modalAdmin">
                              <div class="modal-header">
                                <h5 class="modal-title titluAdmin">'.$arrayImagini[$i]["titlu"].'</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <i class="fas fa-times" style="color: black!important; opacity: 1!important;"></i>
                                </button>
                              <div class="modal-body" >
                                <form class="col-md-offset-2 col-md-8 upload" action="includeri-php/modificareImagine.php" method="post" enctype="multipart/form-data">
                                  <input type="text" style="visibility: hidden; height: 0; width: 0" name="modificaIdFisier" value="'.$arrayImagini[$i]["id"].'">
                                  <input type="text" style="visibility: hidden; height: 0; width: 0" name="caleImagineAnterioara" value="'.$arrayImagini[$i]["numeImagine"].'">
                                  <div class="modifica-form">
                                    <label>Nume:</label>
                                    <input class="modifica-input" type="text" name="modificaNumeFisier" value="'.$numeImagine[0].'">
                                  </div>
                                  <div class="modifica-form">
                                    <label>Titlu:</label>
                                    <input class="modifica-input" type="text" name="modificaTitluFisier" value="'.$arrayImagini[$i]["titlu"].'">
                                  </div>
                                  <div class="modifica-form">
                                    <label>Descriere:</label>
                                    <input class="modifica-input" type="text" name="modificaDescriereFisier" value="'.$arrayImagini[$i]["descriere"].'">
                                  </div>
                                  <div class="modifica-form">
                                    <label>Categorie:</label>
                                    <select class="modifica-input" name="modificaCategorieFisier">
                                      <option value="'.$arrayImagini[$i]["categorieImagine"].'" disabled selected></option>
                                      <option value="preparate">Preparate</option>
                                      <option value="restaurant">Restaurant</option>
                                    </select>
                                  </div>
                                  <input class="modifica-input" id="modificaFile" type="file" name="modificaFile">
                                  <br><br>
                                  <button id="modifica-button" type="submit" name="buton-modifica">Modifică</button>
                                </form>
                              </div>
                            </div>
                            </div>
                          </div>
                        </div>

                        <!-- Fereastra modal -->
                        <div class="modal fade modal-box" id="stergeImaginePreparat'.$arrayImagini[$i]["id"].'" role="dialog">
                          <div class="modal-dialog modal-dialog-centered" role="document" style=" width: 650px!important;">
                            <div class="modal-content fereastra-modal">
                              <div class="modal-header">
                                 <h5 class="modal-title" style="color: #313E53; font-weight: bold;">'.$arrayImagini[$i]["titlu"].'</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                   <span aria-hidden="true">&times;</span>
                                 </button>
                              </div>
                              <div class="modal-body"  style="  height: 100px!important;">
                                 <p>&nbsp;&nbsp;&nbsp;Sunteți sigur(ă) ca vreți să eliminați imaginea:&nbsp;&nbsp; <span style="font-weight: bold;  font-style: italic;">'.$arrayImagini[$i]["titlu"].'</span> ?</p>
                              </div>
                              <div class="modal-footer">
                                 <button type="button" class="btn btn-customize" data-dismiss="modal">Nu</button>
                                 <form class="form-inline form-eliminare" action="includeri-php/eliminareImagine.php" method="post">
                                   <button class="btn btn-customize" type="submit" name="butonEliminaImagine">Elimină</button>
                                   <input type="text" name="stergeIdImagine" id="stergeIdImagine" style="visibility: hidden; height: 0; width: 0;" value="'.$arrayImagini[$i]["id"].'"/>
                                   <input type="text" name="stergeCaleImagine" id="stergeCaleImagine" style="visibility: hidden; height: 0; width: 0;" value="'.$arrayImagini[$i]["numeImagine"].'"/>
                                 </form>
                              </div>
                           </div>
                         </div>
                       </div>';
                      }
                      else
                      {
                        echo '<div class="col-md-4">
                                <div class="polaroid"  id="polaroid-'.$i.'" onclick="afiseazaModalPreparat(this.id)">
                                    <div class="image-div" style="background-image: url(imagini/galerie/'.$arrayImagini[$i]["numeImagine"].');"></div>
                                    <h3>'.$arrayImagini[$i]["titlu"].'</h3>
                                    <p>'.$arrayImagini[$i]["descriere"].'</p>
                                </div>
                              </div>

                              <div class="modal fade" id="modalPreparat'.$i.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                  <div class="modal-content imgModal">
                                    <div class="modal-header">
                                      <h5 class="modal-title">'.$arrayImagini[$i]["titlu"].'</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i class="fas fa-times"></i>
                                      </button>
                                    <div class="modal-body" >
                                      <i class="fas fa-angle-left inapoi" id="inapoi-'.$i.'" onclick="afiseazaPreparatAnterior(this.id)"></i>
                                      <div class="imgPrep" style="background-image: url(imagini/galerie/'.$arrayImagini[$i]["numeImagine"].');">
                                      </div>
                                      <i class="fas fa-angle-right inainte" id="inainte-'.$i.'" onclick="afiseazaPreparatUrmator(this.id)"></i>
                                    </div>
                                          </div>
                                  </div>
                                </div>
                              </div>';
                            }
              }

              echo '  </div>';
            }


            $sql = "SELECT * FROM galerie WHERE categorieImagine = 'restaurant' ORDER BY id DESC;";
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt, $sql))
            {
              echo "Eroare - SQL statement - SELECT";
              exit();
            }
            else
            {
              mysqli_stmt_execute($stmt);
              $rezultat = mysqli_stmt_get_result($stmt);
              $arrayImagini = array();
              echo '<div class="imagini">
                      <h2>Restaurant</h2>';

              while($row = mysqli_fetch_assoc($rezultat))
              {
                array_push($arrayImagini, $row);
              }

              $nrImagini = count($arrayImagini);

              for($i = 0; $i < $nrImagini; $i++)
              {
                if(isset($_SESSION['idAdmin']))
                {
                  $numeImagine = explode(".", $arrayImagini[$i]["numeImagine"]);

                  echo '<div class="col-md-4">
                          <div class="polaroid"  id="polaroid-'.$i.'">
                              <div class="image-div" style="background-image: url(imagini/galerie/'.$arrayImagini[$i]["numeImagine"].');"></div>
                              <h3>'.$arrayImagini[$i]["titlu"].'</h3>
                              <p>'.$arrayImagini[$i]["descriere"].'</p>
                              <div class="col-md-offset-5 col-md-7 optiuniGalerie">
                                <button type="button" class="btn btn-customize" name="modificaImagine" id="modificaImagine-'.$i.'" onclick="modificaImagineRestaurantModal(this.id)"> Modifică </button>
                                <button type="button" class="btn btn-customize" name="stergeImagine" id="stergeImagine-'.$arrayImagini[$i]["id"].'" onclick="stergeImagineModal(this.id)"> Elimină </button>
                              </div>
                          </div>
                        </div>

                        <div class="modal fade" id="modificaImagineRestaurant'.$i.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content modalAdmin">
                              <div class="modal-header">
                                <h5 class="modal-title titluAdmin">'.$arrayImagini[$i]["titlu"].'</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <i class="fas fa-times" style="color: black!important; opacity: 1!important;"></i>
                                </button>
                              <div class="modal-body" >
                                <form class="col-md-8 col-md-offset-2 upload" action="includeri-php/modificareImagine.php" method="post" enctype="multipart/form-data">
                                  <input type="text" style="visibility: hidden; height: 0; width: 0" name="modificaIdFisier" value="'.$arrayImagini[$i]["id"].'">
                                  <input type="text" style="visibility: hidden; height: 0; width: 0" name="caleImagineAnterioara" value="'.$arrayImagini[$i]["numeImagine"].'">
                                  <div class="modifica-form">
                                    <label>Nume:</label>
                                    <input class="modifica-input" type="text" name="modificaNumeFisier" value="'.$numeImagine[0].'">
                                  </div>
                                  <div class="modifica-form">
                                    <label>Titlu:</label>
                                    <input class="modifica-input" type="text" name="modificaTitluFisier" value="'.$arrayImagini[$i]["titlu"].'">
                                  </div>
                                  <div class="modifica-form">
                                    <label>Descriere:</label>
                                    <input class="modifica-input" type="text" name="modificaDescriereFisier" value="'.$arrayImagini[$i]["descriere"].'">
                                  </div>
                                  <div class="modifica-form">
                                    <label>Categorie:</label>
                                    <select class="modifica-input" name="modificaCategorieFisier">
                                      <option value="'.$arrayImagini[$i]["categorieImagine"].'" disabled selected></option>
                                      <option value="preparate">Preparate</option>
                                      <option value="restaurant">Restaurant</option>
                                    </select>
                                  </div>
                                  <input class="modifica-input" id="modificaFile" type="file" name="modificaFile">
                                  <br><br>
                                  <button id="modifica-button" type="submit" name="buton-modifica">Modifică</button>
                                </form>
                              </div>
                            </div>
                            </div>
                          </div>
                        </div>

                        <!-- Fereastra modal -->
                        <div class="modal fade modal-box" id="stergeImaginePreparat'.$arrayImagini[$i]["id"].'" role="dialog">
                          <div class="modal-dialog modal-dialog-centered" role="document" style=" width: 650px!important;">
                            <div class="modal-content fereastra-modal">
                              <div class="modal-header">
                                 <h5 class="modal-title" style="color: #313E53; font-weight: bold;">'.$arrayImagini[$i]["titlu"].'</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                   <span aria-hidden="true">&times;</span>
                                 </button>
                              </div>
                              <div class="modal-body"  style="  height: 100px!important;">
                                 <p>&nbsp;&nbsp;&nbsp;Sunteți sigur(ă) că vreți să eliminați imaginea:&nbsp;&nbsp; <span style="font-weight: bold;  font-style: italic;">'.$arrayImagini[$i]["titlu"].'</span> ?</p>
                              </div>
                              <div class="modal-footer">
                                 <button type="button" class="btn btn-customize" data-dismiss="modal">Nu</button>
                                 <form class="form-inline form-eliminare" action="includeri-php/eliminareImagine.php" method="post">
                                   <button class="btn btn-customize" type="submit" name="butonEliminaImagine">Elimină</button>
                                   <input type="text" name="stergeIdImagine" id="stergeIdImagine" style="visibility: hidden; height: 0; width: 0;" value="'.$arrayImagini[$i]["id"].'"/>
                                   <input type="text" name="stergeCaleImagine" id="stergeCaleImagine" style="visibility: hidden; height: 0; width: 0;" value="'.$arrayImagini[$i]["numeImagine"].'"/>
                                 </form>
                              </div>
                           </div>
                         </div>
                       </div>';
                      }
                      else
                      {
                        echo '<div class="col-md-4">
                                <div class="polaroid" id="polaroid-'.$i.'" onclick="afiseazaModalRestaurant(this.id)">
                                    <div class="image-div" style="background-image: url(imagini/galerie/'.$arrayImagini[$i]["numeImagine"].');"></div>
                                    <h3>'.$arrayImagini[$i]["titlu"].'</h3>
                                    <p>'.$arrayImagini[$i]["descriere"].'</p>
                                </div>
                              </div>

                              <div class="modal fade" id="modalRestaurant'.$i.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title">'.$arrayImagini[$i]["titlu"].'</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i class="fas fa-times"></i>
                                      </button>
                                    <div class="modal-body" >
                                      <i class="fas fa-angle-left inapoi" id="inapoi-'.$i.'" onclick="afiseazaAnterior(this.id)"></i>
                                      <div class="imgPrep" style="background-image: url(imagini/galerie/'.$arrayImagini[$i]["numeImagine"].');">
                                      </div>
                                      <i class="fas fa-angle-right inainte" id="inainte-'.$i.'" onclick="afiseazaUrmator(this.id)"></i>
                                    </div>
                                          </div>
                                  </div>
                                </div>
                              </div>';
                      }

              }

              echo '</div>';
              }
          ?>
        </div>

        <?php

          if(isset($_SESSION['idAdmin']))
          {
            echo '<div class="col-md-6 col-md-offset-3 gallery-upload">
                    <h2>Încărcați o imagine</h2>
                    <form class="upload" action="includeri-php/gallery-upload.php" method="post" enctype="multipart/form-data">
                      <input class="upload-form" type="text" name="numeFisier" placeholder="Nume fisier...">
                      <br>
                      <input class="upload-form" type="text" name="titluFisier" placeholder="Titlu imagine...">
                      <br>
                      <input class="upload-form" type="text" name="descriereFisier" placeholder="Descriere...">
                      <br>
                      <span id="span-dropdown">Alegeți o categorie:<select id="upload-form-dropdown" name="categorieFisier">
                        <option value="" disabled selected></option>
                        <option value="preparate">Preparate</option>
                        <option value="restaurant">Restaurant</option>
                      </select></span>
                      <br>
                      <input class="upload-form" type="file" name="file">
                      <br><br>
                      <button id="upload-button" type="submit" name="submit">Încarcă</button>
                    </form>
                  </div>';
          }
        ?>
      </div>

    </div>


  <?php
    include_once 'includeri-php/footer.php';
  ?>

  <script type="text/javascript" src="javascript/galerie-modal.js"></script>
  <script type="text/javascript" src="javascript/popover-autentificare.js"></script>
  <script type="text/javascript" src="javascript/burger-menu.js"></script>

</body>
</html>
