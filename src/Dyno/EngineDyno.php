<?php

namespace TdiDean\EngineTools\Dyno;

use TdiDean\EngineTools\Engine;
use TdiDean\EngineTools\Dyno\Calculate\EngineShiftPoints;
use TdiDean\EngineTools\Dyno\Output\EngineDynoFigures;
use TdiDean\EngineTools\Dyno\Output\EngineDynoGoogleGraph;

class EngineDyno
{

  protected $_engineDynoFigures;

  public function __construct($stockPs = false, $stockNm = false, $tunedPs = false, $tunedNm = false, $powerIntervals = [], $torqueIntervals = [])
  {
      $stockEngine = new Engine($stockPs, false, false, false, $stockNm);
      $tunedEngine = new Engine($tunedPs, false, false, false, $tunedNm);
      $this->_engineDynoFigures = new EngineDynoFigures(new EngineShiftPoints($powerIntervals, $torqueIntervals), $stockEngine, $tunedEngine);
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
