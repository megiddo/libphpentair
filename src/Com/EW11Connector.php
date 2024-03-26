<?php

namespace Phpentair\Com;

use Phpentair\Command;

class EW11Connector implements IConnector {

    var $host;
    var $port;
    var $socket;

    public function __construct($host, $port) {
        $this->host = $host;
        $this->port = $port;
    }

    public function open() {
        $this->socket = fsockopen($this->host, $this->port);
    }

    public function close() {
        fclose($this->socket);
    }

    public function read($bytes) {
        $read = '';
        for ($b = 0; $b < $bytes; $b++) {
            $read .= fgetc($this->socket);
        }
        return $read;
    }

    public function put(Command $command) {
        return fputs($this->socket, hex2bin($command->toHex()));
    }

}