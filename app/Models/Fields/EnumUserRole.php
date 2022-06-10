<?php

namespace App\Models\Fields;

interface EnumUserRole {
    const ROLE_USER     = 'USER';
    const ROLE_ADMIN    = 'ADMIN';
    const ROLE_SALES     = 'SALES';
    const ROLE_FLOOR_MANAGER    = 'FLOOR_MANAGER';
    const ROLE_BOT      = 'BOT';
}