<?php

  session_start();
  ini_set('display_errors', 1);

  $id             = "";
  $nume           = "";
  $prenume        = "";
  $telefon        = "";
  $email          = "";
  $parola         = "";
  $repetareParola = "";

  if(isset($_POST['daSalvareModificari']))
  {
    $id             = $_SESSION['idClient'];
    $nume           = $_POST['hiddenFormNumeClient'];
    $prenume        = $_POST['hiddenFormPrenumeClient'];
    $telefon        = $_POST['hiddenFormTelefonClient'];
    $email          = $_POST['hiddenFormEmailClient'];
  }
  elseif(isset($_POST['daSalvareModificari2']))
  {
    $id             = $_SESSION['idClient'];
    $nume           = $_POST['hiddenFormNume'];
    $prenume        = $_POST['hiddenFormPrenume'];
    $telefon        = $_POST['hiddenFormTelefon'];
    $email          = $_POST['hiddenFormEmail'];
    $parola         = $_POST['hiddenFormParola'];
    $repetareParola = $_POST['hiddenFormRepetareParola'];
  }
  elseif(isset($_POST['trimiteModificariAngajat']))
  {
    $id             = $_POST['idAngajat'];
    $nume           = $_POST['numeAngajat'];
    $prenume        = $_POST['prenumeAngajat'];
    $telefon        = $_POST['telefonAngajat'];
    $email          = $_POST['emailAngajat'];
    $parola         = $_POST['parolaAngajat'];
    $repetareParola = $_POST['repetareParolaAngajat'];
  }
  else
  {
    header("Location ". $_SERVER['HTTP_REFERER']);
    exit();
  }

    if(!preg_match("/^[a-zA-Z0-9]*$/", $nume))
    {
      header("Location: ". $_SERVER['HTTP_REFERER'] ."?error=numeinvalid");
      exit();
    }
    elseif(!preg_match("/^[a-zA-Z0-9]*$/", $prenume))
    {
      header("Location: ". $_SERVER['HTTP_REFERER'] ."?error=prenumeinvalid");
      exit();
    }
    elseif(!preg_match("/^[0-9]*$/", $telefon) || strlen($telefon) < 10 || strlen($telefon) > 15)
    {
      header("Location: ". $_SERVER['HTTP_REFERER'] ."?error=telefoninvalid");
      exit();
    }
    elseif(strlen($parola)!= 0 && strlen($parola) < 6)
    {
      header("Location: ". $_SERVER['HTTP_REFERER'] ."?error=parolamin6caractere");
      exit();
    }
    elseif($parola != $repetareParola)
    {
      header("Location: ". $_SERVER['HTTP_REFERER'] ."?error=parolediferite");
      exit();
    }
    else
    {
      require 'dbconnection.php';

      if(strlen($parola) > 0)
      {
        $hashedpwd = password_hash($parola, PASSWORD_DEFAULT);

        $sql  = "UPDATE utilizatori SET numeUtilizator=?, prenumeUtilizator=?, telefonUtilizator=?, emailUtilizator=?, parolaUtilizator=? WHERE idUtilizator='$id';";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql))
        {
          header("Location: ". $_SERVER['HTTP_REFERER'] ."?error=sqlerror");
          exit();
        }
        else
        {
          mysqli_stmt_bind_param($stmt, "sssss", $nume, $prenume, $telefon, $email, $hashedpwd);
          mysqli_stmt_execute($stmt);
        }
      }
      else
      {
        $sql  = "UPDATE utilizatori SET numeUtilizator=?, prenumeUtilizator=?, telefonUtilizator=?, emailUtilizator=? WHERE idUtilizator='$id';";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql))
        {
          header("Location: ". $_SERVER['HTTP_REFERER'] ."?error=sqlerror");
          exit();
        }
        else
        {
          mysqli_stmt_bind_param($stmt, "ssss", $nume, $prenume, $telefon, $email);
          mysqli_stmt_execute($stmt);
        }
      }

      if(isset($_SESSION['idClient']))
      {
        $_SESSION['numeClient']    = $nume;
        $_SESSION['prenumeClient'] = $prenume;
        $_SESSION['telefonClient'] = $telefon;
        $_SESSION['emailClient']   = $email;
      }
      elseif(isset($_SESSION['idPersonal']))
      {
        $_SESSION['numePersonal']    = $nume;
        $_SESSION['prenumePersonal'] = $prenume;
        $_SESSION['telefonPersonal'] = $telefon;
        $_SESSION['emailPersonal']   = $email;
      }
      elseif(isset($_SESSION['idAdmin']))
      {
        $_SESSION['numeAdmin']    = $nume;
        $_SESSION['prenumeAdmin'] = $prenume;
        $_SESSION['telefonAdmin'] = $telefon;
        $_SESSION['emailAdmin']   = $email;
      }


        header("Location: ". $_SERVER['HTTP_REFERER'] ."?actualizariInformatii=succes");
        exit();
      }
