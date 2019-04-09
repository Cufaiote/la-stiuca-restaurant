<?php

  if(isset($_POST['contactform-submit']))
  {
    $nume = $_POST['nume'];
    $expeditor = $_POST['email'];
    $subiect = $_POST['subiect'];
    $mesaj = $_POST['mesaj'];

    $destinatar = "restaurantlastiuca@gmail.com";
    $header = "From: ".$expeditor;
    $text = "Ati primit un e-mail de la " .$nume. "! \n\n" .$mesaj;

    mail($destinatar, $subiect, $text, $header);
    header("Location: ../contact.php?mailsend=success");
  }
