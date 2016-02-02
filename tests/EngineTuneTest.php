<?php

namespace TdiDean\EngineTools\Test;

use TdiDean\EngineTools\EngineTune;
use TdiDean\EngineTools\Engine;

class EngineTuneTest extends \PHPUnit_Framework_TestCase
{

  protected $_multiplier = 1.1;
  protected $_stockPowerPs = 115;
  protected $_stockPowerBhp = 113;
  protected $_stockPowerKw = 85;
  protected $_stockTorqueLbFt = 203;
  protected $_stockTorqueNm = 275;
  protected $_tunedPowerPs;
  protected $_tunedPowerBhp;
  protected $_tunedPowerKw;
  protected $_tunedTorqueLbFt;
  protected $_tunedTorqueNm;
  protected $_increasePowerPs;
  protected $_increasePowerBhp;
  protected $_increasePowerKw;
  protected $_increaseTorqueLbFt;
  protected $_increaseTorqueNm;
  protected $_testEngine;


  public function setUp(){
    $this->_tunedPowerPs = round($this->_multiplier * $this->_stockPowerPs);
    $this->_increasePowerPs = round($this->_tunedPowerPs - $this->_stockPowerPs);
    $this->_tunedPowerBhp = round($this->_multiplier * $this->_stockPowerBhp);
    $this->_increasePowerBhp = round($this->_tunedPowerBhp - $this->_stockPowerBhp);
    $this->_tunedPowerKw = round($this->_multiplier * $this->_stockPowerKw);
    $this->_increasePowerKw = round($this->_tunedPowerKw - $this->_stockPowerKw);
    $this->_tunedTorqueLbFt = round($this->_multiplier * $this->_stockTorqueLbFt);
    $this->_increaseTorqueLbFt = round($this->_tunedTorqueLbFt - $this->_stockTorqueLbFt);
    $this->_tunedTorqueNm = round($this->_multiplier * $this->_stockTorqueNm);
    $this->_increaseTorqueNm = round($this->_tunedTorqueNm - $this->_stockTorqueNm);
    $this->_testEngine = new Engine($this->_stockPowerPs, $this->_stockPowerBhp, $this->_stockPowerKw, $this->_stockTorqueLbFt, $this->_stockTorqueNm);
  }

    /**
     * Calculate power in ps, with multiplier.
     */
    public function testCalculatePowerPs()
    {
        $engine = new EngineTune($this->_multiplier);
        $results = $engine->calculate($this->_stockPowerPs);
        $this->assertArraySubset(['ps' => ['stock' => $this->_stockPowerPs, 'tuned' => $this->_tunedPowerPs, 'increase' => $this->_increasePowerPs]], $results);
    }

    /**
     * Calculate power in kw, with multiplier.
     */
    public function testCalculatePowerKw()
    {
      $engine = new EngineTune($this->_multiplier);
      $results = $engine->calculate($this->_stockPowerKw, 'kw');
      $this->assertArraySubset(['kw' => ['stock' => $this->_stockPowerKw, 'tuned' => $this->_tunedPowerKw, 'increase' => $this->_increasePowerKw]], $results);
    }

    /**
     * Calculate torque in nm, with multiplier.
     */
    public function testCalculateTorqueNm()
    {
      $engine = new EngineTune($this->_multiplier);
      $results = $engine->calculate($this->_stockTorqueNm, 'nm');
      $this->assertArraySubset(['nm' => ['stock' => $this->_stockTorqueNm, 'tuned' => $this->_tunedTorqueNm, 'increase' => $this->_increaseTorqueNm]], $results);
    }

    /**
     * Calculate power in bhp, with no multiplier.
     */
    public function testCalculatePowerBhpWithNoMultiplier()
    {
        $engine = new EngineTune();
        $results = $engine->calculate($this->_stockPowerBhp, 'bhp');
        $this->assertArraySubset(['bhp' => ['stock' => $this->_stockPowerBhp, 'tuned' => $this->_stockPowerBhp, 'increase' => 0]], $results);
    }

    /**
     * Calculate zero power in bhp, with multiplier.
     */
    public function testCalculatePowerPsWithZeroStockFigure()
    {
        $engine = new EngineTune($this->_multiplier);
        $results = $engine->calculate(0, 'bhp');
        $this->assertFalse($results);
    }

    /**
     * Calculate empty power in ps, with multiplier.
     */
    public function testCalculatePowerPsWithNoStockFigure()
    {
        $engine = new EngineTune($this->_multiplier);
        $results = $engine->calculate();
        $this->assertFalse($results);
    }

    /**
    * Calculate all power figures ps, bhp and kw, with multiplier.
    */
    public function testCalculatePower(){
        $engine = new EngineTune($this->_multiplier);
        $results = $engine->calculatePower($this->_stockPowerPs, $this->_stockPowerBhp, $this->_stockPowerKw);

        $this->assertArraySubset(
        [
            'power' => [
                'ps' => ['stock' => $this->_stockPowerPs, 'tuned' => $this->_tunedPowerPs, 'increase' => $this->_increasePowerPs],
                'bhp' => ['stock' => $this->_stockPowerBhp, 'tuned' => $this->_tunedPowerBhp, 'increase' => $this->_increasePowerBhp],
                'kw' => ['stock' => $this->_stockPowerKw, 'tuned' => $this->_tunedPowerKw, 'increase' => $this->_increasePowerKw]
            ]
        ], $results);
    }

   /**
    * Calculate all power figures ps, bhp and kw, with no multiplier.
    */
    public function testCalculatePowerWithNoMultiplier(){
        $engine = new EngineTune();
        $results = $engine->calculatePower($this->_stockPowerPs, $this->_stockPowerBhp, $this->_stockPowerKw);

        $this->assertArraySubset(
        [
            'power' => [
              'ps' => ['stock' => $this->_stockPowerPs, 'tuned' => $this->_stockPowerPs, 'increase' => 0],
              'bhp' => ['stock' => $this->_stockPowerBhp, 'tuned' => $this->_stockPowerBhp, 'increase' => 0],
              'kw' => ['stock' => $this->_stockPowerKw, 'tuned' => $this->_stockPowerKw, 'increase' => 0]
            ]
        ], $results);
    }

    /**
     * Calculate some power figures, with no multiplier.
     */
    public function testCalculatePowerWithMissingStockFigures()
    {
        $engine = new EngineTune($this->_multiplier);
        $results = $engine->calculatePower(false, $this->_stockPowerBhp);

        $this->assertArraySubset(
        [
            'power' => [
                'bhp' => ['stock' => $this->_stockPowerBhp, 'tuned' => $this->_tunedPowerBhp, 'increase' => $this->_increasePowerBhp],
            ]
        ], $results);

    }

    /**
     * Calculate empty power, with multiplier.
     */
    public function testCalculatePowerWithMissingAllStockFigures()
    {
        $engine = new EngineTune($this->_multiplier);
        $results = $engine->calculatePower();

        $this->assertFalse($results);

    }

    /**
    * Calculate all torque figures lb ft and nm, with multiplier.
    */
    public function testCalculateTorque(){
        $engine = new EngineTune($this->_multiplier);
        $results = $engine->calculateTorque($this->_stockTorqueLbFt, $this->_stockTorqueNm);

        $this->assertArraySubset(
        [
          'torque' => [
              'lb_ft' => ['stock' => $this->_stockTorqueLbFt, 'tuned' => $this->_tunedTorqueLbFt, 'increase' => $this->_increaseTorqueLbFt],
              'nm' => ['stock' => $this->_stockTorqueNm, 'tuned' => $this->_tunedTorqueNm, 'increase' => $this->_increaseTorqueNm]
          ]
        ], $results);
    }

    /**
     * Calculate all torque figures ps, bhp and kw, with no multiplier.
     */
    public function testCalculateTorqueWithNoMultiplier(){
        $engine = new EngineTune();
        $results = $engine->calculateTorque($this->_stockTorqueLbFt, $this->_stockTorqueNm);

        $this->assertArraySubset(
        [
          'torque' => [
              'lb_ft' => ['stock' => $this->_stockTorqueLbFt, 'tuned' => $this->_stockTorqueLbFt, 'increase' => 0],
              'nm' => ['stock' => $this->_stockTorqueNm, 'tuned' => $this->_stockTorqueNm, 'increase' => 0]
          ]
        ], $results);
    }

    /**
     * Calculate some torque figures, with no multiplier.
     */
    public function testCalculateTorqueWithMissingStockFigures()
    {
        $engine = new EngineTune($this->_multiplier);
        $results = $engine->calculateTorque($this->_stockTorqueLbFt);

        $this->assertArraySubset(
        [
          'torque' => [
              'lb_ft' => ['stock' => $this->_stockTorqueLbFt, 'tuned' => $this->_tunedTorqueLbFt, 'increase' => $this->_increaseTorqueLbFt],
          ]
        ], $results);

    }

    /**
     * Calculate empty torque, with multiplier.
     */
    public function testCalculateTorqueWithMissingAllStockFigures()
    {
        $engine = new EngineTune($this->_multiplier);
        $results = $engine->calculateTorque();

        $this->assertFalse($results);

    }

    /**
     * Calculate all power and torque figures, with multiplier.
     */
    public function testCalculateAll()
    {
        $engine = new EngineTune($this->_multiplier);
        $results = $engine->calculateAll($this->_stockPowerPs, $this->_stockPowerBhp, $this->_stockPowerKw, $this->_stockTorqueLbFt, $this->_stockTorqueNm);

        $this->assertArraySubset(
        [
            'power' => [
                'ps' => ['stock' => $this->_stockPowerPs, 'tuned' => $this->_tunedPowerPs, 'increase' => $this->_increasePowerPs],
                'bhp' => ['stock' => $this->_stockPowerBhp, 'tuned' => $this->_tunedPowerBhp, 'increase' => $this->_increasePowerBhp],
                'kw' => ['stock' => $this->_stockPowerKw, 'tuned' => $this->_tunedPowerKw, 'increase' => $this->_increasePowerKw]
            ],
            'torque' => [
                'lb_ft' => ['stock' => $this->_stockTorqueLbFt, 'tuned' => $this->_tunedTorqueLbFt, 'increase' => $this->_increaseTorqueLbFt],
                'nm' => ['stock' => $this->_stockTorqueNm, 'tuned' => $this->_tunedTorqueNm, 'increase' => $this->_increaseTorqueNm]
            ]
        ], $results);

    }

    /**
     * Calculate all power and torque figures, with no multiplier.
     */
    public function testCalculateAllWithNoMultiplier()
    {
        $engine = new EngineTune();
        $results = $engine->calculateAll($this->_stockPowerPs, $this->_stockPowerBhp, $this->_stockPowerKw, $this->_stockTorqueLbFt, $this->_stockTorqueNm);

        $this->assertArraySubset(
        [
          'power' => [
              'ps' => ['stock' => $this->_stockPowerPs, 'tuned' => $this->_stockPowerPs, 'increase' => 0],
              'bhp' => ['stock' => $this->_stockPowerBhp, 'tuned' => $this->_stockPowerBhp, 'increase' => 0],
              'kw' => ['stock' => $this->_stockPowerKw, 'tuned' => $this->_stockPowerKw, 'increase' => 0]
          ],
          'torque' => [
              'lb_ft' => ['stock' => $this->_stockTorqueLbFt, 'tuned' => $this->_stockTorqueLbFt, 'increase' => 0],
              'nm' => ['stock' => $this->_stockTorqueNm, 'tuned' => $this->_stockTorqueNm, 'increase' => 0]
          ]
        ], $results);

    }

    /**
     * Calculate all ps power, bhp power and nm torque figures with multiplier of 1.2.
     */
    public function testCalculateAllWithMissingStockFigures()
    {
        $engine = new EngineTune($this->_multiplier);
        $results = $engine->calculateAll($this->_stockPowerPs, $this->_stockPowerBhp, false, false, $this->_stockTorqueNm);

        $this->assertArraySubset(
        [
            'power' => [
              'ps' => ['stock' => $this->_stockPowerPs, 'tuned' => $this->_tunedPowerPs, 'increase' => $this->_increasePowerPs],
              'bhp' => ['stock' => $this->_stockPowerBhp, 'tuned' => $this->_tunedPowerBhp, 'increase' => $this->_increasePowerBhp],
            ],
            'torque' => [
                'nm' => ['stock' => $this->_stockTorqueNm, 'tuned' => $this->_tunedTorqueNm, 'increase' => $this->_increaseTorqueNm]
            ]
        ], $results);

    }

    /**
     * Calculate all power ps, bhp  and nm with no torque figures, with multiplier.
     */
    public function testCalculateAllWithMissingTorqueStockFigures()
    {
        $engine = new EngineTune($this->_multiplier);
        $results = $engine->calculateAll($this->_stockPowerPs, $this->_stockPowerBhp, $this->_stockPowerKw, false, false);

        $this->assertArraySubset(
        [
            'power' => [
                'ps' => ['stock' => $this->_stockPowerPs, 'tuned' => $this->_tunedPowerPs, 'increase' => $this->_increasePowerPs],
                'bhp' => ['stock' => $this->_stockPowerBhp, 'tuned' => $this->_tunedPowerBhp, 'increase' => $this->_increasePowerBhp],
                'kw' => ['stock' => $this->_stockPowerKw, 'tuned' => $this->_tunedPowerKw, 'increase' => $this->_increasePowerKw]
            ]
        ], $results);

    }

    /**
     * Calculate all torque lb ft and nm, with multiplier.
     */
    public function testCalculateAllWithMissingPowerStockFigures()
    {
        $engine = new EngineTune($this->_multiplier);
        $results = $engine->calculateAll(false, false, false, $this->_stockTorqueLbFt, $this->_stockTorqueNm);

        $this->assertArraySubset(
        [
          'torque' => [
              'lb_ft' => ['stock' => $this->_stockTorqueLbFt, 'tuned' => $this->_tunedTorqueLbFt, 'increase' => $this->_increaseTorqueLbFt],
              'nm' => ['stock' => $this->_stockTorqueNm, 'tuned' => $this->_tunedTorqueNm, 'increase' => $this->_increaseTorqueNm]
          ]
        ], $results);

    }

    /**
     * Calculate empty power and torque, with multiplier.
     */
    public function testCalculateAllWithMissingAllStockFigures()
    {
        $engine = new EngineTune($this->_multiplier);
        $results = $engine->calculateAll();
        $this->assertFalse($results);
    }

    /**
    * Pass an engine object over and tune.
    */
    public function testTuneEngine(){
        $engineTune = new EngineTune($this->_multiplier);
        $tunedEngine = $engineTune->tune($this->_testEngine);

        $this->assertEquals($this->_tunedPowerPs, $tunedEngine->ps);
        $this->assertEquals($this->_tunedPowerBhp, $tunedEngine->bhp);
        $this->assertEquals($this->_tunedPowerKw, $tunedEngine->kw);
        $this->assertEquals($this->_tunedTorqueLbFt, $tunedEngine->lbFt);
        $this->assertEquals($this->_tunedTorqueNm, $tunedEngine->nm);
    }


}
