<?
  session_start();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>La Știuca</title>
  <link rel="stylesheet" href="css/contact_style.css">
  <link rel="stylesheet" href="css/header_style.css">
  <link rel="stylesheet" href="css/footer_style.css">
  <link rel="shortcut icon" type="image/png" href="imagini/favicon-titlu.ico">
  <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:700" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBu-916DdpKAjTmJNIgngS6HL_kDIKU0aU&callback=myMap"></script>
  <script src="contact_script.js"></script>
</head>

<body>

  <?php
    include_once 'includeri-php/header.php';
  ?>

  <div class="container">
    <div class="row">
      <div class="col-xs-6 col-md-6">
        <div class="descriere">
          <p>
            &nbsp;&nbsp;&nbsp;&nbsp;Ne puteți găsi în Municipiul Brașov, bulevardul Iuliu Maniu, numărul 50.
            Zona este accesibilă din intersecția "Ceasul Rău" (Iuliu Maniu x 13 Decembrie).
          </p>
          <br>
          <p>
            &nbsp;&nbsp;&nbsp;&nbsp;Pentru rezervări, informații, sugestii sau reclamații ne puteți contacta la numărul:
            <ul class="nrtel">
              <li>  0368 333 333 </li>
            </ul>
          </p>
          <p>
            sau puteți completa formularul alăturat.
          </p>
          <br>
          <p>
            Pentru comenzi la domiciliu ne puteți contacta la numerele:
            <ul class="nrtel">
              <li> 0368 368 368 </li>
              <li> 0777 777 777 </li>
            </ul>
          </p>
        </div>
      </div>
      <div class="col-xs-6 col-md-6 ">
        <form class="contact-form" action="includeri-php/contactform.php" method="post">
          <div class="form-group">
            <label for="contactFormNume">Nume:</label>
            <input type="text" class="form-control" id="contactFormNume" name="nume" placeholder="Introduceți numele întreg">
          </div>
          <div class="form-group">
            <label for="contactFormEmail">E-mail:</label>
            <input type="email" class="form-control" id="contactFormEmail" name="email" placeholder="nume@exemplu.com">
          </div>
          <div class="form-group">
            <label for="contactFormSubiect">Subiect:</label>
            <input type="text" class="form-control" id="contactFormSubiect" name="subiect" placeholder="Ex: Rezervare; Sugestie; etc.">
          </div>
          <div class="form-group">
            <label for="contactFormMesaj" id="labelId">Mesaj:</label>
            <textarea class="form-control" id="contactFormMesaj" name="mesaj" rows="4" placeholder="Mesajul dvs. aici...."></textarea>
          </div>
          <button type="submit" name="contactform-submit" class="btn center-block" id="contact-submit">Trimite</button>
        </form>
      </div>
    </div>

    <h1> Locația noastră: </h1>
    <div style="padding-top: 10px; width: 100%"><iframe width="100%" height="600" src="https://maps.google.com/maps?width=100%&amp;height=600&amp;hl=en&amp;coord=45.64930213, 25.60150802&amp;q=Brasov%2CIuliu-Maniu%2C50+(Locatia%20noastra)&amp;ie=UTF8&amp;t=&amp;z=18&amp;iwloc=B&amp;output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"><a href="https://www.maps.ie/map-my-route/">
      Map a route</a></iframe></div><br />
  </div>


  <div class="space-div"></div>

<?php
  include_once 'includeri-php/footer.php';
?>

  <script type="text/javascript" src="javascript/popover-autentificare.js"></script>
  <script type="text/javascript" src="javascript/burger-menu.js"></script>

</body>
</html>
