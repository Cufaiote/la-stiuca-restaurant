<?php

  session_start();

  if(isset($_POST['trimiteAdresa']))
  {
    $localitate = $_POST['localitate'];
    $strada     = $_POST['strada'];
    $numar      = $_POST['numar'];
    $bloc       = $_POST['bloc'];
    $scara      = $_POST['scara'];
    $etaj       = $_POST['etaj'];
    $apartament = $_POST['apartament'];
    $interfon   = $_POST['interfon'];
  }
  elseif(isset($_POST['daSalvareAdresa']))
  {
    $localitate = $_POST['hiddenFormLocalitate'];
    $strada     = $_POST['hiddenFormStrada'];
    $numar      = $_POST['hiddenFormNumar'];
    $bloc       = $_POST['hiddenFormBloc'];
    $scara      = $_POST['hiddenFormScara'];
    $etaj       = $_POST['hiddenFormEtaj'];
    $apartament = $_POST['hiddenFormApartament'];
    $interfon   = $_POST['hiddenFormInterfon'];
  }
  else
  {
    header("Location: ". $_SERVER['HTTP_REFERER']);
    exit();
  }


    if(!preg_match("/^[a-zA-Z0-9\040]*$/", $localitate))
    {
      header("Location ". $_SERVER['HTTP_REFERER']. "?error=localitateinvalida");
      exit();
    }
    elseif(!preg_match("/^[a-zA-Z0-9\040]*$/", $strada))
    {
      header("Location: ". $_SERVER['HTTP_REFERER']. "?error=stradainvalida");
      exit();
    }
    elseif(!preg_match("/^[a-zA-Z0-9]*$/", $numar))
    {
      header("Location: ". $_SERVER['HTTP_REFERER']. "?error=numarinvalid");
      exit();
    }
    elseif(!preg_match("/^[a-zA-Z0-9.\040]*$/", $bloc))
    {
      header("Location: ". $_SERVER['HTTP_REFERER']. "?error=blocinvalid");
      exit();
    }
    elseif(!preg_match("/^[a-zA-Z0-9]*$/", $scara))
    {
      header("Location: ". $_SERVER['HTTP_REFERER']. "?error=scarainvalida");
      exit();
    }
    elseif(!preg_match("/^[a-zA-Z0-9]*$/", $etaj))
    {
      header("Location: ". $_SERVER['HTTP_REFERER']. "?error=etajinvalid");
      exit();
    }
    elseif(!preg_match("/^[a-zA-Z0-9]*$/", $apartament))
    {
      header("Location: ". $_SERVER['HTTP_REFERER']. "?error=apartamentinvalid");
      exit();
    }
    elseif(!preg_match("/^[a-zA-Z0-9]*$/", $interfon))
    {
      header("Location: ". $_SERVER['HTTP_REFERER']. "?error=interfoninvalid");
      exit();
    }
    elseif($localitate == null || $strada == null || $numar == null)
    {
      header("Location: ". $_SERVER['HTTP_REFERER']. "?error=adresaincompleta");
      exit();
    }
    else
    {
      require 'dbconnection.php';

      $sql  = "SELECT * FROM adrese WHERE localitate = ? AND strada = ? AND numar = ? AND bloc = ? AND scara = ? AND etaj = ? AND apartament=? AND interfon = ?;";
      $stmt = mysqli_stmt_init($conn);

      if(!mysqli_stmt_prepare($stmt, $sql))
      {
        header("Location: ". $_SERVER['HTTP_REFERER'] ."?error=sqlerror");
        exit();
      }
      else
      {
        mysqli_stmt_bind_param($stmt, "ssssssss", $localitate, $strada, $numar, $bloc, $scara, $etaj, $apartament, $interfon);
        mysqli_stmt_execute($stmt);

        $rezultat = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($rezultat) > 0)
        {
          $row = mysqli_fetch_assoc($rezultat);

          $sql = "INSERT INTO adrese_clienti(idClient, idAdresa) VALUES('".$_SESSION["idClient"]."', '".$row["idAdresa"]."');";

          if(!mysqli_query($conn, $sql))
          {
            header("Location: ". $_SERVER['HTTP_REFERER'] ."?error=sqlerror2");
            exit();
          }
          else
          {
            header("Location: ". $_SERVER['HTTP_REFERER'] ."?adaugareAdresa=succes");
            exit();
          }
        }
        else
        {
          $sql = "INSERT INTO adrese(localitate,strada, numar, bloc, scara, etaj, apartament, interfon) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";

          if(!mysqli_stmt_prepare($stmt, $sql))
          {
            header("Location: ../cosulmeu.php?error=sqlerror1");
            exit();
          }
          else
          {
            mysqli_stmt_bind_param($stmt, "ssssssss", $localitate, $strada, $numar, $bloc, $scara, $etaj, $apartament, $interfon);
            mysqli_stmt_execute($stmt);

            $sql = "SELECT idAdresa FROM adrese WHERE localitate = ? AND strada = ? AND numar = ? AND bloc = ? AND scara = ? AND etaj = ? AND apartament=? AND interfon = ?;";

            if(!mysqli_stmt_prepare($stmt, $sql))
            {
              header("Location: ". $_SERVER['HTTP_REFERER'] ."?error=sqlerror2");
              exit();
            }
            else
            {
              mysqli_stmt_bind_param($stmt, "ssssssss", $localitate, $strada, $numar, $bloc, $scara, $etaj, $apartament, $interfon);
              mysqli_stmt_execute($stmt);

              $rezultat = mysqli_stmt_get_result($stmt);
              $row      = mysqli_fetch_assoc($rezultat);

              $sql = "INSERT INTO adrese_clienti(idClient, idAdresa) VALUES('".$_SESSION["idClient"]."', '".$row["idAdresa"]."');";

              if(!mysqli_query($conn, $sql))
              {
                header("Location: ". $_SERVER['HTTP_REFERER'] ."?error=sqlerror3");
                exit();
              }
              else
              {
                header("Location: ". $_SERVER['HTTP_REFERER'] ."?adaugareAdresa=succes");
                exit();
              }
            }
          }

        }
      }
    }
