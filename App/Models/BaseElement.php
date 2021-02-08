<?php

namespace App\Models;

class BaseElement implements Printable{
  protected $title;
  public $descripcion;
  public $visible = true;
  public $months;

  public function __construct($title, $descripcion){
    $this->setTitle($title);
    $this->descripcion = $descripcion;
  }

  public function setTitle($title){
    if($title == ''){
      $this->title = 'N/A';
    }else{
      $this->title = $title;
    }
  }

  public function getTitle(){
    return $this->title;
  }

  function getDurationAsString(){
    $years = floor($this->months / 12);
    $extraMonths = $this->months % 12;
    return "{$years} años {$extraMonths} meses";
  }

  public function getDescription(){
    return $this->descripcion;
  }
}