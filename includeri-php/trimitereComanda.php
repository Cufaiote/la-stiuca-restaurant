<?php

  session_start();

  if(isset($_POST['buton-trimite-comanda']))
  {

    require 'dbconnection.php';

    $nume       = $_POST['numeClient'];
    $prenume    = $_POST['prenumeClient'];
    $telefon    = $_POST['telefonClient'];
    $email      = $_POST['emailClient'];
    $localitate = $_POST['localitate'];
    $strada     = $_POST['strada'];
    $numar      = $_POST['numar'];
    $bloc       = $_POST['bloc'];
    $scara      = $_POST['scara'];
    $etaj       = $_POST['etaj'];
    $apartament = $_POST['apartament'];
    $interfon   = $_POST['interfon'];

    if(!preg_match("/^[a-zA-Z0-9]*$/", $nume)  || strpos(strtolower($nume), 'admin') != false || strpos(strtolower($nume), 'personal') != false)
    {
      header("Location: ../cosulmeu.php?error=numeinvalid");
      exit();
    }
    elseif(!preg_match("/^[a-zA-Z0-9]*$/", $prenume) || strpos(strtolower($prenume), 'admin') != false || strpos(strtolower($prenume), 'personal') != false)
    {
      header("Location: ../cosulmeu.php?error=prenumeinvalid");
      exit();
    }
    elseif(!preg_match("/^[0-9]*$/", $telefon) || strlen($telefon) < 10 || strlen($telefon) > 15)
    {
      header("Location: ../cosulmeu.php?error=telefoninvalid");
      exit();
    }
    elseif(!preg_match("/^[a-zA-Z0-9]*$/", $localitate))
    {
      header("Location: ../cosulmeu.php?error=localitateinvalida");
      exit();
    }
    elseif(!preg_match('/^[a-z0-9 .\-]+$/i', $strada))
    {
      header("Location: ../cosulmeu.php?error=stradainvalida");
      exit();
    }
    elseif(!preg_match("/^[a-zA-Z0-9]*$/", $numar))
    {
      header("Location: ../cosulmeu.php?error=numarinvalid");
      exit();
    }
    else
    {
      $sql  = "SELECT idAdresa FROM adrese WHERE localitate = ? AND strada = ? AND numar = ? AND bloc = ? AND scara = ? AND etaj = ? AND apartament=? AND interfon = ?;";
      $stmt = mysqli_stmt_init($conn);

      if(!mysqli_stmt_prepare($stmt, $sql))
      {
        header("Location: ../cosulmeu.php?error=sqlerror1");
        exit();
      }
      else
      {
        mysqli_stmt_bind_param($stmt, "ssssssss", $localitate, $strada, $numar, $bloc, $scara, $etaj, $apartament, $interfon);
        mysqli_stmt_execute($stmt);

        $rezultat = mysqli_stmt_get_result($stmt);

        if($idAdresa = mysqli_fetch_assoc($rezultat))
        {
          $nrObiecte = count($_SESSION["comanda"]);
          $total     = 0;
          $idComanda = hexdec(substr(uniqid(), -10));
          $data      = getdate();
          $data      = date("Y-m-d H:i:s", $data["0"]);

          $timpDePreparare = 0;
          $contor = 0;

          for($i = 1; $i <= $nrObiecte; $i++)
          {
            $total += $_SESSION['comanda'][$i-1]['pretPreparat'] * $_SESSION['comanda'][$i-1]['cantitate'];
            $timp = explode(":", $_SESSION["comanda"][$i-1]["timpDePreparare"]);
            $timpDePreparare += 60 * $timp[0] + $timp[1] + $timp[2]/60;
            $contor ++;
          }

          $timpDePreparare /= ($contor - 1);
          $minut = $timpDePreparare % 60;
          $ora   = intval($timpDePreparare - $minut);

          $timpMediuDeAsteptare = $ora.":".$minut.":00";

          $sql = "INSERT INTO comenzi(idComanda, idClient, idAdresa, statusComanda, total, data) VALUES('$idComanda', '".$_SESSION["idClient"]."', '".$idAdresa["idAdresa"]."', '1', '$total', '$data');";

          if(!mysqli_query($conn, $sql))
          {
            echo "Eroare: " . $sql . "<br>" . mysqli_error($conn);
          }
          else
          {

            for($i = 0; $i < $nrObiecte; $i++)
            {
              $sql = "INSERT INTO comenzi_preparate(idComanda, idPreparat, cantitate) VALUES ('$idComanda', '".$_SESSION["comanda"][$i]["idPreparat"]."', '".$_SESSION["comanda"][$i]["cantitate"]."');";

              if(!mysqli_query($conn, $sql))
              {
                echo "Eroare: " . $sql . "<br>" . mysqli_error($conn);
              }
            }

            unset($_SESSION["comanda"]);
            $_SESSION["comanda"] = array();
            
            header("Location: ../cosulmeu.php?comandaacceptata");
            exit();

          }

        }
      }

    }
  }
  else {
    header("Location: ../cosulmeu.php");
    exit();
  }
