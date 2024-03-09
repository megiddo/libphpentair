<?php

namespace Phpentair\Command;

use Phpentair\TempStatusBytes;
use Phpentair\Commands;
class TempStatus extends \Phpentair\Command {

    var $water;
    var $air;
    var $waterSet;
    var $spaSet;
    var $info;

    public function __construct($json = null) {
        $pmr = $this->init($json);

        if ($pmr) {
            $this->water($pmr->water);
            $this->air($pmr->air);
            $this->waterSet($pmr->waterSet);
            $this->spaSet($pmr->spaSet);
            $this->info($pmr->info);
        }
    }


    public static function CommandType() {
        return Commands::INFO->value;
    }

    public static function parse($raw) {
        $pm = new TempStatus();
        $pm = parent::parseInto($pm, $raw);
        $pm->water($pm->byte(TempStatusBytes::WATER_ACTUAL->value));
        $pm->air($pm->byte(TempStatusBytes::AIR_ACTUAL->value));
        $pm->waterSet($pm->byte(TempStatusBytes::WATER_SET->value));
        $pm->spaSet($pm->byte(TempStatusBytes::SPA_SET->value));
        $pm->info($pm->byte(TempStatusBytes::INFO->value));
        return $pm;
    }
}