<?php namespace App\Controllers;

class Citalac extends Korisnik{
    protected function getController() {
        return "Citalac";
    }

    protected function getStatus() {
        return "Čitalac";
    }
}
