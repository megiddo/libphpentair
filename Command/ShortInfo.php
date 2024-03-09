<?php

namespace Phpentair\Command;

use Phpentair\Commands;
use Phpentair\MessageType;

class ShortInfo extends \Phpentair\Command {

    public function __construct($json = null) {
    }

    public static function CommandType() {
        return Commands::UNKNOWN->value;
    }

    public static function parse($raw) {
        $pm = new ShortInfo();
        $pm->raw($raw);
        return $pm;
    }

    public static function Header()
    {
        return '100250';
    }

    public static function MessageType() {
        return MessageType::SHORT->value;
    }
    public function checksum() {
        return null;
    }
}