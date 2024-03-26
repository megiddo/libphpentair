<?php

namespace Phpentair\Command;

class Unknown extends \Phpentair\Command {

    public function __construct($json = null) {
    }

    public static function Header()
    {
        return false;
    }

    public function checksum() {
        return null;
    }
}