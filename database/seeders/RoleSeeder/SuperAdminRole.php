<?php

namespace Database\Seeders\RoleSeeder;

use App\PermissionsManager\SuperAdminPermissionsManager;
use Database\Seeders\RoleSeeder\Core\RoleSeedRunner;

class SuperAdminRole extends RoleSeedRunner
{
    protected $roleName = 'Super Admin';

    protected $permissionManager = SuperAdminPermissionsManager::class;
    public function __contruct()
    {

    }
}