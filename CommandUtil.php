<?php

namespace Phpentair;

enum MessageType: string {
    case SHORT = 'short-message';
    case STANDARD = 'standard-message';
}

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

enum TempStatusBytes: int {
    // Info temp data
    case WATER_ACTUAL = 10;
    case AIR_ACTUAL = 11;
    case WATER_SET = 12;
    case SPA_SET = 13;
    case INFO = 14;
}

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

// Requests: https://github.com/scottrfrancis/Pentair-Thing/blob/master/PentairProtocol.py
enum CIRCUIT_STATUS: int {
    case CLEANER_PUMP = 0x02;
    case WATER_FEATURE = 0x04;
    case SPA_LIGHT = 0x08;
    case POOL_LIGHT = 0x10;
    case FILTER_PUMP = 0x20;
}

enum CIRCUIT_CHANGE: int {
    case SPA = 0x01;
    case POOL = 0x06;
    case HEAT_BOOST = 0x85;
}

enum CircuitChangeBytes: int {
    case CIRCUIT = 9;
    case STATUS = 10;
}

function dechexbyte($int) {
    return str_pad(dechex($int), 2, '0', STR_PAD_LEFT);
}