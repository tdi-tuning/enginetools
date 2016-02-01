<?php

namespace TdiDean\EngineTools\Dyno\Output;

use TdiDean\EngineTools\Dyno\Calculate\EngineShiftPoints;
use TdiDean\EngineTools\Engine;

class EngineDynoFigures implements EngineDynoFormatInterface
{
  protected $_engineShiftPoints;
  protected $_engines = [];
  protected $_secondEngine = false;

  public function __construct(EngineShiftPoints $engineShiftPoints, Engine $engine)
  {
    $this->_engineShiftPoints = $engineShiftPoints;
    $this->_engines[$engine->returnTag()] = $engine;
  }

  public function addEngine(Engine $engine){
    $this->_engines[$engine->returnTag()] = $engine;
  }

  public function returnFigures(){

    $figures = [];

    foreach($this->_engines as $tag => $engine){
      if(($engine->ps) && ($this->_engineShiftPoints->hasPowerIntervals())){
          $figures[$tag]['power'] = $this->_engineShiftPoints->generate($engine->ps);
      }
      if(($engine->nm) && ($this->_engineShiftPoints->hasTorqueIntervals())){
          $figures[$tag]['torque'] = $this->_engineShiftPoints->generate($engine->nm, 'torque');
      }
    }

    return $figures ?: false;
  }

  public function returnRevIntervals(){
    return $this->_engineShiftPoints->returnRevIntervals();
  }

 }
