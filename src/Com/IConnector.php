<?php

namespace Phpentair\Com;

use Phpentair\Command;

interface IConnector {

    public function open();
    public function close();
    public function read($bytes);
    public function put(Command $command);

}

class NotImplementedException extends \BadMethodCallException {

}