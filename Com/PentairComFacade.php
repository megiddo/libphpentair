<?php

namespace Phpentair\Com;

use Phpentair\CommandTypeFactory;
use \Phpentair\MessageType;
use Phpentair\Command;

class PentairComFacade {

    private IConnector $ipc;
    private \Phpentair\CommandParser $parser;

    public function __construct(IConnector $ipc) {
        $this->ipc = $ipc;
        $this->parser = new \Phpentair\CommandParser($ipc);
    }

    public function readCommand() {
        $this->ipc->open();
        $type = $this->seekHeader();
        $pm = false;
        switch ($type) {
            case MessageType::STANDARD->value: 
                $pm = $this->parser->parse(MessageType::STANDARD);
                break;
            case MessageType::SHORT->value:
                $pm = $this->parser->parse(MessageType::SHORT);
                break;
            default:
                $pm = false;
        }
        $this->ipc->close();
        return $pm;
    }

    public function sendCommand(Command $command) {
        $this->ipc->put($command);
    }

    private function headersMatch($lead) {
        $headers = $this->getHeaders();
        foreach ($headers as $h => $header) {
            if (substr($lead, -1 * strlen($header)) == $header) {
                return $h;
            } 
        }
        return false;
    }

    private function getHeaders() {
        return CommandTypeFactory::GetHeaders();
    }

    private function seekHeader() {
        $lead = 'ff';
        do {
            $c = $this->ipc->read(1);
            if ($c === false) throw new \Phpentair\Exception\EndOfStreamException("");

            $c = bin2hex($c);
            if ($c === false) return false;

            $lead = substr($lead . $c, -8);

            if (($h = $this->headersMatch($lead)) !== false) {
                return $h;
            }
        } while (true);
    }
}