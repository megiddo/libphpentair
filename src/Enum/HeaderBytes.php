<?php

namespace Phpentair\Enum;

enum HeaderBytes: int {
    case SYNC_0 = 0;                // 0xff
    case SYNC_1 = 1;                // 0x00
    case SYNC_2 = 2;                // 0xff
    case SYNC_3 = 3;                // 0xa5
    case PROTOCOL = 4;
    case DST = 5;
    case SRC = 6;
    case COMMAND = 7;
    case LENGTH = 8;                   // 0x1d (29)
}