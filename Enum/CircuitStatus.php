<?php

namespace Phpentair\Enum;

// Requests: https://github.com/scottrfrancis/Pentair-Thing/blob/master/PentairProtocol.py
enum CircuitStatus: int {
    case CLEANER_PUMP = 0x02;
    case WATER_FEATURE = 0x04;
    case SPA_LIGHT = 0x08;
    case POOL_LIGHT = 0x10;
    case FILTER_PUMP = 0x20;
}