<?php

namespace Phpentair;

use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use Phpentair\Enum\MessageType;
use Phpentair\Enum\HeaderBytes;

class CommandParser {

    use LoggerAwareTrait;
    var $ipc;

    public function __construct(Com\IConnector $ipc) {
        $this->ipc = $ipc;
        $this->logger = new NullLogger();
    }

    public function parse(MessageType $type = null) {
        switch ($type->value) {
            case MessageType::SHORT->value:
                return $this->parseShort();
            default:
                return $this->parseStandard();
        }
    }

    private function parseStandard() {
        $header = hex2bin(Command::Header()) . $this->ipc->read(5);
        $msgSize = hexdec(bin2hex($header[HeaderBytes::LENGTH->value])) + 2;
        $message = $this->ipc->read($msgSize);
        $raw = $header . $message;
        $pm = Command::parse($raw);
        try {
            $cmd = \Phpentair\CommandTypeFactory::CallStatic($pm->command, 'parse', $raw);
        } catch (\TypeError $te) {
            $this->logger->critical("Type not understood during parsing: " . $te->getMessage());
            $cmd = new Command();
            $cmd->raw($raw);
            throw $te;
        }
        return $cmd;
    }

    private function parseShort() {
        $msg = hex2bin(Command\ShortInfo::Header()) . $this->ipc->read(5);
        $short = Command\ShortInfo::parse($msg);
        return $short;
    }

    public function fromJson($json) {

    }
}