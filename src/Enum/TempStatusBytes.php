<?php

namespace Phpentair\Enum;

enum TempStatusBytes: int {
    // Info temp data
    case WATER_ACTUAL = 10;
    case AIR_ACTUAL = 11;
    case WATER_SET = 12;
    case SPA_SET = 13;
    case INFO = 14;
}
