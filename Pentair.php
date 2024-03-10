<?php

namespace Phpentair;

use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;

class Pentair {

    use LoggerAwareTrait;
    private $com;
    private $flock;
    private $readCache;

    public function __construct(\Phpentair\PentairComFacade $com, $flock, $readCache) {
        $this->com = $com;
        $this->flock = $flock;
        $this->readCache = $readCache;
        $this->logger = new NullLogger();
    }

    function read() {
        $pm = $this->com->readCommand();
        if ($pm === false) return new Exception\CommandNotSupported();

        $fp = fopen($this->flock, 'c+');

        if (flock($fp, LOCK_EX | LOCK_NB)) {
            file_put_contents($this->readCache, $pm->toJson());
            flock($fp, LOCK_UN);
        }
        flock($fp, LOCK_SH);
        $json = file_get_contents($this->readCache);
        flock($fp, LOCK_UN);

        fclose($fp);

        return Command::fromJson($json);
    }

    function write($message) {
        return $this->com->sendCommand($message);
    }

}