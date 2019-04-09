<?php

  session_start();
  include 'dbconnection.php';

  if(isset($_POST["buton-modifica"]))
  {
    $idFisier   = $_POST['modificaIdFisier'];
    $numeFisier = $_POST['modificaNumeFisier'];

    if(!$_POST['modificaNumeFisier'])
    {
      $numeFisier = "Imagine";
    }
    else {
      $numeFisier = strtolower(str_replace(" ", "-", $numeFisier));
    }

    $titluFisier     = $_POST['modificaTitluFisier'];
    $descriereFisier = $_POST['modificaDescriereFisier'];
    $categorieFisier = $_POST['modificaCategorieFisier'];

    $fisier = $_FILES['modificaFile'];

    if($fisier["error"])
    {
      if(empty($titluFisier) || empty($descriereFisier))
      {
        header("Location: ../gallery.php?modificareimagine=campurinecompletate");
        exit();
      }
      else
      {
        $sql  = "UPDATE galerie SET titlu = ?, descriere = ?, categorieImagine = ? WHERE id = '$idFisier';";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt,$sql))
        {
          echo "Eroare - SQL Statement";
          exit();
        }
        else
        {
          mysqli_stmt_bind_param($stmt, "sss", $titluFisier, $descriereFisier, $categorieFisier);
          mysqli_stmt_execute($stmt);

          header("Location: ../gallery.php?modificareImagine=succes");
          exit();
        }
      }
    }
    else
    {
      $caleImagineAnterioara = $_POST["caleImagineAnterioara"];

      $numeActualFisier = $fisier['name'];
      $tipFisier        = $fisier['type'];
      $numeTempFisier   = $fisier['tmp_name'];
      $eroareFisier     = $fisier['error'];
      $marimeFisier     = $fisier['size'];

      $exstensieFisier       = explode(".", $numeActualFisier);
      $extensieActualaFisier = strtolower(end($exstensieFisier));

      $exstensiiPermise = array("jpg", "jpeg", "png");

      if(in_array($extensieActualaFisier, $exstensiiPermise))
      {
        if($eroareFisier !== 0)
        {
          echo "Eroare la selectarea fisierului!";
          exit();
        }
        else
        {
          if($marimeFisier > 2000000)
          {
            echo "Fisierului este prea mare!";
            exit();
          }
          else
          {
            unlink("../imagini/galerie/" . $caleImagineAnterioara);

            $numeFisier       = $numeFisier . "." . uniqid("", true) . "." . $extensieActualaFisier;
            $destinatieFisier = "../imagini/galerie/" . $numeFisier;

            if(empty($titluFisier) || empty($descriereFisier))
            {
              header("Location: ../gallery.php?upload=empty");
              exit();
            }
            else
            {
              $sql  = "UPDATE galerie SET titlu = ?, descriere = ?, numeImagine = ?, categorieImagine = ? WHERE id = '$idFisier';";
              $stmt = mysqli_stmt_init($conn);

              if(!mysqli_stmt_prepare($stmt, $sql))
              {
                echo "Eroare - SQL statement";
                exit();
              }
              else
              {
                mysqli_stmt_bind_param($stmt, "ssss", $titluFisier, $descriereFisier, $numeFisier, $categorieFisier);
                mysqli_stmt_execute($stmt);

                move_uploaded_file($numeTempFisier, $destinatieFisier);

                header("Location: ../gallery.php?modificareImagine=succes");
                exit();
              }
            }
          }
        }
      }
    }
  }
  else
  {
    header("Location: ../gallery.php");
    exit();
  }
