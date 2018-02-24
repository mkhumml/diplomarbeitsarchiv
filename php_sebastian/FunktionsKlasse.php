<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FunktionsKlasse
 *
 * @author Sebastian Kielbasa
 */
class FunktionsKlasse
{


    public static function hashpw($passwort)
    { //Statische Funktion ( Kann auch ohne Objektinstanzierung aufgerufen werden)
        $pw = hash("sha512", $passwort);
        return $pw;
    }

    public static function logoutnow()
    {
        session_start();
        session_destroy();
        echo "Loggout erfolgreich";
    }

    public static function checkEmail($email)
    { //Prüft Email auf format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { //Filter_var prüft eingabe auf Format
            return false;
        } else {
            return true;
        }
    }

    public static function checkPasswordLength($password)
    { //Prüft ob Password Länge >=8
        if (strlen($password) < 8) {
            return false;
        } else {
            return true;
        }
    }

    public static function checkForeAndSurename($name)
    {
        if (preg_match("/^[a-zA-Z]*$/", $name) && !(empty($name))) { //Prüft ob Name(String) nur Buchstaben enthält und nicht leer ist
            return true;  //Falls gültig
        } else {
            return false;
        }
    }
}
