<?php

namespace Phpentair\Command;

use Phpentair\CIRCUIT_CHANGE;
use Phpentair\CircuitChangeBytes;
use Phpentair\Enum\Commands;
use function Phpentair\dechexbyte;

// https://github.com/scottrfrancis/Pentair-Thing/blob/49e6014866029771a31eaba075b89401fac2593a/PentairProtocol.py#L258
class CircuitChange extends \Phpentair\Command
{

    var $circuit;
    var $status;

    public static int $ON = 1;
    public static int $OFF = 0;

    public function __construct($json = null)
    {
        $pmr = $this->init($json);

        if ($pmr) {
            $this->circuit($pmr->circuit);
            $this->status($pmr->status);
        }
    }

    public static function CommandType() {
        return Commands::CIRCUIT_CHANGE_REQUEST->value;
    }

    public function toHex()
    {
        $header = $this->buildHeaderHex();
        echo "HEADER: $header\n";
        return $this->buildHex(hex2bin($header .
            dechexbyte($this->circuit->value) .
            dechexbyte($this->status)
        ));
    }

    public static function spa($protocol, $status) {
        echo "Target protocol $protocol\n";
        return CircuitChange::change($protocol, CIRCUIT_CHANGE::SPA, $status);
    }

    public static function pool($protocol, $status) {
        return CircuitChange::change($protocol, CIRCUIT_CHANGE::POOL, $status);
    }

    private static function change($protocol, $circuit, $status) {
        $cmd = new CircuitChange();
        $cmd->command(Commands::CIRCUIT_CHANGE_REQUEST->value);
        $cmd->protocol($protocol);
        $cmd->length(2);
        $cmd->source(32);
        $cmd->destination(16);
        $cmd->circuit($circuit);
        $cmd->status($status ? 1 : 0);
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