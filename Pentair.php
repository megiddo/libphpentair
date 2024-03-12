<?php

namespace Phpentair;

use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;

class Pentair {

    use LoggerAwareTrait;
    private $com;

    public function __construct(\Phpentair\PentairComFacade $com) {
        $this->com = $com;
        $this->logger = new NullLogger();
    }

    function read() {
        $pm = $this->com->readCommand();
        if ($pm === false) return new Exception\CommandNotSupported();

        return $pm;
    }

    function write(Command $command) {
        $this->com->sendCommand($command);
    }

}