<?php

  session_start();

  $nrObiecte = count($_SESSION["comanda"]);

  for($i = 1; $i <= $nrObiecte; $i++)
  {
    if(isset($_POST["eliminareElement".$i]))
    {
      unset($_SESSION["comanda"][$i-1]);
      $_SESSION["comanda"] = array_values($_SESSION["comanda"]);

      header("Location: ../cosulmeu.php");
      exit();
    }
  }

  header("Location: ../cosulmeu.php");
  exit();
