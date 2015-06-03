<?php
class View {
  private $txtView='';
  
  public function __construct() { }
  
  public function init($file, $data = array()){
    ob_start();
    require('./vue/'.$file);
    $txt = ob_get_contents();
    ob_end_clean();
    $this->txtView .= $txt;
  }
  public function getPage(){
    return $this->txtView;
  }
}
?>
