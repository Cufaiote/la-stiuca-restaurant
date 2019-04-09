<?php
  session_start();
?>

<header>
  <nav class="active navbar navbar-fixed-top"  id="container-meniu">
    <div class="toggle">
      <i class="fa fa-bars" id="afiseaza-meniu" aria-hidden="true" onclick="afiseazaMeniu()"></i>
      <i class="fa fa-bars" id="ascunde-meniu"  aria-hidden="true" onclick="ascundeMeniu()" style="display: none;"></i>
    </div>

    <div class="container-fluid">
      <div class="navbar-header">
        <a style="padding:0; margin:0;" class="navbar-left" href="index.php">
          <img style="padding:0; margin:0; margin-top: 5px; width: 80px; height: 50px;" src="imagini/logoHeader.png" alt="">
        </a>
      </div>
      <ul class="nav navbar-nav" id="meniu-standard">
        <li class="active"><a href="index.php">La Știuca</a></li>
        <li><a href="about.php">Despre noi</a></li>
        <li><a href="menu.php">Meniu</a></li>
        <li><a href="gallery.php">Galerie</a></li>
        <li><a href="contact.php">Contact</a></li>
      </ul>

      <div class="container-fluid sign-in">
        <ul class="user" id="meniu-utilizator">
          <?php

            if(isset($_SESSION['idClient']))
            {
              echo '<li>
                      <p id="label-nume">' . $_SESSION['numeClient'] . ' ' . $_SESSION['prenumeClient'] . '</p>
                    </li>
                    <li>
                      <a style="text-decoration: none;" href="contulmeu.php">Contul Meu</a>
                    </li>
                    <li>
                      <a style="text-decoration: none;" href="cosulmeu.php">Coșul Meu</a>
                    </li>
                    <li>
                      <form class="form-inline log-out" action="includeri-php/logout.php" method="post">
                        <button type="submit" name="buton-iesire" id="buton-iesire">Ieșire</button>
                      </form>
                    </li>';

            }
            elseif(isset($_SESSION['idPersonal']))
            {
              echo '<li>
                      <p id="label-nume">' . $_SESSION['numePersonal'] . ' ' . $_SESSION['prenumePersonal'] . '</p>
                    </li>
                    <li>
                      <a style="text-decoration: none;" href="contAngajat.php">Contul Meu</a>
                    </li>
                    <li>
                      <a style="text-decoration: none;" href="comenzi.php">Comenzi</a>
                    </li>
                    <li>
                      <form class="form-inline log-out" action="includeri-php/logout.php" method="post">
                        <button type="submit" name="buton-iesire" id="buton-iesire">Ieșire</button>
                      </form>
                    </li>';
            }
            elseif (isset($_SESSION['idAdmin']))
            {
              echo '<li>
                      <p id="label-nume">' . $_SESSION['numeAdmin'] . ' ' . $_SESSION['prenumeAdmin'] . '</p>
                    </li>
                    <li>
                      <a style="text-decoration: none;" href="contAngajat.php">Contul Meu</a>
                    </li>
                    <li>
                      <a style="text-decoration: none;" href="https://mail.google.com/mail/u/3/#inbox" target="_blank">Mesaje</a>
                    </li>
                    <li>
                      <a style="text-decoration: none;" href="gestionarePersonal.php">Gestionare Personal</a>
                    </li>
                    <li>
                      <form class="form-inline log-out" action="includeri-php/logout.php" method="post">
                        <button type="submit" name="buton-iesire" id="buton-iesire">Ieșire</button>
                      </form>
                    </li>';
            }
            else
            {
              echo '<li>
                      <button data-placement="bottom" data-toggle="popover" data-title="" data-container="body" type="button" data-html="true" href="#" id="login">Autentificare</button>
                      <div id="popover-content" class="hide">
                        <form class="form-inline log-in" role="form" action="includeri-php/login.php" method="post">
                          <div class="form-group">
                            <input type="text" class="form-control mb-2 mr-sm-2" id="email-header" name="email_tel" placeholder="E-mail/Telefon...">
                            <input type="password" class="form-control" id="password-header" name="parola" placeholder="Parola...">
                            <button type="submit" class="btn btn-info mb-2" name="buton-autentificare">Autentificare</button>
                          </div>
                        </form>
                      </div>
                    </li>
                    <li>
                      <a style="text-decoration: none; margin: 0px;" href="inregistrare.php">Înregistrare</a>
                    </li>';
            }

          ?>

        </ul>
      </div>

    </div>
  </nav>
</header>
