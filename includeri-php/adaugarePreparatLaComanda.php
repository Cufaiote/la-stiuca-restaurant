<?php

  session_start();

  if(isset($_POST['button-addToCart']))
  {
    $idPreparat = $_POST['idPrep'];
    $cantitate  = $_POST['cantitate'];

    require 'dbconnection.php';

    $sql  = "SELECT * FROM preparate WHERE idPreparat = '$idPreparat';";
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

      $row = mysqli_fetch_assoc($rezultat);

      $element = array("idPreparat" => $row["idPreparat"], "numePreparat" => $row["numePreparat"], "pretPreparat" => $row["pretPreparat"], "cantitate" => $cantitate, "caleImagine" => $row["caleImagine"], "timpDePreparare" => $row["timpDePreparare"]);

      $nrObiecte = count($_SESSION["comanda"]);
      $exista = false;

      for($i = 0; $i < $nrObiecte; $i++)
      {
        if($element["numePreparat"] == $_SESSION["comanda"][$i]["numePreparat"])
        {
          $_SESSION["comanda"][$i]["cantitate"] += $element["cantitate"];

          $exista = true;
        }
      }

      if($exista == false)
      {
        array_push($_SESSION["comanda"], $element);
      }

      header("Location: " . $_SERVER['HTTP_REFERER']);
      exit();
    }
  }
  else
  {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
  }
