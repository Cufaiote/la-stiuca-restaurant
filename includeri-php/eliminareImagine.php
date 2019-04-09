<?php

  session_start();

  if(isset($_POST["butonEliminaImagine"]))
  {
    $idImagine   = $_POST["stergeIdImagine"];
    $caleImagine = $_POST["stergeCaleImagine"];

    include 'dbconnection.php';

    $sql = "DELETE FROM galerie WHERE id = '$idImagine';";

    if (!mysqli_query($conn, $sql))
    {
      echo "Eroare: ".$sql;
      echo "<br>". mysqli_error($conn);
      exit();
    }
    else
    {
      unlink("../imagini/galerie/".$caleImagine);

      header("Location: ../gallery.php?eliminareImagine=succes");
      exit();
    }
  }
  else
  {
    header("Location: ../gallery.php");
    exit();
  }
