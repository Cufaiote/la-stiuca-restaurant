<?php

  if(isset($_POST['buton-iesire']))
  {
    session_start();
    session_unset();

    session_destroy();

    $paginaAnterioara = explode("?", $_SERVER['HTTP_REFERER']);

    if($paginaAnterioara[0] == "http://localhost/laStiuca/index.php")
    {
      header("Location: ../index.php");
      exit();
    }
    elseif($paginaAnterioara[0] == "http://localhost/laStiuca/about.php")
    {
      header("Location: ../about.php");
      exit();
    }
    elseif($paginaAnterioara[0] == "http://localhost/laStiuca/menu.php")
    {
      header("Location: ../menu.php");
      exit();
    }
    elseif($paginaAnterioara[0] == "http://localhost/laStiuca/gallery.php")
    {
      header("Location: ../gallery.php");
      exit();
    }
    elseif($paginaAnterioara[0] == "http://localhost/laStiuca/contact.php")
    {
      header("Location: ../contact.php");
      exit();
    }
    else
    {
      header("Location: ../index.php");
      exit();
    }
  }
