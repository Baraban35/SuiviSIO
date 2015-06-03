<?php
class Crypte{

  private $melContact='';
  private $smtp=false;
  private $crypte=false;

  public function __construct(){
    include './dirrw/param/param.ini.php';
    $this->melContact = $melContact;
    $this->smtp = $smtp;
    $this->crypte = $crypte;
  }

  public function getCrypte() {
    return $this->crypte;
  }

  public function getSmtp() {
    return $this->smtp;
  }

  public function getMelContact(){
    return $this->melContact;
  }
}