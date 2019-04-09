<?php

  session_start();

  ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

  if(isset($_POST['submit']))
  {
    $numePreparat        = $_POST['numePreparat'];

    preg_match('/([0-9]+\.?[0-9].)/', $_POST['pretPreparat'], $matches);
    $pretPreparat        = (float) $matches[1];

    $ingredientePreparat = str_replace(['.', ';', ':', '/', '\\', '|'], ',', $_POST['ingredientePreparat']);

    $categoriePreparat   = $_POST['categoriePreparat'];
    $timpDePreparare     = $_POST['timpDePreparare'];

    $fisier = $_FILES['file'];

    $numeActualImagine = $fisier['name'];
    $tipImagine        = $fisier['type'];
    $numeTempImagine   = $fisier['tmp_name'];
    $eroareImagine     = $fisier['error'];
    $marimeImagine     = $fisier['size'];

    $extensieImagine   = explode(".", $numeActualImagine);
    $extensieActualaImagine = strtolower(end($extensieImagine));

    $extensiiPermise   = array("jpg", "jpeg", "png", "ico");

    if(in_array($extensieActualaImagine, $extensiiPermise))
    {
      if($eroareImagine !== 0)
      {
        echo "Eroare la selectarea imaginii!";
        echo $eroareImagine;
        exit();
      }
      elseif($marimeImagine > 2000000)
      {
        echo "Imaginea este prea mare!";
        exit();
      }
      else
      {
        $numeImagine       = strtolower(str_replace(" ", "-", $numePreparat)) . "." . uniqid("", true) . "." . $extensieActualaImagine;
        $destinatieImagine = "../imagini/meniu/" . $numeImagine;

        include_once 'dbconnection.php';

        if(empty($numePreparat) || empty($pretPreparat))
        {
          header("Location: ../menu.php?upload=emptyfields&numePreparat=" . $numePreparat . "&pretPreparat=" . $pretPreparat . "&ingredientePreparat=" . $ingredientePreparat . "&timpDePreparare=" . $timpDePreparare);
          exit();
        }
        else
        {
          $sql  = "INSERT INTO preparate (numePreparat, pretPreparat, ingredientePreparat, categoriePreparat, caleImagine, timpDePreparare) VALUES (?, ?, ?, ?, ?, ?);";
          $stmt = mysqli_stmt_init($conn);

          if(!mysqli_stmt_prepare($stmt, $sql))
          {
            echo "Eroare - SQL Statement";
            exit();
          }
          else
          {
            mysqli_stmt_bind_param($stmt, "ssssss", $numePreparat, $pretPreparat, $ingredientePreparat, $categoriePreparat, $numeImagine, $timpDePreparare);
            mysqli_stmt_execute($stmt);

            move_uploaded_file($numeTempImagine, $destinatieImagine);

            header("Location: ../menu.php?upload=success");
            exit();
          }
        }
      }
    }
    else
    {
      echo "Incarcati un fisier cu extensie adecvata!";
      exit();
    }
  }
