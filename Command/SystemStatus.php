<?php

namespace Phpentair\Command;

use Phpentair\CIRCUIT_STATUS;
use Phpentair\Commands;
use Phpentair\StatusCommandBytes;

// https://github.com/scottrfrancis/Pentair-Thing/blob/49e6014866029771a31eaba075b89401fac2593a/PentairProtocol.py#L63
class SystemStatus extends \Phpentair\Command {

    var $minutes;
    var $hours;
    var $circuits;
    var $circuitStatus;
    var $waterTemp;
    var $heaterTemp;
    var $airTemp;

    public function __construct($json = null) {
        $pmr = $this->init($json);

        if ($pmr) {
            $this->minutes($pmr->minutes);
            $this->hours($pmr->hours);
            $this->circuits($pmr->circuits);
            $this->waterTemp($pmr->waterTemp);
            $this->heaterTemp($pmr->heaterTemp);
            $this->airTemp($pmr->airTemp);
            $this->setCircuitStatus();
        }
    }


    public static function CommandType() {
        return Commands::SYSTEM_STATUS->value;
    }

    public function toHex() {
        return $this->buildHex(substr(hex2bin($this->raw), 4, -2));
    }

    private function setCircuitStatus() {
        $this->circuitStatus = new \stdClass();
        $this->circuitStatus->filterPump = $this->circuits & CIRCUIT_STATUS::FILTER_PUMP->value ? "on" : "off";
        $this->circuitStatus->cleanerPump = $this->circuits & CIRCUIT_STATUS::CLEANER_PUMP->value ? "on" : "off";
        $this->circuitStatus->waterFeature = $this->circuits & CIRCUIT_STATUS::WATER_FEATURE->value ? "on" : "off";
        $this->circuitStatus->spaLight = $this->circuits & CIRCUIT_STATUS::SPA_LIGHT->value ? "on" : "off";
        $this->circuitStatus->poolLight = $this->circuits & CIRCUIT_STATUS::POOL_LIGHT->value ? "on" : "off";
    }

    public static function parse($raw) {
        $pm = new SystemStatus();
        $pm = parent::parseInto($pm, $raw);
        $pm->minutes($pm->byte(StatusCommandBytes::MINUTES->value));
        $pm->hours($pm->byte(StatusCommandBytes::HOURS->value));
        $pm->circuits($pm->byte(StatusCommandBytes::CIRCUITS_0->value));
        $pm->waterTemp($pm->byte(StatusCommandBytes::WATER_TEMP->value));
        $pm->heaterTemp($pm->byte(StatusCommandBytes::HEATER_TEMP->value));
        $pm->airTemp($pm->byte(StatusCommandBytes::AIR_TEMP->value));
        $pm->setCircuitStatus();
        return $pm;
    }
}