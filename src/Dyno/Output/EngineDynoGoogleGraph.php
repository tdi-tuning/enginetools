<?php

namespace TdiDean\EngineTools\Dyno\Output;

class EngineDynoGoogleGraph extends EngineDynoDecorater implements EngineDynoFormatInterface {

    public function returnFigures() {

        $figures = $this->_engineDynoFigures->returnFigures();

        $google = [];

        foreach ($this->_engineDynoFigures->returnRevIntervals() as $revInterval) {

            $stockPower = isset($figures['stock']['power']) ? $figures['stock']['power'][$revInterval] : null;
            $stockTorque = isset($figures['stock']['torque']) ? $figures['stock']['torque'][$revInterval] : null;
            $tunedPower = isset($figures['tuned']['power']) ? $figures['tuned']['power'][$revInterval] : null;
            $tunedTorque = isset($figures['tuned']['torque']) ? $figures['tuned']['torque'][$revInterval] : null;

            array_push($google, [$revInterval, $stockPower, $tunedPower, false, $stockTorque, $tunedTorque, false]);
        }

        return json_encode($google);
    }

}
