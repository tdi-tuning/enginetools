<?php

namespace TdiDean\EngineTools;

class Engine
{

  public $ps;
  public $bhp;
  public $kw;
  public $lbFt;
  public $nm;

  public function __construct($ps, $bhp, $kw, $lbFt, $nm)
  {
    $this->ps = $ps;
    $this->bhp = $bhp;
    $this->kw = $kw;
    $this->lbFt = $lbFt;
    $this->nm = $nm;
  }

}
