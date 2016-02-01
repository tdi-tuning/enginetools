<?php

namespace TdiDean\EngineTools\Dyno;

use TdiDean\EngineTools\Engine;
use TdiDean\EngineTools\Dyno\Calculate\EngineRevIntervals;
use TdiDean\EngineTools\Dyno\Output\EngineDynoFigures;
use TdiDean\EngineTools\Dyno\Output\EngineDynoGoogleGraph;

class EngineDyno
{

  protected $_engineDynoFigures;

  public function __construct($stockPs = false, $stockNm = false, $tunedPs = false, $tunedNm = false, $powerIntervals = [], $torqueIntervals = [])
  {
      $this->_engineDynoFigures = new EngineDynoFigures(new EngineRevIntervals($powerIntervals, $torqueIntervals), new Engine($stockPs, false, false, false, $stockNm, 'stock'));

      if(($tunedPs) || ($tunedNm))
      {
        $this->_engineDynoFigures->addEngine(new Engine($tunedPs, false, false, false, $tunedNm, 'tuned'));
      }
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
