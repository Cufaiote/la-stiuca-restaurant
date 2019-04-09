<?php

  if(isset($_POST['buton-inregistrare']))
  {
    $nume           = $_POST['nume'];
    $prenume        = $_POST['prenume'];
    $telefon        = $_POST['telefon'];
    $telefon        = str_replace("+", "00", $telefon);
    $email          = $_POST['email'];
    $parola         = $_POST['parola'];
    $repetareParola = $_POST['repetareParola'];
    $tipUtilizator  = 1;
  }
  elseif (isset($_POST['angajeaza']))
  {
    $nume           = $_POST['numeAngajat'];
    $prenume        = $_POST['prenumeAngajat'];
    $telefon        = $_POST['telefonAngajat'];
    $telefon        = str_replace("+", "00", $telefon);
    $email          = $_POST['emailAngajat'];
    $parola         = $_POST['parolaAngajat'];
    $repetareParola = $_POST['repetareParolaAngajat'];
    $tipUtilizator  = $_POST['functieAngajat'];
  }
  else
  {
    header("Location: ../inregistrare.php");
    exit();
  }

    require 'dbconnection.php';

    if(empty($nume) || empty($prenume) || empty($telefon) || empty($email) || empty($parola) || empty($repetareParola))
    {
      header("Location ../inregistrare.php?error=necompletat&nume=" . $nume . "&prenume=" . $prenume . "&telefon=" . $telefon . "&email=" . $email);
      exit();
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $nume) && !preg_match("/^[a-zA-Z0-9]*$/", $prenume) && !preg_match("/^[0-9]*$/", $telefon))
    {
      header("Location ../inregistrare.php?error=invalidnume,prenume,telefon,email");
      exit();
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
      header("Location ../inregistrare.php?error=emailinvalid&nume=" . $nume . "&prenume=" . $prenume . "&telefon=" . $telefon);
      exit();
    }
    elseif(!preg_match("/^[a-zA-Z0-9]*$/", $nume)  || strpos(strtolower($nume), 'admin') != false || strpos(strtolower($nume), 'personal') != false)
    {
      header("Location ../inregistrare.php?error=numeinvalid&prenume=" . $prenume . "&telefon=" . $telefon . "&email=" . $email);
      exit();
    }
    elseif(!preg_match("/^[a-zA-Z0-9]*$/", $prenume) || strpos(strtolower($prenume), 'admin') != false || strpos(strtolower($prenume), 'personal') != false)
    {
      header("Location ../inregistrare.php?error=prenumeinvalid&nume=" . $nume . "&telefon=" . $telefon . "&email=" . $email);
      exit();
    }
    elseif(!preg_match("/^[0-9]*$/", $telefon) || strlen($telefon) < 10 || strlen($telefon) > 15)
    {
      header("Location ../inregistrare.php?error=telefoninvalid&nume=" . $nume . "&prenume=" . $prenume . "&email=" . $email);
      exit();
    }
    elseif($parola != $repetareParola)
    {
      header("Location: ../inregistrare.php?error=parolediferite&nume=" . $nume . "&prenume=" . $prenume . "&telefon=" . $telefon . "&email=" . $email);
    }
    else
    {
      $sql  = "SELECT * FROM utilizatori WHERE emailUtilizator=?;";
      $stmt = mysqli_stmt_init($conn);

      if(!mysqli_stmt_prepare($stmt, $sql))
      {
        header("Location: ../inregistrare.php?error=sqlerror1");
        exit();
      }
      else
      {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        $rezultat = mysqli_stmt_num_rows($stmt);

        if($rezultat > 0)
        {
          header("Location ../inregistrare.php?error=emailfolosit&nume=" . $nume . "&prenume=" . $prenume . "&telefon=" . $telefon);
          exit();
        }
        else
        {
          $sql  = "SELECT * FROM utilizatori WHERE telefonUtilizator=?;";
          $stmt = mysqli_stmt_init($conn);

          if(!mysqli_stmt_prepare($stmt, $sql))
          {
            header("Location: ../inregistrare.php?error=sqlerror2");
            exit();
          }
          else
          {
            mysqli_stmt_bind_param($stmt, "s", $telefon);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            $rezultat = mysqli_stmt_num_rows($stmt);

            if($rezultat > 0)
            {
              header("Location ../inregistrare.php?error=telefonfolosit&nume=" . $nume . "&prenume=" . $prenume . "&email=" . $email);
              exit();
            }
            else
            {
              $sql  = "INSERT INTO utilizatori (numeUtilizator, prenumeUtilizator, telefonUtilizator, emailUtilizator, parolaUtilizator, tipUtilizator) VALUES (?, ?, ?, ?, ?, ?)";
              $stmt = mysqli_stmt_init($conn);

              if(!mysqli_stmt_prepare($stmt, $sql))
              {
                header("Location: ../inregistrare.php?error=sqlerror3");
                exit();
              }
              else
              {
                $hashedpwd = password_hash($parola, PASSWORD_DEFAULT);

                mysqli_stmt_bind_param($stmt, "ssssss", $nume, $prenume, $telefon, $email, $hashedpwd, $tipUtilizator);
                mysqli_stmt_execute($stmt);

                $sql  = "SELECT * FROM utilizatori WHERE emailUtilizator=? OR telefonUtilizator=?;";

                if(!mysqli_stmt_prepare($stmt, $sql))
                {
                  header("Location: " . $_SERVER['HTTP_REFERER'] . "?error=sqlerror");
                  exit();
                }
                else
                {
                  mysqli_stmt_bind_param($stmt, "ss", $email, $telefon);
                  mysqli_stmt_execute($stmt);

                  $rezultat = mysqli_stmt_get_result($stmt);

                  $row = mysqli_fetch_assoc($rezultat);

                  $verificareParola = password_verify($parola, $row['parolaUtilizator']);

                  if($verificareParola == false)
                  {
                    header("Location: " . $_SERVER['HTTP_REFERER'] . "?error=parolagresita");
                    exit();
                  }
                  elseif($verificareParola == true)
                  {
                    if(isset($_POST["angajeaza"]))
                    {
                      header("Location: ../gestionarePersonal.php?angajat=succes");
                      exit();
                    }
                    else
                    {
                      session_start();

                      $_SESSION['idClient']      = $row['idUtilizator'];
                      $_SESSION['numeClient']    = $row['numeUtilizator'];
                      $_SESSION['prenumeClient'] = $row['prenumeUtilizator'];
                      $_SESSION['telefonClient'] = $row['telefonUtilizator'];
                      $_SESSION['emailClient']   = $row['emailUtilizator'];
                      $_SESSION['tipClient']     = $row['tipUtilizator'];
                      $_SESSION["comanda"]       = array();

                      header("Location: ../contulmeu.php");
                      exit();
                    }
                  }
                }
              }
            }
          }
        }
      }
    }
