<?php

  if(isset($_POST['submit']))
  {
    $numeFisier = $_POST['numeFisier'];

    if(!$_POST['numeFisier'])
    {
      $numeFisier = "Imagine";
    }
    else {
      $numeFisier = strtolower(str_replace(" ", "-", $numeFisier));
    }

    $titluFisier     = $_POST['titluFisier'];
    $descriereFisier = $_POST['descriereFisier'];
    $categorieFisier = $_POST['categorieFisier'];

    $fisier = $_FILES['file'];

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
          $numeFisier       = $numeFisier . "." . uniqid("", true) . "." . $extensieActualaFisier;
          $destinatieFisier = "../imagini/galerie/" . $numeFisier;

          include_once 'dbconnection.php';

          if(empty($titluFisier) || empty($descriereFisier))
          {
            header("Location: ../gallery.php?upload=empty");
            exit();
          }
          else
          {
            $sql  = "INSERT INTO galerie (titlu, descriere, numeImagine, categorieImagine) VALUES (?, ?, ?, ?);";
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

              header("Location: ../gallery.php?upload=success");
            }
          }
        }
      }
    }
    else {
      echo "Incarcati un fisier cu extensie adecvata!";
      exit();
    }
  }
