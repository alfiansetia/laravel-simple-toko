<?php

use App\Enums\Role;

function hrg($angka)
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

function role_admin($role)
{
    return $role == Role::ADMIN->value;
}
