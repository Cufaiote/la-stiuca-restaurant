<?
  session_start();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>La Știuca</title>
  <link rel="stylesheet" href="css/header_style.css">
  <link rel="stylesheet" href="css/inregistrare_style.css">
  <link rel="stylesheet" href="css/footer_style.css">
  <link rel="shortcut icon" type="image/png" href="imagini/favicon-titlu.ico">
  <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:700" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Rouge+Script" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
  <?php
    include_once 'includeri-php/header.php';
  ?>
  <div class="container signup-form">
    <form class="col-md-offset-2 col-md-8" action="includeri-php/login.php" method="post">
      <h2>Autentificare</h2>
      <p>Completati formularul de mai jos pentru a putea intra in cont! </p>
      <hr>
      <div class="form-group">
        <div class="input-group">
          <span class="input-group-addon"><i class="fa fa-paper-plane"></i></span>
          <input type="email" class="form-control" name="email" placeholder="E-mail/Telefon..." required="required">
        </div>
      </div>
      <div class="form-group">
        <div class="input-group">
          <span class="input-group-addon"><i class="fa fa-lock"></i></span>
          <input type="password" class="form-control" name="parola" placeholder="Parola..." required="required">
        </div>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-lg center-block" name="autentificare">Trimite</button>
      </div>
    </form>
  </div>
  <?php
    include_once 'includeri-php/footer.php';
  ?>
  <script type="text/javascript" src="javascript/popover-autentificare.js"></script>
  <script type="text/javascript" src="javascript/burger-menu.js"></script>
</body>
</html>
