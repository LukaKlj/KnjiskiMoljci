<?php namespace App\Controllers;

class Recenzent extends Korisnik{
    protected function getController() {
        return "Recenzent";
    }

    protected function getStatus() {
        return "Recenzent";
    }
}