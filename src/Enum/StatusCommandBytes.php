<?php

namespace Phpentair\Enum;

// https://github.com/michaelusner/pentair-pool-controler/blob/master/PACKET_SPEC.txt
enum StatusCommandBytes: int {
    case HOURS = 9;
    case MINUTES = 10;
    case CIRCUITS_0 = 11;
    case CIRCUITS_1 = 12;
    case CIRCUITS_2 = 13;

    //https://github.com/scottrfrancis/Pentair-Thing/blob/49e6014866029771a31eaba075b89401fac2593a/PentairProtocol.py#L76
    case UOM = 18;

    // https://github.com/scottrfrancis/Pentair-Thing/blob/49e6014866029771a31eaba075b89401fac2593a/PentairProtocol.py#L83
    case HEATER = 19;
    case DELAY = 21;
    case WATER_TEMP = 23;
    case HEATER_TEMP = 24;
    case HEATER_ACTIVE = 25;
    case AIR_TEMP = 27;

    // https://github.com/scottrfrancis/Pentair-Thing/blob/49e6014866029771a31eaba075b89401fac2593a/PentairProtocol.py#L92
    case HEATER_MODE = 31;
    case TEMP_2 = 34;
    case TEMP_3 = 35;
}