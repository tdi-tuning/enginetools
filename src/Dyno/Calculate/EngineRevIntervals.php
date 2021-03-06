<?php

namespace TdiDean\EngineTools\Dyno\Calculate;

class EngineRevIntervals
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
    * Return if power intervals are set. TEST
    */
    public function hasPowerIntervals(){
        return $this->_powerIntervals ? true : false;
    }

    /**
    * Return if torque intervals set. TEST
    */
    public function hasTorqueIntervals(){
        return $this->_torqueIntervals ? true : false;
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
          $revs = [];
          foreach($intervals as $revInterval => $figure)
          {
            $revs[$revInterval] = $this->_figurePercent($engineValue, $figure);
          }
          return $revs;
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
