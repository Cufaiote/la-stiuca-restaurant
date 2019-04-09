<?php

  session_start();

  include 'dbconnection.php';

  $sql = "SELECT COUNT(idComanda) AS nrComenzi FROM comenzi WHERE statusComanda = '2';";

  if(!mysqli_query($conn, $sql))
  {
    echo 'Eroare: ' . $sql;
    echo '<br>Descriere:' . mysqli_error($conn);
    exit();
  }
  else
  {
    $rezultat  = mysqli_query($conn, $sql);
    $nrComenzi = mysqli_fetch_assoc($rezultat);

    for($i = 1; $i <= $nrComenzi; $i++)
    {
      if(isset($_POST["finalizareComanda".$i]))
      {
        $idComanda = $_POST["nrBon"];

        $sql = "UPDATE comenzi SET statusComanda = '3' WHERE idComanda = '$idComanda';";

        if(!mysqli_query($conn, $sql))
        {
          echo 'Eroare: ' . $sql;
          echo '<br>' . mysqli_error($conn);
          exit();
        }
        else
        {
          header("Location: ../comenzi.php?comandaFinalizata");
          exit();
        }
      }
    }

    header("Location: ../comenzi.php");
    exit();
  }
