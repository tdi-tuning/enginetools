<?php

namespace TdiDean\EngineTools\Test;

use TdiDean\EngineTools\Dyno\Calculate\EngineShiftPoints;
use \ReflectionClass;

class EngineShiftPointsTest extends \PHPUnit_Framework_TestCase
{

  protected $_powerIntervals = [1000 => 15.4, 1500 => 25.7, 2000 => 48.8, 2500 => 60.4, 3000 => 68, 3500 => 76, 4000 => 82, 4500 => 87, 5000 => 93, 5500 => 97, 6000 => 100];
  protected $_torqueIntervals = [1000 => 31.06, 1500 => 56.27, 2000 => 86.27, 2500 => 94.83, 3000 => 96.10, 3500 => 100, 4000 => 98.64, 4500 => 95.96, 5000 => 93.97, 5500 => 89.41, 6000 => 80.64];

  /**
  * Reflection to test private and protected methods.
  */
  protected static function getMethod($name) {
    $class = new ReflectionClass('TdiDean\EngineTools\Dyno\Calculate\EngineShiftPoints');
    $method = $class->getMethod($name);
    $method->setAccessible(true);
    return $method;
  }

  public function testHasPowerIntervals(){
      $shiftPoints = new EngineShiftPoints($this->_powerIntervals);
      $result = $shiftPoints->hasPowerIntervals();
      $this->assertTrue($result);
  }

  public function testHasTorqueIntervals(){
      $shiftPoints = new EngineShiftPoints(false, $this->_torqueIntervals);
      $result = $shiftPoints->hasTorqueIntervals();
      $this->assertTrue($result);
  }

  public function testHasNoIntervals(){
      $shiftPoints = new EngineShiftPoints();
      $this->assertFalse($shiftPoints->hasPowerIntervals());
      $this->assertFalse($shiftPoints->hasTorqueIntervals());
  }

  public function testPrivateFigurePercent() {
    $privateFigurePercent = self::getMethod('_figurePercent');
    $shiftPoints = new EngineShiftPoints($this->_powerIntervals, $this->_torqueIntervals);
    $result = $privateFigurePercent->invokeArgs($shiftPoints, [127, 86.27]);
    $this->assertEquals(109.56, $result);
  }

  public function testGenerateForPower127WithPowerAndTorqueIntervalsSet()
  {
      $shiftPoints = new EngineShiftPoints($this->_powerIntervals, $this->_torqueIntervals);
      $points = $shiftPoints->generate(127);
      $this->assertArraySubset([1000 => 19.56, 1500 => 32.64, 2000 => 61.98, 2500 => 76.71, 3000 => 86.36, 3500 => 96.52, 4000 => 104.14, 4500 => 110.49, 5000 => 118.11, 5500 => 123.19, 6000 => 127], $points);
  }

  public function testGenerateForPower127WithNoPowerAndTorqueIntervalsSet()
  {
      $shiftPoints = new EngineShiftPoints();
      $points = $shiftPoints->generate(127);
      $this->assertFalse($points);
  }

  public function testGenerateForTorque303WithPowerAndTorqueIntervalsSet()
  {
      $shiftPoints = new EngineShiftPoints($this->_powerIntervals, $this->_torqueIntervals);
      $points = $shiftPoints->generate(303, 'torque');
      $this->assertArraySubset([1000 => 94.11, 1500 => 170.5, 2000 => 261.4, 2500 => 287.33, 3000 => 291.18, 3500 => 303, 4000 => 298.88, 4500 => 290.76, 5000 => 284.73, 5500 => 270.91, 6000 => 244.34], $points);
  }

  public function testGenerateForTorque303WithNoPowerAndTorqueIntervalsSet()
  {
      $shiftPoints = new EngineShiftPoints();
      $points = $shiftPoints->generate(303, 'torque');
      $this->assertFalse($points);
  }



}
