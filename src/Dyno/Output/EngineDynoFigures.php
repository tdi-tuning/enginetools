<?php

namespace TdiDean\EngineTools\Dyno\Output;

use TdiDean\EngineTools\Dyno\Calculate\EngineShiftPoints;

class EngineDynoFigures implements EngineDynoFormatInterface
{
  protected $_stockPs;
  protected $_stockNm;
  protected $_tunedPs;
  protected $_tunedNm;

  public function __construct(EngineShiftPoints $engineShiftPoints, $stockPs = 0, $stockNm = 0, $tunedPs = 0, $tunedNm = 0)
  {
    $this->_revIntervals = $engineShiftPoints->returnRevIntervals();
    $this->_stockPs = $engineShiftPoints->generate($stockPs);
    $this->_stockNm = $engineShiftPoints->generate($stockNm, 'torque');
    $this->_tunedPs = $engineShiftPoints->generate($tunedPs);
    $this->_tunedNm = $engineShiftPoints->generate($tunedNm, 'torque');
  }

  public function returnFigures(){

    $figures = [];

    if($this->_stockPs){
        $figures['stock']['power'] = $this->_stockPs;
    }

    if($this->_stockNm){
        $figures['stock']['torque'] = $this->_stockNm;
    }

    if($this->_tunedPs){
        $figures['tuned']['power'] = $this->_tunedPs;
    }

    if($this->_tunedNm){
        $figures['tuned']['torque'] = $this->_tunedNm;
    }

    return $figures ?: false;
  }

  public function returnRevIntervals(){
    return $this->_revIntervals;
  }

 }
