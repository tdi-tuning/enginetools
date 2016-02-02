<?php

namespace TdiDean\EngineTools;

class EngineTune {

    protected $_multiplier;

    /**
     * Set multiplier, default 1.
     * @param type $multiplier
     */
    public function __construct($multiplier = 1) {
        $this->_multiplier = $multiplier;
    }

    /**
     * Calculate increase of a unit of measurement individually.
     * @param type $stockFigure
     * @param type $unit
     * @return boolean
     */
    public function calculate($stockFigure = false, $unit = 'ps') {
        if (($stockFigure) && ($stockFigure > 0)) {
            $gains = round($stockFigure * $this->_multiplier);
            return [$unit =>
                [
                    'stock' => round($stockFigure),
                    'tuned' => round($gains),
                    'increase' => round($gains - $stockFigure)
                ]
            ];
        }
        return false;
    }

    /**
     * Calculate all power increase figures.
     * @param type $ps
     * @param type $bhp
     * @param type $kw
     * @return type
     */
    public function calculatePower($ps = false, $bhp = false, $kw = false) {
        $power = array_filter([
            'power' =>
            array_merge(
                    $this->calculate($ps, 'ps') ? : [], $this->calculate($bhp, 'bhp') ? : [], $this->calculate($kw, 'kw') ? : []
            )
                ], function($power) {
            return !empty($power);
        });

        return !empty($power) ? $power : false;
    }

    /**
     * Calculate all torque increase figures.
     * @param type $lb_ft
     * @param type $nm
     * @return type
     */
    public function calculateTorque($lb_ft = false, $nm = false) {
        $torque = array_filter([
            'torque' =>
            array_merge(
                    $this->calculate($lb_ft, 'lb_ft') ? : [], $this->calculate($nm, 'nm') ? : []
            )
                ], function($torque) {
            return !empty($torque);
        });

        return !empty($torque) ? $torque : false;
    }

    /**
     * Calculate all power and torque increase figures.
     * @param type $ps
     * @param type $bhp
     * @param type $kw
     * @param type $lb_ft
     * @param type $nm
     * @return type
     */
    public function calculateAll($ps = false, $bhp = false, $kw = false, $lb_ft = false, $nm = false) {
        $engineFigures = array_merge($this->calculatePower($ps, $bhp, $kw) ? : [], $this->calculateTorque($lb_ft, $nm) ? : []);
        return !empty($engineFigures['power']) || !empty($engineFigures['torque']) ? array_filter($engineFigures) : false;
    }

    /**
     * Passover over exisiting engine, tune and return.
     * @param Engine $engine
     * @return Engine $engine
     */
     public function tune(Engine $engine){
       return new Engine($this->calculate($engine->ps, 'ps')['ps']['tuned'], $this->calculate($engine->bhp, 'bhp')['bhp']['tuned'], $this->calculate($engine->kw, 'kw')['kw']['tuned'], $this->calculate($engine->lbFt, 'lb_ft')['lb_ft']['tuned'], $this->calculate($engine->nm, 'nm')['nm']['tuned'], 'tuned');
     }

    /**
     * Compare two engines side by side, in array format.
     * @param \TdiDean\EngineTools\Engine $stockEngine
     * @param \TdiDean\EngineTools\Engine $tunedEngine
     * @return type
     */
    public function compare(Engine $stockEngine, Engine $tunedEngine) {
        return ['power' =>
            [
                'ps' => [
                    'stock' => $stockEngine->ps ?: null,
                    'tuned' => $tunedEngine->ps ?: null,
                    'increase' => ($tunedEngine->ps) - ($stockEngine->ps) ?: null
                ],
                'bhp' => [
                    'stock' => $stockEngine->bhp ?: null,
                    'tuned' => $tunedEngine->bhp ?: null,
                    'increase' => ($tunedEngine->bhp) - ($stockEngine->bhp) ?: null
                ],
                'kw' => [
                    'stock' => $stockEngine->kw ?: null,
                    'tuned' => $tunedEngine->kw ?: null,
                    'increase' => ($tunedEngine->kw) - ($stockEngine->kw) ?: null
                ]
            ],
            'torque' =>
            [
                'lb_ft' => [
                    'stock' => $stockEngine->lbFt ?: null,
                    'tuned' => $tunedEngine->lbFt ?: null,
                    'increase' => ($tunedEngine->lbFt) - ($stockEngine->lbFt) ?: null
                ],
                'nm' => [
                    'stock' => $stockEngine->nm ?: null,
                    'tuned' => $tunedEngine->nm ?: null,
                    'increase' => ($tunedEngine->nm) - ($stockEngine->nm) ?: null
                ]
            ]
        ];
    }

}
