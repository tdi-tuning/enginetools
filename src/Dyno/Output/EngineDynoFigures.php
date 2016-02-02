<?php

namespace TdiDean\EngineTools\Dyno\Output;

use TdiDean\EngineTools\Dyno\Calculate\EngineRevIntervals;
use TdiDean\EngineTools\Engine;

class EngineDynoFigures implements EngineDynoFormatInterface
{
  protected $_engineRevIntervals;
  protected $_engines = [];

  public function __construct(EngineRevIntervals $engineRevIntervals, Engine $engine)
  {
    $this->_engineRevIntervals = $engineRevIntervals;
    $this->_engines[$engine->returnTag()] = $engine;
  }

  public function addEngine(Engine $engine){
    $this->_engines[$engine->returnTag()] = $engine;
  }

  public function returnFigures(){

    $figures = [];

    foreach($this->_engines as $tag => $engine){
      if(($engine->ps) && ($this->_engineRevIntervals->hasPowerIntervals())){
          $figures[$tag]['power'] = $this->_engineRevIntervals->generate($engine->ps);
      }
      if(($engine->nm) && ($this->_engineRevIntervals->hasTorqueIntervals())){
          $figures[$tag]['torque'] = $this->_engineRevIntervals->generate($engine->nm, 'torque');
      }
    }

    return $figures ?: false;
  }

  public function returnRevIntervals(){
    return $this->_engineRevIntervals->returnRevIntervals();
  }

 }
