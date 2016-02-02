<?php

namespace TdiDean\EngineTools\Dyno;

use TdiDean\EngineTools\Engine;
use TdiDean\EngineTools\Dyno\Calculate\EngineRevIntervals;
use TdiDean\EngineTools\Dyno\Output\EngineDynoFigures;
use TdiDean\EngineTools\Dyno\Output\EngineDynoGoogleGraph;

class EngineStockVsTunedDyno
{

  protected $_engineDynoFigures;

  public function __construct(Engine $stockEngine, Engine $tunedEngine, $powerIntervals = [], $torqueIntervals = [])
  {
      $this->_engineDynoFigures = new EngineDynoFigures(new EngineRevIntervals($powerIntervals, $torqueIntervals), $stockEngine);
      $this->_engineDynoFigures->addEngine($tunedEngine);
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
