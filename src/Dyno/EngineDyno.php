<?php

namespace TdiDean\EngineTools\Dyno;

use TdiDean\EngineTools\Dyno\Calculate\EngineShiftPoints;
use TdiDean\EngineTools\Dyno\Output\EngineDynoFigures;
use TdiDean\EngineTools\Dyno\Output\EngineDynoGoogleGraph;

class EngineDyno
{

  protected $_engineDynoFigures;

  public function __construct($stockPs = false, $stockNm = false, $tunedPs = false, $tunedNm = false, $powerIntervals = [], $torqueIntervals = [])
  {
      $this->_engineDynoFigures = new EngineDynoFigures(new EngineShiftPoints($powerIntervals, $torqueIntervals), $stockPs, $stockNm, $tunedPs, $tunedNm);
  }

  public function returnFigures($type = 'google')
  {
    switch($type)
    {
      case 'google': $dynoFigures = new EngineDynoGoogleGraph($this->_engineDynoFigures); break;
      default : $dynoFigures = $this->_engineDynoFigures;
    }

    return $dynoFigures->returnFigures();
  }


}
