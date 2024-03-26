<?php

namespace Phpentair\Exception;

class CommandNotSupported extends \Phpentair\Command {

    var $error = 'COMMAND-NOT-SUPPORTED';

    public function __construct($json = null) {
    }

    public static function parse($raw) {
        $pm = new CommandNotSupported();
        $pm->raw($raw);
        return $pm;
    }
}