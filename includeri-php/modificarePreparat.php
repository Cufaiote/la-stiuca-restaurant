<?php

  session_start();

  if(isset($_POST["modifica"]))
  {
    include 'dbconnection.php';

    $idPreparat          = $_POST["modificaidPreparat"];
    $numePreparat        = $_POST["modificaNumePreparat"];
    $ingredientePreparat = str_replace(['.', ';', ':', '/', '\\', '|'], ',', $_POST["modificaIngredientePreparat"]);
    $timpDePreparare     = $_POST["modificaTimpDePreparare"];
    $categoriePreparat   = $_POST["modificaCategoriePreparat"];

    preg_match('/([0-9]+\.?[0-9].)/', $_POST['modificaPretPreparat'], $matches);
    $pretPreparat        = (float) $matches[1];

    $fisier              = $_FILES['modificaFile'];

    if($fisier["error"])
    {
      if(empty($numePreparat) || empty($pretPreparat))
      {
        header("Location: ../menu.php?upload=emptyfields&numePreparat=" . $numePreparat . "&pretPreparat=" . $pretPreparat . "&ingredientePreparat=" . $ingredientePreparat . "&timpDePreparare=" . $timpDePreparare);
        exit();
      }
      else
      {
        $sql  = "UPDATE preparate SET numePreparat = ?, pretPreparat = ?, ingredientePreparat = ?, categoriePreparat = ?, timpDePreparare = ? WHERE idPreparat='$idPreparat';";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql))
        {
          echo "Eroare - SQL Statement";
          exit();
        }
        else
        {
          mysqli_stmt_bind_param($stmt, "sssss", $numePreparat, $pretPreparat, $ingredientePreparat, $categoriePreparat, $timpDePreparare);
          mysqli_stmt_execute($stmt);

          header("Location: ../menu.php?modificarePreparat=succes");
          exit();
        }
      }
    }
    else
    {
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

          if(empty($numePreparat) || empty($pretPreparat) || empty($ingredientePreparat) || empty($timpDePreparare))
          {
            header("Location: ../menu.php?upload=emptyfields&numePreparat=" . $numePreparat . "&pretPreparat=" . $pretPreparat . "&ingredientePreparat=" . $ingredientePreparat . "&timpDePreparare=" . $timpDePreparare);
            exit();
          }
          else
          {
            $sql  = "UPDATE preparate SET numePreparat = ?, pretPreparat = ?, ingredientePreparat = ?, categoriePreparat = ?, caleImagine = ?, timpDePreparare =? WHERE idPreparat = '$idPreparat';";
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

              header("Location: ../menu.php?modificarePreparat=succes");
              exit();
            }
          }
        }
      }
    }
  }
  else
  {
    header("Location: menu.php");
    exit();
  }
