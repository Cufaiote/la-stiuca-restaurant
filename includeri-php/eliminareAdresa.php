<?php

  session_start();

  require 'dbconnection.php';

  $sql = "SELECT COUNT(idAdresa) AS adrese FROM adrese_clienti WHERE idClient = '".$_SESSION["idClient"]."';";
  $rezultat = mysqli_query($conn, $sql);

  $nrAdrese = mysqli_fetch_assoc($rezultat);

  for($i = 1; $i <= $nrAdrese["adrese"]; $i++)
  {
    if(isset($_POST["stergereAdresa".$i]))
    {
      $idAdresa = $_POST["idAdresa".$i];

      $sql = "DELETE FROM adrese_clienti WHERE idClient = '".$_SESSION["idClient"]."' AND idAdresa = '$idAdresa';";

      if(!mysqli_query($conn, $sql))
      {
        echo "Eroare!  " .$sql;
        echo "<br>" . mysqli_error($conn);
        exit();
      }
      else
      {
        $sql = "SELECT * FROM adrese_clienti WHERE idAdresa = '$idAdresa';";
        $rezultat = mysqli_query($conn, $sql);

        if (mysqli_num_rows($rezultat) > 0)
        {
          header("Location: ../contulmeu.php?eliminareAdresa=succes");
          exit();
        }
        else
        {

          $sql = "DELETE FROM adrese WHERE idAdresa = '$idAdresa';";

          if(!mysqli_query($conn, $sql))
          {
            echo "Eroare!  " .$sql;
            echo "<br>" . mysqli_error($conn);
            exit();
          }
          else
          {
            header("Location: ../contulmeu.php?eliminareAdresa=succes");
            exit();
          }
        }
      }
    }
  }

  header("Location: ../contulmeu.php");
  exit();
