<?php

namespace TdiDean\EngineTools\Test;

use TdiDean\EngineTools\Dyno\EngineDyno;

class EngineDynoTest extends \PHPUnit_Framework_TestCase
{

  protected $_powerIntervals = [1000 => 15.4, 1500 => 25.7, 2000 => 48.8, 2500 => 60.4, 3000 => 68, 3500 => 76, 4000 => 82, 4500 => 87, 5000 => 93, 5500 => 97, 6000 => 100];
  protected $_torqueIntervals = [1000 => 31.06, 1500 => 56.27, 2000 => 86.27, 2500 => 94.83, 3000 => 96.10, 3500 => 100, 4000 => 98.64, 4500 => 95.96, 5000 => 93.97, 5500 => 89.41, 6000 => 80.64];

/**
* Pass over stock and tuned power / torque figures with rev intervals to return dyno points as an array.
*/
  public function testReturnFiguresAsArray(){
        $engineDyno = new EngineDyno(115, 275, 127, 303, $this->_powerIntervals, $this->_torqueIntervals);
        $results = $engineDyno->returnFigures(false);
        
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
* Pass over stock and tuned power / torque figures without any rev intervals.
*/
    public function testReturnFiguresAsArrayWithoutIntervals(){
      $engineDyno = new EngineDyno(115, 275, 127, 303);
      $results = $engineDyno->returnFigures(false);
      $this->assertFalse($results);
    }

/**
* Pass over stock and tuned power / torque figures with only power rev intervals.
*/
    public function testReturnFiguresAsArrayWithOnlyPowerIntervals(){
      $engineDyno = new EngineDyno(115, 275, 127, 303, $this->_powerIntervals);
      $results = $engineDyno->returnFigures(false);
      $this->assertArraySubset([
            'stock' => [
              'power' => [1000 => 17.71, 1500 => 29.56, 2000 => 56.12, 2500 => 69.46, 3000 => 78.2, 3500 => 87.4, 4000 => 94.3, 4500 => 100.05, 5000 => 106.95, 5500 => 111.55, 6000 => 115],
            ],
            'tuned' =>[
              'power' => [1000 => 19.56, 1500 => 32.64, 2000 => 61.98, 2500 => 76.71, 3000 => 86.36, 3500 => 96.52, 4000 => 104.14, 4500 => 110.49, 5000 => 118.11, 5500 => 123.19, 6000 => 127],
            ]
          ], $results);
    }

/**
* Pass over stock and tuned power / torque figures with only torque power rev intervals.
*/
    public function testReturnFiguresAsArrayWithOnlyTorqueIntervals(){
      $engineDyno = new EngineDyno(115, 275, 127, 303, false, $this->_torqueIntervals);
      $results = $engineDyno->returnFigures(false);
      $this->assertArraySubset([
        'stock' => [
          'torque' => [1000 => 85.42, 1500 => 154.74, 2000 => 237.24, 2500 => 260.78, 3000 => 264.28, 3500 => 275, 4000 => 271.26, 4500 => 263.89, 5000 => 258.42, 5500 => 245.88, 6000 => 221.76]
        ],
        'tuned' =>[
          'torque' => [1000 => 94.11, 1500 => 170.5, 2000 => 261.4, 2500 => 287.33, 3000 => 291.18, 3500 => 303, 4000 => 298.88, 4500 => 290.76, 5000 => 284.73, 5500 => 270.91, 6000 => 244.34]
        ]
          ], $results);
    }

/**
* Pass over stock power / torque figures with with rev intervals.
*/
    public function testReturnFiguresForStockOnlyAsArray(){
          $engineDyno = new EngineDyno(115, 275, false, false, $this->_powerIntervals, $this->_torqueIntervals);
          $results = $engineDyno->returnFigures(false);
          $this->assertArraySubset([
                'stock' => [
                  'power' => [1000 => 17.71, 1500 => 29.56, 2000 => 56.12, 2500 => 69.46, 3000 => 78.2, 3500 => 87.4, 4000 => 94.3, 4500 => 100.05, 5000 => 106.95, 5500 => 111.55, 6000 => 115],
                  'torque' => [1000 => 85.42, 1500 => 154.74, 2000 => 237.24, 2500 => 260.78, 3000 => 264.28, 3500 => 275, 4000 => 271.26, 4500 => 263.89, 5000 => 258.42, 5500 => 245.88, 6000 => 221.76]
                ]
              ], $results);
      }

/**
* Pass over tuned power / torque figures with rev intervals.
*/
    public function testReturnFiguresForTunedOnlyAsArray(){
            $engineDyno = new EngineDyno(false, false, 127, 303, $this->_powerIntervals, $this->_torqueIntervals);
            $results = $engineDyno->returnFigures(false);
            $this->assertArraySubset([
                  'tuned' =>[
                    'power' => [1000 => 19.56, 1500 => 32.64, 2000 => 61.98, 2500 => 76.71, 3000 => 86.36, 3500 => 96.52, 4000 => 104.14, 4500 => 110.49, 5000 => 118.11, 5500 => 123.19, 6000 => 127],
                    'torque' => [1000 => 94.11, 1500 => 170.5, 2000 => 261.4, 2500 => 287.33, 3000 => 291.18, 3500 => 303, 4000 => 298.88, 4500 => 290.76, 5000 => 284.73, 5500 => 270.91, 6000 => 244.34]
                  ]
                ], $results);
        }

/**
* Pass over stock and tuned power / torque figures with rev intervals to return dyno points as a google ready json array.
*/
    public function testReturnFiguresAsGoogleJson(){
      $engineDyno = new EngineDyno(115, 275, 127, 303, $this->_powerIntervals, $this->_torqueIntervals);
      $results = $engineDyno->returnFigures();
      $this->assertJsonStringEqualsJsonString(json_encode([[1000,17.71,19.56,false,85.42,94.11,false],[1500,29.56,32.64,false,154.74,170.5,false],[2000,56.12,61.98,false,237.24,261.4,false],[2500,69.46,76.71,false,260.78,287.33,false],[3000,78.2,86.36,false,264.28,291.18,false],[3500,87.4,96.52,false,275,303,false],[4000,94.3,104.14,false,271.26,298.88,false],[4500,100.05,110.49,false,263.89,290.76,false],[5000,106.95,118.11,false,258.42,284.73,false],[5500,111.55,123.19,false,245.88,270.91,false],[6000,115,127,false,221.76,244.34,false]]), $results);
    }

}
