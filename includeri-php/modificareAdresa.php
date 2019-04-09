<?php

  session_start();

  if(isset($_POST["trimiteModificari"]))
  {
    $idAdresa   = $_POST["modificareIdAdresa"];
    $localitate = $_POST["modificareLocalitate"];
    $strada     = $_POST["modificareStrada"];
    $numar      = $_POST["modificareNumar"];
    $bloc       = $_POST["modificareBloc"];
    $scara      = $_POST["modificareScara"];
    $etaj       = $_POST["modificareEtaj"];
    $apartament = $_POST["modificareApartament"];
    $interfon   = $_POST["modificareInterfon"];

    if(!preg_match("/^[a-zA-Z0-9\040]*$/", $localitate))
    {
      header("Location: ../contulmeu.php?error=localitateinvalida");
      exit();
    }
    elseif(!preg_match("/^[a-zA-Z0-9\040]*$/", $strada))
    {
      header("Location: ../contulmeu.php?error=stradainvalida");
      exit();
    }
    elseif(!preg_match("/^[a-zA-Z0-9\040]*$/", $numar))
    {
      header("Location: ../contulmeu.php?error=numarinvalid");
      exit();
    }
    else
    {
      require 'dbconnection.php';

      $sql  = "UPDATE adrese SET localitate = ?, strada = ?, numar = ?, bloc = ?, scara = ?, etaj = ?, apartament = ?, interfon = ? WHERE idAdresa = '$idAdresa';";
      $stmt = mysqli_stmt_init($conn);

      if(!mysqli_stmt_prepare($stmt, $sql))
      {
        header("Location: ../contulmeu.php?error=sqlerror");
        echo mysqli_stmt_error($stmt);
        exit();
      }
      else
      {
        mysqli_stmt_bind_param($stmt, "ssssssss", $localitate, $strada, $numar, $bloc, $scara, $etaj, $apartament, $interfon);
        mysqli_stmt_execute($stmt);


        header("Location: ../contulmeu.php?modificariAdresa=succes");
        exit();
      }
    }
  }
  else {
    header("Location: ../contulmeu.php");
    exit();
  }
