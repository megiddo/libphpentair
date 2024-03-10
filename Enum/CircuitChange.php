<?php

namespace Phpentair\Enum;

enum CircuitChange: int {
    case SPA = 0x01;
    case POOL = 0x06;
    case HEAT_BOOST = 0x85;
}