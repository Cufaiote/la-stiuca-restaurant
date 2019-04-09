<?php

  require 'dbconnection.php';
  
  $sql = "SELECT COUNT(idUtilizator) AS angajati FROM utilizatori WHERE tipUtilizator LIKE '2%';";
  $rezultat = mysqli_query($conn, $sql);

  $nrAngajati = mysqli_fetch_assoc($rezultat);

  for($i = 1; $i <= $nrAngajati["angajati"]; $i++)
  {
    if(isset($_POST["concediazaAngajat".$i]))
    {
      $idAngajat = $_POST["idAngajat".$i];

      $sql = "DELETE FROM utilizatori WHERE idUtilizator = '".$idAngajat."';";

      if(!mysqli_query($conn, $sql))
      {
        echo "Eroare!  " .$sql;
        echo "<br>" . mysqli_error($conn);
        exit();
      }
      else
      {
        header("Location: ../gestionarePersonal.php?angajatconcediat");
        exit();
      }
    }
  }
