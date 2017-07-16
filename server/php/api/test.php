<?php

class test{

  protected $r = false;

  public function __construct($r){
    $this->r = $r;
    $this->r->finish('Hello world :)');
  }

}

?>