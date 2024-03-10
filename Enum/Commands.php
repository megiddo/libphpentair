<?php

namespace Phpentair\Enum;

enum Commands: int {
    case UNKNOWN = 0x0;
    case SYSTEM_STATUS = 0x02;
    case CIRCUIT_CHANGE_REQUEST = 0x86;
    case TEMP_CHANGE_REQUEST = 0x88;
    case CIRCUIT_CHANGE_ACK = 0x01;
    case REMOTE_LAYOUT_REQUEST = 0xE1;
    case REMOTE_LAYOUT_ACK = 0x21;
    case CLOCK_BROADCAST = 0x05;
    case PUMP_STATUS_REQUEST = 0x07;
    case INFO = 0x08;
}