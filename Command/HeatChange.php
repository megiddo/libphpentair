<?php

namespace Phpentair\Command;

use Phpentair\CIRCUIT_CHANGE;
use Phpentair\CircuitChangeBytes;
use Phpentair\Enum\Commands;
use function Phpentair\dechexbyte;

// https://github.com/scottrfrancis/Pentair-Thing/blob/49e6014866029771a31eaba075b89401fac2593a/PentairProtocol.py#L288
class HeatChange extends \Phpentair\Command
{

    var $poolSet;
    var $spaSet;
    var $mode;

    public static $SPAMODE = 0x04;
    public static $POOLMODE = 0x01;

    public function __construct($json = null)
    {
        $pmr = $this->init($json);

        if ($pmr) {
            $this->poolSet($pmr->poolSet);
            $this->spaSet($pmr->spaSet);
            $this->mode($pmr->mode);
        }
    }

    public static function CommandType() {
        return Commands::TEMP_CHANGE_REQUEST->value;
    }

    public function toHex()
    {
        $header = $this->buildHeaderHex();
        echo "HEADER: $header\n";
        return $this->buildHex(hex2bin($header .
            dechexbyte($this->poolSet) .
            dechexbyte($this->spaSet) .
            dechexbyte($this->mode) .
            '00'
        ));
    }

    public static function set($protocol, int $spaTemp, int $poolTemp, int $mode) {
        $cmd = new HeatChange();
        $cmd->command(Commands::TEMP_CHANGE_REQUEST->value);
        $cmd->protocol($protocol);
        $cmd->length(4);
        $cmd->source(32);
        $cmd->destination(16);
        $cmd->spaSet($spaTemp);
        $cmd->poolSet($poolTemp);
        $cmd->mode($mode);
        return $cmd;
    }

    public static function parse($raw)
    {
        $pm = new TempStatus();
        $pm = parent::parseInto($pm, $raw);
        $pm->circuit($pm->byte(CircuitChangeBytes::CIRCUIT->value));
        $pm->status($pm->byte(CircuitChangeBytes::STATUS->value));
        return $pm;
    }
}