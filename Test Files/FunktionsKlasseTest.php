<?php

/**
 * Generated by PHPUnit_SkeletonGenerator on 2018-02-08 at 13:52:38.
 */

require_once '../FunktionsKlasse.php';
class FunktionsKlasseTest extends PHPUnit_Framework_TestCase {

    /**
     * @var FunktionsKlasse
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new FunktionsKlasse;
       
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    public function testHashpw() {

         $this->assertEquals(128, strlen(FunktionsKlasse::hashpw("abcd")));  
    }   
    public function testCheckEmail(){ // Testes die Email-Format Testing Funktion
        $email ="boby@gmail.com"; //Richtiges Format, Formatfunktion checkEmail sollte true zurück liefern
        $email2 ="roä#55.ce"; // Falsches Format, Formationfunktion checkEmail sollte false zurück liefern
        $email3 ="<<><@<<>.da-ss.cdllf#"; // Falsches Format, Formationfunktion checkEmail sollte false zurück liefern
        $this->assertEquals(true,FunktionsKlasse::checkEmail($email)); 
         $this->assertEquals(false,FunktionsKlasse::checkEmail($email2));
         $this->assertEquals(false,FunktionsKlasse::checkEmail($email3));
    }     
    public function testCheckPasswordLength(){ //Prüft ob die Funktion checkPasswordLength prüft ob Passwort >= 8  Zeichen
        $password ="hey"; // Zu kurzes Passwort 
        $password2 ="12345678"; //Mögliches Passwort
        $password3 ="##quertybertyerty"; //Gutes Passwort
         $this->assertEquals(false,FunktionsKlasse::checkPasswordLength($password)); 
        $this->assertEquals(true,FunktionsKlasse::checkPasswordLength($password2)); 
        $this->assertEquals(true,FunktionsKlasse::checkPasswordLength($password3)); 
    }
    public function testCheckForeAndSurename(){
        
        $name4 = null;
         $name ="Sebastian"; //richtiges Format
         $name1 =""; //Leerer String
         $name2="Sebi 123"; // Keine Zahlen
         $name3="Gabriel Kielbasa"; //Abstand falsch
         $this->assertEquals(true,FunktionsKlasse::checkForeAndSurename($name)); 
         $this->assertEquals(false,FunktionsKlasse::checkForeAndSurename($name1)); 
        $this->assertEquals(false,FunktionsKlasse::checkForeAndSurename($name2)); 
        $this->assertEquals(false,FunktionsKlasse::checkForeAndSurename($name3)); 
         
        $this->assertEquals(false,FunktionsKlasse::checkForeAndSurename($name4)); 
    }
    
    
    

}