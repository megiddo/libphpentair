<?php

namespace Phpentair\Com;

use Phpentair\Command;

class EW11HexSampleConnector implements IConnector {

    var $raw;
    var $currentByte;

    public function __constructor($fileName) {
        $this->raw = EW11HexSampleConnector::sample2bin($fileName);
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

    public static function sample2bin($file) {
        $hexlines = file($file);
        $bin = '';
        foreach ($hexlines as $hexline) {
            preg_match_all('/\s*(?:<\s0x[0-9a-f]+\s+|<\s+)(.*)/U', $hexline, $out);
            $hexplode = implode('', $out[1]);
            $bin .= hex2bin($hexplode);
        }
        return $bin;
    }
}
