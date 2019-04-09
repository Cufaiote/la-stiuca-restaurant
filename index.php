<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>La Știuca</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" href="css/header_style.css">
  <link rel="stylesheet" href="css/footer_style.css">
  <link rel="shortcut icon" type="image/png" href="imagini/favicon-titlu.ico">
  <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:700" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
</head>
<body>

  <?php
    include_once 'includeri-php/header.php';

  ?>

  <div class="header">
    <div class="logo" style="width:auto; text-align:center; margin-top:200px;">
         <img class="responsive" src="imagini/logoLaStiuca.png"  alt="">
       </div>
  </div>

  <!-- PARTEA DE INFORMATII -->
  <div class="infos">
    <div class="container">
      <center>
        <h1>Bine ați venit!</h1>
        <br>
        <p>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Restaurantul „La Știuca” vă invită să descoperiți cele mai rafinate si delicioase preparate
          din pește din oras. Produsele noastre sunt alese cu atenție si gătite cu măiestrie de către maieștrii nostri
          bucătari, iar spațiul de servire agreabil și amabilitatea personalului transformă o simplă masă într-o experientă
          culinară desavârșită.
        </p>
      </center>
    </div>
  </div>

  <div class="afisare-optiuni">
   <div class="container m">

     <div class="col-md-3 col-xs-12 coloana">
       <div class="info-pagina">
         <i class="fas fa-utensils"></i>
         <h3>Despre noi</h3>
         <p>&nbsp;&nbsp;&nbsp;Aflați mai multe detalii despre ce înseamnă restaurantul "La Știuca":
           povestea noastră, obiectivele noastre și multe alte informații.  </p>
         </div>
         <a href="about.php">Mai mult...</a>
       </div>

       <div class="col-md-3 col-xs-12 coloana">
         <div class="info-pagina">
           <i class="fas fa-book-open"></i>
           <h3>Meniu</h3>
           <p>
             &nbsp;&nbsp;&nbsp;Vă invităm să descoperiți cele mai bune preparate din pește.
             Vizitați pagina „Meniu”, de unde puteți comanda preparatele la domiciliu.
           </p>
         </div>
         <a href="menu.php">Mai mult...</a>
       </div>

       <div class="col-md-3 col-xs-12 coloana">
         <div class="info-pagina">
           <i class="fas fa-images"></i>
           <h3>Galerie</h3>
           <p>Se spune că o imagine face cât 1000 de cuvinte. Pentru mai multe imagini vă invităm să vizitați pagina „Galerie”.</p>
         </div>
         <a href="gallery.php">Mai mult...</a>
       </div>

       <div class="col-md-3 coloana">
         <div class="info-pagina">
           <i class="fas fa-users"></i>
           <h3>Inregistreaza-te</h3>
           <p>Aveți poftă de cele mai bune preparate de pește și doriți să comandați la domiciliu? Înregistrațiv-ă acum!</p>
         </div>
         <a href="inregistrare.php">Mai mult...</a>
       </div>

   </div>
  </div>

  <div class="galerie">


    <div id="carusel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#carusel" data-slide-to="0" class="active"></li>
        <li data-target="#carusel" data-slide-to="1"></li>
        <li data-target="#carusel" data-slide-to="2"></li>
      </ol>

      <!-- Wrapper for slides -->
      <div class="carousel-inner">

        <div class="item active">
          <img src="imagini/one.jpg" alt="La Știuca" style="width:100%;z-index:0;">
          <div class="carousel-caption">
            <h3>La Știuca</h3>
          </div>
        </div>

        <div class="item">
          <img src="imagini/two.jpg" alt="La Știuca" style="width:100%;">
          <div class="carousel-caption">
            <h3>La Știuca</h3>
          </div>
        </div>

        <div class="item">
          <img src="imagini/three.jpg" alt="La Știuca" style="width:100%;">
          <div class="carousel-caption">
            <h3>La Știuca</h3>
          </div>
        </div>
      </div>

      <!-- Left and right controls -->
      <a class="left carousel-control" href="#carusel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#carusel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </div>

  <?php
    include_once "includeri-php/footer.php";
  ?>

  <script type="text/javascript" src="javascript/popover-autentificare.js"></script>
  <script type="text/javascript" src="javascript/burger-menu.js"></script>

</body>
</html>
