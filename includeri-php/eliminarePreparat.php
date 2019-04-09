<?php

  session_start();

  if(isset($_POST["butonEliminaPreparat"]))
  {
    $idPreparat  = $_POST["stergeIdPreparat"];
    $caleImagine = $_POST["stergeCaleImagine"];

    include 'dbconnection.php';

    $sql = "DELETE FROM preparate WHERE idPreparat = '$idPreparat';";

    if (!mysqli_query($conn, $sql))
    {
      echo "Eroare: ".$sql;
      echo "<br>". mysqli_error($conn);
      exit();
    }
    else
    {
      unlink("../imagini/meniu/".$caleImagine);

      header("Location: ../menu.php?eliminarePreparat=succes");
      exit();
    }
  }
  else
  {
    header("Location: ../menu.php");
    exit();
  }
