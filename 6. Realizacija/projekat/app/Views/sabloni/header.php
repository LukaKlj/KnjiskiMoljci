<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Library</title>
    <link rel="icon" href="<?php echo base_url(); ?>/assets/images/icon.jpg"/>  
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel='stylesheet' href='<?php echo base_url(); ?>/assets/css/style.css'>
</head>
<body class="texture">
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <!-- logo -->
        <a class="navbar-brand" href="<?php echo site_url($controller) ?>"><img src="<?php echo base_url(); ?>/assets/images/logo.jpg" alt="LOGO" class="img-fluid"></a>
        
        <!-- kada se smanji prozor da se pojavi collapse button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- linkovi -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item <?php if($akcija=="pocetna") echo 'active';?>">
                    <a class="nav-link" href="<?php echo site_url($controller) ?>">Pocetna strana</a>
                </li>
                <?php
                if($controller=="Admin")
                echo '<li class="nav-item">
                    <a class="nav-link" href="'.site_url($controller."/zahtevi").'">Zahtevi</a>
                </li>';
                ?>
                <?php
                if($controller=="Recenzent")
                echo '<li class="nav-item ';
                if($akcija=="recenziranje") echo 'active';
                echo '">
                    <a class="nav-link" href="'.site_url($controller."/recenziranje").'">Recenziraj</a>
                </li>';
                ?>
                <?php
                if($controller=="Pisac")
                echo '<li class="nav-item">
                    <a class="nav-link" href="'.site_url($controller."/slanjeZahteva").'">Postani recenzent</a>
                </li>';
                ?>
                <li class="nav-item <?php if($akcija=="objava") echo 'active';?>">
                    <a class="nav-link" href="<?php echo site_url($controller."/objavaTeksta")?>">Objavi tekst</a>
                </li> 
                <li class="nav-item <?php if($akcija=="podaci") echo 'active';?>">
                    <a class="nav-link" href="<?php echo site_url($controller."/promenaPodataka")?>">Promeni lične podatke</a>
                </li> 
                <li class="nav-item <?php if($akcija=="lozinka") echo 'active';?>">
                    <a class="nav-link" href="<?php echo site_url($controller."/promenaLozinke")?>">Promeni lozinku</a>
                </li> 
            </ul>
        </div> 
        <span class="navbar-text">
            <div>
                Korisnik:
                <a href="listaTekstova.html">korisnik1</a>
            </div>
            Status: <?php echo $status?>
        </span>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.html" id="logout">Odjava</a>
            </li>
        </ul>
    </nav>