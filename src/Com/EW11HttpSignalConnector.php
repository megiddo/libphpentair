<?php

namespace Phpentair\Com;

use Phpentair\Command;

class EW11HttpSignalConnector implements IConnector {

    var $raw;
    var $currentByte;

    public function __constructor($signal) {
        $this->raw = EW11HttpSignalConnector::ew112bin($signal);
        $this->currentByte = 0;
    }

    public function open() {

    }

    public function close() {

    }

    public function read($bytes) {
        $read = substr($this->raw, $this->currentByte, $bytes);
        $this->currentByte += $bytes;
        return $read;
    }

    public function put(Command $command) {
        throw new NotImplementedException();
    }

    public static function ew112bin($signal) {

    }
}