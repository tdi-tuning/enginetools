<?php

namespace TdiDean\EngineTools\Dyno\Calculate;

class EngineShiftPoints
{
  protected $_powerIntervals = [];
  protected $_torqueIntervals = [];

    /**
     * Set power intervals and torque intervals.
     */
    public function __construct($powerIntervals = false, $torqueIntervals = false)
    {
        $this->_powerIntervals = $powerIntervals ?: [];
        $this->_torqueIntervals = $torqueIntervals ?: [];
    }

    /**
    * Calculate the shift points to plot dyno graph.
    */
    public function generate($engineValue, $type = 'power')
    {
      if($engineValue)
      {
        $intervals = ($type == 'power') ? $this->_powerIntervals : $this->_torqueIntervals;
        if($intervals)
        {
          $shiftPoints = [];
          foreach($intervals as $revInterval => $figure)
          {
            $shiftPoints[$revInterval] = $this->_figurePercent($engineValue, $figure);
          }
          return $shiftPoints;
        }
      }
      return false;
    }

    public function returnRevIntervals(){
      return array_unique(array_merge(array_keys($this->_powerIntervals ?: []), array_keys($this->_torqueIntervals ?: [])));
    }

    /**
     * Calculates value of figure based on pergecentage given
     *
     * @param int $quantity
     * @param int $percent
     * @return int
     */
    private function _figurePercent($value, $percent) {
        return round($value * $percent / 100, 2);
    }




 }
