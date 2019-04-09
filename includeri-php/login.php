<?php
  session_start();

  if(isset($_POST['buton-autentificare']))
  {
    $email_tel = $_POST['email_tel'];
    $parola    = $_POST['parola'];
  }
  elseif(isset($_POST['autentificare']))
  {
    $email_tel = $_POST['email'];
    $parola    = $_POST['parola'];
  }
  else
  {
    header("Location: "  . $_SERVER['HTTP_REFERER']);
    exit();
  }

    require 'dbconnection.php';

    if(empty($email_tel) || empty($parola))
    {
      header("Location: " . $_SERVER['HTTP_REFERER'] . "?error=necompletat&email_tel=" . $email_tel);
      exit();
    }
    else
    {
      $sql  = "SELECT * FROM utilizatori WHERE emailUtilizator=? OR telefonUtilizator=?;";
      $stmt = mysqli_stmt_init($conn);

      if(!mysqli_stmt_prepare($stmt, $sql))
      {
        header("Location: " . $_SERVER['HTTP_REFERER'] . "?error=sqlerror");
        exit();
      }
      else
      {
        mysqli_stmt_bind_param($stmt, "ss", $email_tel, $email_tel);
        mysqli_stmt_execute($stmt);

        $rezultat = mysqli_stmt_get_result($stmt);

        if($row = mysqli_fetch_assoc($rezultat))
        {
          $verificareParola = password_verify($parola, $row['parolaUtilizator']);

          if($verificareParola == false)
          {
            header("Location: " . $_SERVER['HTTP_REFERER'] . "?error=parolagresita");
            exit();
          }
          elseif($verificareParola == true)
          {
            session_start();

            if($row['tipUtilizator'] == 1)
            {
              $_SESSION['idClient']      = $row['idUtilizator'];
              $_SESSION['numeClient']    = $row['numeUtilizator'];
              $_SESSION['prenumeClient'] = $row['prenumeUtilizator'];
              $_SESSION['telefonClient'] = $row['telefonUtilizator'];
              $_SESSION['emailClient']   = $row['emailUtilizator'];
              $_SESSION['tipClient']     = $row['tipUtilizator'];
              $_SESSION["comanda"]       = array();
            }
            elseif($row['tipUtilizator'] == 21 || $row['tipUtilizator'] == 22)
            {
              $_SESSION['idPersonal']      = $row['idUtilizator'];
              $_SESSION['numePersonal']    = $row['numeUtilizator'];
              $_SESSION['prenumePersonal'] = $row['prenumeUtilizator'];
              $_SESSION['telefonPersonal'] = $row['telefonUtilizator'];
              $_SESSION['emailPersonal']   = $row['emailUtilizator'];
              $_SESSION['tipPersonal']     = $row['tipUtilizator'];
            }
            elseif($row['tipUtilizator'] == 3)
            {
              $_SESSION['idAdmin']      = $row['idUtilizator'];
              $_SESSION['numeAdmin']    = $row['numeUtilizator'];
              $_SESSION['prenumeAdmin'] = $row['prenumeUtilizator'];
              $_SESSION['telefonAdmin'] = $row['telefonUtilizator'];
              $_SESSION['emailAdmin']   = $row['emailUtilizator'];
              $_SESSION['tipAdmin']     = $row['tipUtilizator'];
            }

            if($_SERVER['HTTP_REFERER'] == "http://localhost/laStiuca/autentificare.php")
            {
              header("Location: ../contulmeu.php?login=success");
              exit();
            }
            if($_SERVER['HTTP_REFERER'] == "http://localhost/laStiuca/inregistrare.php")
            {
              header("Location: ../contulmeu.php?login=success");
              exit();
            }
            else
            {
              header("Location: " . $_SERVER['HTTP_REFERER'] . "?login=success");
              exit();
            }
          }
          else
          {
            header("Location: " . $_SERVER['HTTP_REFERER'] . "?error=parolagresita2");
            exit();
          }
        }
        else
        {
          header("Location: " . $_SERVER['HTTP_REFERER'] . "?error=continexistent");
          exit();
        }
      }
    }
