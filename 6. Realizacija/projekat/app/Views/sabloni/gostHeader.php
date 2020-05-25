<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Library</title>
    <link rel="icon" href="<?php echo base_url(); ?>/assets/images/icon.jpg"/>  
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel='stylesheet' href='<?php echo base_url(); ?>/assets/css/style.css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="<?php echo site_url("/assets/js/script.js"); ?>"></script>
</head>
<body class="texture">
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <!-- logo -->
        <a class="navbar-brand" href="<?php echo site_url($controller) ?>"><img src="<?php echo base_url(); ?>/assets/images/logo.jpg" alt="LOGO" class="img-fluid"></a>
        <ul class="nav navbar-nav ml-auto" name="gost">
            <?php
                if($akcija=="prijava") {
                echo '<li class="nav-item ';
                echo '">
                    <a class="nav-link" href="'.site_url($controller."/registrujSe").'">Registruj se</a>
                </li>';
                }
                if ($akcija=='registracija') {
                  echo '<li class="nav-item ';
                echo '">
                    <a class="nav-link" href="'.site_url($controller).'">Prijavi se</a>
                </li>';  
                }
              ?>
        </ul>
    </nav>