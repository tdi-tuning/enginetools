<?php

namespace TdiDean\EngineTools\Test;

use TdiDean\EngineTools\Dyno\Calculate\EngineShiftPoints;
use TdiDean\EngineTools\Dyno\Output\EngineDynoFigures;

class EngineDynoFiguresTest extends \PHPUnit_Framework_TestCase
{

  protected $_completeEngineShiftPoints;
  protected $_powerEngineShiftPoints;
  protected $_torqueEngineShiftPoints;

  public function setUp(){
    $powerIntervals = [1000 => 15.4, 1500 => 25.7, 2000 => 48.8, 2500 => 60.4, 3000 => 68, 3500 => 76, 4000 => 82, 4500 => 87, 5000 => 93, 5500 => 97, 6000 => 100];
    $torqueIntervals = [1000 => 31.06, 1500 => 56.27, 2000 => 86.27, 2500 => 94.83, 3000 => 96.10, 3500 => 100, 4000 => 98.64, 4500 => 95.96, 5000 => 93.97, 5500 => 89.41, 6000 => 80.64];

    $this->_completeEngineShiftPoints = new EngineShiftPoints($powerIntervals, $torqueIntervals);
    $this->_powerEngineShiftPoints = new EngineShiftPoints($powerIntervals);
    $this->_torqueEngineShiftPoints = new EngineShiftPoints(false, $torqueIntervals);
  }

    /**
    * Pass over stock and tuned power / torque figures with rev intervals to return dyno points as an array.
    */
    public function testReturnFigures(){
          $engineDynoFigures = new EngineDynoFigures($this->_completeEngineShiftPoints, 115, 275, 127, 303);
          $results = $engineDynoFigures->returnFigures();
          $this->assertArraySubset([
                'stock' => [
                  'power' => [1000 => 17.71, 1500 => 29.56, 2000 => 56.12, 2500 => 69.46, 3000 => 78.2, 3500 => 87.4, 4000 => 94.3, 4500 => 100.05, 5000 => 106.95, 5500 => 111.55, 6000 => 115],
                  'torque' => [1000 => 85.42, 1500 => 154.74, 2000 => 237.24, 2500 => 260.78, 3000 => 264.28, 3500 => 275, 4000 => 271.26, 4500 => 263.89, 5000 => 258.42, 5500 => 245.88, 6000 => 221.76]
                ],
                'tuned' =>[
                  'power' => [1000 => 19.56, 1500 => 32.64, 2000 => 61.98, 2500 => 76.71, 3000 => 86.36, 3500 => 96.52, 4000 => 104.14, 4500 => 110.49, 5000 => 118.11, 5500 => 123.19, 6000 => 127],
                  'torque' => [1000 => 94.11, 1500 => 170.5, 2000 => 261.4, 2500 => 287.33, 3000 => 291.18, 3500 => 303, 4000 => 298.88, 4500 => 290.76, 5000 => 284.73, 5500 => 270.91, 6000 => 244.34]
                ]
              ], $results);
      }

      /**
      * Pass over stock power / torque figures with rev intervals to return dyno points as an array.
      */
      public function testReturnFiguresForStockEngine(){
            $engineDynoFigures = new EngineDynoFigures($this->_completeEngineShiftPoints, 115, 275, false, false);
            $results = $engineDynoFigures->returnFigures();
            $this->assertArraySubset([
                  'stock' => [
                    'power' => [1000 => 17.71, 1500 => 29.56, 2000 => 56.12, 2500 => 69.46, 3000 => 78.2, 3500 => 87.4, 4000 => 94.3, 4500 => 100.05, 5000 => 106.95, 5500 => 111.55, 6000 => 115],
                    'torque' => [1000 => 85.42, 1500 => 154.74, 2000 => 237.24, 2500 => 260.78, 3000 => 264.28, 3500 => 275, 4000 => 271.26, 4500 => 263.89, 5000 => 258.42, 5500 => 245.88, 6000 => 221.76]
                  ]
                ], $results);
        }

        /**
        * Pass over tuned power / torque figures with rev intervals to return dyno points as an array.
        */
        public function testReturnFiguresForTunedEngine(){
              $engineDynoFigures = new EngineDynoFigures($this->_completeEngineShiftPoints, false, false, 127, 303);
              $results = $engineDynoFigures->returnFigures();
              $this->assertArraySubset([
                    'tuned' =>[
                      'power' => [1000 => 19.56, 1500 => 32.64, 2000 => 61.98, 2500 => 76.71, 3000 => 86.36, 3500 => 96.52, 4000 => 104.14, 4500 => 110.49, 5000 => 118.11, 5500 => 123.19, 6000 => 127],
                      'torque' => [1000 => 94.11, 1500 => 170.5, 2000 => 261.4, 2500 => 287.33, 3000 => 291.18, 3500 => 303, 4000 => 298.88, 4500 => 290.76, 5000 => 284.73, 5500 => 270.91, 6000 => 244.34]
                    ]
                  ], $results);
          }

      /**
      * Pass over stock ps power figure with power rev intervals to return dyno points as an array.
      */
      public function testReturnFiguresStockPsPowerOnly(){
            $engineDynoFigures = new EngineDynoFigures($this->_powerEngineShiftPoints, 115, false, false, false);
            $results = $engineDynoFigures->returnFigures();
            $this->assertArraySubset([
                  'stock' => [
                    'power' => [1000 => 17.71, 1500 => 29.56, 2000 => 56.12, 2500 => 69.46, 3000 => 78.2, 3500 => 87.4, 4000 => 94.3, 4500 => 100.05, 5000 => 106.95, 5500 => 111.55, 6000 => 115],
                    ]
                ], $results);
        }

        /**
        * Pass over tuned nm torque figure with torque rev intervals to return dyno points as an array.
        */
        public function testReturnFiguresTunedNmTorqueOnly(){
              $engineDynoFigures = new EngineDynoFigures($this->_torqueEngineShiftPoints, false, false, false, 303, false);
              $results = $engineDynoFigures->returnFigures();
              $this->assertArraySubset([
                    'tuned' =>[
                      'torque' => [1000 => 94.11, 1500 => 170.5, 2000 => 261.4, 2500 => 287.33, 3000 => 291.18, 3500 => 303, 4000 => 298.88, 4500 => 290.76, 5000 => 284.73, 5500 => 270.91, 6000 => 244.34]
                    ]
                  ], $results);
          }

        /**
        * Pass over tuned ps power figure with torque rev intervals.
        */
        public function testReturnFiguresStockPsPowerOnlyWithTorqueIntervals(){
              $engineDynoFigures = new EngineDynoFigures($this->_torqueEngineShiftPoints,false, false, 127, false, false);
              $results = $engineDynoFigures->returnFigures();
              $this->assertFalse($results);
        }

        /**
        * Return array of rev intervals.
        */
        public function testReturnRevIntervals()
        {
          $engineDynoFigures = new EngineDynoFigures($this->_completeEngineShiftPoints, false, false, false, false, false);
          $results = $engineDynoFigures->returnRevIntervals();
          $this->assertArraySubset([1000, 1500, 2000, 2500, 3000, 3500, 4000, 4500, 5000, 5500, 6000], $results);
        }


}
