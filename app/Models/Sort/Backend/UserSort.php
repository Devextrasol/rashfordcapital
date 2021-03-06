<?php

namespace App\Models\Sort\Backend;

use App\Models\Sort\Sort;

class UserSort extends Sort
{
    protected $sortableColumns = [
        'id'                => 'id',
        'name'              => 'name',
        'email'             => 'email',
        'status'            => 'status',
        'last_login_time'   => 'last_login_time',
        'phone'              => 'phone',
        'country'              => 'country',
        'created_at'              => 'created_at',
    ];
}