<?php

namespace Database\Seeders\RoleSeeder\Core;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeedRunner
{
    /**
     * Role name
     * 
     * @var array
     */
    protected $roleName = '';

    /**
     * Role's permission manager class
     */
    protected $permissionManager = '';

    public function seed()
    {
        $role = Role::where("name", $this->roleName)->first();
        if (empty($role)) $role = Role::create(['name' => $this->roleName]);

        $permissionManager = new $this->permissionManager;
        $permissions = $permissionManager->getPermissions();

        //Existing role permissions
        $existingPermissions = $role->permissions->pluck('name')->toArray();
        $shouldRevokePermissions = array_diff($existingPermissions, $permissions);

        if (count($shouldRevokePermissions) > 0) {
            $role->revokePermissionTo($shouldRevokePermissions);
            echo $this->roleName . " - REVOKING PERMISSION - :" . implode("\n -- ", $shouldRevokePermissions) . ":\n";
        }

        foreach ($permissions as $index => $permissionName) {
            echo ($this->roleName." PERMISSION ".$index." of ".count($permissions)) . "\n";
            $permission = Permission::where('name', $permissionName)->first();
            if (empty($permission)) Permission::create(['name' => $permissionName]);
            if (!$role->hasPermissionTo($permissionName)) $role->givePermissionTo($permissionName);
        }
    }
}