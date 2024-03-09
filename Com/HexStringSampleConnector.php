<?php

namespace Phpentair\Com;

use Phpentair\Command;

class HexStringSampleConnector implements IConnector {

    var $raw;
    var $currentByte;

    public function __construct($str) {
        $this->raw = hex2bin($str);
        $this->currentByte = 0;
    }

    public function open() {

    }

    public function close() {

    }

    public function read($bytes) {
        if ($this->currentByte > strlen($this->raw)) {
            return false;
        }
        $read = substr($this->raw, $this->currentByte, $bytes);
        $this->currentByte += $bytes;
        return $read;
    }

    public function put(Command $command) {
        throw new NotImplementedException();
    }

}
