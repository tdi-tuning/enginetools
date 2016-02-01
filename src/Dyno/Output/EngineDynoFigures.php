<?php

namespace TdiDean\EngineTools\Dyno\Output;

use TdiDean\EngineTools\Dyno\Calculate\EngineShiftPoints;
use TdiDean\EngineTools\Engine;

class EngineDynoFigures implements EngineDynoFormatInterface
{
  protected $_engineShiftPoints;
  protected $_stockEngine;
  protected $_tunedEngine;

  //protected $_stockPs;
  //protected $_stockNm;
  //protected $_tunedPs;
  //protected $_tunedNm;

  public function __construct(EngineShiftPoints $engineShiftPoints, Engine $stockEngine, Engine $tunedEngine) //$stockPs = 0, $stockNm = 0, $tunedPs = 0, $tunedNm = 0)
  {
    //$this->_revIntervals = $engineShiftPoints->returnRevIntervals();
    $this->_engineShiftPoints = $engineShiftPoints;
    $this->_stockEngine = $stockEngine;
    $this->_tunedEngine = $tunedEngine;

    //$this->_stockPs = $engineShiftPoints->generate($stockPs);
    //$this->_stockNm = $engineShiftPoints->generate($stockNm, 'torque');
    //$this->_tunedPs = $engineShiftPoints->generate($tunedPs);
    //$this->_tunedNm = $engineShiftPoints->generate($tunedNm, 'torque');
  }

  public function returnFigures(){

    $figures = [];

    if(($this->_stockEngine->ps) && ($this->_engineShiftPoints->hasPowerIntervals())){
        $figures['stock']['power'] = $this->_engineShiftPoints->generate($this->_stockEngine->ps);
    }

    if(($this->_stockEngine->nm) && ($this->_engineShiftPoints->hasTorqueIntervals())){
        $figures['stock']['torque'] = $this->_engineShiftPoints->generate($this->_stockEngine->nm, 'torque');
    }

    if(($this->_tunedEngine->ps) && ($this->_engineShiftPoints->hasPowerIntervals())){
        $figures['tuned']['power'] = $this->_engineShiftPoints->generate($this->_tunedEngine->ps);
    }

    if(($this->_tunedEngine->nm) && ($this->_engineShiftPoints->hasTorqueIntervals())){
        $figures['tuned']['torque'] = $this->_engineShiftPoints->generate($this->_tunedEngine->nm, 'torque');
    }

    return $figures ?: false;
  }

  public function returnRevIntervals(){
    return $this->_engineShiftPoints->returnRevIntervals();
  }

 }
