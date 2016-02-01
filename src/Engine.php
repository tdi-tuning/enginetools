<?php

namespace TdiDean\EngineTools;

class Engine
{
  protected $_tag;
  protected $_rev
  public $ps;
  public $bhp;
  public $kw;
  public $lbFt;
  public $nm;

  public function __construct($ps = false, $bhp = false, $kw = false, $lbFt = false, $nm = false, $tag = 'stock')
  {
    $this->_tag = $tag;
    $this->ps = $ps;
    $this->bhp = $bhp;
    $this->kw = $kw;
    $this->lbFt = $lbFt;
    $this->nm = $nm;
  }

  public function returnTag(){
    return $this->_tag;
  }

}
