<?php

namespace Phpentair;

class CommandTypeFactory {

    public static function GetType($cmdValue) {
        $commandmap = [];
        foreach (CommandTypeFactory::ListCommands() as $command) {
            $value = __NAMESPACE__ . '\\Command\\' . $command;
            $commandmap[call_user_func([__NAMESPACE__ . '\\Command\\' . $command, 'CommandType'])] = $value;
        }
        return isset($commandmap[$cmdValue]) ? $commandmap[$cmdValue] : (__NAMESPACE__ . '\\Command\\Unknown');
    }

    public static function GetHeaders() {
        $headers = self::BuildMap('MessageType', 'Header');
        return $headers;
    }

    public static function BuildMap($keyFn, $valueFn) {
        $map = [];
        foreach (CommandTypeFactory::ListCommands() as $command) {
            $value = call_user_func([__NAMESPACE__ . '\\Command\\' . $command, $valueFn]);
            if (strlen($value) > 2)
                $map[call_user_func([__NAMESPACE__ . '\\Command\\' . $command, $keyFn])] = $value;
        }
        return $map;
    }

    public static function ListCommands() {
        $scan = scandir(dirname(__FILE__) . DIRECTORY_SEPARATOR . "Command");
        $filter = array_filter($scan, function($v) {
            return strstr($v, '.php');
        });
        $map = array_map(function($v) {
            preg_match('/(\w+)\.php/', $v, $matches);
            return $matches[1];
        }, $filter);
        return $map;
    }

    public static function CallStatic($cmdValue, $method, $params) {
        $call = CommandTypeFactory::GetType($cmdValue);
        return call_user_func([$call, $method], $params);
    }
}