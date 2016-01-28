<?php

namespace TdiDean\EngineTools\Dyno\Output;

class EngineDynoGoogleGraph extends EngineDynoDecorater implements EngineDynoFormatInterface
{

  public function returnFigures(){

    $figures = $this->_engineDynoFigures->returnFigures();

    $google = [];
    foreach($this->_engineDynoFigures->returnRevIntervals() as $revInterval){
      array_push($google, [$revInterval, $figures['stock']['power'][$revInterval], $figures['tuned']['power'][$revInterval], false, $figures['stock']['torque'][$revInterval], $figures['tuned']['torque'][$revInterval], false]);
    }

    return json_encode($google);

  }



 }
