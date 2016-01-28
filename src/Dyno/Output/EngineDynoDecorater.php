<?php

namespace TdiDean\EngineTools\Dyno\Output;

abstract class EngineDynoDecorater implements EngineDynoFormatInterface
{
  protected $_engineDynoFigures;

  public function __construct(EngineDynoFigures $engineDynoFigures){
    $this->_engineDynoFigures = $engineDynoFigures;
  }

  abstract public function returnFigures();

 }
