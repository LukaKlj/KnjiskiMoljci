<?php namespace App\Controllers;

class Admin extends Korisnik{
    protected function getController() {
        return "Admin";
    }

    protected function getStatus() {
        return "Administrator";
    }
}