<?php

namespace Phpentair;

class Command {

    var $raw;
    var $protocol;
    var $destination;
    var $source;
    var $command;
    var $length;

    public function __construct($json = null) {
        $this->init($json);
    }

    public static function fromJson($json) {
        $pm = json_decode($json, false);
        if (strlen($pm->command) == 0 && substr($pm->raw, 0, 6) == '100250') {
            return Command\ShortInfo::parse(hex2bin($pm->raw));
        }
        return \Phpentair\CommandTypeFactory::CallStatic($pm->command, 'parse', hex2bin($pm->raw));
    }

    function init($json = null) {
        if (is_null($json)) return false;

        $pmr = json_decode($json, false);
        $this->raw(hex2bin($pmr->raw));
        $this->protocol($pmr->protocol);
        $this->destination($pmr->destination);
        $this->source($pmr->source);
        $this->command($pmr->command);
        $this->length($pmr->length);
        return $pmr;
    }

    public function getBytes() {
        return hex2bin($this->toHex());
    }

    public function toHex() {
        return $this->buildHex($this->raw);
    }

    public static function Header() {
        return 'ff00ffa5';
    }

    public static function CommandType() {
        return Commands::UNKNOWN->value;
    }

    public static function Fqcn() {
        return '';
    }

    public static function MessageType() {
        return MessageType::STANDARD->value;
    }

    protected function buildHex($raw) {
        $checksum = Command::pentaircs(hex2bin('a5' . bin2hex($raw)));
        return $this->header() . bin2hex($raw) . str_pad(dechex($checksum), 4, '0', STR_PAD_LEFT);
    }

    protected function buildHeaderHex() {
        return dechexbyte($this->protocol) .
            dechexbyte($this->destination) .
            dechexbyte($this->source) .
            dechexbyte($this->command) .
            dechexbyte($this->length);
    }

    public function checksum() {
        return Command::pentaircs(substr(hex2bin($this->raw), 3, -2));
    }

    protected static function pentaircs($raw) {
        $checksum = 0;
        for ($c = 0; $c < strlen($raw); $c++) {
            $checksum += hexdec(bin2hex($raw[$c]));
        }
        return $checksum % 65536;
    }

    public function toJson($pretty = null) {
        $this->raw(bin2hex($this->raw));
        $json = json_encode($this, $pretty);
        return $json;
    }

    public static function parseInto($pm, $raw) {
        $pm->raw($raw);
        $pm->protocol($pm->byte(HeaderBytes::PROTOCOL->value));
        $pm->destination($pm->byte(HeaderBytes::DST->value));
        $pm->source($pm->byte(HeaderBytes::SRC->value));
        $pm->command($pm->byte(HeaderBytes::COMMAND->value));
        $pm->length($pm->byte(HeaderBytes::LENGTH->value));
        return $pm;
    }

    public static function parse($raw) {
        $pm = new Command();
        return Command::parseInto($pm, $raw);
    }

    public function byte($byte) {
        $val = hexdec(bin2hex($this->raw[$byte]));
        return $val;
    }

    public function __call($field, $value) {
        if (property_exists($this, $field)) {
            $this->$field = $value[0];
        }
    }
}